<script type="module">
    class User {
        constructor() {
            this.emptyImage = "{{ asset(config('tablar.default.preview.path')) }}" // empty image
            this.subject = 'users'; // subject of modal event

            this.modalAdd = new bootstrap.Modal($(`#modal-add-users`)); // modal add
            this.modalEdit = new bootstrap.Modal($(`#modal-edit-users`)); // modal edit
            this.modalImport = new bootstrap.Modal($(`#modal-import-users`)); // modal import

            // Special Select
            this.tomSelectAddDepartment = new TomSelect($('#add-department'), { // tom select add departments
                placeholder: `Select department`,
                plugins: {
                    remove_button: {
                        title: "Remove this item",
                    },
                },
            })
            this.tomSelectEditDepartment = new TomSelect($('#edit-department'), { // tom select edit departments
                placeholder: `Select department`,
                plugins: {
                    remove_button: {
                        title: "Remove this item",
                    },
                },
            })

            this.tomSelectAddRoles = new TomSelect($('#add-roles'), { // tom select add roles
                placeholder: `Select role`,
                plugins: {
                    remove_button: {
                        title: "Remove this item",
                    },
                },
                maxItems: 2,
            })
            this.tomSelectEditRoles = new TomSelect($('#edit-roles'), { // tom select edit roles
                placeholder: `Select role`,
                plugins: {
                    remove_button: {
                        title: "Remove this item",
                    },
                },
                maxItems: 2,
            })

            this.tomSelectAddCabinets = new TomSelect($('#add-cabinets'), { // tom select add cabinets
                placeholder: `Select cabinet`,
                plugins: {
                    remove_button: {
                        title: "Remove this item",
                    },
                },
                maxItems: 2,
            })
            this.tomSelectEditCabinets = new TomSelect($('#edit-cabinets'), { // tom select edit cabinets
                placeholder: `Select cabinet`,
                plugins: {
                    remove_button: {
                        title: "Remove this item",
                    },
                },
                maxItems: 2,
            })

            this.tomSelectAddGender = new TomSelect($('#edit-gender'), {
                placeholder: `Select gender`,
                plugins: {
                    remove_button: {
                        title: "Remove this item",
                    },
                },
            })

            this.tomSelectEditGender = new TomSelect($('#add-gender'), {
                placeholder: `Select gender`,
                plugins: {
                    remove_button: {
                        title: "Remove this item",
                    },
                },
            })

            // Url
            this.storeUrl = "{{ route('users-management.users.store') }}"; // url store
            this.editUrl = "{{ route('users-management.users.edit', ':id') }}"; // url edit
            this.deleteUrl = "{{ route('users-management.users.destroy', ':id') }}"; // url delete
            this.updateUrl = "{{ route('users-management.users.update', ':id') }}"; // url update
            this.importUrl = "{{ route('import.users') }}"; // Set url

            // Datatable
            this.table = $('#table-users'); // datatable selector
            this.tableDataUrl = "{{ route('users-management.users.index') }}"; // url datatable
            this.tableColumns = [{
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
                    className: 'dt-center',
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
                    title: 'Cabinet',
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
                    data: 'department',
                    name: 'department.name',
                    title: 'Department',
                    orderable: false,
                    render: (data) => data ? `<span class="badge badge-outline text-blue m-1">${data.name}</span>` : ''
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
            ];
        }

        initDtEvents() {
            // Modal Events
            $(`#modal-add-${this.subject}`).on("hidden.bs.modal", (e) => {
                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").remove();

                $(`#form-add-${this.subject}`)[0].reset(); // reset form
                $(`#preview-add-picture`).attr("src", this.emptyImage); // reset preview image
                this.tomSelectAddDepartment.clear(); // clear tom select
                this.tomSelectAddCabinets.clear(); // clear tom select
                this.tomSelectAddRoles.clear(); // clear tom select
            });

            $(`#modal-edit-${this.subject}`).on("hidden.bs.modal", (e) => {
                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").remove();

                $(`#form-edit-${this.subject}`)[0].reset(); // reset form
                $(`#preview-edit-picture`).attr("src", this.emptyImage); // reset preview image
                this.tomSelectEditDepartment.clear(); // clear tom select
                this.tomSelectEditCabinets.clear(); // clear tom select
                this.tomSelectEditRoles.clear(); // clear tom select
            });

            $(`#modal-import-${this.subject}`).on("hidden.bs.modal", (e) => {
                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").remove();

                $(`#form-import-${this.subject}`)[0].reset(); // reset form
            });

            // Image Preview Events
            $(`#add-picture`).on("change", () => {
                const file = $(`#add-picture`)[0].files[0]; // get file
                const name = $(`#add-picture`)[0].name; // name of input file
                const reader = new FileReader(); // create reader

                reader.onload = function(e) {
                    // set image source to preview image name
                    $(`#preview-add-${name}`).attr("src", e.target.result);
                };
                reader.readAsDataURL(file);
            });

            $(`#edit-picture`).on("change", () => {
                const file = $(`#edit-picture`)[0].files[0]; // get file
                const name = $(`#edit-picture`)[0].name; // name of input file
                const reader = new FileReader(); // create reader

                reader.onload = function(e) {
                    // set image source to preview image name
                    $(`#preview-edit-${name}`).attr("src", e.target.result);
                };
                reader.readAsDataURL(file);
            });
        }

        initDtTable() {
            this.table.DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: this.tableDataUrl,
                columns: this.tableColumns,
                drawCallback: () => {
                    $('.btn-edit').on('click', (e) => {
                        e.preventDefault();

                        $(`#edit-id-${this.subject}`).val($(e.currentTarget).data("id"));

                        $.ajax({
                            url: this.editUrl.replace(":id", $(e.currentTarget).data("id")),
                            method: "GET",
                            success: (response) => {
                                $('#edit-name').val(response.data.name);
                                $('#edit-email').val(response.data.email);
                                $('#edit-nim').val(response.data.nim);
                                $('#edit-npa').val(response.data.npa);
                                $('#edit-name_bagus').val(response.data.name_bagus);
                                $('#edit-year').val(response.data.year);
                                $('#edit-gender').val(response.data.gender);
                                $(`#preview-edit-picture`).attr("src", response.data.picture);
                                this.tomSelectEditDepartment.setValue(response.data.department.id);
                                this.tomSelectEditCabinets.setValue(response.data.cabinets.map((item) => item.id));
                                this.tomSelectEditRoles.setValue(response.data.roles.map((item) => item.id));
                                this.modalEdit.show();
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                Swal.fire("Error!", thrownError, "error");
                            },
                        });
                    });

                    $('.btn-delete').on('click', (e) => {
                        e.preventDefault();

                        const id = $(e.currentTarget).data("id");

                        Swal.fire({
                            title: "Are you sure?",
                            text: "You won't be able to revert this!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, delete it!",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: this.deleteUrl.replace(":id", id),
                                    method: "DELETE",
                                    success: (response) => {
                                        if (response.status === "success") {
                                            Swal.fire({
                                                icon: "success",
                                                title: "Berhasil",
                                                text: response.message,
                                                showConfirmButton: false,
                                                timer: 1500,
                                            }).then(() => {
                                                this.table.DataTable().ajax.reload();

                                                $(`#card-${this.subject}`).before(`
                                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                        <strong>Success!</strong> ${response.message}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                `);

                                                $(".alert").delay(3000).slideUp(300);
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
                }
            });
        }

        initDtSubmit() {
            $(`#submit-add-${this.subject}`).on("click", (e, item) => {
                e.preventDefault();

                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").remove();
                $(`#submit-add-${this.subject}`).attr("disabled", true);
                $(`#submit-add-${this.subject}`).addClass("btn-loading");

                const formData = new FormData(); // Membuat objek FormData
                const cabinets = this.tomSelectAddCabinets.getValue();
                const roles = this.tomSelectAddRoles.getValue();

                formData.append("name", $(`#add-name`).val());
                formData.append("email", $(`#add-email`).val());
                formData.append("nim", $(`#add-nim`).val());
                formData.append("npa", $(`#add-npa`).val());
                formData.append("name_bagus", $(`#add-name_bagus`).val());
                formData.append("year", $(`#add-year`).val());
                formData.append("is_active", $(`#add-is_active`).prop("checked") ? 1 : 0);
                formData.append("password", $(`#add-password`).val());
                formData.append("password_confirmation", $(`#add-password_confirmation`).val());
                formData.append("gender", $(`#add-gender`).val());
                formData.append("picture", $(`#add-picture`)[0].files[0]);
                formData.append("department", $(`#add-department`).val());
                // formData.append("cabinets", $(`#add-cabinets`).val());
                // formData.append("roles", $(`#add-roles`).val());
                cabinets.forEach((item) => {
                    formData.append("cabinets[]", item);
                });
                roles.forEach((item) => {
                    formData.append("roles[]", item);
                });

                $.ajax({
                    url: this.storeUrl, // Assign URL
                    method: "POST",
                    data: formData, // Menggunakan objek FormData sebagai data
                    contentType: false, // Mengatur contentType ke false
                    processData: false, // Mengatur processData ke false
                    complete: () => {
                        $(`#submit-add-${this.subject}`).attr("disabled", false);
                        $(`#submit-add-${this.subject}`).removeClass("btn-loading");
                    },
                    success: (response) => {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(() => {
                            this.modalAdd.hide(); // hide modal

                            this.table.DataTable().ajax.reload(); // reload datatable

                            $(`#card-${this.subject}`).before(`
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> ${response.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `);

                            $(".alert").delay(3000).slideUp(300);
                        });
                    },
                    error: (response) => {
                        if (response.status === 422) {
                            const errors = response.responseJSON.errors;
                            for (const key in errors) {
                                if (Object.hasOwnProperty.call(errors, key)) {
                                    const element = errors[key];
                                    $(`#add-${key}`).addClass("is-invalid");
                                    $(`#add-${key}`).after(`<div class="invalid-feedback">${element[0]}</div>`);
                                }
                            }
                        } else {
                            Swal.fire("Error!", "Something went wrong!", "error");
                        }
                    },
                });
            });

            $(`#submit-edit-${this.subject}`).on("click", (e, item) => {
                e.preventDefault();

                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").remove();
                $(`#submit-edit-${this.subject}`).attr("disabled", true);
                $(`#submit-edit-${this.subject}`).addClass("btn-loading");

                const formData = new FormData();
                const cabinets = this.tomSelectEditCabinets.getValue();
                const roles = this.tomSelectEditRoles.getValue();

                formData.append("_method", "PUT"); // Method PUT with FormData defined in Here
                formData.append("id", $(`#edit-id-${this.subject}`).val());
                formData.append("name", $(`#edit-name`).val());
                formData.append("email", $(`#edit-email`).val());
                formData.append("nim", $(`#edit-nim`).val());
                formData.append("npa", $(`#edit-npa`).val());
                formData.append("name_bagus", $(`#edit-name_bagus`).val());
                formData.append("year", $(`#edit-year`).val());
                formData.append("is_active", $(`#edit-is_active`).prop("checked") ? 1 : 0);
                formData.append("password", $(`#edit-password`).val());
                formData.append("password_confirmation", $(`#edit-password_confirmation`).val());
                formData.append("gender", $(`#edit-gender`).val());
                formData.append("picture", $(`#edit-picture`)[0].files[0]);
                formData.append("department", $(`#edit-department`).val());
                // formData.append("cabinets", $(`#edit-cabinets`).val());
                // formData.append("roles", $(`#edit-roles`).val());
                cabinets.forEach((item) => {
                    formData.append("cabinets[]", item);
                });
                roles.forEach((item) => {
                    formData.append("roles[]", item);
                });

                $.ajax({
                    url: this.updateUrl.replace(":id", formData.get("id")), // Assign URL
                    method: "POST", // With FormData we can't use PUT method in here
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting the content type
                    data: formData,
                    complete: () => {
                        $(`#submit-edit-${this.subject}`).attr("disabled", false);
                        $(`#submit-edit-${this.subject}`).removeClass("btn-loading");
                    },
                    success: (response) => {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(() => {
                            this.modalEdit.hide(); // hide modal

                            this.table.DataTable().ajax.reload(); // reload datatable

                            // Show Alert
                            $(`#card-${this.subject}`).before(`
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Success!</strong> ${response.message}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                `);

                            $(".alert").delay(3000).slideUp(300);
                        });
                    },
                    error: (response) => {
                        if (response.status === 422) {
                            const errors = response.responseJSON.errors;
                            for (const key in errors) {
                                if (Object.hasOwnProperty.call(errors, key)) {
                                    const element = errors[key];
                                    $(`#edit-${key}`).addClass("is-invalid");
                                    $(`#edit-${key}`).after(`<div class="invalid-feedback">${element[0]}</div>`);
                                }
                            }
                        } else {
                            Swal.fire("Error!", "Something went wrong!", "error");
                        }
                    },
                });
            });

            $(`#submit-import-${this.subject}`).on("click", (e) => {
                e.preventDefault();

                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").remove();
                $(`#submit-import-users`).attr("disabled", true);
                $(`#submit-import-users`).addClass("btn-loading");

                const form = $(`#form-import-${this.subject}`); // Ambil form
                const formData = new FormData(form[0]); // Buat form data

                $.ajax({
                    url: this.importUrl, // File tujuan
                    method: "POST",
                    data: formData, // Menggunakan objek FormData sebagai data
                    contentType: false, // Mengatur contentType ke false
                    processData: false, // Mengatur processData ke false
                    complete: () => {
                        $(`#submit-import-${this.subject}`).attr("disabled", false);
                        $(`#submit-import-${this.subject}`).removeClass("btn-loading");

                        this.modalImport.hide();

                        this.table.DataTable().ajax.reload();
                    },
                    success: (response) => {
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
                        if (response.status === 422) {
                            const errors = response.responseJSON.errors;
                            for (const key in errors) {
                                if (Object.hasOwnProperty.call(errors, key)) {
                                    const element = errors[key];
                                }
                            }
                        } else {
                            Swal.fire("Error!", response.responseJSON.message, "error");
                        }
                    },
                });
            });
        }
    }

    $(document).ready(function() {
        const user = new User();
        user.initDtEvents();
        user.initDtTable();
        user.initDtSubmit();
    });
</script>
