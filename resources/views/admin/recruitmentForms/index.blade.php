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
                <div class="panel-heading d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        {{ trans('cruds.recruitmentForm.title_singular') }} {{ trans('global.list') }}
                    </div>
                    <div class="btn-group" role="group" aria-label="Status filter">
                        <button type="button" class="btn btn-secondary filter-status" data-status="">Todos</button>
                        @foreach($status as $key => $label)
                            <button type="button" class="btn btn-secondary filter-status" data-status="{{ $key }}">{{ $label }}</button>
                        @endforeach
                    </div>
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
                                    {{ trans('cruds.recruitmentForm.fields.created_at') }}
                                </th>
                                <th>
                                    {{ trans('cruds.recruitmentForm.fields.updated_at') }}
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
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);

        @can('recruitment_form_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.recruitment-forms.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                    return entry.id;
                });

                if (ids.length === 0) {
                    alert('{{ trans('global.datatables.zero_selected') }}');
                    return;
                }

                if (confirm('{{ trans('global.areYouSure') }}')) {
                    $.ajax({
                        headers: { 'x-csrf-token': _token },
                        method: 'POST',
                        url: config.url,
                        data: { ids: ids, _method: 'DELETE' }
                    }).done(function () { location.reload(); });
                }
            }
        };
        dtButtons.push(deleteButton);
        @endcan

        let dtOverrideGlobals = {
            buttons: dtButtons,
            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            ajax: {
                url: "{{ route('admin.recruitment-forms.index') }}",
                data: function (d) {
                    d.status = $('.filter-status.active').data('status');
                }
            },
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
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'actions', name: '{{ trans('global.actions') }}' }
            ],
            orderCellsTop: true,
            order: [[1, 'desc']],
            pageLength: 100,
        };

        let table = $('.datatable-RecruitmentForm').DataTable(dtOverrideGlobals);

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

        let visibleColumnsIndexes = null;

        $('.datatable thead').on('input', '.search', function () {
            let strict = $(this).attr('strict') || false;
            let value = strict && this.value ? "^" + this.value + "$" : this.value;

            let index = $(this).parent().index();
            if (visibleColumnsIndexes !== null) {
                index = visibleColumnsIndexes[index];
            }

            table.column(index).search(value, strict).draw();
        });

        table.on('column-visibility.dt', function (e, settings, column, state) {
            visibleColumnsIndexes = [];
            table.columns(":visible").every(function (colIdx) {
                visibleColumnsIndexes.push(colIdx);
            });
        });

        $('.filter-status').on('click', function () {
            $('.filter-status').removeClass('active');
            $(this).addClass('active');
            table.ajax.reload();
        });
    });
</script>

@endsection