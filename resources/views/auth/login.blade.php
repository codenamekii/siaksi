<?php

// 1. resources/views/auth/login.blade.php
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'SIAKSI') }} - Login</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
  <div class="min-h-screen flex items-center justify-center px-4 py-8">
    <div
      class="flex flex-col lg:flex-row w-full max-w-4xl bg-white border border-gray-300 rounded-lg shadow-lg overflow-hidden">
      <!-- Ilustrasi -->
      <div class="w-full lg:w-1/2 h-64 lg:h-auto">
        <img src="{{ asset('storage/login.jpg') }}" alt="Ilustrasi Login" class="w-full h-full object-cover">
      </div>

      <!-- Form login -->
      <div class="w-full lg:w-1/2 p-8 sm:p-10">
        <h2 class="text-2xl font-bold text-gray-800 text-center">SIAKSI</h2>
        <p class="text-sm text-gray-600 text-center">Sistem Informasi Dokumen Akreditasi</p>

        <form class="mt-8 space-y-6" action="{{ route('login.post') }}" method="POST">
          @csrf

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" name="email" type="email" autocomplete="email" required
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') @enderror"
              value="{{ old('email') }}">
            @error('email')
              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('password') @enderror">
            @error('password')
              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input id="remember" name="remember" type="checkbox"
                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
              <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
            </div>
          </div>

          <div>
            <button type="submit"
              class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Sign in
            </button>
          </div>
        </form>

        <div class="mt-6">
          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-2 bg-white text-gray-500">Login sebagai</span>
            </div>
          </div>

          <div class="mt-4 flex justify-center gap-3 flex-wrap">
            <span class="px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">GJM</span>
            <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">UJM</span>
            <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Asesor</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
