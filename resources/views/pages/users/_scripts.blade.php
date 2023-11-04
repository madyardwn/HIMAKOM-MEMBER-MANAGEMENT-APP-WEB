<script type="module">
    class User {
        constructor() {
            // Empty & Subject
            this.emptyImage = "{{ asset(config('tablar.default.preview.path')) }}"
            this.subject = 'users';

            // Modal
            this.modalAdd = new bootstrap.Modal($(`#modal-add-users`));
            this.modalEdit = new bootstrap.Modal($(`#modal-edit-users`));
            this.modalImport = new bootstrap.Modal($(`#modal-import-users`));

            // Form
            this.formAdd = $(`#form-add-users`);
            this.formEdit = $(`#form-edit-users`);
            this.formImport = $(`#form-import-users`);

            // Tom Select
            this.tomSelectAddDepartment = new TomSelect($('#add-department'), {
                placeholder: 'Select Department',
            })
            this.tomSelectEditDepartment = new TomSelect($('#edit-department'), {
                placeholder: 'Select Department',
            })
            this.tomSelectAddRole = new TomSelect($('#add-role'), {
                placeholder: 'Select Role',
            })
            this.tomSelectEditRole = new TomSelect($('#edit-role'), {
                placeholder: 'Select Role',
            })
            this.tomSelectAddCabinet = new TomSelect($('#add-cabinet'), {
                placeholder: 'Select Cabinet',
            })
            this.tomSelectEditCabinet = new TomSelect($('#edit-cabinet'), {
                placeholder: 'Select Cabinet',
            })
            this.tomSelectAddGender = new TomSelect($('#add-gender'), {
                placeholder: 'Select Gender',
            })
            this.tomSelectEditGender = new TomSelect($('#edit-gender'), {
                placeholder: 'Select Gender',
            })

            // URL
            this.storeUrl = "{{ route('users-management.users.store') }}";
            this.editUrl = "{{ route('users-management.users.edit', ':id') }}";
            this.deleteUrl = "{{ route('users-management.users.destroy', ':id') }}";
            this.updateUrl = "{{ route('users-management.users.update', ':id') }}";
            this.importUrl = "{{ route('import.users') }}";

            // DataTable
            this.table = $('#table-users');
            this.tableDataUrl = "{{ route('users-management.users.index') }}";
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
                    data: 'cabinet',
                    name: 'cabinet.name',
                    title: 'Cabinet',
                    orderable: false,
                    render: (data) => data ? `<span class="badge badge-outline text-blue m-1">${data.name}</span>` : ''
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
            $(`#modal-add-${this.subject}`).on("hidden.bs.modal", (e) => {
                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").remove();
                $(`#preview-add-picture`).attr("src", this.emptyImage);

                this.formAdd[0].reset();
                this.tomSelectAddGender.clear();
                this.tomSelectAddDepartment.clear();
                this.tomSelectAddCabinet.clear();
                this.tomSelectAddRole.clear();
            });

            $(`#modal-edit-${this.subject}`).on("hidden.bs.modal", (e) => {
                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").remove();
                $(`#preview-edit-picture`).attr("src", this.emptyImage);

                this.formEdit[0].reset();
                this.tomSelectEditGender.clear();
                this.tomSelectEditDepartment.clear();
                this.tomSelectEditCabinet.clear();
                this.tomSelectEditRole.clear();
            });

            $(`#modal-import-${this.subject}`).on("hidden.bs.modal", (e) => {
                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").remove();

                this.formImport[0].reset();
            });


            $(`#add-picture`).on("change", () => {
                const file = $(`#add-picture`)[0].files[0];
                const name = $(`#add-picture`)[0].name;
                const reader = new FileReader();

                reader.onload = function(e) {

                    $(`#preview-add-${name}`).attr("src", e.target.result);
                };
                reader.readAsDataURL(file);
            });

            $(`#edit-picture`).on("change", () => {
                const file = $(`#edit-picture`)[0].files[0];
                const name = $(`#edit-picture`)[0].name;
                const reader = new FileReader();

                reader.onload = function(e) {

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

                        // Set ID, We'll use it later
                        $(`#edit-id-${this.subject}`).val($(e.currentTarget).data("id"));

                        $.ajax({
                            url: this.editUrl.replace(":id", $(e.currentTarget).data("id")),
                            method: "GET",
                            success: (response) => {
                                $('#edit-name').val(response.data?.name);
                                $('#edit-email').val(response.data?.email);
                                $('#edit-nim').val(response.data?.nim);
                                $('#edit-npa').val(response.data?.npa);
                                $('#edit-name_bagus').val(response.data?.name_bagus);
                                $('#edit-year').val(response.data?.year);
                                $(`#preview-edit-picture`).attr("src", response.data?.picture);
                                this.tomSelectEditGender.setValue(response.data?.gender);
                                this.tomSelectEditDepartment.setValue(response.data?.department?.id);
                                this.tomSelectEditCabinet.setValue(response.data?.cabinet?.id);
                                this.tomSelectEditRole.setValue(response.data?.roles.map((item) => item?.id));
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

                const formData = new FormData(this.formAdd[0]);

                $.ajax({
                    url: this.storeUrl,
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
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
                            this.modalAdd.hide();

                            this.table.DataTable().ajax.reload();

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

                const formData = new FormData(this.formEdit[0]);
                formData.append("_method", "PUT");

                $.ajax({
                    url: this.updateUrl.replace(":id", formData.get("id")),
                    method: "POST",
                    processData: false,
                    contentType: false,
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
                            this.modalEdit.hide();

                            this.table.DataTable().ajax.reload();


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

                const form = $(`#form-import-${this.subject}`);
                const formData = new FormData(form[0]);

                $.ajax({
                    url: this.importUrl,
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
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
