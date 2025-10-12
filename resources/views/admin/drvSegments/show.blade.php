@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.drvSegment.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.drv-segments.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvSegment.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $drvSegment->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvSegment.fields.session') }}
                                    </th>
                                    <td>
                                        {{ $drvSegment->session->started_at ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvSegment.fields.kind') }}
                                    </th>
                                    <td>
                                        {{ App\Models\DrvSegment::KIND_RADIO[$drvSegment->kind] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvSegment.fields.started_at') }}
                                    </th>
                                    <td>
                                        {{ $drvSegment->started_at }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvSegment.fields.ended_at') }}
                                    </th>
                                    <td>
                                        {{ $drvSegment->ended_at }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvSegment.fields.duration_seconds') }}
                                    </th>
                                    <td>
                                        {{ $drvSegment->duration_seconds }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.drvSegment.fields.notes') }}
                                    </th>
                                    <td>
                                        {{ $drvSegment->notes }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.drv-segments.index') }}">
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