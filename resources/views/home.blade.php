@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Atividade
                </div>
                <div class="panel-body">

                </div>
            </div>
        </div>
        <div class="col-md-6">

        </div>
    </div>

</div>
@endsection
<script>
    console.log({
    bolt_activities: {!! $bolt_activities !!},
    uber_activities: {!! $uber_activities !!},
    adjustments: {!! $adjustments !!},
    tvde_week: {!! $tvde_week !!}
})
</script>