<script type="module">
    class Cabinets {
        constructor() {
            this.emptyImage = "{{ asset(config('tablar.default.preview.path')) }}" // empty image
            this.subject = 'cabinets'; // subject of modal event

            this.modalAdd = new bootstrap.Modal($(`#modal-add-cabinets`)); // modal add
            this.modalEdit = new bootstrap.Modal($(`#modal-edit-cabinets`)); // modal edit

            // Special Select
            this.tomSelectAddDepartments = new TomSelect($('#add-departments'), { // tom select add departments
                placeholder: `Select departments`,
                plugins: {
                    remove_button: {
                        title: "Remove this item",
                    },
                },
            })
            this.tomSelectEditDepartments = new TomSelect($('#edit-departments'), { // tom select edit departments
                placeholder: `Select departments`,
                plugins: {
                    remove_button: {
                        title: "Remove this item",
                    },
                },
            })

            // Url
            this.storeUrl = "{{ route('periodes.cabinets.store') }}"; // url store
            this.editUrl = "{{ route('periodes.cabinets.edit', ':id') }}"; // url edit
            this.deleteUrl = "{{ route('periodes.cabinets.destroy', ':id') }}"; // url delete
            this.updateUrl = "{{ route('periodes.cabinets.update', ':id') }}"; // url update

            // Datatable
            this.table = $('#table-cabinets'); // datatable selector
            this.tableDataUrl = "{{ route('periodes.cabinets.index') }}"; // url datatable
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
                    data: 'logo',
                    name: 'logo',
                    title: 'Logo',
                    orderable: false,
                    searchable: false,
                    className: 'dt-center',
                    responsivePriority: 1,
                    width: '20%',
                    render: function(data, type, row) {
                        return `<img src="${data}" alt="Logo" class="img-fluid" width="100">`;
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                    title: 'Name',
                    responsivePriority: 2,
                    width: '20%'
                },
                {
                    data: 'description',
                    name: 'description',
                    title: 'Description',
                    width: '20%',
                },
                {
                    data: 'visi',
                    name: 'visi',
                    title: 'Visi',
                    width: '20%',
                    'responsivePriority': 4,
                },
                {
                    data: 'misi',
                    name: 'misi',
                    title: 'Misi',
                    width: '20%',
                    'responsivePriority': 4,
                },
                {
                    data: 'year',
                    name: 'year',
                    title: 'Year',
                    width: '20%',
                    responsivePriority: 4,
                },
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
                    data: 'departments',
                    name: 'departments.name',
                    title: 'Departments',
                    orderable: false,
                    width: '30%',
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
                this.tomSelectAddDepartments.clear(); // clear tom select
            });

            $(`#modal-edit-${this.subject}`).on("hidden.bs.modal", (e) => {
                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").remove();

                $(`#form-edit-${this.subject}`)[0].reset(); // reset form
                this.tomSelectEditDepartments.clear(); // clear tom select
            });

            // Image Preview Events
            $(`#add-logo`).on("change", () => {
                const file = $(`#add-logo`)[0].files[0]; // get file
                const name = $(`#add-logo`)[0].name; // name of input file
                const reader = new FileReader(); // create reader

                reader.onload = function(e) {
                    // set image source to preview image name
                    $(`#preview-add-${name}`).attr("src", e.target.result);
                };
                reader.readAsDataURL(file);
            });

            $(`#edit-logo`).on("change", () => {
                const file = $(`#edit-logo`)[0].files[0]; // get file
                const name = $(`#edit-logo`)[0].name; // name of input file
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
                                $('#edit-description').val(response.data.description);
                                $('#edit-visi').val(response.data.visi);
                                $('#edit-misi').val(response.data.misi);
                                $('#edit-year').val(response.data.year);
                                $('#edit-is_active').prop("checked", response.data.is_active);
                                $(`#preview-edit-logo`).attr("src", response.data.logo ? response.data.logo : this.emptyImage);
                                this.tomSelectEditDepartments.setValue(response.data.departments.map((item) => item.id));
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
                const departments = this.tomSelectAddDepartments.getValue();

                formData.append("name", $(`#add-name`).val());
                formData.append("description", $(`#add-description`).val());
                formData.append("visi", $(`#add-visi`).val());
                formData.append("misi", $(`#add-misi`).val());
                formData.append("year", $(`#add-year`).val());
                formData.append("is_active", $(`#add-is_active`).prop("checked") ? 1 : 0);
                formData.append("logo", $(`#add-logo`)[0].files[0]);
                departments.forEach((departments) => {
                    formData.append("departments[]", departments);
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
                const departments = this.tomSelectEditDepartments.getValue();

                formData.append("_method", "PUT"); // Method PUT with FormData defined in Here
                formData.append("id", $(`#edit-id-${this.subject}`).val());
                formData.append("name", $(`#edit-name`).val());
                formData.append("description", $(`#edit-description`).val());
                formData.append("visi", $(`#edit-visi`).val());
                formData.append("misi", $(`#edit-misi`).val());
                formData.append("year", $(`#edit-year`).val());
                formData.append("is_active", $(`#edit-is_active`).prop("checked") ? 1 : 0);
                formData.append("logo", $(`#edit-logo`)[0].files[0]);
                departments.forEach((departments) => {
                    formData.append("departments[]", departments);
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
        }
    }

    $(document).ready(function() {
        const cabinet = new Cabinets();
        cabinet.initDtEvents();
        cabinet.initDtTable();
        cabinet.initDtSubmit();
    });
</script>
