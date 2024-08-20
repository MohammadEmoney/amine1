<div class="card mt-3">
    <div class="card-body">
        <h5 class="text-center">True Or False</h5>
        @foreach ($questions as $key => $question)
            <div class="card mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="exampleInputtext1" class="form-label">شماره سوال
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
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label for="exampleInputtext1" class="form-label">سوال
                                    *</label>
                                <input type="text" class="form-control text-start"
                                    wire:model.live.debounce.800ms="questions.{{ $key }}.title" id="exampleInputtext1" min="1"
                                    aria-describedby="textHelp" placeholder="Example: Reading Task 1">
                                <div>
                                    @error('questions.{{ $key }}.title')
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
                    <div class="mb-3 row">
                        <label for="answer-{{ $key }}" class="col-sm-2 col-form-label">جواب</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="answer-{{ $key }}" wire:model.live.debounce.800ms="questions.{{ $key }}.answer">
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
