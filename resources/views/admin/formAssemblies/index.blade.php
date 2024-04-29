@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.formAssembly.title') }}
                </div>
                <form action="">
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Form list
                </div>
                <div class="list-group">
                    @foreach ($form_names as $form)
                    <a href="{{ url('admin/form-assemblies') }}/{{ $form->id }}" class="list-group-item">{{ $form->name
                        }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        @if ($form_name)
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New field
                </div>
                <form action="{{ route('admin.form-assemblies.new-field') }}" method="post">
                    @csrf
                    <input type="hidden" name="form_name_id" value="{{ $form_name->id }}">
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Label</label>
                            <input type="text" class="form-control" name="label">
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="type" id="text" value="text" checked>
                                Text
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="type" id="number" value="number">
                                Number
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="type" id="date" value="date">
                                Date
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="type" id="textarea" value="textarea">
                                Textarea
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="type" id="checkbox" value="checkbox">
                                Checkbox
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="type" id="radio" value="radio">
                                Radio
                            </label>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-success" type="submit">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $form_name->name }}
                </div>
                <form action="{{ route('admin.form-assemblies.send-form-data') }}" method="post">
                    @csrf
                    <input type="hidden" name="form_name_id" value="{{ $form_name->id }}">
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Driver</label>
                            <select name="driver_id" class="form-control">
                                <option selected disabled">Select</option>
                                @foreach ($drivers as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>License</label>
                            <select name="vehicle_item_id" class="form-control">
                                <option selected disabled">Select</option>
                                @foreach ($vehicle_items as $vehicle_item)
                                <option value="{{ $vehicle_item->id }}">{{ $vehicle_item->license_plate }}</option>
                                @endforeach
                            </select>
                        </div>
                        @foreach ($form_name->form_inputs as $form_input)
                        @switch($form_input->type)
                        @case('text')
                        <div class="form-group">
                            <label>{{ $form_input->label }}</label>
                            <input type="text" class="form-control" name="{{ $form_input->name }}" required>
                        </div>
                        @break
                        @case('number')
                        <div class="form-group">
                            <label>{{ $form_input->label }}</label>
                            <input type="number" class="form-control" name="{{ $form_input->name }}" required>
                        </div>
                        @break
                        @case('date')
                        <div class="form-group">
                            <label>{{ $form_input->label }}</label>
                            <input type="date" class="form-control" name="{{ $form_input->name }}" required>
                        </div>
                        @break
                        @case('textarea')
                        <div class="form-group">
                            <label>{{ $form_input->label }}</label>
                            <textarea class="form-control" name="{{ $form_input->name }}" required></textarea>
                        </div>
                        @break
                        @case('checkbox')
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="{{ $form_input->name }}"> {{ $form_input->label }}
                            </label>
                        </div>
                        @break
                        @case('radio')
                        <label>{{ $form_input->label }}</label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="{{ $form_input->name }}" id="{{ $form_input->name }}_1"
                                    value="Sim" checked>
                                Sim
                            </label>
                        </div>
                        <div class="radio disabled">
                            <label>
                                <input type="radio" name="{{ $form_input->name }}" id="{{ $form_input->name }}_2"
                                    value="Não">
                                Não
                            </label>
                        </div>
                        @break
                        @default
                        @endswitch
                        @endforeach
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-success">Send</button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection