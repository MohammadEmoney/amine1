@extends('layouts.admin-panel')

@section('title', $title = 'ایجاد کاربر جدید')

@section('content')
<div class="container-fluid">
    <livewire:admin.components.live-breadcrumb :items="[['title' => 'کاربران', 'route' => route('admin.users.'.$type.'.index')], ['title' => $title]]" />
    <livewire:admin.users.live-user-create :type="$type" />
</div>
@endsection
