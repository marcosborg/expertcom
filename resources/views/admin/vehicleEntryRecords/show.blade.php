@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.vehicleEntryRecord.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.vehicle-entry-records.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleEntryRecord.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $vehicleEntryRecord->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleEntryRecord.fields.date_time') }}
                                    </th>
                                    <td>
                                        {{ $vehicleEntryRecord->date_time }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleEntryRecord.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $vehicleEntryRecord->user->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleEntryRecord.fields.vehicle') }}
                                    </th>
                                    <td>
                                        {{ $vehicleEntryRecord->vehicle->license_plate ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleEntryRecord.fields.battery_enter') }}
                                    </th>
                                    <td>
                                        {{ $vehicleEntryRecord->battery_enter }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleEntryRecord.fields.quilometers') }}
                                    </th>
                                    <td>
                                        {{ $vehicleEntryRecord->quilometers }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleEntryRecord.fields.photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleEntryRecord->photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                                <img src="{{ $media->getUrl('thumb') }}">
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.vehicle-entry-records.index') }}">
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