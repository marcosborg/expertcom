@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab"
                            data-toggle="tab">Por pagar</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab"
                            data-toggle="tab">Pagos</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                {{ trans('cruds.myReceipt.title') }}
                            </div>
                            <div class="panel-body">
                                <table class=" table table-bordered table-striped table-hover"
                                    id="datatable-My-Receipt1">
                                    <thead>
                                        <tr>
                                            <th>
                                                Condutor
                                            </th>
                                            <th>
                                                Data
                                            </th>
                                            <th>
                                                {{ trans('cruds.receipt.fields.value') }}
                                            </th>
                                            <th>
                                                {{ trans('cruds.receipt.fields.file') }}
                                            </th>
                                            <th>
                                                Pago
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($receipts1 as $receipt)
                                        <tr>
                                            <td>{{ $receipt->driver->name ?? '' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($receipt->created_at)->format('d-m-Y') }}</td>
                                            <td>{{ $receipt->value }}</td>
                                            <td><a target="_new"
                                                    href="{{ $receipt->file ? $receipt->file->getUrl() : '' }}">Ver
                                                    recibo</a></td>
                                            <td style="text-align: center;">
                                                <input {{ !$company ? 'disabled' : '' }} type="checkbox" {{ $receipt->paid ? 'checked' : '' }}
                                                onclick="payReceipt({{ $receipt->id }}, this)">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                {{ trans('cruds.myReceipt.title') }}
                            </div>
                            <div class="panel-body">
                                <table class=" table table-bordered table-striped table-hover"
                                    id="datatable-My-Receipt2">
                                    <thead>
                                        <tr>
                                            <th>
                                                Condutor
                                            </th>
                                            <th>
                                                Data
                                            </th>
                                            <th>
                                                {{ trans('cruds.receipt.fields.value') }}
                                            </th>
                                            <th>
                                                {{ trans('cruds.receipt.fields.file') }}
                                            </th>
                                            <th>
                                                Pago
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($receipts2 as $receipt)
                                        <tr>
                                            <td>{{ $receipt->driver->name ?? '' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($receipt->created_at)->format('d-m-Y') }}</td>
                                            <td>{{ $receipt->value }}</td>
                                            <td><a target="_new"
                                                    href="{{ $receipt->file ? $receipt->file->getUrl() : '' }}">Ver
                                                    recibo</a></td>
                                            <td style="text-align: center;">
                                                <input {{ !$company ? 'disabled' : '' }} type="checkbox" {{ $receipt->paid ? 'checked' : '' }}
                                                onclick="payReceipt({{ $receipt->id }}, this)">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    $('#datatable-My-Receipt1').DataTable();
        payReceipt = (receipt_id, element) => {
            if ($(element).is(':checked')) {
                $.get('/admin/my-receipts/pay-receipt/' + receipt_id + '/' + 1).then((resp) => {
                    console.log(resp);
                });
            } else {
                $.get('/admin/my-receipts/pay-receipt/' + receipt_id + '/' + 0);
            }
        }
        $('#datatable-My-Receipt2').DataTable();
        payReceipt = (receipt_id, element) => {
            if ($(element).is(':checked')) {
                $.get('/admin/my-receipts/pay-receipt/' + receipt_id + '/' + 1).then((resp) => {
                    console.log(resp);
                });
            } else {
                $.get('/admin/my-receipts/pay-receipt/' + receipt_id + '/' + 0);
            }
        }
</script>
@endsection