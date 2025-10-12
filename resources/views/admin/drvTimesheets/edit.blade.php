@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.drvTimesheet.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.drv-timesheets.update", [$drvTimesheet->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group {{ $errors->has('driver') ? 'has-error' : '' }}">
                            <label class="required" for="driver_id">{{ trans('cruds.drvTimesheet.fields.driver') }}</label>
                            <select class="form-control select2" name="driver_id" id="driver_id" required>
                                @foreach($drivers as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('driver_id') ? old('driver_id') : $drvTimesheet->driver->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('driver'))
                                <span class="help-block" role="alert">{{ $errors->first('driver') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvTimesheet.fields.driver_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                            <label class="required" for="date">{{ trans('cruds.drvTimesheet.fields.date') }}</label>
                            <input class="form-control date" type="text" name="date" id="date" value="{{ old('date', $drvTimesheet->date) }}" required>
                            @if($errors->has('date'))
                                <span class="help-block" role="alert">{{ $errors->first('date') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvTimesheet.fields.date_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('total_drive_seconds') ? 'has-error' : '' }}">
                            <label class="required" for="total_drive_seconds">{{ trans('cruds.drvTimesheet.fields.total_drive_seconds') }}</label>
                            <input class="form-control" type="number" name="total_drive_seconds" id="total_drive_seconds" value="{{ old('total_drive_seconds', $drvTimesheet->total_drive_seconds) }}" step="1" required>
                            @if($errors->has('total_drive_seconds'))
                                <span class="help-block" role="alert">{{ $errors->first('total_drive_seconds') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvTimesheet.fields.total_drive_seconds_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('total_pause_seconds') ? 'has-error' : '' }}">
                            <label class="required" for="total_pause_seconds">{{ trans('cruds.drvTimesheet.fields.total_pause_seconds') }}</label>
                            <input class="form-control" type="number" name="total_pause_seconds" id="total_pause_seconds" value="{{ old('total_pause_seconds', $drvTimesheet->total_pause_seconds) }}" step="1" required>
                            @if($errors->has('total_pause_seconds'))
                                <span class="help-block" role="alert">{{ $errors->first('total_pause_seconds') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvTimesheet.fields.total_pause_seconds_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                            <label>{{ trans('cruds.drvTimesheet.fields.status') }}</label>
                            @foreach(App\Models\DrvTimesheet::STATUS_RADIO as $key => $label)
                                <div>
                                    <input type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}" {{ old('status', $drvTimesheet->status) === (string) $key ? 'checked' : '' }}>
                                    <label for="status_{{ $key }}" style="font-weight: 400">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('status'))
                                <span class="help-block" role="alert">{{ $errors->first('status') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.drvTimesheet.fields.status_helper') }}</span>
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