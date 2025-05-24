@extends('main.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
    <h1 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->name }}</h1>
    <!-- Konten dashboard mahasiswa -->
@endsection
