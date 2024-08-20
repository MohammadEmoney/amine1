<?php

namespace App\Livewire\Dashboard\Attendances;

use App\Models\Attendance;
use App\Models\Semester;
use App\Models\User;
use App\Rules\JDate;
use App\Traits\AlertLiveComponent;
use App\Traits\DateTrait;
use App\Traits\MediaTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Morilog\Jalali\Jalalian;

class LiveAttendanceEdit extends Component
{
    use AlertLiveComponent;
    use MediaTrait;
    use WithFileUploads;
    use DateTrait;

    public $paginate = 10;
    public $sort = 'created_at';
    public $sortDirection = 'DESC';
    public $search;
    public $disabledCreate = true;
    public $attendance;
    public $semester;
    public $time_start;
    public $data = [];
    public $rollCall = [];
    public $initiatRollCall = [];

    public function mount(Attendance $attendance)
    {
        $this->attendance = $attendance;
        $this->data['time_start'] = $attendance->time_start;
        $this->semester = $attendance->semester;
        $convertedTime = \Morilog\Jalali\CalendarUtils::convertNumbers($attendance->time_start, true);
        $this->time_start = \Carbon\Carbon::createFromFormat('H:i:s', $convertedTime)->format('h:i');
        $this->data['date'] = Jalalian::fromDateTime($attendance->date)->format('Y-m-d');
        $this->initiateRollCalls($this->attendance);
    }

    public function initiateRollCalls($attendance)
    {
        $initiatRollCall = [];
        $rollCall = [];
        foreach($attendance->students as $student){
            $initiatRollCall[$student->id] = ['presence_time' => $student->pivot->presence_time, 'present' => $student->pivot->present];
            $rollCall[$student->id] = $student->pivot->present ? true : false;
        }
        $this->initiatRollCall = $initiatRollCall;
        $this->rollCall = $rollCall;
    }

    public function validations()
    {
        $this->validate(
            [
                'data.date' => ['required', 'max:255', new JDate()],
                'time_start' => ['required', 'string', 'max:255', 'date_format:H:i'],
            ],
            [
                'time_start.date_format' => 'فرمت شروع کلاس معتبر نمی باشد.',
            ],
            [
                'data.date' => 'تاریخ',
                'time_start' => 'شروع',
                'data.semester_id' => 'کلاس',
            ]
        );
    }

    public function updated($field, $value)
    {
        if($field == "data.time_start"){
            $convertedTime = \Morilog\Jalali\CalendarUtils::convertNumbers($value, true);
            $this->time_start = $convertedTime;
        }
        if($field == "data.semester_id"){
            $this->initiateRollCalls($this->attendance);
        }
        $this->disabledCreate = true;
        $this->validations();
        $this->disabledCreate = false;
    }

    public function submit()
    {
        try {
            DB::beginTransaction();
            $this->validations();
            $this->attendance->update([
                'date' => $this->convertToGeorgianDate($this->data['date']),
                'time_start' => $this->time_start ?: null,
            ]);
            $attendances = [];
            foreach($this->rollCall as $key => $value){
                $attendances[$key] = ['presence_time' => Carbon::now()->format('H:i'), 'present' => $value];
            }
            $this->attendance->students()->sync($attendances);
            $this->alert('حضور غیاب با موفقیت ثبت شد.')->success();
            DB::commit();
            return redirect()->to(route('profile.attendances.index', ['class' => $this->semester->id]));
        } catch (\Exception $e) {
            $this->alert($e->getMessage())->error();
        }
    }
    
    public function render()
    {
        $students = User::query()->whereRelation('semesters', 'semester_id', $this->semester->id);
        $search = preg_replace('/\s*\/\s*/', '/', trim($this->search));
        if($search && mb_strlen($search) > 2){
            $students = $students->where(function($query) use ($search) {
                $query->where('national_code', 'like', "%$search%")
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"]);
            });
        }
        $students = $students->orderBy($this->sort, $this->sortDirection)->paginate($this->paginate);
        
        $semesters = Semester::with(['course', 'teacher'])->whereRelation('teacher', 'id', Auth::id())->get();
        return view('livewire.dashboard.attendances.live-attendance-edit', compact('semesters', 'students'))
            ->extends('layouts.panel')->section('content');
    }
}
