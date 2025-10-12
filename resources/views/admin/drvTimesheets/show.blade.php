@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.drvTimesheet.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.drv-timesheets.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvTimesheet.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $drvTimesheet->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvTimesheet.fields.driver') }}
                                    </th>
                                    <td>
                                        {{ $drvTimesheet->driver->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvTimesheet.fields.date') }}
                                    </th>
                                    <td>
                                        {{ $drvTimesheet->date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvTimesheet.fields.total_drive_seconds') }}
                                    </th>
                                    <td>
                                        {{ $drvTimesheet->total_drive_seconds }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvTimesheet.fields.total_pause_seconds') }}
                                    </th>
                                    <td>
                                        {{ $drvTimesheet->total_pause_seconds }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvTimesheet.fields.status') }}
                                    </th>
                                    <td>
                                        {{ App\Models\DrvTimesheet::STATUS_RADIO[$drvTimesheet->status] ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.drv-timesheets.index') }}">
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