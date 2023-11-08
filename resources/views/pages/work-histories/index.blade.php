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
                        {{ ucwords($activeMenu) ?? '' }}
                    </div>
                    <h2 class="page-title">
                        {{ ucwords($activeSubMenu) ?? '' }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container">
            <div class="card" id="card-work-histories">
                <div class="card-body">
                    <table id="table-work-histories" class="table table-bordered responsive w-100">
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('pages.work-histories._show')
@endsection

@section('js')
    @include('pages.work-histories._scripts')
@endsection
