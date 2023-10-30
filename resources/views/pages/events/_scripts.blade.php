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
                    className: 'dt-center',
                    responsivePriority: 1,
                    width: '10%',
                    render: function(data, type, row) {
                        return `<img src="${data}" alt="Poster" class="img-fluid" width="100">`;
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

        events.table.on("click", ".btn-notification", function(e) {
            e.preventDefault();

            const id = $(this).attr('data-id');
            console.log(id);
            Swal.fire({
                title: 'Send Notification',
                html: `
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" id="swal-title" placeholder="Title">
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="form-control" id="swal-body" placeholder="Content" rows="4"></textarea>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" id="swal-link" placeholder="Link">
                        </div>
                    `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, send it!',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    return {
                        title: $('#swal-title').val(),
                        body: $('#swal-body').val(),
                        link: $('#swal-link').val(),
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('title', result.value.title);
                    formData.append('body', result.value.body);
                    formData.append('link', result.value.link);

                    $.ajax({
                        method: 'POST',
                        url: "{{ route('periodes.events.notification', ':id') }}".replace(':id', id),
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            if (res) {
                                Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        html: res.message,
                                        showConfirmButton: true
                                    })
                                    .then((result) => {
                                        if (result.isConfirmed) {
                                            events.table.ajax.reload();
                                            $('#card').before(
                                                '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                                res.message +
                                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                                '</div>'
                                            );

                                            $('.alert').delay(3000).slideUp(300,
                                                function() {
                                                    $(this).alert('close');
                                                });
                                        }
                                    });
                            }
                        },
                        error: (xhr, ajaxOptions, thrownError) => {
                            Swal.fire("Error!", thrownError, "error");

                            $(`#card-${this.subject}`).before(`
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error!</strong> ${thrownError}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `);

                            $(".alert").delay(3000).slideUp(300);
                        },
                    });
                }
            });
        });
    });
</script>
