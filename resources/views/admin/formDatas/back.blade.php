@extends('layouts.admin')
@section('content')
<div class="content">
    @can('form_data_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.form-datas.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.formData.title_singular') }}
            </a>
        </div>
    </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.formData.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-FormData">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('cruds.formData.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.formData.fields.form_name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.formData.fields.driver') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.formData.fields.vehicle_item') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.formData.fields.data') }}
                                    </th>
                                    <th>
                                        {{ trans('global.created_at') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($formDatas as $key => $formData)
                                <tr data-entry-id="{{ $formData->id }}">
                                    <td>

                                    </td>
                                    <td>
                                        {{ $formData->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $formData->form_name->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $formData->driver->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $formData->vehicle_item->license_plate ?? '' }}
                                    </td>
                                    <td>
                                        @foreach (json_decode($formData->data) as $label => $value)
                                        <label>{{ $label }}: </label> {{ $value }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $formData->created_at }}
                                    </td>
                                    <td>
                                        @can('form_data_show')
                                        <a class="btn btn-xs btn-primary"
                                            href="{{ route('admin.form-datas.show', $formData->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                        @endcan

                                        @can('form_data_edit')
                                        <a class="btn btn-xs btn-info"
                                            href="{{ route('admin.form-datas.edit', $formData->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                        @endcan

                                        @can('form_data_delete')
                                        <form action="{{ route('admin.form-datas.destroy', $formData->id) }}"
                                            method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger"
                                                value="{{ trans('global.delete') }}">
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
@can('form_data_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.form-datas.massDestroy') }}",
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
  let table = $('.datatable-FormData:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection