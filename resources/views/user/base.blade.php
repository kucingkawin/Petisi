@extends('layouts.app')

@section('navbar-left')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.index') }}">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.lihatPetisi') }}">Lihat Petisi</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.petisiSaya') }}">Petisi Saya</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.petisiDitandatangani') }}">Petisi Ditandatangani</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.petisiDikomentari') }}">Petisi Dikomentari</a>
    </li>
@endsection
