<div class="card mt-3">
    <div class="card-body">
        @foreach ($questions as $key => $q)
            <div class="card mt-3 shadow-none">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="fw-bolder">{{ $q['number'] ?? $key + 1 }}. {{ $q['title'] ?? "-" }}</p>
                        </div>
                        @foreach ($q['choices'] ?? [] as $choiceKey => $choice)
                            <div class="col">
                                <span>{{ $choice['id'] ?? $choiceKey + 1 }}) {{ $choice['title'] ?? "-" }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
