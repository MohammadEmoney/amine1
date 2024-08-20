<div class="container">
    <div class="employee-container">
        <div class="row">
            @forelse ($semesters as $key => $semester)
                @include('livewire.dashboard.classes.components.class-item')
            @empty
                <p class="text-center"> هیچ دوره ای یافت نشد. <i class="ti ti-alert-piangle"></i></p>
            @endforelse
        </div>
    </div>
</div>