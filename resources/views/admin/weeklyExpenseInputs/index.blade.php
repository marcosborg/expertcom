@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.weeklyExpenseInput.title') }}
                </div>
                <div class="panel-body">
                    @if ($company_id != 0)
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Semana</label>
                                <select name="tvde_week_id" class="form-control select2">
                                    <option selected disabled>Selecionar semana</option>
                                    @foreach ($tvde_weeks as $tvde_week)
                                    <option {{ $tvde_week->id == $tvde_week_id ? 'selected' : '' }} value="{{
                                        $tvde_week->id
                                        }}">{{ $tvde_week->start_date }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @foreach ($company_expenses as $company_expense)
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Despesa</label>
                                <input type="text" disabled value="{{ $company_expense->name }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Quantidade</label>
                                <input type="number" min="0" class="form-control" name="qty">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Semanal</label>
                            <input type="text" class="form-control" disabled
                                value="{{ $company_expense->weekly_value }} €">
                        </div>
                    </div>
                    @endforeach
                    <div class="form-group">
                        <button class="btn btn-success">Gravar despesas</button>
                    </div>
                    @if (!$weekly_expense)
                    <div class="alert alert-info">
                        Ainda não foram gravadas as despesas desta semana
                    </div>
                    @endif
                    @else
                    <div class="alert alert-info">
                        Deve selecionar uma empresa.
                    </div>
                    @endif
                </div>
            </div>



        </div>
    </div>
</div>
@endsection
<script>
    console.log({!! $company_expenses !!})
</script>