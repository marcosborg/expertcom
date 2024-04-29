<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\FormData;
use App\Models\FormInput;
use App\Models\FormName;
use App\Models\VehicleItem;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FormAssemblyController extends Controller
{
    public function index($id = null)
    {
        abort_if(Gate::denies('form_assembly_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $form_names = FormName::all();

        $form_name = FormName::find($id);

        if ($form_name) {
            $form_name->load('form_inputs');
        }

        $drivers = Driver::all();
        $vehicle_items = VehicleItem::all();

        return view('admin.formAssemblies.index', compact('form_names', 'form_name', 'drivers', 'vehicle_items'));
    }

    public function newField(Request $request)
    {
        $request->validate([
            'name' => 'required|max: 255',
            'label' => 'required|max: 255',
        ]);

        $form_input = new FormInput;
        $form_input->name = $request->name;
        $form_input->label = $request->label;
        $form_input->type = $request->type;
        $form_input->form_name_id = $request->form_name_id;
        $form_input->save();

        return redirect()->back()->with('message', 'Success');

    }

    public function sendFormData(Request $request)
    {
        $driver = Driver::find($request->driver_id)->load('company');
        $vehicle_item = VehicleItem::find($request->vehicle_item_id)->load('company', 'vehicle_brand', 'vehicle_model');
        $data = [];
        $data['driver'] = $driver->name . ' - ' . $driver->company->name;
        $data['vehicle_item'] = $vehicle_item->license_plate . ' - (' . $vehicle_item->vehicle_brand->name . ' ' . $vehicle_item->vehicle_model->name . ')';

        foreach ($request->all() as $label => $value) {
            if ($label != '_token' && $label != 'form_name_id' && $label != 'driver_id' && $label != 'vehicle_item_id') {
                $data[$label] = $value;
            }
        }

        $data = json_encode($data);

        $form_data = new FormData;
        $form_data->form_name_id = $request->form_name_id;
        $form_data->driver_id = $request->driver_id;
        $form_data->vehicle_item_id = $request->vehicle_item_id;
        $form_data->data = $data;
        $form_data->save();

        return redirect()->back()->with('message', 'Success');
    }

}
