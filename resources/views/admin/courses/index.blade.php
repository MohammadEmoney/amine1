@extends('layouts.admin-panel')

@section('title', $title = 'لیست دوره ها')

@section('content')
    <div class="container-fluid">
        <livewire:admin.components.live-breadcrumb :items="[['title' => $title]]" />
        <livewire:admin.courses.live-course-index />
    </div>
@endsection

@push('scripts')
@endpush
