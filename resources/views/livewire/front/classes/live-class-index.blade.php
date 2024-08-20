<div>
    @include('front.components.header', [
        'background' => asset('front/img/carousel-1.jpg'),
        'title' => $title,
        'subTitle' => '',
        'items' => [['title' => $title]]
    ])

    <!-- Courses Start -->
    <div class="container-xxl">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h6 class="text-primary text-uppercase mb-2">دوره های تخصصی</h6>
                <h1 class="display-6 mb-4">برنامه های آموزشی متنوع و کاربردی برای یادگیری زبان انگلیسی</h1>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach ($semesters as $key => $semester)
                    <div class="col-lg-4 col-md-6">
                        <livewire:front.components.live-class-item :key="$semester->id" :semester="$semester" />
                    </div>
                @endforeach
            </div>
            <div class="mt-3">
                {{ $semesters->links("pagination::bootstrap-6") }}
            </div>
        </div>
    </div>
    <!-- Courses End -->
</div>