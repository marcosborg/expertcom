@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.vehicleDamageCheckin.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.vehicle-damage-checkins.update", [$vehicleDamageCheckin->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group {{ $errors->has('vehicle_manage_checkin') ? 'has-error' : '' }}">
                            <label class="required" for="vehicle_manage_checkin_id">{{ trans('cruds.vehicleDamageCheckin.fields.vehicle_manage_checkin') }}</label>
                            <select class="form-control select2" name="vehicle_manage_checkin_id" id="vehicle_manage_checkin_id" required>
                                @foreach($vehicle_manage_checkins as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('vehicle_manage_checkin_id') ? old('vehicle_manage_checkin_id') : $vehicleDamageCheckin->vehicle_manage_checkin->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('vehicle_manage_checkin'))
                                <span class="help-block" role="alert">{{ $errors->first('vehicle_manage_checkin') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleDamageCheckin.fields.vehicle_manage_checkin_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('driver_warning') ? 'has-error' : '' }}">
                            <div>
                                <input type="hidden" name="driver_warning" value="0">
                                <input type="checkbox" name="driver_warning" id="driver_warning" value="1" {{ $vehicleDamageCheckin->driver_warning || old('driver_warning', 0) === 1 ? 'checked' : '' }}>
                                <label for="driver_warning" style="font-weight: 400">{{ trans('cruds.vehicleDamageCheckin.fields.driver_warning') }}</label>
                            </div>
                            @if($errors->has('driver_warning'))
                                <span class="help-block" role="alert">{{ $errors->first('driver_warning') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleDamageCheckin.fields.driver_warning_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('company_warning') ? 'has-error' : '' }}">
                            <div>
                                <input type="hidden" name="company_warning" value="0">
                                <input type="checkbox" name="company_warning" id="company_warning" value="1" {{ $vehicleDamageCheckin->company_warning || old('company_warning', 0) === 1 ? 'checked' : '' }}>
                                <label for="company_warning" style="font-weight: 400">{{ trans('cruds.vehicleDamageCheckin.fields.company_warning') }}</label>
                            </div>
                            @if($errors->has('company_warning'))
                                <span class="help-block" role="alert">{{ $errors->first('company_warning') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleDamageCheckin.fields.company_warning_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('admin_warning') ? 'has-error' : '' }}">
                            <div>
                                <input type="hidden" name="admin_warning" value="0">
                                <input type="checkbox" name="admin_warning" id="admin_warning" value="1" {{ $vehicleDamageCheckin->admin_warning || old('admin_warning', 0) === 1 ? 'checked' : '' }}>
                                <label for="admin_warning" style="font-weight: 400">{{ trans('cruds.vehicleDamageCheckin.fields.admin_warning') }}</label>
                            </div>
                            @if($errors->has('admin_warning'))
                                <span class="help-block" role="alert">{{ $errors->first('admin_warning') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleDamageCheckin.fields.admin_warning_helper') }}</span>
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