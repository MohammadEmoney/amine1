<div class="card mt-3">
    <div class="card-body">
        <h5 class="text-center">تطابق</h5>
        @foreach ($questions as $key => $question)
            <div class="card mt-3" dir="ltr">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="exampleInputtext1" class="form-label">شماره
                                    *</label>
                                <input type="number" class="form-control"
                                    wire:model.live.debounce.800ms="questions.{{ $key }}.number" id="exampleInputtext1" min="1"
                                    aria-describedby="textHelp" placeholder="">
                                <div>
                                    @error('questions.{{ $key }}.number')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="exampleInputtext1" class="form-label">ستون چپ
                                    *</label>
                                <input type="text" class="form-control text-start"
                                    wire:model.live.debounce.800ms="questions.{{ $key }}.left_column" id="exampleInputtext1" min="1"
                                    aria-describedby="textHelp" placeholder="Example: Reading Task 1">
                                <div>
                                    @error('questions.{{ $key }}.left_column')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="exampleInputtext1" class="form-label">ستون راست
                                    *</label>
                                <input type="text" class="form-control text-start"
                                    wire:model.live.debounce.800ms="questions.{{ $key }}.right_column" id="exampleInputtext1" min="1"
                                    aria-describedby="textHelp" placeholder="Example: Reading Task 1">
                                <div>
                                    @error('questions.{{ $key }}.right_column')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 pt-3">
                            <div class="mb-3 mb-3 pt-3">
                                <button type="button" class="btn btn-sm btn-danger" wire:click="deleteQuestion({{ $key }})"><i class="ti ti-minus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="text-center mt-3">
            <button type="button" class="btn btn-success" wire:click="addQuestion"><i class="ti ti-plus"></i> افزودن سوال</button>
        </div>
    </div>
</div>
