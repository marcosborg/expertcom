@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.driverClass.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.driver-classes.update", [$driverClass->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label class="required" for="name">{{ trans('cruds.driverClass.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $driverClass->name) }}" required>
                            @if($errors->has('name'))
                                <span class="help-block" role="alert">{{ $errors->first('name') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.driverClass.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('from') ? 'has-error' : '' }}">
                            <label for="from">{{ trans('cruds.driverClass.fields.from') }}</label>
                            <input class="form-control" type="number" name="from" id="from" value="{{ old('from', $driverClass->from) }}" step="0.01">
                            @if($errors->has('from'))
                                <span class="help-block" role="alert">{{ $errors->first('from') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.driverClass.fields.from_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('to') ? 'has-error' : '' }}">
                            <label class="required" for="to">{{ trans('cruds.driverClass.fields.to') }}</label>
                            <input class="form-control" type="number" name="to" id="to" value="{{ old('to', $driverClass->to) }}" step="0.01" required>
                            @if($errors->has('to'))
                                <span class="help-block" role="alert">{{ $errors->first('to') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.driverClass.fields.to_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('minimum_value') ? 'has-error' : '' }}">
                            <label for="minimum_value">{{ trans('cruds.driverClass.fields.minimum_value') }}</label>
                            <input class="form-control" type="number" name="minimum_value" id="minimum_value" value="{{ old('minimum_value', $driverClass->minimum_value) }}" step="0.01">
                            @if($errors->has('minimum_value'))
                                <span class="help-block" role="alert">{{ $errors->first('minimum_value') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.driverClass.fields.minimum_value_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('additional_commission') ? 'has-error' : '' }}">
                            <label for="additional_commission">{{ trans('cruds.driverClass.fields.additional_commission') }}</label>
                            <input class="form-control" type="number" name="additional_commission" id="additional_commission" value="{{ old('additional_commission', $driverClass->additional_commission) }}" step="1">
                            @if($errors->has('additional_commission'))
                                <span class="help-block" role="alert">{{ $errors->first('additional_commission') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.driverClass.fields.additional_commission_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('time_for_loyalty_bonus') ? 'has-error' : '' }}">
                            <label for="time_for_loyalty_bonus">{{ trans('cruds.driverClass.fields.time_for_loyalty_bonus') }}</label>
                            <input class="form-control" type="number" name="time_for_loyalty_bonus" id="time_for_loyalty_bonus" value="{{ old('time_for_loyalty_bonus', $driverClass->time_for_loyalty_bonus) }}" step="1">
                            @if($errors->has('time_for_loyalty_bonus'))
                                <span class="help-block" role="alert">{{ $errors->first('time_for_loyalty_bonus') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.driverClass.fields.time_for_loyalty_bonus_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('value_of_the_loyalty_bonus') ? 'has-error' : '' }}">
                            <label for="value_of_the_loyalty_bonus">{{ trans('cruds.driverClass.fields.value_of_the_loyalty_bonus') }}</label>
                            <input class="form-control" type="number" name="value_of_the_loyalty_bonus" id="value_of_the_loyalty_bonus" value="{{ old('value_of_the_loyalty_bonus', $driverClass->value_of_the_loyalty_bonus) }}" step="0.01">
                            @if($errors->has('value_of_the_loyalty_bonus'))
                                <span class="help-block" role="alert">{{ $errors->first('value_of_the_loyalty_bonus') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.driverClass.fields.value_of_the_loyalty_bonus_helper') }}</span>
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