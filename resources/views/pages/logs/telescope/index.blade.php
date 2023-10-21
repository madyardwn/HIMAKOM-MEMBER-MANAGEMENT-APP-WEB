@extends('tablar::page')

@section('css')
<style>
    iframe {
        width: 100%; /* Menggunakan lebar viewport (viewport width) untuk mengisi seluruh lebar layar */
        height: 100vh; /* Menggunakan tinggi viewport (viewport height) untuk mengisi seluruh tinggi layar */
        transform: scale(0.8); /* Mengatur faktor zoom 0.8 (80% dari ukuran asli) */
        transform-origin: 0 0; /* Mengatur titik asal transformasi ke sudut kiri atas */
        position: absolute; /* Menempatkan iframe di luar aliran dokumen */
        overflow: hidden; /* Menghapus scroll */
    } 
</style>
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
    <div class="page-body">
        <div class="container">
            <iframe src="{{ env('APP_ENV') === 'local' ? '/telescope' : env('APP_URL') . '/telescope' }}" frameborder="0"></iframe>
        </div>
    </div>
@endsection

@section('js')
@endsection
