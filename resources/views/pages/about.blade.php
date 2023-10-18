@extends('tablar::page')

@section('css')

@endsection

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <h2 class="page-title">
                {{ __('About Page') }}
            </h2>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <p class="card-text">
                        {{ __('This is a about page.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
