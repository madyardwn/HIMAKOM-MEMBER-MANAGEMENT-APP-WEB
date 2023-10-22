<script type="module">        
    $(document).ready(function () {        
        const cabinet = new TemplateCRUD({
            emptyImage: "{{ asset(config('tablar.default.preview.path')) }}",
            editUrl: "{{ route('periodes.events.edit', ':id') }}",
            deleteUrl: "{{ route('periodes.events.destroy', ':id') }}",
            submitAddUrl: "{{ route('periodes.events.store') }}",
            submitEditUrl: "{{ route('periodes.events.update', ':id') }}",
            tableDataUrl: "{{ route('periodes.events.index') }}",
            subject: 'events',
            columns: [{ 
                    title: 'No',
                    data: null,
                    orderable: false,
                    searchable: false,
                    responsivePriority: 1,
                    width: '1%',
                    className: 'dt-center',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'poster',
                    name: 'poster',
                    title: 'Poster',
                    orderable: false,
                    searchable: false,
                    responsivePriority: 1,
                    width: '10%',
                    render: function(data, type, row) {
                        return `<img src="${data}" alt="Logo" class="img-fluid" width="100">`;
                    }
                },
                { data: 'name', name: 'name', title: 'Name', responsivePriority: 1, width: '10%' },
                { data: 'description', name: 'description', title: 'Description', width: '10%' },
                { data: 'date', name: 'date', title: 'Date', width: '10%' },
                { data: 'time', name: 'time', title: 'Time', width: '10%' },
                { data: 'location', name: 'location', title: 'Location', width: '10%' },
                { data: 'type', name: 'type', title: 'Type', width: '10%' },                
                {
                    data: 'is_active',
                    name: 'is_active',
                    title: 'Status',
                    width: '20%',
                    responsivePriority: 1,
                    render: function(data, type, row) {
                        return data == 1 ? `<span class="badge bg-blue-lt">Active</span>` : `<span class="badge bg-red-lt">Inactive</span>`;
                    }
                },
                {
                    data: null,
                    title: 'Action',
                    orderable: false,
                    searchable: false,
                    responsivePriority: 1,
                    width: '1%',
                    render: function(data, type, row) {
                        let html = '';
                        html = `
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu">                                    
                                    <li><a class="dropdown-item btn-edit" href="" data-id="${data.id}" data-bs-toggle="modal" data-bs-target="#modal-edit-events"><i class="ti ti-pencil"></i>&nbsp; Edit</a></li>
                                    <li><a class="dropdown-item btn-delete" href="" data-id="${data.id}"><i class="ti ti-trash"></i>&nbsp; Delete</a></li>
                                </ul>
                            </div>
                        `;
                        return html;
                    }
                },
            ]
        });

        cabinet.init();
    });
</script>