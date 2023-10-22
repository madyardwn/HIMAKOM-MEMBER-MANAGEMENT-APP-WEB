<script type="module">
    $(document).ready(function() {
        const activityLogs = new TemplateCRUD({
            emptyImage: "{{ asset(config('tablar.default.preview.path')) }}",
            subject: 'activity-logs',
            editUrl: "",
            deleteUrl: "",
            submitAddUrl: "",
            submitEditUrl: "",
            tableDataUrl: "{{ route('logs.activity-logs.index') }}",
            columns: [{ // datatable columns configuration
                    title: 'No',
                    data: null,
                    orderable: false,
                    searchable: false,
                    responsivePriority: 1,
                    width: '1%',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { title: 'Log Name', data: 'log_name', name: 'log_name', responsivePriority: 2, width: '5%' },
                { title: 'Causer', data: 'causer.name', name: 'causer.name', responsivePriority: 2, width: '5%' },        
                { title: 'Description', data: 'description', name: 'description', responsivePriority: 2, width: '5%' },
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
                    width: '5%',
                    render: (data) => moment(data).format('DD MMMM YYYY HH:mm:ss')
                },
            ],
        });

        activityLogs.init();
    });
</script>