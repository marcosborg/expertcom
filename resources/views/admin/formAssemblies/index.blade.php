@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.formAssembly.title') }}
                </div>
                <form action="{{ route('admin.form-assemblies.add-form-name') }}" method="post">
                    @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </form>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Form list
                </div>
                <div class="list-group">
                    @foreach ($form_names as $form)
                    <a href="{{ url('admin/form-assemblies') }}/{{ $form->id }}" class="list-group-item">
                        <label>{{ $form->name }}</label><br>
                        <small>{!! $form->description !!}</small>
                    </a>
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
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="required" value="true"> Required
                            </label>
                        </div>
                        <hr>
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
                        <div class="radio">
                            <label>
                                <input type="radio" name="type" id="photos" value="photos">
                                Photos
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
                    <a onclick="return confirm('Are you sure?');"
                        href="{{ route('admin.form-assemblies.delete-form-name', ['form_name_id' => $form_name->id]) }}"
                        class="btn btn-sm btn-link pull-right"><span class="glyphicon glyphicon-trash"
                            aria-hidden="true"></span></a>
                </div>
                <form action="{{ route('admin.form-assemblies.send-form-data') }}" method="post">
                    @csrf
                    <input type="hidden" name="form_name_id" value="{{ $form_name->id }}">
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Driver *</label>
                            <select name="driver_id" class="form-control select2">
                                <option selected disabled>Select</option>
                                @foreach ($drivers as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>License *</label>
                            <select name="vehicle_item_id" class="form-control select2">
                                <option selected disabled>Select</option>
                                @foreach ($vehicle_items as $vehicle_item)
                                <option value="{{ $vehicle_item->id }}">{{ $vehicle_item->license_plate }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="form_input_content"></div>
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
@section('styles')
<style>
    label {
        width: 100%;
    }
</style>
@endsection
@if ($form_name)
@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(()=>{
        loadFormInputs();
    });

    loadFormInputs = () => {
        $.get("{{ route('admin.form-assemblies.form-inputs', ['form_name_id' => $form_name->id]) }}").then((resp) => {
            $('#form_input_content').html(resp);
            $('#form_input_content').sortable({
                update: () => {
                    let data = [];
                    $('.item').each(function(index) {
                        let position = index + 1;
                        let form_input_id = $(this).attr('data-form_input_id');
                        let item = {
                            form_input_id: form_input_id,
                            position: position
                        }
                        data.push(item);
                    });
                    $.ajax({
                        url: "{{ route('admin.form-assemblies.update-input-position') }}",
                        method: 'POST',
                        data: {data: JSON.stringify(data)},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: (resp) => {
                            console.log(resp);
                        },
                        error: (error) => {
                            console.log(error);
                        }
                    })
                } 
            });
        });
    }

</script>
@endsection
@endif