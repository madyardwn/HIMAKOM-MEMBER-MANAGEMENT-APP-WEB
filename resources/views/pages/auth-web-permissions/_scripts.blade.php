<script type="module">
    $(document).ready(function() {
        const authWebPermissions = new TemplateCRUD({
            emptyImage: "{{ asset(config('tablar.default.preview.path')) }}",
            subject: 'auth-web-permissions',
            editUrl: "",
            deleteUrl: "",
            submitAddUrl: "",
            submitEditUrl: "",
            tableDataUrl: "{{ route('auth-web.permissions.index') }}",
            columns: [{
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
            ],
        });

        authWebPermissions.init();
    });
</script>
