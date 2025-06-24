@extends('layouts.admin')
@section('content')
<div class="content">
    @can('vehicle_manage_checkin_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.vehicle-manage-checkins.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.vehicleManageCheckin.title_singular') }}
                </a>
                <div class="pull-right">
                    <a class="btn btn-sm btn-primary" href="/admin/vehicle-manage-checkins">
                        Ver todos
                    </a>
                    <a class="btn btn-sm btn-info" href="/admin/vehicle-manage-checkins?reparado=0">
                        Não reparados
                    </a>
                    <a class="btn btn-sm btn-warning" href="/admin/vehicle-manage-checkins?reparado=1">
                        Reparados
                    </a>
                </div>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.vehicleManageCheckin.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-VehicleManageCheckin">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('cruds.vehicleManageCheckin.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vehicleManageCheckin.fields.user') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vehicleManageCheckin.fields.vehicle_item') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vehicleManageCheckin.fields.driver') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vehicleManageCheckin.fields.data_e_horario') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vehicleManageCheckin.fields.bateria_a_chegada') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vehicleManageCheckin.fields.km_atual') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vehicleManageCheckin.fields.tratado') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vehicleManageCheckin.fields.reparado') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vehicleManageCheckin.fields.signature_collector_data') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vehicleManageCheckin.fields.signature_driver_data') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <select class="search">
                                        <option value>{{ trans('global.all') }}</option>
                                        @foreach($users as $key => $item)
                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="search">
                                        <option value>{{ trans('global.all') }}</option>
                                        @foreach($vehicle_items as $key => $item)
                                            <option value="{{ $item->license_plate }}">{{ $item->license_plate }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="search">
                                        <option value>{{ trans('global.all') }}</option>
                                        @foreach($drivers as $key => $item)
                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                </td>
                            </tr>
                        </thead>
                    </table>
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
@can('vehicle_manage_checkin_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.vehicle-manage-checkins.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: {
        url: "{{ route('admin.vehicle-manage-checkins.index') }}",
        data: function (d) {
            d.reparado = getQueryParam('reparado'); // aqui é o truque
        }
    },
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'user_name', name: 'user.name' },
{ data: 'vehicle_item_license_plate', name: 'vehicle_item.license_plate' },
{ data: 'driver_name', name: 'driver.name' },
{ data: 'data_e_horario', name: 'data_e_horario' },
{ data: 'bateria_a_chegada', name: 'bateria_a_chegada' },
{ data: 'km_atual', name: 'km_atual' },
{ data: 'tratado', name: 'tratado' },
{ data: 'reparado', name: 'reparado' },
{ data: 'signature_collector_data', name: 'signature_collector_data' },
{ data: 'signature_driver_data', name: 'signature_driver_data' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-VehicleManageCheckin').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value

      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
});

function getQueryParam(param) {
    let params = new URLSearchParams(window.location.search);
    return params.get(param);
}


</script>
@endsection