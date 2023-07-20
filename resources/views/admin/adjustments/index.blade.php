@extends('layouts.admin')
@section('content')
<div class="content">
    @can('adjustment_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.adjustments.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.adjustment.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.adjustment.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Adjustment">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('cruds.adjustment.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.adjustment.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.adjustment.fields.type') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.adjustment.fields.apply') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($adjustments as $key => $adjustment)
                                    <tr data-entry-id="{{ $adjustment->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $adjustment->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $adjustment->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\Adjustment::TYPE_RADIO[$adjustment->type] ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\Adjustment::APPLY_RADIO[$adjustment->apply] ?? '' }}
                                        </td>
                                        <td>
                                            @can('adjustment_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.adjustments.show', $adjustment->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('adjustment_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.adjustments.edit', $adjustment->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('adjustment_delete')
                                                <form action="{{ route('admin.adjustments.destroy', $adjustment->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('adjustment_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.adjustments.massDestroy') }}",
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
  let table = $('.datatable-Adjustment:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection