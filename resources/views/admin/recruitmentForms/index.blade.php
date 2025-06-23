@extends('layouts.admin')
@section('content')
<div class="content">
    @can('recruitment_form_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.recruitment-forms.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.recruitmentForm.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.recruitmentForm.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-RecruitmentForm">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('cruds.recruitmentForm.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.recruitmentForm.fields.user') }}
                                </th>
                                <th>
                                    {{ trans('cruds.recruitmentForm.fields.company') }}
                                </th>
                                <th>
                                    {{ trans('cruds.recruitmentForm.fields.name') }}
                                </th>
                                <th>
                                    {{ trans('cruds.recruitmentForm.fields.email') }}
                                </th>
                                <th>
                                    {{ trans('cruds.recruitmentForm.fields.cv') }}
                                </th>
                                <th>
                                    {{ trans('cruds.recruitmentForm.fields.contact_successfully') }}
                                </th>
                                <th>
                                    {{ trans('cruds.recruitmentForm.fields.phone') }}
                                </th>
                                <th>
                                    {{ trans('cruds.recruitmentForm.fields.scheduled_interview') }}
                                </th>
                                <th>
                                    {{ trans('cruds.recruitmentForm.fields.appointment') }}
                                </th>
                                <th>
                                    {{ trans('cruds.recruitmentForm.fields.done') }}
                                </th>
                                <th>
                                    {{ trans('cruds.recruitmentForm.fields.status') }}
                                </th>
                                <th>
                                    {{ trans('cruds.recruitmentForm.fields.type') }}
                                </th>
                                <th>
                                    {{ trans('cruds.recruitmentForm.fields.chanel') }}
                                </th>
                                <th>
                                    {{ trans('cruds.recruitmentForm.fields.start_time') }}
                                </th>
                                <th>
                                    {{ trans('cruds.recruitmentForm.fields.end_time') }}
                                </th>
                                <th>
                                    {{ trans('cruds.recruitmentForm.fields.day_off') }}
                                </th>
                                <th>
                                    {{ trans('cruds.recruitmentForm.fields.amount_to_pay') }}
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
                                        @foreach($companies as $key => $item)
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
                                </td>
                                <td>
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                </td>
                                <td>
                                    <select class="search" strict="true">
                                        <option value>{{ trans('global.all') }}</option>
                                        @foreach(App\Models\RecruitmentForm::STATUS_RADIO as $key => $item)
                                            <option value="{{ $key }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="search" strict="true">
                                        <option value>{{ trans('global.all') }}</option>
                                        @foreach(App\Models\RecruitmentForm::TYPE_RADIO as $key => $item)
                                            <option value="{{ $key }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="search" strict="true">
                                        <option value>{{ trans('global.all') }}</option>
                                        @foreach(App\Models\RecruitmentForm::CHANEL_RADIO as $key => $item)
                                            <option value="{{ $key }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                    <select class="search" strict="true">
                                        <option value>{{ trans('global.all') }}</option>
                                        @foreach(App\Models\RecruitmentForm::DAY_OFF_RADIO as $key => $item)
                                            <option value="{{ $key }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
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
@can('recruitment_form_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.recruitment-forms.massDestroy') }}",
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
    ajax: "{{ route('admin.recruitment-forms.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'user_name', name: 'user.name' },
{ data: 'company_name', name: 'company.name' },
{ data: 'name', name: 'name' },
{ data: 'email', name: 'email' },
{ data: 'cv', name: 'cv', sortable: false, searchable: false },
{ data: 'contact_successfully', name: 'contact_successfully' },
{ data: 'phone', name: 'phone' },
{ data: 'scheduled_interview', name: 'scheduled_interview' },
{ data: 'appointment', name: 'appointment' },
{ data: 'done', name: 'done' },
{ data: 'status', name: 'status' },
{ data: 'type', name: 'type' },
{ data: 'chanel', name: 'chanel' },
{ data: 'start_time', name: 'start_time' },
{ data: 'end_time', name: 'end_time' },
{ data: 'day_off', name: 'day_off' },
{ data: 'amount_to_pay', name: 'amount_to_pay' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-RecruitmentForm').DataTable(dtOverrideGlobals);
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

</script>
@endsection