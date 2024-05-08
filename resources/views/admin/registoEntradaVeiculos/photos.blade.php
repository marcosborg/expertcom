@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Viatura
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">

        </div>
    </div>
</div>
@endsection
<script>console.log({
    vehicle_item: {!! $vehicle_item !!},
    medias: {!! $medias !!}
})</script>