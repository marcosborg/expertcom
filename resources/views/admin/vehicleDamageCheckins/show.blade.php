@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.vehicleDamageCheckin.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.vehicle-damage-checkins.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleDamageCheckin.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $vehicleDamageCheckin->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleDamageCheckin.fields.vehicle_manage_checkin') }}
                                    </th>
                                    <td>
                                        {{ $vehicleDamageCheckin->vehicle_manage_checkin->data_e_horario ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleDamageCheckin.fields.driver_warning') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleDamageCheckin->driver_warning ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleDamageCheckin.fields.company_warning') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleDamageCheckin->company_warning ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleDamageCheckin.fields.admin_warning') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleDamageCheckin->admin_warning ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleDamageCheckin.fields.created_at') }}
                                    </th>
                                    <td>
                                        {{ $vehicleDamageCheckin->created_at }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.vehicle-damage-checkins.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection