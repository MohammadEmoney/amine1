<div class="card mt-3">
    <div class="card-body">
        {{-- @dd($questions) --}}
        @php
            $leftColumns = collect($questions)->pluck('left_column', 'number');
            $rightColumns = collect($questions)->pluck('right_column', 'number');
        @endphp
        {{-- @dd($leftColumns, $rightColumns, $rightColumns->shuffle()) --}}
        
            <div class="card mt-3 shadow-none">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                @foreach ($leftColumns as $key => $q)
                                    <div class="col-sm-12">
                                        <p class="fw-bolder">{{ $key }}. {{ $q ?: "-" }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                @foreach ($rightColumns->shuffle() as $key => $q)
                                    <div class="col-sm-12">
                                        <p class="fw-bolder">{{ chr(ord('@') + $loop->iteration) }}. {{ $q ?: "-" }}</p>
                                        {{-- <p class="fw-bolder">{{ chr(ord('`') + $loop->iteration) }}. {{ $q ?: "-" }}</p> --}}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
