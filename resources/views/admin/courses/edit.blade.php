@extends('layouts.admin-panel')

@section('title', $title = 'ویرایش دوره ' . $course->title)

@section('content')
<div class="container-fluid">
    <livewire:admin.components.live-breadcrumb :items="[['title' => 'دوره ها', 'route' => route('admin.courses.index')], ['title' => $title]]" />
    <livewire:admin.courses.live-course-edit :course="$course" />
</div>
@endsection
