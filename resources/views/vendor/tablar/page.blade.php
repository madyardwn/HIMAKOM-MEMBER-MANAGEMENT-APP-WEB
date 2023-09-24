@extends('tablar::master')

@inject('layoutHelper', 'TakiElias\Tablar\Helpers\LayoutHelper')

@section('tablar_css')
    @include('tablar::_styles')
    @stack('css')
    @yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="page">
        @include('tablar::partials.navbar.nav')
        <div class="page-wrapper">
            <!-- Page body -->
            @yield('content')
            @include('tablar::partials.footer.bottom')
        </div>
    </div>
@stop

@section('tablar_js')    
    @include('tablar::_scripts')
    @stack('js')
    @yield('js')
@stop

