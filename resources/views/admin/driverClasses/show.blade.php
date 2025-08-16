@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.driverClass.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.driver-classes.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.driverClass.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $driverClass->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.driverClass.fields.name') }}
                                    </th>
                                    <td>
                                        {{ $driverClass->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.driverClass.fields.from') }}
                                    </th>
                                    <td>
                                        {{ $driverClass->from }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.driverClass.fields.to') }}
                                    </th>
                                    <td>
                                        {{ $driverClass->to }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.driverClass.fields.minimum_value') }}
                                    </th>
                                    <td>
                                        {{ $driverClass->minimum_value }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.driverClass.fields.additional_commission') }}
                                    </th>
                                    <td>
                                        {{ $driverClass->additional_commission }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.driverClass.fields.time_for_loyalty_bonus') }}
                                    </th>
                                    <td>
                                        {{ $driverClass->time_for_loyalty_bonus }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.driverClass.fields.value_of_the_loyalty_bonus') }}
                                    </th>
                                    <td>
                                        {{ $driverClass->value_of_the_loyalty_bonus }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.driver-classes.index') }}">
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