<script type="module">
    class AuthWebPermissions {
        constructor() {
            this.table = $('#table-auth-web-permissions');
            this.tableDataUrl = "{{ route('auth-web.permissions.index') }}";
            this.tableColumns = [{
                    data: 'id',
                    name: 'id',
                    title: 'No',
                    width: '1%'
                },
                {
                    data: 'name',
                    name: 'name',
                    title: 'Name'
                },
            ];
        }

        initDtTable() {
            this.table.DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: this.tableDataUrl,
                columns: this.tableColumns,
            });
        }
    }

    $(document).ready(function() {
        const authWebPermissions = new AuthWebPermissions();
        authWebPermissions.initDtTable();
    });
</script>
