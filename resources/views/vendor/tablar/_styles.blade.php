<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/TomSelect/tom-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/Parsley/parsley.min.css') }}">
<style>
    @media (max-width: 767px) {
        .dataTables_length label, .dataTables_filter label {
            display: block;
        }

        .dataTables_length select, .dataTables_filter input {
            width: 100%;
        }

        .dataTables_filter label {
            margin-top: 10px; /* Atur jarak antara label Search dan input */
        }
    }
</style>