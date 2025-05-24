@extends('layouts.app')

@section('content')
    <h1>Dashboard Mahasiswa</h1>
    <p>Selamat datang, {{ auth()->user()->name }}!</p>
    <!-- Konten spesifik mahasiswa -->
@endsection
