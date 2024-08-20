<div class="card mt-3">
    <div class="card-body">
        @foreach ($questions as $key => $q)
            <div class="card mt-3 shadow-none">
                <div class="card-body p-0">
                   <div class="row">
                        <div class="col-sm-9">
                            <p class="fw-bolder">{{ $q['number'] ?? $key + 1 }}. {{ $q['title'] ?? "-" }}</p>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions{{ $key }}" id="inlineRadio{{ $key }}" value="1">
                                <label class="form-check-label" for="inlineRadio{{ $key }}">True</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions{{ $key }}" id="inlineRadio{{ $key }}" value="0">
                                <label class="form-check-label" for="inlineRadio{{ $key }}">False</label>
                              </div>
                        </div>
                   </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
