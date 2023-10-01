<script type="module">
    let table, formAdd, formEdit;

    // tomSelect
    let addPermissions, editPermissions;

    function initDtTable() {
        table = new DataTable('#auth-web-roles-table', {
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: "{{ route('users-management.auth-web.roles.index') }}",            
            columns: [
                {data: 'id', name: 'id', title: 'No', width: '1%'},
                {data: 'name', name: 'name', title: 'Name'},
                {
                    data: null, 
                    title: 'Action',
                    orderable: false, 
                    searchable: false, 
                    responsivePriority: 1,
                    width: '1%',
                    render: function (data, type, row) {
                        return `
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu">                                    
                                    <li><a class="dropdown-item btn-edit" href="" data-id="${data.id}" data-bs-toggle="modal" data-bs-target="#modal-edit-roles"><i class="ti ti-pencil"></i>&nbsp; Edit</a></li>
                                    <li><a class="dropdown-item btn-delete" href="{{ route('users-management.users.index') }}/${data.id}"><i class="ti ti-trash"></i>&nbsp; Delete</a></li>
                                </ul>
                            </div>
                        `;
                    }
                },
            ],
        });         
    }

    function initDtEvents() {
        addPermissions = new TomSelect("#add-permissions", {
            valueField: 'id',            
            labelField: 'name',
            searchField: 'name',
            create: false,
            persist: false,
            maxItems: 5,
            placeholder: 'Select permissions',    
            plugins: {
                remove_button:{
                    title:'Remove this item',
                }
            },
            load: function (query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: "{{ route('tom-select.permissions') }}",
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        q: query,
                    },
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        callback(res);
                    }
                });
            },
            render: {
                option: function (item, escape) {
                    return '<div>' +
                        '<span class="title">' + escape(item.name) + '</span>' +
                        '</div>';
                },
                item: function (item, escape) {
                    return '<div>' +
                        escape(item.name) +
                        '</div>';
                }
            },
        });

        editPermissions = new TomSelect("#edit-permissions", {
            valueField: 'id',            
            labelField: 'name',
            searchField: 'name',
            placeholder: 'Select permissions',          
            plugins: {
                remove_button:{
                    title:'Remove this item',
                }
            },  
            onDelete: function(values) {
                return confirm(values.length > 1 ? 'Are you sure you want to remove these ' + values.length + ' items?' : 'Are you sure you want to remove "' + values[0] + '"?');
            },
            load: function (query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: "{{ route('tom-select.permissions') }}",
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        q: query,
                    },
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        callback(res);
                    }
                });
            },
            render: {
                option: function (item, escape) {
                    return '<div>' +
                        '<span class="title">' + escape(item.name) + '</span>' +
                        '</div>';
                },
                item: function (item, escape) {
                    return '<div>' +
                        escape(item.name) +
                        '</div>';
                }
            },
        });

        table.on('click', '.btn-edit', function (e) {
            e.preventDefault();
            $('#edit-name').val('');
            editPermissions.clear();
            
            const id = $(this).data('id');
            $('#edit-id').val(id);
            $.ajax({
                url: "{{ route('users-management.auth-web.roles.edit', ['role' => 'id']) }}".replace('id', id),
                method: 'GET',
                success: function (response) {
                    if (response.status === 'success') {
                        const role = response.data;
                        $('#edit-name').val(role.name);
                        editPermissions.addOption(role.permissions.map(p => ({id: p.id, name: p.name})));
                        editPermissions.addItems(role.permissions.map(p => p.id));
                    } else {
                        alert(response.message);
                    }
                },
                error: function (response) {
                    alert('Something went wrong!');
                    console.log(response);
                }
            });
        });

        table.on('click', '.btn-delete', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            if (confirm('Are you sure want to delete this data?')) {
                $.ajax({
                    url: "{{ route('users-management.auth-web.roles.destroy', ['role' => 'id']) }}".replace('id', id),
                    method: 'DELETE',
                    success: function (response) {
                        if (response.status === 'success') {
                            table.draw();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function (response) {
                        alert('Something went wrong!');
                    }
                });
            }
        });
    }

    function initDtSubmit() {
        $('#submit-add-role').on('click', function (e) {
            e.preventDefault();
            const name = $('#add-name').val();
            const permissions = addPermissions.getValue();
            $.ajax({
                url: "{{ route('users-management.auth-web.roles.store') }}",
                method: 'POST',
                data: {
                    name: name,
                    permissions: permissions,
                },
                success: function (response) {
                    if (response.status === 'success') {
                        table.draw();
                    } else {
                        alert(response.message);
                    }
                },
                error: function (response) {
                    alert('Something went wrong!');
                    console.log(response);
                }
            });
        });

        $('#submit-edit-role').on('click', function (e) {
            e.preventDefault();
            const name = $('#edit-name').val();
            const permissions = editPermissions.getValue();
            const id = $('#edit-id').val();
            $.ajax({
                url: "{{ route('users-management.auth-web.roles.update', ['role' => 'id']) }}".replace('id', id),
                method: 'PUT',
                data: {
                    name: name,
                    permissions: permissions,
                },
                success: function (response) {
                    if (response.status === 'success') {
                        table.draw();
                    } else {
                        alert(response.message);
                    }
                },
                error: function (response) {
                    alert('Something went wrong!');
                    console.log(response);
                }
            });
        });
    }
    
    // docuemnt on ready
    $(document).ready(function () {
        initDtTable();
        initDtEvents();
        initDtSubmit();

        // $('#form-add-roles').parsley();
    });
</script>