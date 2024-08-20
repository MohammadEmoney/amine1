@extends('layouts.admin-panel')

@section('title', $title = 'نمایش کاربر ' . $user->full_name)

@section('content')
    <div class="container-fluid">
        <livewire:admin.components.live-breadcrumb :items="[['title' => 'کاربران', 'route' => route('admin.users.'. ($user->type ?: 'student') .'.index')], ['title' => $title]]" />
        <livewire:admin.users.live-user-show :user="$user" />
    </div>
@endsection

@push('scripts')
@endpush
