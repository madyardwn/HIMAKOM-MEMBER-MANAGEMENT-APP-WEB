<script type="module">
    class ActivityLogs {
        constructor() {
            this.table = $('#table-activity-logs');
            this.tableDataUrl = "{{ route('logs.activity-logs.index') }}";
            this.tableColumns = [{ // datatable columns configuration
                    title: 'No',
                    data: null,
                    orderable: false,
                    searchable: false,
                    responsivePriority: 1,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    title: 'Log Name',
                    data: 'log_name',
                    name: 'log_name',
                    responsivePriority: 2,
                    width: '5%'
                },
                {
                    title: 'Causer',
                    data: 'causer.name',
                    name: 'causer.name',
                    responsivePriority: 2,
                },
                {
                    title: 'Description',
                    data: 'description',
                    name: 'description',
                    responsivePriority: 2,
                },
                {
                    data: 'properties',
                    name: 'properties',
                    title: 'Properties',
                    responsivePriority: 4,
                    render: (data) => {
                        return `<pre class="mb-0">${JSON.stringify(data, null, 2)}</pre>`;
                    }
                },
                {
                    title: 'Created At',
                    data: 'created_at',
                    name: 'created_at',
                    responsivePriority: 3,
                    width: '20%',
                    render: (data) => moment(data).format('DD MMMM YYYY HH:mm:ss')
                },
            ];
        }

        initDtTtable() {
            this.table.DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: this.tableDataUrl,
                columns: this.tableColumns,
                order: [
                    [5, 'desc']
                ],
            });
        }
    }

    $(document).ready(function() {
        const activityLogs = new ActivityLogs();
        activityLogs.initDtTtable();
    });
</script>
