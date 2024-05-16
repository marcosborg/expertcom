<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFormDataRequest;
use App\Http\Requests\StoreFormDataRequest;
use App\Http\Requests\UpdateFormDataRequest;
use App\Models\Driver;
use App\Models\FormData;
use App\Models\FormName;
use App\Models\VehicleItem;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FormDataController extends Controller
{
    public function index(Request $request)
    {

        abort_if(Gate::denies('form_data_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = FormData::with(['form_name', 'driver', 'vehicle_item'])->select(sprintf('%s.*', (new FormData)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'form_data_show';
                $editGate      = 'form_data_edit';
                $deleteGate    = 'form_data_delete';
                $crudRoutePart = 'form-datas';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('form_name_name', function ($row) {
                return $row->form_name ? $row->form_name->name : '';
            });

            $table->addColumn('driver_code', function ($row) {
                return $row->driver ? $row->driver->code : '';
            });

            $table->addColumn('vehicle_item_license_plate', function ($row) {
                return $row->vehicle_item ? $row->vehicle_item->license_plate : '';
            });

            $table->editColumn('data', function ($row) {
                $html = '';
                foreach (json_decode($row->data) as $key => $value) {
                    $html .= '<label>' . $key . '</label>: ' . $value . '<br>';
                }
                return $row->data ? $html : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'form_name', 'driver', 'vehicle_item', 'data']);

            return $table->make(true);
        }

        $form_names    = FormName::get();
        $drivers       = Driver::get();
        $vehicle_items = VehicleItem::get();

        return view('admin.formDatas.index', compact('form_names', 'drivers', 'vehicle_items'));
    }

    public function create()
    {
        abort_if(Gate::denies('form_data_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $form_names = FormName::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $drivers = Driver::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicle_items = VehicleItem::pluck('license_plate', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.formDatas.create', compact('drivers', 'form_names', 'vehicle_items'));
    }

    public function store(StoreFormDataRequest $request)
    {
        $formData = FormData::create($request->all());

        return redirect()->route('admin.form-datas.index');
    }

    public function edit(FormData $formData)
    {
        abort_if(Gate::denies('form_data_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $form_names = FormName::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $drivers = Driver::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicle_items = VehicleItem::pluck('license_plate', 'id')->prepend(trans('global.pleaseSelect'), '');

        $formData->load('form_name', 'driver', 'vehicle_item');

        return view('admin.formDatas.edit', compact('drivers', 'formData', 'form_names', 'vehicle_items'));
    }

    public function update(UpdateFormDataRequest $request, FormData $formData)
    {
        $formData->update($request->all());

        return redirect()->route('admin.form-datas.index');
    }

    public function show(FormData $formData)
    {
        abort_if(Gate::denies('form_data_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $formData->load('form_name', 'driver', 'vehicle_item');

        return view('admin.formDatas.show', compact('formData'));
    }

    public function destroy(FormData $formData)
    {
        abort_if(Gate::denies('form_data_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $formData->delete();

        return back();
    }

    public function massDestroy(MassDestroyFormDataRequest $request)
    {
        $formDatas = FormData::find(request('ids'));

        foreach ($formDatas as $formData) {
            $formData->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}