@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.weeklyExpense.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.weekly-expenses.update", [$weeklyExpense->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                            <label class="required" for="company_id">{{ trans('cruds.weeklyExpense.fields.company') }}</label>
                            <select class="form-control select2" name="company_id" id="company_id" required>
                                @foreach($companies as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('company_id') ? old('company_id') : $weeklyExpense->company->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('company'))
                                <span class="help-block" role="alert">{{ $errors->first('company') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.weeklyExpense.fields.company_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('tvde_week') ? 'has-error' : '' }}">
                            <label class="required" for="tvde_week_id">{{ trans('cruds.weeklyExpense.fields.tvde_week') }}</label>
                            <select class="form-control select2" name="tvde_week_id" id="tvde_week_id" required>
                                @foreach($tvde_weeks as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('tvde_week_id') ? old('tvde_week_id') : $weeklyExpense->tvde_week->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('tvde_week'))
                                <span class="help-block" role="alert">{{ $errors->first('tvde_week') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.weeklyExpense.fields.tvde_week_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('expenses') ? 'has-error' : '' }}">
                            <label class="required" for="expenses">{{ trans('cruds.weeklyExpense.fields.expenses') }}</label>
                            <textarea class="form-control" name="expenses" id="expenses" required>{{ old('expenses', $weeklyExpense->expenses) }}</textarea>
                            @if($errors->has('expenses'))
                                <span class="help-block" role="alert">{{ $errors->first('expenses') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.weeklyExpense.fields.expenses_helper') }}</span>
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