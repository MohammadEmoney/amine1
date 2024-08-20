 <!-- Page Header Start -->
 <div class="container-fluid page-header py-6 my-6 mt-0 wow fadeIn"
  data-wow-delay="0.1s"
  style="background: linear-gradient(rgba(0, 0, 0, .75), rgba(0, 0, 0, .75)), url({{ $background}}) center center no-repeat; background-size: cover;">
    <div class="container text-center">
        <h1 class="display-4 text-white animated slideInDown mb-4">{{ $title ?? "" }}</h1>
        {{-- <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="{{ route('home') }}">صفحه اصلی</a></li>
                @foreach ($items as $item)
                    <li class="breadcrumb-item {{ $loop->last ? 'text-primary active' : '' }}"
                        @if ($loop->last) aria-current="page" @endif>
                        @if (isset($item['route']))
                            <a href="{{ $item['route'] }}" class="text-white">{{ $item['title'] }}</a>
                        @else
                            {{ $item['title'] }}
                        @endif
                    </li>
                @endforeach
            </ol>
        </nav> --}}
    </div>
</div>
<!-- Page Header End -->