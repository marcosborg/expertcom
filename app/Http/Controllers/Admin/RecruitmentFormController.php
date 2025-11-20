<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyRecruitmentFormRequest;
use App\Http\Requests\StoreRecruitmentFormRequest;
use App\Http\Requests\UpdateRecruitmentFormRequest;
use App\Models\Company;
use App\Models\RecruitmentForm;
use App\Models\User;
use App\Notifications\RecruitmentFormNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class RecruitmentFormController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('recruitment_form_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        if ($request->ajax()) {

            $query = RecruitmentForm::with(['user', 'company'])
                ->select(sprintf('%s.*', (new RecruitmentForm)->getTable()));

            // Filtro de empresa para utilizadores que não são admin
            if (!$user->hasRole('admin') && session()->has('company_id')) {
                $companyId = session('company_id');
                $query->where('company_id', $companyId);
            }

            // Filtro por status vindo do DataTables (via botão de filtro)
            $table = Datatables::of($query);

            $table->filter(function ($query) use ($request) {
                if ($request->filled('status')) {
                    $query->where('status', $request->status);
                }

                if ($searchValue = $request->input('search.value')) {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('name', 'like', "%{$searchValue}%")
                            ->orWhere('email', 'like', "%{$searchValue}%")
                            ->orWhere('phone', 'like', "%{$searchValue}%")
                            ->orWhere('status', 'like', "%{$searchValue}%")
                            ->orWhere('type', 'like', "%{$searchValue}%")
                            ->orWhere('chanel', 'like', "%{$searchValue}%")
                            ->orWhere('responsible_for_the_lead', 'like', "%{$searchValue}%")
                            ->orWhereHas('company', fn ($company) => $company->where('name', 'like', "%{$searchValue}%"))
                            ->orWhereHas('user', fn ($user) => $user->where('name', 'like', "%{$searchValue}%"));
                    });
                }
            });

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'recruitment_form_show';
                $editGate      = 'recruitment_form_edit';
                $deleteGate    = 'recruitment_form_delete';
                $crudRoutePart = 'recruitment-forms';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', fn($row) => $row->id ?? '');
            $table->addColumn('user_name', fn($row) => $row->user?->name ?? '');
            $table->addColumn('company_name', fn($row) => $row->company?->name ?? '');
            $table->editColumn('name', fn($row) => $row->name ?? '');
            $table->editColumn('email', fn($row) => $row->email ?? '');
            $table->editColumn('responsible_for_the_lead', fn($row) => $row->responsible_for_the_lead ?? '');
            $table->editColumn('contact_successfully', fn($row) => '<input type="checkbox" disabled ' . ($row->contact_successfully ? 'checked' : '') . '>');
            $table->editColumn('phone', fn($row) => $row->phone ?? '');
            $table->editColumn('scheduled_interview', fn($row) => '<input type="checkbox" disabled ' . ($row->scheduled_interview ? 'checked' : '') . '>');
            $table->editColumn('done', fn($row) => '<input type="checkbox" disabled ' . ($row->done ? 'checked' : '') . '>');
            $table->editColumn('status', fn($row) => $row->status ? RecruitmentForm::STATUS_RADIO[$row->status] : '');
            $table->editColumn('type', fn($row) => $row->type ? RecruitmentForm::TYPE_RADIO[$row->type] : '');
            $table->editColumn('chanel', fn($row) => $row->chanel ? RecruitmentForm::CHANEL_RADIO[$row->chanel] : '');
            $table->editColumn('start_time', fn($row) => $row->start_time ?? '');
            $table->editColumn('end_time', fn($row) => $row->end_time ?? '');
            $table->editColumn('day_off', fn($row) => $row->day_off ? RecruitmentForm::DAY_OFF_RADIO[$row->day_off] : '');
            $table->editColumn('amount_to_pay', fn($row) => $row->amount_to_pay ?? '');
            $table->editColumn('created_at', fn($row) => $row->created_at ?? '');
            $table->editColumn('updated_at', fn($row) => $row->updated_at ?? '');

            $table->rawColumns(['actions', 'placeholder', 'cv', 'contact_successfully', 'scheduled_interview', 'done']);

            return $table->make(true);
        }

        $status = RecruitmentForm::STATUS_RADIO;

        return view('admin.recruitmentForms.index', compact('status'));
    }

    public function report(Request $request)
    {
        abort_if(Gate::denies('recruitment_form_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();
        $dateFormat = config('panel.date_format');

        $startDateInput = $request->input('start_date');
        $endDateInput = $request->input('end_date');

        $startDate = $startDateInput
            ? Carbon::createFromFormat($dateFormat, $startDateInput)
            : Carbon::today()->subMonths(3);
        $endDate = $endDateInput
            ? Carbon::createFromFormat($dateFormat, $endDateInput)
            : Carbon::today();

        if ($startDate->gt($endDate)) {
            [$startDate, $endDate] = [$endDate, $startDate];
        }

        if ($startDate->floatDiffInMonths($endDate) > 3.0) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'O per\u00edodo m\u00e1ximo \u00e9 de 3 meses.');
        }

        $baseQuery = RecruitmentForm::with(['company', 'user']);

        if (!$user->hasRole('admin') && session()->has('company_id')) {
            $baseQuery->where('company_id', session('company_id'));
        }

        if ($request->filled('status')) {
            $baseQuery->where('status', $request->status);
        }

        $baseQuery->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()]);

        $recruitmentForms = (clone $baseQuery)
            ->orderByDesc('created_at')
            ->get();

        $summary = [
            'total'                 => $recruitmentForms->count(),
            'contact_successfully'  => $recruitmentForms->where('contact_successfully', 1)->count(),
            'scheduled_interview'   => $recruitmentForms->where('scheduled_interview', 1)->count(),
            'done'                  => $recruitmentForms->where('done', 1)->count(),
        ];

        $funnel = [
            'leads_total'     => $summary['total'],
            'interviews'      => $summary['scheduled_interview'],
            'closed'          => $summary['done'],
        ];

        $grouped = [
            'status' => $recruitmentForms->groupBy('status')->map->count()->sortDesc(),
            'type'   => $recruitmentForms->groupBy('type')->map->count()->sortDesc(),
            'chanel' => $recruitmentForms->groupBy('chanel')->map->count()->sortDesc(),
        ];

        $responsibles = $recruitmentForms
            ->groupBy('responsible_for_the_lead')
            ->map->count()
            ->sortDesc();

        $chanelConversion = $recruitmentForms
            ->groupBy('chanel')
            ->map(function ($items) {
                $total = $items->count();
                $interviews = $items->where('scheduled_interview', 1)->count();
                $closed = $items->where('done', 1)->count();

                return [
                    'total'       => $total,
                    'interviews'  => $interviews,
                    'closed'      => $closed,
                    'rate_lead_to_interview' => $total > 0 ? round(($interviews / $total) * 100, 1) : 0,
                    'rate_interview_to_closed' => $interviews > 0 ? round(($closed / max($interviews, 1)) * 100, 1) : 0,
                    'rate_lead_to_closed' => $total > 0 ? round(($closed / $total) * 100, 1) : 0,
                ];
            })
            ->sortByDesc('rate_lead_to_closed');

        $responsibleSuccess = $recruitmentForms
            ->groupBy('responsible_for_the_lead')
            ->map(function ($items) {
                $total = $items->count();
                $closed = $items->where('done', 1)->count();
                $rate = $total > 0 ? round(($closed / $total) * 100, 1) : 0;
                return [
                    'total'  => $total,
                    'closed' => $closed,
                    'rate'   => $rate,
                ];
            })
            ->sortByDesc('rate');

        $responsibleConversion = $recruitmentForms
            ->groupBy('responsible_for_the_lead')
            ->map(function ($items) {
                $total = $items->count();
                $interviews = $items->where('scheduled_interview', 1)->count();
                $closed = $items->where('done', 1)->count();
                return [
                    'total'       => $total,
                    'interviews'  => $interviews,
                    'closed'      => $closed,
                    'rate_lead_to_interview' => $total > 0 ? round(($interviews / $total) * 100, 1) : 0,
                    'rate_interview_to_closed' => $interviews > 0 ? round(($closed / max($interviews, 1)) * 100, 1) : 0,
                    'rate_lead_to_closed' => $total > 0 ? round(($closed / $total) * 100, 1) : 0,
                ];
            })
            ->sortByDesc('rate_lead_to_closed');

        $closedForms = $recruitmentForms
            ->where('done', 1)
            ->sortByDesc('created_at');

        $period = [
            'first'        => $startDate->format($dateFormat),
            'last'         => $endDate->format($dateFormat),
            'generated_at' => Carbon::now()->format($dateFormat . ' ' . config('panel.time_format')),
        ];

        $groupedForms = $recruitmentForms
            ->sortByDesc('created_at')
            ->groupBy('status');

        $pdf = Pdf::loadView('admin.recruitmentForms.report', [
            'summary' => $summary,
            'funnel' => $funnel,
            'grouped' => $grouped,
            'responsibles' => $responsibles,
            'responsibleSuccess' => $responsibleSuccess,
            'chanelConversion' => $chanelConversion,
            'responsibleConversion' => $responsibleConversion,
            'groupedForms' => $groupedForms,
            'closedForms' => $closedForms,
            'period'  => $period,
        ])->setOption([
            'isRemoteEnabled'     => true,
            'enable_html5_parser' => true,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('recruitment-forms-report.pdf');
    }


    public function create()
    {
        abort_if(Gate::denies('recruitment_form_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.recruitmentForms.create', compact('companies'));
    }

    public function store(StoreRecruitmentFormRequest $request)
    {
        $recruitmentForm = RecruitmentForm::create($request->all())->load('company');

        if ($request->input('cv', false)) {
            $recruitmentForm->addMedia(storage_path('tmp/uploads/' . basename($request->input('cv'))))->toMediaCollection('cv');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $recruitmentForm->id]);
        }

        Notification::route('mail', $recruitmentForm->company->email)
            ->notify(new RecruitmentFormNotification($recruitmentForm, 'Formulário de recrutamento'));

        return redirect()->route('admin.recruitment-forms.index');
    }

    public function edit(RecruitmentForm $recruitmentForm)
    {
        abort_if(Gate::denies('recruitment_form_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $recruitmentForm->load('company', 'user', 'to_company');

        return view('admin.recruitmentForms.edit', compact('companies', 'users', 'recruitmentForm'));
    }

    public function update(UpdateRecruitmentFormRequest $request, RecruitmentForm $recruitmentForm)
    {

        $sendEmail = false;

        if ($recruitmentForm->status !== $request->status) {
            $sendEmail = true;
        }

        $recruitmentForm->update($request->all());

        if ($request->input('cv', false)) {
            if (!$recruitmentForm->cv || $request->input('cv') !== $recruitmentForm->cv->file_name) {
                if ($recruitmentForm->cv) {
                    $recruitmentForm->cv->delete();
                }
                $recruitmentForm->addMedia(storage_path('tmp/uploads/' . basename($request->input('cv'))))->toMediaCollection('cv');
            }
        } elseif ($recruitmentForm->cv) {
            $recruitmentForm->cv->delete();
        }

        if ($sendEmail == true) {
            Notification::route('mail', $recruitmentForm->company->email ?? 'info@expertcom.pt')
                ->notify(new RecruitmentFormNotification($recruitmentForm, 'Alteração ao estado do recrutamento'));
        }

        return redirect()->route('admin.recruitment-forms.index');
    }

    public function show(RecruitmentForm $recruitmentForm)
    {
        abort_if(Gate::denies('recruitment_form_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $recruitmentForm->load('company');

        return view('admin.recruitmentForms.show', compact('recruitmentForm'));
    }

    public function destroy(RecruitmentForm $recruitmentForm)
    {
        abort_if(Gate::denies('recruitment_form_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $recruitmentForm->delete();

        return back();
    }

    public function massDestroy(MassDestroyRecruitmentFormRequest $request)
    {
        $recruitmentForms = RecruitmentForm::find(request('ids'));

        foreach ($recruitmentForms as $recruitmentForm) {
            $recruitmentForm->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('recruitment_form_create') && Gate::denies('recruitment_form_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new RecruitmentForm();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
