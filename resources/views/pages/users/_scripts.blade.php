<script type="module">
    let user;

    function initImportSubmit() {
        $(`#submit-import-users`).on("click", (e, item) => {
            e.preventDefault();

            $(".is-invalid").removeClass("is-invalid");
            $(".invalid-feedback").remove();
            $(`#submit-import-users`).attr("disabled", true);
            $(`#submit-import-users`).addClass("btn-loading");

            const form = $(`#form-import-users`); // Ambil form
            const formData = new FormData(form[0]); // Buat form data
            const url = "{{ route('users-management.users.import') }}"; // Set url

            $.ajax({
                url: url, // Set url
                method: "POST",
                data: formData, // Menggunakan objek FormData sebagai data
                contentType: false, // Mengatur contentType ke false
                processData: false, // Mengatur processData ke false
                success: (response) => {
                    $(`#submit-import-users`).attr("disabled", false);
                    $(`#submit-import-users`).removeClass("btn-loading");
                    if (response.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(() => {
                            user.table.ajax.reload();
                            $(`#card-users`).before(`
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> ${response.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `);
                            $(".alert").delay(3000).slideUp(300);
                        });
                    } else {
                        Swal.fire("Error!", response.message, "error");
                    }
                },
                error: (response) => {
                    $(`#submit-import-users`).attr("disabled", false);
                    $(`#submit-import-users`).removeClass("btn-loading");
                    if (response.status === 422) {
                        const errors = response.responseJSON.errors;
                        for (const key in errors) {
                            if (Object.hasOwnProperty.call(errors, key)) {
                                const element = errors[key];
                            }
                        }
                    } else {
                        Swal.fire("Error!", "Something went wrong!", "error");
                    }
                },
            });
        });
    }

    function initImportEvents() {
        $(`#modal-import-users`).on("hidden.bs.modal", (e) => {
            $(".is-invalid").removeClass("is-invalid");
            $(".invalid-feedback").remove();

            $(`#form-import-users`)[0].reset(); // reset form            
        });
    }

    $(document).ready(function() {

        const genderOption = [];

        @foreach ($gender as $key => $value)
            genderOption.push({
                id: {{ $key }},
                name: "{{ $value }}"
            })
        @endforeach

        user = new TemplateCRUD({
            emptyImage: "{{ asset(config('tablar.default.preview.path')) }}",
            subject: 'users',
            modalAdd: new bootstrap.Modal($(`#modal-add-users`)),
            modalEdit: new bootstrap.Modal($(`#modal-edit-users`)),
            editUrl: "{{ route('users-management.users.edit', ':id') }}",
            deleteUrl: "{{ route('users-management.users.destroy', ':id') }}",
            submitAddUrl: "{{ route('users-management.users.store') }}",
            submitEditUrl: "{{ route('users-management.users.update', ':id') }}",
            tableDataUrl: "{{ route('users-management.users.index') }}",
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
                    data: 'picture',
                    name: 'picture',
                    title: 'Picture',
                    orderable: false,
                    searchable: false,
                    responsivePriority: 1,
                    width: '10%',
                    render: function(data, type, row) {
                        return `<img src="${data}" alt="picture" class="img-fluid" width="100">`;
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                    title: 'Name',
                    responsivePriority: 2,
                    width: '10%'
                },
                {
                    data: 'email',
                    name: 'email',
                    title: 'Email',
                    responsivePriority: 3,
                    width: '10%'
                },
                {
                    data: 'nim',
                    name: 'nim',
                    title: 'NIM',
                    responsivePriority: 4,
                    width: '10%'
                },
                {
                    data: 'npa',
                    name: 'npa',
                    title: 'NPA',
                    responsivePriority: 5,
                    width: '10%'
                },
                {
                    data: 'name_bagus',
                    name: 'name_bagus',
                    title: 'Name Bagus',
                    responsivePriority: 5,
                    width: '10%'
                },
                {
                    data: 'gender',
                    name: 'gender',
                    title: 'Gender',
                    responsivePriority: 5,
                    width: '10%',
                    render: (data) => data == '1' ? 'Male' : 'Female'
                },
                {
                    data: 'year',
                    name: 'year',
                    title: 'Year',
                    responsivePriority: 5,
                    width: '10%'
                },
                {
                    data: 'cabinets',
                    name: 'cabinets.name',
                    title: 'Cabinets',
                    orderable: false,
                    render: function(data, type, row) {
                        let html = '';
                        data.forEach(function(item, index) {
                            html += `<span class="badge badge-outline text-blue m-1">${item.name}</span>`;
                        });
                        return html;
                    }
                },
                {
                    data: 'departments',
                    name: 'departments.name',
                    title: 'Department',
                    orderable: false,
                    render: function(data, type, row) {
                        let html = '';
                        data.forEach(function(item, index) {
                            html += `<span class="badge badge-outline text-blue m-1">${item.name}</span>`;
                        });
                        return html;
                    }
                },
                {
                    data: 'roles',
                    name: 'roles.name',
                    title: 'Roles',
                    orderable: false,
                    render: function(data, type, row) {
                        let html = '';
                        data.forEach(function(item, index) {
                            html += `<span class="badge badge-outline text-blue m-1">${item.name}</span>`;
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
                    name: 'cabinets',
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
                },
                {
                    name: 'roles',
                    settings: {
                        valueField: "id",
                        labelField: "name",
                        searchField: "name",
                        placeholder: `Select roles`,
                        plugins: {
                            remove_button: {
                                title: "Remove this item",
                            },
                        },
                        load: (query, callback) => {
                            if (!query.length) return callback();
                            $.ajax({
                                url: "{{ route('tom-select.roles') }}",
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
                    name: 'departments',
                    settings: {
                        valueField: "id",
                        labelField: "name",
                        searchField: "name",
                        placeholder: `Select departments`,
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
                    name: 'gender',
                    settings: {
                        valueField: "id",
                        labelField: "name",
                        searchField: "name",
                        placeholder: `Select Gender`,
                        options: genderOption,
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
                }
            ]
        });

        user.init();

        initImportSubmit();
        initImportEvents();
    });
</script>
