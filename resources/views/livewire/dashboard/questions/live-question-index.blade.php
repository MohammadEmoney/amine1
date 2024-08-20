<div class="container-fluid" dir="rtl">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <h5 class="card-title fw-semibold">سوال ها</h5>
                <button class="btn btn-sm btn-ac-info" wire:click="create">ایجاد سوال</button>
            </div>
            @if ($questions?->count())
                <div class="table-responsive mt-4">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control border-info" wire:model.live.debounce.600="search" placeholder="جستجو ...">
                        </div>
                    </div>

                    <div dir="ltr">
                        @foreach ($questions as $key => $question )
                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <h3 class="text-center mb-3">{{ $question->section ?: "Section Title" }} <i class="ti ti-pencil fs-6 text-info cursor-pointer" wire:click="edit({{ $question->id }})"></i></h3>
                                    
                                    <h5>{{ $question->title }}</h5>
                                    <p class="fst-italic fw-bolder">{{ $question->subtitle }}</p>

                                    @if ($audio = $question->getFirstMediaUrl('audio'))
                                        <div class="col-md-6 mb-3">
                                            <audio controls class="w-100">
                                                <source
                                                src="{{ $audio }}"
                                                type="audio/mpeg"
                                                />
                                                <source
                                                src="{{ $audio }}"
                                                type="audio/ogg"
                                                />
                                                <source
                                                src="{{ $audio }}"
                                                type="audio/wav"
                                                />
                                                Audio not supported
                                            </audio>
                                        </div>
                                    @endif

                                    

                                    @if ($image = $question->getFirstMediaUrl('mainImage'))
                                        <div class="col-md-6 mb-3">
                                            <img src="{{ $image }}" alt="" class="img-fluid" style="height: auto">
                                        </div>
                                    @endif



                                    <div>{!! $question->description !!}</div>
                                </div>
                                @includeWhen($question->type === \App\Enums\EnumQuestionType::MULTICHOICE, 'livewire.admin.questions.displays.multiple-choice', ['questions' => $question->questions])
                                @includeWhen($question->type === \App\Enums\EnumQuestionType::MATCHING, 'livewire.admin.questions.displays.matching', ['questions' => $question->questions])
                                @includeWhen($question->type === \App\Enums\EnumQuestionType::TRUE_OR_FALSE, 'livewire.admin.questions.displays.t-or-f', ['questions' => $question->questions])
                                @includeWhen($question->type === \App\Enums\EnumQuestionType::DESCRIPTION, 'livewire.admin.questions.displays.description', ['questions' => $question->questions])
                            </div>
                        @endforeach
                    </div>
                    
                    {{ $questions->links() }}
                </div>
            @else
                <div class="row">
                    <p class="text-center"> هیچ سوالی یافت نشد. <i class="ti ti-alert-piangle"></i></p>
                </div>
            @endif
        </div>
    </div>
</div>
