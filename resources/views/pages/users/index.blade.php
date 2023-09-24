@extends('tablar::page')

@section('css')
    
@endsection

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        {{ ucwords($activeMenu) }}
                    </div>
                    <h2 class="page-title">
                        {{ ucwords($activeSubMenu) }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container">
            <div class="card">
                <div class="card-header">Data {{ ucwords($activeSubMenu) }}</div>
                <div class="card-body">
                    <table id="users-table" class="table table-bordered responsive w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
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
    @include('pages.users._scripts')
@endsection