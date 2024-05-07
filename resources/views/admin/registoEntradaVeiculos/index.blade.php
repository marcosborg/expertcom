@extends('layouts.admin')
@section('content')
<div class="content">
    @can('registo_entrada_veiculo_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.registo-entrada-veiculos.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.registoEntradaVeiculo.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.registoEntradaVeiculo.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-RegistoEntradaVeiculo">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.data_e_horario') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.user') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.driver') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.vehicle_item') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.bateria_a_chegada') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.de_bateria_de_saida') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.km_atual') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registoEntradaVeiculos as $key => $registoEntradaVeiculo)
                                    <tr data-entry-id="{{ $registoEntradaVeiculo->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $registoEntradaVeiculo->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $registoEntradaVeiculo->data_e_horario ?? '' }}
                                        </td>
                                        <td>
                                            {{ $registoEntradaVeiculo->user->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $registoEntradaVeiculo->driver->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $registoEntradaVeiculo->vehicle_item->license_plate ?? '' }}
                                        </td>
                                        <td>
                                            {{ $registoEntradaVeiculo->bateria_a_chegada ?? '' }}
                                        </td>
                                        <td>
                                            {{ $registoEntradaVeiculo->de_bateria_de_saida ?? '' }}
                                        </td>
                                        <td>
                                            {{ $registoEntradaVeiculo->km_atual ?? '' }}
                                        </td>
                                        <td>
                                            @can('registo_entrada_veiculo_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.registo-entrada-veiculos.show', $registoEntradaVeiculo->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('registo_entrada_veiculo_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.registo-entrada-veiculos.edit', $registoEntradaVeiculo->id) }}?step=1">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('registo_entrada_veiculo_delete')
                                                <form action="{{ route('admin.registo-entrada-veiculos.destroy', $registoEntradaVeiculo->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                            @endcan

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
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('registo_entrada_veiculo_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.registo-entrada-veiculos.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-RegistoEntradaVeiculo:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection