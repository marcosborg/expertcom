@extends('layouts.admin')
@section('content')
<div class="content">
    @can('vehicle_entry_record_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.vehicle-entry-records.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.vehicleEntryRecord.title_singular') }}
                </a>
                <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans('global.app_csvImport') }}
                </button>
                @include('csvImport.modal', ['model' => 'VehicleEntryRecord', 'route' => 'admin.vehicle-entry-records.parseCsvImport'])
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.vehicleEntryRecord.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-VehicleEntryRecord">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('cruds.vehicleEntryRecord.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vehicleEntryRecord.fields.date_time') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vehicleEntryRecord.fields.user') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vehicleEntryRecord.fields.driver') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vehicleEntryRecord.fields.vehicle') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vehicleEntryRecord.fields.battery_enter') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vehicleEntryRecord.fields.battery_exit') }}
                                </th>
                                <th>
                                    {{ trans('cruds.vehicleEntryRecord.fields.quilometers') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
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
@can('vehicle_entry_record_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.vehicle-entry-records.massDestroy') }}",
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
    ajax: "{{ route('admin.vehicle-entry-records.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'date_time', name: 'date_time' },
{ data: 'user_name', name: 'user.name' },
{ data: 'driver_name', name: 'driver.name' },
{ data: 'vehicle_license_plate', name: 'vehicle.license_plate' },
{ data: 'battery_enter', name: 'battery_enter' },
{ data: 'battery_exit', name: 'battery_exit' },
{ data: 'quilometers', name: 'quilometers' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-VehicleEntryRecord').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection