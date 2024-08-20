<div class="row my-3">
    <div class="col-md-12">
        <div id="collapseFilter" class="accordion-collapse collapse" aria-labelledby="headingFilter" data-bs-parent="#accordionExample" wire:ignore.self>
            <div class="accordion-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <button class="btn btn-info" wire:click="resetFilter()" type="button">ریست فیلتر</button>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" wire:model.live="filters.is_foreigner" type="checkbox" role="switch" id="is_foreigner">
                            <label class="form-check-label" for="is_foreigner">اتباع خارجی</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" wire:model.live="filters.dropout" type="checkbox" role="switch" id="dropout">
                            <label class="form-check-label" for="dropout">ریزشی</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" wire:model.live="filters.has_personal_image" type="checkbox" role="switch" id="has_personal_image">
                            <label class="form-check-label" for="has_personal_image">بدون عکس</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" wire:model.live="filters.has_national_card_image" type="checkbox" role="switch" id="has_personal_image">
                            <label class="form-check-label" for="has_personal_image">بدون کپی شناسنامه</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="exampleInputtext1" class="form-label"></label>
                            <select id="" class="form-control @error('filters.preferd_course') invalid-input @enderror"
                                wire:model.live="filters.preferd_course">
                                <option value="">دوره ها</option>
                                @foreach ($courses as $value)
                                    <option value="{{ $value->id }}">
                                        {{ $value->title_with_part }} ({{ \App\Enums\EnumCourseTypes::trans($value->type) }} / {{ \App\Enums\EnumCourseAges::trans($value->age) }})</option>
                                @endforeach
                            </select>
                            <div>
                                @error('filters.preferd_course')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>