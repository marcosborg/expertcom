@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-md-3">
            <form method="POST" action="{{ route("admin.vehicle-manage-checkins.store") }}" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ trans('global.create') }} {{ trans('cruds.vehicleManageCheckin.title_singular') }}
                    </div>
                    <div class="panel-body">

                        @csrf
                        <div class="form-group {{ $errors->has('user') ? 'has-error' : '' }}">
                            <label class="required" for="user_id">{{ trans('cruds.vehicleManageCheckin.fields.user') }}</label>
                            <select class="form-control select2" name="user_id" id="user_id" required>
                                @foreach($users as $id => $entry)
                                <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                            <span class="help-block" role="alert">{{ $errors->first('user') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleManageCheckin.fields.user_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('vehicle_item') ? 'has-error' : '' }}">
                            <label class="required" for="vehicle_item_id">{{ trans('cruds.vehicleManageCheckin.fields.vehicle_item') }}</label>
                            <select class="form-control select2" name="vehicle_item_id" id="vehicle_item_id" required>
                                @foreach($vehicle_items as $id => $entry)
                                <option value="{{ $id }}" {{ old('vehicle_item_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('vehicle_item'))
                            <span class="help-block" role="alert">{{ $errors->first('vehicle_item') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleManageCheckin.fields.vehicle_item_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('driver') ? 'has-error' : '' }}">
                            <label class="required" for="driver_id">{{ trans('cruds.vehicleManageCheckin.fields.driver') }}</label>
                            <select class="form-control select2" name="driver_id" id="driver_id" required>
                                @foreach($drivers as $id => $entry)
                                <option value="{{ $id }}" {{ old('driver_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('driver'))
                            <span class="help-block" role="alert">{{ $errors->first('driver') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleManageCheckin.fields.driver_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('data_e_horario') ? 'has-error' : '' }}">
                            <label class="required" for="data_e_horario">{{ trans('cruds.vehicleManageCheckin.fields.data_e_horario') }}</label>
                            <input class="form-control datetime" type="text" name="data_e_horario" id="data_e_horario" value="{{ old('data_e_horario') }}" required>
                            @if($errors->has('data_e_horario'))
                            <span class="help-block" role="alert">{{ $errors->first('data_e_horario') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleManageCheckin.fields.data_e_horario_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('bateria_a_chegada') ? 'has-error' : '' }}">
                            <label class="required" for="bateria_a_chegada">{{ trans('cruds.vehicleManageCheckin.fields.bateria_a_chegada') }}</label>
                            <input class="form-control" type="number" name="bateria_a_chegada" id="bateria_a_chegada" value="{{ old('bateria_a_chegada', '') }}" step="1" required>
                            @if($errors->has('bateria_a_chegada'))
                            <span class="help-block" role="alert">{{ $errors->first('bateria_a_chegada') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleManageCheckin.fields.bateria_a_chegada_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('km_atual') ? 'has-error' : '' }}">
                            <label class="required" for="km_atual">{{ trans('cruds.vehicleManageCheckin.fields.km_atual') }}</label>
                            <input class="form-control" type="number" name="km_atual" id="km_atual" value="{{ old('km_atual', '') }}" step="1" required>
                            @if($errors->has('km_atual'))
                            <span class="help-block" role="alert">{{ $errors->first('km_atual') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleManageCheckin.fields.km_atual_helper') }}</span>
                        </div>

                    </div>
                    <div class="panel-footer">
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
