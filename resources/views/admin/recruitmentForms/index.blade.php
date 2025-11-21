@extends('layouts.admin')
@section('content')
<div class="content">
    <style>
        tr.group-row td {
            background: #f7f7f7;
            font-weight: 600;
        }
    </style>
    @can('recruitment_form_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.recruitment-forms.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.recruitmentForm.title_singular') }}
                </a>
                <div class="btn-group" style="margin-left: 6px;">
                    <input type="date" id="start_date_filter" class="form-control input-sm" style="width: 140px; display:inline-block;" placeholder="Data início">
                    <input type="date" id="end_date_filter" class="form-control input-sm" style="width: 140px; display:inline-block;" placeholder="Data fim">
                    <a class="btn btn-default" id="btn-recruitment-report" target="_blank" href="{{ route('admin.recruitment-forms.report') }}">
                        Gerar PDF
                    </a>
                </div>
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
                        <button type="button" class="btn btn-secondary filter-status active" data-status="">Todos</button>
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
                                    {{ trans('cruds.recruitmentForm.fields.responsible_for_the_lead') }}
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
                                    {{ trans('cruds.recruitmentForm.fields.not_recruited_reason') }}
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
        const _token = $('meta[name="csrf-token"]').attr('content');

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
                url: "{{ route('admin.recruitment-forms.datatable') }}",
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': _token },
                data: function (d) {
                    d.status = $('.filter-status.active').data('status') || '';
                }
            },
            columns: [
                { data: 'placeholder', name: 'placeholder' },
                { data: 'id', name: 'id' },
                { data: 'user_name', name: 'user.name' },
                { data: 'company_name', name: 'company.name' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'responsible_for_the_lead', name: 'responsible_for_the_lead' },
                { data: 'contact_successfully', name: 'contact_successfully' },
                { data: 'phone', name: 'phone' },
                { data: 'scheduled_interview', name: 'scheduled_interview' },
                { data: 'appointment', name: 'appointment' },
                { data: 'done', name: 'done' },
                { data: 'status', name: 'status' },
                { data: 'not_recruited_reason', name: 'not_recruited_reason' },
                { data: 'type', name: 'type' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'actions', name: '{{ trans('global.actions') }}' }
            ],
            orderCellsTop: true,
            order: [[12, 'asc'], [1, 'desc']],
            pageLength: 100,
        };

        let table = $('.datatable-RecruitmentForm').DataTable(dtOverrideGlobals);
        const groupColumn = 12;

        table.on('draw', function () {
            const rows = table.rows({ page: 'current' }).nodes();
            let last = null;

            table.column(groupColumn, { page: 'current' }).data().each(function (group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                        '<tr class="group-row"><td colspan="18">' + (group || 'Sem status') + '</td></tr>'
                    );
                    last = group;
                }
            });
        });

        table.draw();

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

        $('#btn-recruitment-report').on('click', function (e) {
            e.preventDefault();
            const baseUrl = $(this).attr('href');
            const status = $('.filter-status.active').data('status') || '';
            const startDate = $('#start_date_filter').val();
            const endDate = $('#end_date_filter').val();

            if (startDate && endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                if (start > end) {
                    alert('A data inicial n\u00e3o pode ser superior \u00e0 data final.');
                    return;
                }
                const diffDays = (end - start) / (1000 * 60 * 60 * 24);
                if (diffDays > 93) {
                    alert('O per\u00edodo m\u00e1ximo \u00e9 de 3 meses.');
                    return;
                }
            }

            const params = [];
            if (status) params.push(`status=${encodeURIComponent(status)}`);
            if (startDate) params.push(`start_date=${encodeURIComponent(startDate)}`);
            if (endDate) params.push(`end_date=${encodeURIComponent(endDate)}`);

            const url = params.length ? `${baseUrl}?${params.join('&')}` : baseUrl;
            window.open(url, '_blank');
        });
    });
</script>

@endsection
