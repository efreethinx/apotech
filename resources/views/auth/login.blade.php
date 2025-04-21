@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <div class="login-box">
        <div class="login-logo d-none">
            <p class="mb-0"><b>Login</b> Administrator</p>
        </div>

        <!-- /.login-logo -->
        <p class="login-box-msg mb-3">
            <img src="{{ $setting->url_logo }}" alt="" class="img-fluid" width="158">
        </p>

        <div class="card">
            <div class="card-body login-card-body">
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <div class="input-group has-feedback">
                            <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                placeholder="Masukan email" name="email" value="{{ old('email') }}" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-danger text-sm">
                            @if ($errors->has('email'))
                                {{ $errors->first('email') }}
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group has-feedback">
                            <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                placeholder="Masukan kata sandi" name="password" value="{!! old('password') !!}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <span class="text-danger text-sm">
                            <span class="font-weight-normal">
                                @if ($errors->has('password'))
                                    {{ $errors->first('password') }}
                                @endif
                            </span>
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block">Masuk</button>
                        </div>

                        <div class="col-12">
                            <p class="text-muted mt-3 text-center" style="font-family: 'Ma Shan Zheng', cursive;">Copyright
                                &copy; {{ $setting->nama_apotek }}</p>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
@endsection
