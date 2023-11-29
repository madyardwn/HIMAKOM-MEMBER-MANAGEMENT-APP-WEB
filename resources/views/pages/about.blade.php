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
                        {{ __('Aplikasi Pengelolaan Anggota Himakom, yang dikembangkan oleh UNIT TEKNOLOGI, dirancang untuk membantu efisiensi dan efektivitas dalam manajemen anggota Himpunan Mahasiswa Komputer. Aplikasi ini menyediakan berbagai fitur yang memungkinkan pengurus dan anggota Himakom untuk dengan mudah mengelola data anggota, memantau keaktifan, serta merencanakan dan melacak berbagai kegiatan yang terkait dengan himpunan.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
