@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.formInput.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.form-inputs.update", [$formInput->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group {{ $errors->has('label') ? 'has-error' : '' }}">
                            <label class="required" for="label">{{ trans('cruds.formInput.fields.label') }}</label>
                            <input class="form-control" type="text" name="label" id="label" value="{{ old('label', $formInput->label) }}" required>
                            @if($errors->has('label'))
                                <span class="help-block" role="alert">{{ $errors->first('label') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.formInput.fields.label_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label class="required" for="name">{{ trans('cruds.formInput.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $formInput->name) }}" required>
                            @if($errors->has('name'))
                                <span class="help-block" role="alert">{{ $errors->first('name') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.formInput.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                            <label class="required">{{ trans('cruds.formInput.fields.type') }}</label>
                            @foreach(App\Models\FormInput::TYPE_RADIO as $key => $label)
                                <div>
                                    <input type="radio" id="type_{{ $key }}" name="type" value="{{ $key }}" {{ old('type', $formInput->type) === (string) $key ? 'checked' : '' }} required>
                                    <label for="type_{{ $key }}" style="font-weight: 400">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('type'))
                                <span class="help-block" role="alert">{{ $errors->first('type') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.formInput.fields.type_helper') }}</span>
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