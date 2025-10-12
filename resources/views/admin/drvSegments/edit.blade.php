@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.drvSegment.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.drv-segments.update", [$drvSegment->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group {{ $errors->has('session') ? 'has-error' : '' }}">
                            <label class="required" for="session_id">{{ trans('cruds.drvSegment.fields.session') }}</label>
                            <select class="form-control select2" name="session_id" id="session_id" required>
                                @foreach($sessions as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('session_id') ? old('session_id') : $drvSegment->session->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('session'))
                                <span class="help-block" role="alert">{{ $errors->first('session') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvSegment.fields.session_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('kind') ? 'has-error' : '' }}">
                            <label class="required">{{ trans('cruds.drvSegment.fields.kind') }}</label>
                            @foreach(App\Models\DrvSegment::KIND_RADIO as $key => $label)
                                <div>
                                    <input type="radio" id="kind_{{ $key }}" name="kind" value="{{ $key }}" {{ old('kind', $drvSegment->kind) === (string) $key ? 'checked' : '' }} required>
                                    <label for="kind_{{ $key }}" style="font-weight: 400">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('kind'))
                                <span class="help-block" role="alert">{{ $errors->first('kind') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvSegment.fields.kind_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('started_at') ? 'has-error' : '' }}">
                            <label class="required" for="started_at">{{ trans('cruds.drvSegment.fields.started_at') }}</label>
                            <input class="form-control datetime" type="text" name="started_at" id="started_at" value="{{ old('started_at', $drvSegment->started_at) }}" required>
                            @if($errors->has('started_at'))
                                <span class="help-block" role="alert">{{ $errors->first('started_at') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvSegment.fields.started_at_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('ended_at') ? 'has-error' : '' }}">
                            <label for="ended_at">{{ trans('cruds.drvSegment.fields.ended_at') }}</label>
                            <input class="form-control datetime" type="text" name="ended_at" id="ended_at" value="{{ old('ended_at', $drvSegment->ended_at) }}">
                            @if($errors->has('ended_at'))
                                <span class="help-block" role="alert">{{ $errors->first('ended_at') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvSegment.fields.ended_at_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('duration_seconds') ? 'has-error' : '' }}">
                            <label class="required" for="duration_seconds">{{ trans('cruds.drvSegment.fields.duration_seconds') }}</label>
                            <input class="form-control" type="number" name="duration_seconds" id="duration_seconds" value="{{ old('duration_seconds', $drvSegment->duration_seconds) }}" step="1" required>
                            @if($errors->has('duration_seconds'))
                                <span class="help-block" role="alert">{{ $errors->first('duration_seconds') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvSegment.fields.duration_seconds_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('notes') ? 'has-error' : '' }}">
                            <label for="notes">{{ trans('cruds.drvSegment.fields.notes') }}</label>
                            <input class="form-control" type="text" name="notes" id="notes" value="{{ old('notes', $drvSegment->notes) }}">
                            @if($errors->has('notes'))
                                <span class="help-block" role="alert">{{ $errors->first('notes') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvSegment.fields.notes_helper') }}</span>
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