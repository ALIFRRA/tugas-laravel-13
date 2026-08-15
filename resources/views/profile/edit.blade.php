@extends('layouts.admin')

@section('title', 'Pengaturan Akun — SMK Shuka (秀華高等専門学校)')
@section('heading', 'Pengaturan Akun')
@section('subheading', 'Kelola informasi profil dasar dan kata sandi login Anda.')

@section('content')
    <div class="mx-auto max-w-2xl space-y-6">
        <div class="bg-white border border-slate-200 rounded-lg p-5 sm:p-6 shadow-sm">
            @include('profile.partials.update-profile-information-form')
        </div>
        <div class="bg-white border border-slate-200 rounded-lg p-5 sm:p-6 shadow-sm">
            @include('profile.partials.update-password-form')
        </div>
        <div class="bg-white border border-slate-200 rounded-lg p-5 sm:p-6 shadow-sm">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection
