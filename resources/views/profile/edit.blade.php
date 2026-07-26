@extends('layouts.admin')

@section('title', 'Akun — Shuka Highschool')
@section('heading', 'Akun')
@section('subheading', 'Pengaturan profil login Anda.')

@section('content')
    <div class="mx-auto max-w-2xl space-y-6">
        <div class="soft-panel p-5 sm:p-6">
            @include('profile.partials.update-profile-information-form')
        </div>
        <div class="soft-panel p-5 sm:p-6">
            @include('profile.partials.update-password-form')
        </div>
        <div class="soft-panel p-5 sm:p-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection
