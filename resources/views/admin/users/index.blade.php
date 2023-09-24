@extends('tablar::page')

@section('css')
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/r-2.5.0/rr-1.4.1/datatables.min.css" rel="stylesheet">
@endsection

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        Welcome, {{ Auth::user()->name }}!
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container">
            <div class="card">
                <div class="card-header">Manage Users</div>
                <div class="card-body">
                    <table class="table table-bordered data-table responsive w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Name</th>
                                <th>Name</th>
                                <th>Name</th>
                                <th>Name</th>
                                <th>Name</th>
                                <th>Name</th>
                                <th>Name</th>
                                <th>Name</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Email</th><th>Email</th>
                                <th width="105px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="module" src="https://cdn.datatables.net/v/bs5/dt-1.13.6/r-2.5.0/rr-1.4.1/datatables.min.js"></script>
    <script type="module">
        $(function () {
            new DataTable('.data-table', {
                processing: true,
                responsive: true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                serverSide: true,
                ajax: "{{ route('admin.users.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'name', name: 'name'},
                    {data: 'name', name: 'name'},
                    {data: 'name', name: 'name'},
                    {data: 'name', name: 'name'},
                    {data: 'name', name: 'name'},
                    {data: 'name', name: 'name'},
                    {data: 'name', name: 'name'},
                    {data: 'name', name: 'name'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},                    
                    {data: 'email', name: 'email'},      
                    {data: 'email', name: 'email'},     
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });         
        });
    </script>
@endsection