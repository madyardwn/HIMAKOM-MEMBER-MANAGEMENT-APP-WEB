<script type="module">
    $(document).ready(function() {
        const filosofie = new TemplateCRUD({
            emptyImage: "{{ asset(config('tablar.default.preview.path')) }}",
            subject: 'filosofies',
            editUrl: "{{ route('periodes.filosofies.edit', ':id') }}",
            deleteUrl: "{{ route('periodes.filosofies.destroy', ':id') }}",
            submitAddUrl: "{{ route('periodes.filosofies.store') }}",
            submitEditUrl: "{{ route('periodes.filosofies.update', ':id') }}",
            tableDataUrl: "{{ route('periodes.filosofies.index') }}",
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
                    data: 'logo',
                    name: 'logo',
                    title: 'Logo',
                    orderable: false,
                    searchable: false,
                    responsivePriority: 1,
                    width: '10%',
                    render: function(data, type, row) {
                        return `<img src="${data}" alt="Logo" class="img-fluid" width="100">`;
                    }
                },
                {
                    data: 'cabinet.name',
                    name: 'cabinet.name',
                    title: 'Cabinet',
                    responsivePriority: 1,
                    width: '10%'
                },
                {
                    data: 'label',
                    name: 'label',
                    title: 'Label',
                    responsivePriority: 2
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
                                    <li><a class="dropdown-item btn-edit" href="" data-id="${data.id}" data-bs-toggle="modal" data-bs-target="#modal-edit-filosofies"><i class="ti ti-pencil"></i>&nbsp; Edit</a></li>
                                    <li><a class="dropdown-item btn-delete" href="" data-id="${data.id}"><i class="ti ti-trash"></i>&nbsp; Delete</a></li>
                                </ul>
                            </div>
                        `;
                        return html;
                    }
                },
            ],
            tomSelects: [{
                name: 'cabinet',
                settings: {
                    valueField: "id",
                    labelField: "name",
                    searchField: "name",
                    placeholder: `Select cabinet`,
                    plugins: {
                        remove_button: {
                            title: "Remove this item",
                        },
                    },
                    load: (query, callback) => {
                        if (!query.length) return callback();
                        $.ajax({
                            url: "{{ route('tom-select.cabinets') }}",
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
            }]
        });

        filosofie.init();
    });
</script>
