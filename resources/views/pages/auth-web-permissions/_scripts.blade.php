<script type="module">
    let table, formAdd, formEdit;

    function initDtTable() {
        table = new DataTable('#auth-web-permissions-table', {
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: "{{ route('auth-web.permissions.index') }}",            
            columns: [
                {data: 'id', name: 'id', title: 'No', width: '1%'},
                {data: 'name', name: 'name', title: 'Name'},
            ],
        });         
    }

    // docuemnt on ready
    $(document).ready(function () {
        initDtTable();
        // initDtEvents();

        const addCabinet = new TomSelect("#add-cabinet", {
            persist: false,
            createOnBlur: true,
            create: true
        });

        const addDepartment = new TomSelect("#add-department", {
            persist: false,
            createOnBlur: true,
            create: true
        });

        const addRole = new TomSelect("#add-role", {
            persist: false,
            createOnBlur: true,
            create: true
        });

    });
</script>