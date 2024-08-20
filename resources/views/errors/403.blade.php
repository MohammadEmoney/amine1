@extends(request()->routeIs('admin.*') ? 'layouts.admin-panel' : 'errors::minimal')

@section('title', __('Forbidden'))

@if(request()->routeIs('admin.*'))
    @section('content')
        <div class="container-fluid">
            <div class="text-center">
                <h1 class="my-5">403</h1>
                <h1 class="text-warning"><i class="ti ti-alert-octagon"></i></h1>
                <p class="mb-4">شما اجازه دسترسی به این صفحه را ندارید.</p>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-ac-primary rounded-0">بازگشت</a>
            </div>
        </div>
    @endsection
@else
    @section('code', '403')
    @section('message', __($exception->getMessage() ?: 'Forbidden'))
@endif
