@extends('layouts.admin-panel')

@section('title', $title = 'نمایش کاربر')

@section('content')
    <div class="container-fluid">
        <livewire:admin.components.live-breadcrumb :items="[['title' => $title]]" />
        <livewire:admin.users.live-user-index :user="$user" />
    </div>
@endsection

@push('scripts')
@endpush
