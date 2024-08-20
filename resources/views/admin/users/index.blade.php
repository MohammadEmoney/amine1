@extends('layouts.admin-panel')

@section('title', 'لیست کاربران')

@section('content')
    <div class="container-fluid">
        <livewire:admin.components.live-breadcrumb :items="[['title' => 'کاربران']]" />
        <livewire:admin.users.live-user-index :type="$type" />
    </div>
@endsection

@push('scripts')
@endpush
