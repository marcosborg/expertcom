@extends('layouts.admin')
@section('content')
<div class="content">
    @can('drv_session_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.drv-sessions.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.drvSession.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.drvSession.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-DrvSession">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('cruds.drvSession.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.drvSession.fields.driver') }}
                                </th>
                                <th>
                                    {{ trans('cruds.drvSession.fields.started_at') }}
                                </th>
                                <th>
                                    {{ trans('cruds.drvSession.fields.ended_at') }}
                                </th>
                                <th>
                                    {{ trans('cruds.drvSession.fields.status') }}
                                </th>
                                <th>
                                    {{ trans('cruds.drvSession.fields.total_drive_seconds') }}
                                </th>
                                <th>
                                    {{ trans('cruds.drvSession.fields.total_pause_seconds') }}
                                </th>
                                <th>
                                    {{ trans('cruds.drvSession.fields.started_lat') }}
                                </th>
                                <th>
                                    {{ trans('cruds.drvSession.fields.started_lng') }}
                                </th>
                                <th>
                                    {{ trans('cruds.drvSession.fields.ended_lat') }}
                                </th>
                                <th>
                                    {{ trans('cruds.drvSession.fields.ended_lng') }}
                                </th>
                                <th>
                                    {{ trans('cruds.drvSession.fields.source') }}
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
@can('drv_session_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.drv-sessions.massDestroy') }}",
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
    ajax: "{{ route('admin.drv-sessions.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'driver_name', name: 'driver.name' },
{ data: 'started_at', name: 'started_at' },
{ data: 'ended_at', name: 'ended_at' },
{ data: 'status', name: 'status' },
{ data: 'total_drive_seconds', name: 'total_drive_seconds' },
{ data: 'total_pause_seconds', name: 'total_pause_seconds' },
{ data: 'started_lat', name: 'started_lat' },
{ data: 'started_lng', name: 'started_lng' },
{ data: 'ended_lat', name: 'ended_lat' },
{ data: 'ended_lng', name: 'ended_lng' },
{ data: 'source', name: 'source' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-DrvSession').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection