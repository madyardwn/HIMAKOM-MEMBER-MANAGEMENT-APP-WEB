<script type="module">
    let options = []

    @foreach ($events as $key => $value)
        options.push({
            id: {{ $key }},
            name: "{{ $value }}"
        })
    @endforeach

    $(document).ready(function() {

        const events = new TemplateCRUD({
            emptyImage: "{{ asset(config('tablar.default.preview.path')) }}",
            modalAdd: new bootstrap.Modal($(`#modal-add-events`)),
            modalEdit: new bootstrap.Modal($(`#modal-edit-events`)),
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
                    title: 'Description',
                    width: '10%'
                },
                {
                    data: 'date',
                    name: 'date',
                    title: 'Date',
                    width: '10%',
                    render: (data, type, row) => moment(data).format('DD MMMM YYYY HH:mm')
                },
                {
                    data: 'location',
                    name: 'location',
                    title: 'Location',
                    width: '10%'
                },
                {
                    data: 'type',
                    name: 'type',
                    title: 'Type',
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
                                    <li><a class="dropdown-item btn-notification" href="" data-id="${data.id}"><i class="ti ti-bell"></i>&nbsp; Notification</a></li>
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
                name: 'type',
                settings: {
                    valueField: "id",
                    labelField: "name",
                    searchField: "name",
                    placeholder: `Select Type`,
                    options: options,
                    plugins: {
                        remove_button: {
                            title: "Remove this item",
                        },
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
        events.init();
    });
</script>
