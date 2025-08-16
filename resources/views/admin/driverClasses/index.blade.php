@extends('layouts.admin')
@section('content')
<div class="content">
    @can('driver_class_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.driver-classes.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.driverClass.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.driverClass.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-DriverClass">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('cruds.driverClass.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.driverClass.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.driverClass.fields.from') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.driverClass.fields.to') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.driverClass.fields.minimum_value') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.driverClass.fields.additional_commission') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.driverClass.fields.time_for_loyalty_bonus') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.driverClass.fields.value_of_the_loyalty_bonus') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($driverClasses as $key => $driverClass)
                                    <tr data-entry-id="{{ $driverClass->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $driverClass->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $driverClass->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $driverClass->from ?? '' }}
                                        </td>
                                        <td>
                                            {{ $driverClass->to ?? '' }}
                                        </td>
                                        <td>
                                            {{ $driverClass->minimum_value ?? '' }}
                                        </td>
                                        <td>
                                            {{ $driverClass->additional_commission ?? '' }}
                                        </td>
                                        <td>
                                            {{ $driverClass->time_for_loyalty_bonus ?? '' }}
                                        </td>
                                        <td>
                                            {{ $driverClass->value_of_the_loyalty_bonus ?? '' }}
                                        </td>
                                        <td>
                                            @can('driver_class_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.driver-classes.show', $driverClass->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('driver_class_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.driver-classes.edit', $driverClass->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('driver_class_delete')
                                                <form action="{{ route('admin.driver-classes.destroy', $driverClass->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('driver_class_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.driver-classes.massDestroy') }}",
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
  let table = $('.datatable-DriverClass:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection