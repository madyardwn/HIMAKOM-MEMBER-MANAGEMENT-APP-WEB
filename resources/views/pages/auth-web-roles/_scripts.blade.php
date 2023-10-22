<script type="module">
    $(document).ready(function() {
        const authWebRoles = new TemplateCRUD({
            emptyImage: "{{ asset(config('tablar.default.preview.path')) }}",
            subject: 'auth-web-roles',
            editUrl: "{{ route('auth-web.roles.edit', ':id') }}",
            deleteUrl: "{{ route('auth-web.roles.destroy', ':id') }}",
            submitAddUrl: "{{ route('auth-web.roles.store') }}",
            submitEditUrl: "{{ route('auth-web.roles.update', ':id') }}", 
            tableDataUrl: "{{ route('auth-web.roles.index') }}",
            columns: [{ // datatable columns configuration
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
                { data: 'name', name: 'name', title: 'Name', responsivePriority: 1, width: '20%' },
                {
                    data: 'permissions',
                    name: 'permissions.name',
                    title: 'Permissions',
                    orderable: false,
                    render: function(data, type, row) {
                        let html = '';
                        data.forEach(function(item, index) {
                            html +=`<span class="badge badge-outline text-blue m-1">${item.name}</span>`;
                        });
                        return html;
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
                        let html = `
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu">                                    
                                    <li><a class="dropdown-item btn-edit" href="" data-id="${data.id}" data-bs-toggle="modal" data-bs-target="#modal-edit-auth-web-roles"><i class="ti ti-pencil"></i>&nbsp; Edit</a></li>
                                    <li><a class="dropdown-item btn-delete" href="" data-id="${data.id}"><i class="ti ti-trash"></i>&nbsp; Delete</a></li>
                                </ul>
                            </div>
                        `;
                        return data.id == 1 ? '' : html;
                    }
                },
            ]
        });         

        authWebRoles.init();
    });
</script>