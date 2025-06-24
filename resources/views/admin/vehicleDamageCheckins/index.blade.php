@extends('layouts.admin')
@section('content')
<div class="content">
    @can('vehicle_damage_checkin_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.vehicle-damage-checkins.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.vehicleDamageCheckin.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.vehicleDamageCheckin.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-VehicleDamageCheckin">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('cruds.vehicleDamageCheckin.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.vehicleDamageCheckin.fields.vehicle_manage_checkin') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.vehicleDamageCheckin.fields.driver_warning') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.vehicleDamageCheckin.fields.company_warning') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.vehicleDamageCheckin.fields.admin_warning') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.vehicleDamageCheckin.fields.created_at') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vehicleDamageCheckins as $key => $vehicleDamageCheckin)
                                    <tr data-entry-id="{{ $vehicleDamageCheckin->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $vehicleDamageCheckin->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $vehicleDamageCheckin->vehicle_manage_checkin->data_e_horario ?? '' }}
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $vehicleDamageCheckin->driver_warning ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $vehicleDamageCheckin->driver_warning ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $vehicleDamageCheckin->company_warning ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $vehicleDamageCheckin->company_warning ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $vehicleDamageCheckin->admin_warning ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $vehicleDamageCheckin->admin_warning ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            {{ $vehicleDamageCheckin->created_at ?? '' }}
                                        </td>
                                        <td>
                                            @can('vehicle_damage_checkin_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.vehicle-damage-checkins.show', $vehicleDamageCheckin->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('vehicle_damage_checkin_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.vehicle-damage-checkins.edit', $vehicleDamageCheckin->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('vehicle_damage_checkin_delete')
                                                <form action="{{ route('admin.vehicle-damage-checkins.destroy', $vehicleDamageCheckin->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('vehicle_damage_checkin_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.vehicle-damage-checkins.massDestroy') }}",
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
  let table = $('.datatable-VehicleDamageCheckin:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection