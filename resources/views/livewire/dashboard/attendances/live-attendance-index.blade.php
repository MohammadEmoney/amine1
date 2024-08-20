<div dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="submit">
                        <div class="row justify-content-center">
                            <div class="col-12 border bg-ac-secondary text-white">
                                <p class="p-2 text-center">لطفا از طریق یکی از گزینه های زیر کلاس مورد نظر خود را انتخاب نمایید .</p>
                            </div>
                            <div class="col-6 border bg-ac-primary text-white text-center py-2">نام کلاس و یا کلاس مورد نظر</div>
                            <div class="col-6 border">
                                <input type="text" class="form-control border-0 text-center" wire:model.live="search" placeholder="مثلا: آیلتس\IELTS">
                            </div>
                            <div class="col-6 border text-center py-2"><span class="text-ac-primary cursor-pointer" wire:click="displayAll">مشاهده همه کلاس ها</span></div>
                            <div class="col-6 border text-center d-grid gap-2 px-0">
                                <button type="submit" class="btn btn-ac-light @if(!$disableSearchBtn) blink_me @endif rounded-0" @if($disableSearchBtn) disabled @endif>جستجو</button>
                            </div>
                        </div>
                    </form>

                    <div class="d-flex text-center justify-content-center mt-3">
                        <button class="btn btn-light" wire:click="create">ایجاد حضور غیاب +</button>
                    </div>
                </div>
            </div>

            @includeWhen($display,'livewire.dashboard.attendances.components.attendance-list')
          
        </div>
    </div>
</div>
