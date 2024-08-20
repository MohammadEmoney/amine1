<!DOCTYPE html>
<html lang="en">

@include('layouts.front_partials.head')

<body dir="rtl">
    @include('layouts.front_partials.nav')
    @yield('content')
    @include('layouts.front_partials.footer')
   @include('layouts.front_partials.script')
</body>

</html>
