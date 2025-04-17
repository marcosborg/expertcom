@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.vehicleEntryRecord.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.vehicle-entry-records.update", [$vehicleEntryRecord->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group {{ $errors->has('date_time') ? 'has-error' : '' }}">
                            <label class="required" for="date_time">{{ trans('cruds.vehicleEntryRecord.fields.date_time') }}</label>
                            <input class="form-control datetime" type="text" name="date_time" id="date_time" value="{{ old('date_time', $vehicleEntryRecord->date_time) }}" required>
                            @if($errors->has('date_time'))
                                <span class="help-block" role="alert">{{ $errors->first('date_time') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleEntryRecord.fields.date_time_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('user') ? 'has-error' : '' }}">
                            <label class="required" for="user_id">{{ trans('cruds.vehicleEntryRecord.fields.user') }}</label>
                            <select class="form-control select2" name="user_id" id="user_id" required>
                                @foreach($users as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $vehicleEntryRecord->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                                <span class="help-block" role="alert">{{ $errors->first('user') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleEntryRecord.fields.user_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('driver') ? 'has-error' : '' }}">
                            <label class="required" for="driver_id">{{ trans('cruds.vehicleEntryRecord.fields.driver') }}</label>
                            <select class="form-control select2" name="driver_id" id="driver_id" required>
                                @foreach($drivers as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('driver_id') ? old('driver_id') : $vehicleEntryRecord->driver->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('driver'))
                                <span class="help-block" role="alert">{{ $errors->first('driver') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleEntryRecord.fields.driver_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('vehicle') ? 'has-error' : '' }}">
                            <label class="required" for="vehicle_id">{{ trans('cruds.vehicleEntryRecord.fields.vehicle') }}</label>
                            <select class="form-control select2" name="vehicle_id" id="vehicle_id" required>
                                @foreach($vehicles as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('vehicle_id') ? old('vehicle_id') : $vehicleEntryRecord->vehicle->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('vehicle'))
                                <span class="help-block" role="alert">{{ $errors->first('vehicle') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleEntryRecord.fields.vehicle_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('battery_enter') ? 'has-error' : '' }}">
                            <label class="required" for="battery_enter">{{ trans('cruds.vehicleEntryRecord.fields.battery_enter') }}</label>
                            <input class="form-control" type="number" name="battery_enter" id="battery_enter" value="{{ old('battery_enter', $vehicleEntryRecord->battery_enter) }}" step="1" required>
                            @if($errors->has('battery_enter'))
                                <span class="help-block" role="alert">{{ $errors->first('battery_enter') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleEntryRecord.fields.battery_enter_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('battery_exit') ? 'has-error' : '' }}">
                            <label class="required" for="battery_exit">{{ trans('cruds.vehicleEntryRecord.fields.battery_exit') }}</label>
                            <input class="form-control" type="number" name="battery_exit" id="battery_exit" value="{{ old('battery_exit', $vehicleEntryRecord->battery_exit) }}" step="1" required>
                            @if($errors->has('battery_exit'))
                                <span class="help-block" role="alert">{{ $errors->first('battery_exit') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleEntryRecord.fields.battery_exit_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('quilometers') ? 'has-error' : '' }}">
                            <label class="required" for="quilometers">{{ trans('cruds.vehicleEntryRecord.fields.quilometers') }}</label>
                            <input class="form-control" type="number" name="quilometers" id="quilometers" value="{{ old('quilometers', $vehicleEntryRecord->quilometers) }}" step="1" required>
                            @if($errors->has('quilometers'))
                                <span class="help-block" role="alert">{{ $errors->first('quilometers') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleEntryRecord.fields.quilometers_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection