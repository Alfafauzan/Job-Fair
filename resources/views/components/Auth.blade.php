@extends('layouts.auth')

@section('title', request()->routeIs('login') ? 'Login' : 'Register')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="w-100 rounded text-light" style="max-width: 500px; ">

            @if (session('login_error'))
                <x-showalert type="danger" title="Well fails!" footer="{{ session('login_error') }}" />
            @endif

            @if (request()->routeIs('login') || request()->routeIs('Register'))
                <form class="border rounded p-4 shadow" style="background-color: #ff65c3;"
                    action="{{ request()->routeIs('login') ? '/loginproses' : route('register.proses') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <h2 class="mb-4 ">{{ request()->routeIs('login') ? 'Login' : 'Register' }}</h2>

                    @if (request()->routeIs('Register'))
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control"
                                aria-describedby="validationServerNamaFeedback">
                            @error('nama')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                        @error('email')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    @if (request()->routeIs('Register'))
                        <div class="mb-3">
                            <label for="cmpassword" class="form-label">Confirm Password</label>
                            <input type="password" id="cmpassword" name="confrmpassword" class="form-control">
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="true" id="checkChecked"
                                name="perusahaan">
                            <label class="form-check-label" for="checkChecked">
                                Daftar Sebagai Perusahaan
                            </label>
                        </div>
                    @endif

                    @if (request()->routeIs('login'))
                        <div class="mb-3 text-end">
                            <a href="/forgetpassword" class="text-decoration-none">Lupa password?</a>
                        </div>
                    @endif
                    <button type="submit"
                        class="btn btn-primary w-100 mb-3">{{ request()->routeIs('login') ? 'Login' : 'Register' }}</button>

                    <p class="text-center">
                        {{ request()->routeIs('login') ? 'Belum Punya Akun?' : 'Sudah punya Akun?' }}
                        <a href="{{ request()->routeIs('login') ? '/register' : '/login' }}">
                            {{ request()->routeIs('login') ? 'klik untuk register' : 'klik untuk login' }}
                        </a>
                    </p>
                </form>
            @endif

            {{-- Forgot Password --}}
            @if (request()->routeIs('forgetpassword'))
                <div class="d-flex flex-column align-items-center mt-5">
                    <div class="mb-3">
                        <img src="{{ asset('images/wnn3.png') }}" alt="Winn Jobs Logo" height="50" width="180">
                    </div>
                    <form action="{{ route('password.send') }}" method="post" class="border rounded p-4 shadow w-100"
                        style="background-color: #ff65c3;">
                        @csrf
                        <h2 class="mb-3">Lupa Password</h2>
                        <p class="mb-3">Masukkan email untuk reset password</p>
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" id="email" name="email" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Reset</button>
                    </form>
                </div>
            @endif

            {{-- Verify Code --}}
            @if (request()->routeIs('reset.password'))
                <div class="d-flex flex-column align-items-center mt-5">
                    <div class="mb-3">
                        <img src="{{ asset('images/wnn3.png') }}" alt="Winn Jobs Logo" height="50" width="180">
                    </div>
                    <form action="{{ route('password.verify') }}" method="post" class="border rounded p-4 shadow w-100">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <h2 class="mb-3">Cek email anda !</h2>
                        <p class="mb-3">Kami mengirimkan link reset ke email Anda, masukkan 4 digit kode yang disebutkan
                            dalam email.</p>
                        <div class="mb-3">
                            <label for="kode" class="form-label">Kode</label>
                            <input type="number" id="kode" name="kode" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Verif Kode</button>
                    </form>
                </div>
            @endif

            {{-- New Password --}}
            @if (request()->routeIs('newpassword'))
                <div class="d-flex flex-column align-items-center mt-5">
                    <div class="mb-3">
                        <img src="{{ asset('images/wnn3.png') }}" alt="Winn Jobs Logo" height="50" width="180">
                    </div>
                    <form action="{{ route('addnewpassword') }}" method="post" class="border rounded p-4 shadow w-100">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <h2 class="mb-3">Masukkan Password Baru Anda</h2>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control" id="password">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">New Password!</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
