@extends('layouts.custom')

@section('title', 'Login')

@section('content')
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
                <img src="../assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
            @endif

            <div class="card card-primary">
                <div class="card-header">
                    <h4>Login</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('loginPost') }}" class="needs-validation" novalidate="">
                        @csrf
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input id="username" type="username"
                                class="form-control @error('username') is-invalid @enderror" name="username" tabindex="1"
                                autofocus>
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="d-block">
                                <label for="password" class="control-label">Password</label>
                            </div>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" tabindex="2">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- <div class="mt-5 text-muted text-center">
        Don't have an account? <a href="{{ route('register') }}">Create One</a>
      </div> --}}
            <footer class="simple-footer">
                <div class="container">
                    <div class="row text-nowrap">
                        <div class="col">
                            <p class="mb-0">&copy; 2023. All rights reserved.</p>
                        </div>
                        <div class="col">
                            <p class="mb-0">Design By <a href="https://www.nauv.al/">Muhamad Nauval Azhar</a></p>
                        </div>
                        <div class="col">
                            <p class="mb-0">Modified By <a href="https://rikurunico.github.io/">Wazir Nico</a></p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
