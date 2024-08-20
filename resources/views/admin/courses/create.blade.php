@extends('layouts.admin-panel')

@section('title', $title = 'ایجاد دوره جدید')

@section('content')
<div class="container-fluid">
    <livewire:admin.components.live-breadcrumb :items="[['title' => 'دوره ها', 'route' => route('admin.courses.index')], ['title' => $title]]" />
    <livewire:admin.courses.live-course-create />
</div>
@endsection
