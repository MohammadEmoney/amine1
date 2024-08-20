<div class="row">
    <div class="col-md-4">
        <div class="form-check form-switch mb-3">
            <input class="form-check-input" wire:model.live="dropout" type="checkbox" role="switch" id="dropout">
            <label class="form-check-label" for="dropout">ریزشی</label>
        </div>
    </div>
</div>
@if ($dropout)
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3" wire:ignore>
                <label for="exampleInputtext1" class="form-label">علت ریزش دانش آموز</label>
                <select id="" class="form-control select2 @error('dropouts.reasons') invalid-input @enderror"
                    wire:model.live="dropouts.reasons" onchange="livewireSelect2Multi('dropouts.reasons', this)" multiple>
                    <option value="">انتخاب نمایید</option>
                    @foreach ($dropoutReasons as $key => $value)
                        <option value="{{ $value }}">
                            {{ $value }}</option>
                    @endforeach
                </select>
                <div>
                    @error('dropouts.reasons')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="exampleInputtext1" class="form-label">تاریخ
                    ترک *</label>
                <input type="text" class="form-control date @error('dropouts.date_left') invalid-input @enderror"
                    wire:model.live="dropouts.date_left"
                    id="date_left" aria-describedby="textHelp"
                    autocomplete="new-password"
                    data-date="{{ $dropouts['date_left'] ?? "" }}" value="{{ $dropouts['date_left'] ?? "" }}">
                <div>
                    @error('dropouts.date_left')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="exampleInputtext1" class="form-label">تاریخ
                    بازگشت</label>
                <input type="text" class="form-control date @error('dropouts.date_return') invalid-input @enderror"
                    wire:model.live="dropouts.date_return"
                    id="date_return" aria-describedby="textHelp"
                    autocomplete="new-password"
                    data-date="{{ $dropouts['date_return'] ?? "" }}" value="{{ $dropouts['date_return'] ?? "" }}">
                <div>
                    @error('dropouts.date_return')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3" wire:ignore>
                <label for="exampleInputtext1"
                    class="form-label">توضیحات</label>
                <textarea class="form-control" wire:model.live="dropouts.description" id="description" cols="10" rows="10"
                    style="height: 60px;"></textarea>
            </div>
        </div>
    </div>
@endif