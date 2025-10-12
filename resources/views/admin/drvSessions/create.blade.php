@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.create') }} {{ trans('cruds.drvSession.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.drv-sessions.store") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group {{ $errors->has('driver') ? 'has-error' : '' }}">
                            <label class="required" for="driver_id">{{ trans('cruds.drvSession.fields.driver') }}</label>
                            <select class="form-control select2" name="driver_id" id="driver_id" required>
                                @foreach($drivers as $id => $entry)
                                    <option value="{{ $id }}" {{ old('driver_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('driver'))
                                <span class="help-block" role="alert">{{ $errors->first('driver') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvSession.fields.driver_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('started_at') ? 'has-error' : '' }}">
                            <label class="required" for="started_at">{{ trans('cruds.drvSession.fields.started_at') }}</label>
                            <input class="form-control datetime" type="text" name="started_at" id="started_at" value="{{ old('started_at') }}" required>
                            @if($errors->has('started_at'))
                                <span class="help-block" role="alert">{{ $errors->first('started_at') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvSession.fields.started_at_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('ended_at') ? 'has-error' : '' }}">
                            <label for="ended_at">{{ trans('cruds.drvSession.fields.ended_at') }}</label>
                            <input class="form-control datetime" type="text" name="ended_at" id="ended_at" value="{{ old('ended_at') }}">
                            @if($errors->has('ended_at'))
                                <span class="help-block" role="alert">{{ $errors->first('ended_at') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvSession.fields.ended_at_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                            <label class="required">{{ trans('cruds.drvSession.fields.status') }}</label>
                            @foreach(App\Models\DrvSession::STATUS_RADIO as $key => $label)
                                <div>
                                    <input type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}" {{ old('status', 'running') === (string) $key ? 'checked' : '' }} required>
                                    <label for="status_{{ $key }}" style="font-weight: 400">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('status'))
                                <span class="help-block" role="alert">{{ $errors->first('status') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvSession.fields.status_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('total_drive_seconds') ? 'has-error' : '' }}">
                            <label class="required" for="total_drive_seconds">{{ trans('cruds.drvSession.fields.total_drive_seconds') }}</label>
                            <input class="form-control" type="number" name="total_drive_seconds" id="total_drive_seconds" value="{{ old('total_drive_seconds', '0') }}" step="1" required>
                            @if($errors->has('total_drive_seconds'))
                                <span class="help-block" role="alert">{{ $errors->first('total_drive_seconds') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvSession.fields.total_drive_seconds_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('total_pause_seconds') ? 'has-error' : '' }}">
                            <label class="required" for="total_pause_seconds">{{ trans('cruds.drvSession.fields.total_pause_seconds') }}</label>
                            <input class="form-control" type="number" name="total_pause_seconds" id="total_pause_seconds" value="{{ old('total_pause_seconds', '0') }}" step="1" required>
                            @if($errors->has('total_pause_seconds'))
                                <span class="help-block" role="alert">{{ $errors->first('total_pause_seconds') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvSession.fields.total_pause_seconds_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('started_lat') ? 'has-error' : '' }}">
                            <label for="started_lat">{{ trans('cruds.drvSession.fields.started_lat') }}</label>
                            <input class="form-control" type="number" name="started_lat" id="started_lat" value="{{ old('started_lat', '') }}" step="0.0000001">
                            @if($errors->has('started_lat'))
                                <span class="help-block" role="alert">{{ $errors->first('started_lat') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvSession.fields.started_lat_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('started_lng') ? 'has-error' : '' }}">
                            <label for="started_lng">{{ trans('cruds.drvSession.fields.started_lng') }}</label>
                            <input class="form-control" type="number" name="started_lng" id="started_lng" value="{{ old('started_lng', '') }}" step="0.0000001">
                            @if($errors->has('started_lng'))
                                <span class="help-block" role="alert">{{ $errors->first('started_lng') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvSession.fields.started_lng_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('ended_lat') ? 'has-error' : '' }}">
                            <label for="ended_lat">{{ trans('cruds.drvSession.fields.ended_lat') }}</label>
                            <input class="form-control" type="number" name="ended_lat" id="ended_lat" value="{{ old('ended_lat', '') }}" step="0.0000001">
                            @if($errors->has('ended_lat'))
                                <span class="help-block" role="alert">{{ $errors->first('ended_lat') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvSession.fields.ended_lat_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('ended_lng') ? 'has-error' : '' }}">
                            <label for="ended_lng">{{ trans('cruds.drvSession.fields.ended_lng') }}</label>
                            <input class="form-control" type="number" name="ended_lng" id="ended_lng" value="{{ old('ended_lng', '') }}" step="0.0000001">
                            @if($errors->has('ended_lng'))
                                <span class="help-block" role="alert">{{ $errors->first('ended_lng') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvSession.fields.ended_lng_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('source') ? 'has-error' : '' }}">
                            <label>{{ trans('cruds.drvSession.fields.source') }}</label>
                            @foreach(App\Models\DrvSession::SOURCE_RADIO as $key => $label)
                                <div>
                                    <input type="radio" id="source_{{ $key }}" name="source" value="{{ $key }}" {{ old('source', 'app') === (string) $key ? 'checked' : '' }}>
                                    <label for="source_{{ $key }}" style="font-weight: 400">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('source'))
                                <span class="help-block" role="alert">{{ $errors->first('source') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvSession.fields.source_helper') }}</span>
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