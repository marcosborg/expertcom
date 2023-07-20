@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.create') }} {{ trans('cruds.adjustment.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.adjustments.store") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label class="required" for="name">{{ trans('cruds.adjustment.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                            @if($errors->has('name'))
                                <span class="help-block" role="alert">{{ $errors->first('name') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.adjustment.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                            <label class="required">{{ trans('cruds.adjustment.fields.type') }}</label>
                            @foreach(App\Models\Adjustment::TYPE_RADIO as $key => $label)
                                <div>
                                    <input type="radio" id="type_{{ $key }}" name="type" value="{{ $key }}" {{ old('type', 'charge') === (string) $key ? 'checked' : '' }} required>
                                    <label for="type_{{ $key }}" style="font-weight: 400">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('type'))
                                <span class="help-block" role="alert">{{ $errors->first('type') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.adjustment.fields.type_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('apply') ? 'has-error' : '' }}">
                            <label class="required">{{ trans('cruds.adjustment.fields.apply') }}</label>
                            @foreach(App\Models\Adjustment::APPLY_RADIO as $key => $label)
                                <div>
                                    <input type="radio" id="apply_{{ $key }}" name="apply" value="{{ $key }}" {{ old('apply', 'permanent') === (string) $key ? 'checked' : '' }} required>
                                    <label for="apply_{{ $key }}" style="font-weight: 400">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('apply'))
                                <span class="help-block" role="alert">{{ $errors->first('apply') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.adjustment.fields.apply_helper') }}</span>
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