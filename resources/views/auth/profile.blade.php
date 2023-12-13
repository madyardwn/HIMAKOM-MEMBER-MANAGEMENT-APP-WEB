@extends('tablar::page')

@section('css')
@endsection

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        {{ config('app.name') }}
                    </div>
                    <h2 class="page-title">
                        {{ __('My profile') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible">
                    <div class="d-flex">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l5 5l10 -10"></path>
                            </svg>
                        </div>
                        <div>
                            {{ $message }}
                        </div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            @if ($message = Session::get('errors'))
                @foreach ($message->all() as $error)
                    <div class="alert alert-danger alert-dismissible">
                        <div class="d-flex">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <line x1="9" y1="10" x2="9.01" y2="10"></line>
                                    <line x1="15" y1="10" x2="15.01" y2="10"></line>
                                    <path d="M9.5 16a10 10 0 0 1 6 -1.5"></path>
                                </svg>
                            </div>
                            <div>
                                {{ $error }}
                            </div>
                        </div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endforeach
            @endif

            <form action="{{ route('profile.update') }}" method="POST" class="card" autocomplete="off">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <label class="form-label">Picture</label>
                            <div class="mb-3">
                                <img src="{{ auth()->user()->picture }}" class="img-thumbnail">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name ?? '' }}" readonly disabled>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Gender</label>
                                    <input type="text" class="form-control" value="{{ $gender[auth()->user()->gender]  ?? '' }}" readonly disabled>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ auth()->user()->email  ?? '' }}" readonly disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIM</label>
                                <input type="number" class="form-control" value="{{ auth()->user()->nim  ?? '' }}" readonly disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NPA</label>
                                <input type="number" class="form-control" value="{{ auth()->user()->npa  ?? '' }}" readonly disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Name Bagus</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name_bagus  ?? '' }}" readonly disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Year</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->year  ?? '' }}" readonly disabled>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->roles->first()->name  ?? '' }}" readonly disabled>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Cabinet</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->cabinet->name ?? '' }}" readonly disabled>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Department</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->department->name ?? '' }}" readonly disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label required">{{ __('New password') }}</label>
                                        <div class="input-group input-group-flat">
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('New password') }}">
                                            <span class="input-group-text">
                                                <a href="#" class="link-secondary" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <circle cx="12" cy="12" r="2" />
                                                        <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                                                    </svg>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('New password confirmation') }}</label>
                                        <div class="input-group input-group-flat">
                                            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="{{ __('New password confirmation') }}" autocomplete="new-password">
                                            <span class="input-group-text">
                                                <a href="#" class="link-secondary" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <circle cx="12" cy="12" r="2" />
                                                        <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                                                    </svg>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Update Data') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
