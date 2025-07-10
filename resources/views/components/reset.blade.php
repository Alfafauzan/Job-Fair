@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <div class="absolute top-5 left-5">
        <img src="{{ asset('images/wnn3.png') }}" alt="Winn Jobs Logo" class="h-12 w-44">
    </div>
    <div
        class="max-w-sm mx-auto p-6 rounded-2xl bg-pink-400 text-white shadow-[0_0_35px_2px_rgba(255,255,255,0.11)] backdrop-blur-sm mt-20">
        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-semibold">Mengatur ulang kata sandi baru</h2>
            </div>
            <p class="mb-4">Tentukan password baru anda !!</p>
            <div>
                <label for="password" class="block mb-1">Password</label>
                <input type="password" id="password" class="w-full p-2 rounded bg-pink-200 text-black focus:outline-none">
            </div>
            <div>
                <label for="cmpassword" class="block mb-1">Confirm Password</label>
                <input type="password" id="cmpassword" class="w-full p-2 rounded bg-pink-200 text-black focus:outline-none">
            </div>
            <button class="w-full py-3 rounded bg-blue-600 hover:bg-blue-700 font-bold mt-4 text-white">
                Melanjutkan
            </button>
        </div>
    </div>
@endsection
