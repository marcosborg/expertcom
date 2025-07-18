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
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

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
            if ($request->has('status') && $request->status !== '') {
                $query->where('status', $request->status);
            }

            $table = Datatables::of($query);

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
