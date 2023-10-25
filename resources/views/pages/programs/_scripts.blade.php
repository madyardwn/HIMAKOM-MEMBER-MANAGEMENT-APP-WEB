<script type="module">
    $(document).ready(function() {
        const program = new TemplateCRUD({
            emptyImage: "{{ asset(config('tablar.default.preview.path')) }}",
            modalAdd: new bootstrap.Modal($(`#modal-add-programs`)),
            modalEdit: new bootstrap.Modal($(`#modal-edit-programs`)),
            editUrl: "{{ route('periodes.programs.edit', ':id') }}",
            deleteUrl: "{{ route('periodes.programs.destroy', ':id') }}",
            submitAddUrl: "{{ route('periodes.programs.store') }}",
            submitEditUrl: "{{ route('periodes.programs.update', ':id') }}",
            tableDataUrl: "{{ route('periodes.programs.index') }}",
            subject: 'programs',
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
                    data: 'name',
                    name: 'name',
                    title: 'Name',
                    responsivePriority: 1,
                    width: '10%'
                },
                {
                    data: 'description',
                    name: 'description',
                    title: 'Description'
                },
                {
                    data: 'user.name',
                    name: 'user.name',
                    title: 'Lead By',
                    width: '10%'
                },
                {
                    data: 'department.name',
                    name: 'department.name',
                    title: 'Department',
                    width: '10%'
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
                                    <li><a class="dropdown-item btn-edit" href="" data-id="${data.id}"><i class="ti ti-pencil"></i>&nbsp; Edit</a></li>
                                    <li><a class="dropdown-item btn-delete" href="" data-id="${data.id}"><i class="ti ti-trash"></i>&nbsp; Delete</a></li>
                                </ul>
                            </div>
                        `;
                        return html;
                    }
                },
            ],
            tomSelects: [{
                    name: 'department',
                    settings: {
                        valueField: "id",
                        labelField: "name",
                        searchField: "name",
                        placeholder: `Select department`,
                        plugins: {
                            remove_button: {
                                title: "Remove this item",
                            },
                        },
                        load: (query, callback) => {
                            if (!query.length) return callback();
                            $.ajax({
                                url: "{{ route('tom-select.departments') }}",
                                type: "GET",
                                dataType: "json",
                                data: {
                                    q: query,
                                },
                                error: function() {
                                    callback();
                                },
                                success: function(res) {
                                    callback(res);
                                },
                            });
                        },
                        render: {
                            option: function(item, escape) {
                                return `<div>
                                <span class="title">${escape(item.name)}</span>
                            </div>`;
                            },
                            item: function(item, escape) {
                                return `<div>
                                ${escape(item.name)}
                            </div>`;
                            },
                        },
                    },
                },
                {
                    name: 'user',
                    settings: {
                        valueField: "id",
                        labelField: "name",
                        searchField: "name",
                        placeholder: `Select user`,
                        plugins: {
                            remove_button: {
                                title: "Remove this item",
                            },
                        },
                        load: (query, callback) => {
                            if (!query.length) return callback();
                            $.ajax({
                                url: "{{ route('tom-select.users') }}",
                                type: "GET",
                                dataType: "json",
                                data: {
                                    q: query,
                                },
                                error: function() {
                                    callback();
                                },
                                success: function(res) {
                                    callback(res);
                                },
                            });
                        },
                        render: {
                            option: function(item, escape) {
                                return `<div>
                                <span class="title">${escape(item.name)}</span>
                            </div>`;
                            },
                            item: function(item, escape) {
                                return `<div>
                                ${escape(item.name)}
                            </div>`;
                            },
                        },
                    },
                },
            ]
        });

        program.init();
    });
</script>
