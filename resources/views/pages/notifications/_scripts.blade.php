<script type="module">
    $(document).ready(function() {
        const notification = new TemplateCRUD({
            emptyImage: "{{ asset(config('tablar.default.preview.path')) }}",
            modalAdd: new bootstrap.Modal($(`#modal-add-notifications`)),
            modalEdit: "",
            editUrl: "",
            deleteUrl: "{{ route('users-management.notifications.destroy', ':id') }}",
            submitAddUrl: "{{ route('users-management.notifications.store') }}",
            submitEditUrl: "",
            tableDataUrl: "{{ route('users-management.notifications.index') }}",
            subject: 'notifications',
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
                    data: 'title',
                    name: 'title',
                    title: 'Title',
                    responsivePriority: 1,
                    width: '10%'
                },
                {
                    data: 'body',
                    name: 'body',
                    title: 'Body',
                    width: '10%',
                    responsivePriority: 1,
                },
                {
                    data: 'link',
                    name: 'link',
                    title: 'Link',
                    width: '10%',
                    responsivePriority: 2,
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    title: 'Created At',
                    width: '10%',
                    responsivePriority: 3,
                    render: (data) => moment(data).format('DD MMMM YYYY HH:mm')
                },
                {
                    data: 'users',
                    name: 'users.name',
                    title: 'Sent To',
                    render: function(data, type, row) {
                        let html = '';
                        data.forEach(function(item, index) {
                            html += `<span class="badge badge-outline text-grey">${item.name}</span>`;
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
                        let html = '';
                        html = `
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu">                                    
                                    <li><a class="dropdown-item btn-delete" href="" data-id="${data.id}"><i class="ti ti-trash"></i>&nbsp; Delete</a></li>
                                </ul>
                            </div>
                        `;
                        return html;
                    }
                },
            ],
            tomSelects: []
        });

        notification.init();
    });
</script>
