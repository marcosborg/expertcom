@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.drvSession.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.drv-sessions.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvSession.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $drvSession->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvSession.fields.driver') }}
                                    </th>
                                    <td>
                                        {{ $drvSession->driver->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvSession.fields.started_at') }}
                                    </th>
                                    <td>
                                        {{ $drvSession->started_at }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvSession.fields.ended_at') }}
                                    </th>
                                    <td>
                                        {{ $drvSession->ended_at }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvSession.fields.status') }}
                                    </th>
                                    <td>
                                        {{ App\Models\DrvSession::STATUS_RADIO[$drvSession->status] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvSession.fields.total_drive_seconds') }}
                                    </th>
                                    <td>
                                        {{ $drvSession->total_drive_seconds }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvSession.fields.total_pause_seconds') }}
                                    </th>
                                    <td>
                                        {{ $drvSession->total_pause_seconds }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvSession.fields.started_lat') }}
                                    </th>
                                    <td>
                                        {{ $drvSession->started_lat }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvSession.fields.started_lng') }}
                                    </th>
                                    <td>
                                        {{ $drvSession->started_lng }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvSession.fields.ended_lat') }}
                                    </th>
                                    <td>
                                        {{ $drvSession->ended_lat }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvSession.fields.ended_lng') }}
                                    </th>
                                    <td>
                                        {{ $drvSession->ended_lng }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvSession.fields.source') }}
                                    </th>
                                    <td>
                                        {{ App\Models\DrvSession::SOURCE_RADIO[$drvSession->source] ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.drv-sessions.index') }}">
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