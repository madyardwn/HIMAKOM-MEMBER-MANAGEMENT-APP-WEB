<script type="module">
    class Event {
        constructor() {
            this.emptyImage = "{{ asset(config('tablar.default.preview.path')) }}" // empty image
            this.subject = 'events'; // subject of modal event

            this.modalAdd = new bootstrap.Modal($(`#modal-add-events`)); // modal add
            this.modalEdit = new bootstrap.Modal($(`#modal-edit-events`)); // modal edit

            // Special Select
            this.tomSelectAddType = new TomSelect($('#add-type'), {
                placeholder: `Select type`,
                plugins: {
                    remove_button: {
                        title: "Remove this item",
                    },
                },
            })
            this.tomSelectEditType = new TomSelect($('#edit-type'), {
                placeholder: `Select type`,
                plugins: {
                    remove_button: {
                        title: "Remove this item",
                    },
                },
            })

            // Url
            this.storeUrl = "{{ route('periodes.events.store') }}"; // url store
            this.editUrl = "{{ route('periodes.events.edit', ':id') }}"; // url edit
            this.deleteUrl = "{{ route('periodes.events.destroy', ':id') }}"; // url delete
            this.updateUrl = "{{ route('periodes.events.update', ':id') }}"; // url update

            // Datatable
            this.table = $('#table-events'); // datatable selector
            this.tableDataUrl = "{{ route('periodes.events.index') }}"; // url datatable
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
                    responsivePriority: 2,
                },
                {
                    data: 'location',
                    name: 'location',
                    title: 'Location',
                    width: '10%',
                    responsivePriority: 3,
                },
                {
                    data: 'type',
                    name: 'type',
                    title: 'Type',
                    width: '10%',
                    responsivePriority: 3,
                },
                {
                    data: 'date',
                    name: 'date',
                    title: 'Date',
                    responsivePriority: 2,
                    render: (data, type, row) => moment(data).format('DD MMMM YYYY HH:mm')
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
            ];
        }

        initDtEvents() {
            // Modal Events
            $(`#modal-add-${this.subject}`).on("hidden.bs.modal", (e) => {
                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").remove();

                $(`#form-add-${this.subject}`)[0].reset(); // reset form
                $(`#preview-add-poster`).attr("src", this.emptyImage); // reset preview image
                this.tomSelectAddType.clear(); // clear tom select
            });

            $(`#modal-edit-${this.subject}`).on("hidden.bs.modal", (e) => {
                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").remove();

                $(`#form-edit-${this.subject}`)[0].reset(); // reset form
                $(`#preview-edit-poster`).attr("src", this.emptyImage); // reset preview image
                this.tomSelectEditType.clear(); // clear tom select
            });

            // Image Preview Events
            $(`#add-poster`).on("change", () => {
                const file = $(`#add-poster`)[0].files[0]; // get file
                const name = $(`#add-poster`)[0].name; // name of input file
                const reader = new FileReader(); // create reader

                reader.onload = function(e) {
                    // set image source to preview image name
                    $(`#preview-add-${name}`).attr("src", e.target.result);
                };
                reader.readAsDataURL(file);
            });

            $(`#edit-poster`).on("change", () => {
                const file = $(`#edit-poster`)[0].files[0]; // get file
                const name = $(`#edit-poster`)[0].name; // name of input file
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
                drawCallback: () => { // Button Dropdown Events

                    // Button Notification
                    $(`.btn-notification`).on('click', function(e) {
                        e.preventDefault();

                        const id = $(this).attr('data-id');

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

                    $('.btn-edit').on('click', (e) => {
                        e.preventDefault();

                        $(`#edit-id-${this.subject}`).val($(e.currentTarget).data("id"));

                        $.ajax({
                            url: this.editUrl.replace(":id", $(e.currentTarget).data("id")),
                            method: "GET",
                            success: (response) => {
                                $('#edit-name').val(response.data.name);
                                $('#edit-description').val(response.data.description);
                                $('#edit-date').val(moment(response.data.date).format('YYYY-MM-DDTHH:mm'));
                                $('#edit-location').val(response.data.location);
                                $(`#preview-edit-poster`).attr("src", response.data.poster);
                                this.tomSelectEditType.setValue(response.data.type.id);
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

                formData.append("name", $(`#add-name`).val());
                formData.append("description", $(`#add-description`).val());
                formData.append("date", $(`#add-date`).val());
                formData.append("location", $(`#add-location`).val());
                formData.append("poster", $(`#add-poster`)[0].files[0]);
                formData.append("type", this.tomSelectAddType.getValue());

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

                formData.append("_method", "PUT"); // Method PUT with FormData defined in Here
                formData.append("id", $(`#edit-id-${this.subject}`).val());
                formData.append("name", $(`#edit-name`).val());
                formData.append("description", $(`#edit-description`).val());
                formData.append("date", $(`#edit-date`).val());
                formData.append("location", $(`#edit-location`).val());
                formData.append("type", this.tomSelectEditType.getValue());
                formData.append("poster", $(`#edit-poster`)[0].files[0]);

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
        const event = new Event();
        event.initDtEvents();
        event.initDtTable();
        event.initDtSubmit();
    });
</script>
