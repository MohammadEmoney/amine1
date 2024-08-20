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
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class LiveAttendanceCreate extends Component
{
    use AlertLiveComponent;
    use MediaTrait;
    use WithFileUploads;
    use DateTrait;

    public $disabledCreate = true;
    public $evaluation;
    public $time_start;
    public $data = [];
    public $rollCall = [];
    public $display;
    public $title;
    public $semester;
    public $search;
    public $paginate = 10;
    public $sort = 'created_at';
    public $sortDirection = 'DESC';

    public function mount(Semester $class)
    {
        $this->semester = $class;
        $this->display = true;
        $this->title = "حضور غیاب";
        Config::set('app.name', $this->title);
        $students = User::whereRelation('semesters', 'semester_id', $this->semester->id);
        $this->rollCall = $students->pluck('id', 'id')->map(function ($item) {
            return false;
        })->toArray();
    }

    public function validations()
    {
        $this->validate(
            [
                'data.date' => ['required', 'string', 'max:255', new JDate()],
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
        $this->disabledCreate = true;
        $this->validations();
        $this->disabledCreate = false;
    }

    public function submit()
    {
        try {
            DB::beginTransaction();
            $this->validations();
            $attendance =  Attendance::create([
                'date' => $this->convertToGeorgianDate($this->data['date']),
                'time_start' => $this->time_start ?: null,
                'semester_id' => $this->semester->id,
                'user_id' => Auth::id(),
            ]);
            $attendances = [];
            foreach($this->rollCall as $key => $value){
                $attendances[$key] = ['presence_time' => Carbon::now()->format('H:i'), 'present' => $value];
            }
            $attendance->students()->attach($attendances);
            $this->alert('حضور غیاب با موفقیت ثبت شد.')->success();
            DB::commit();
            return redirect()->to(route('profile.attendances.index', ['class' => $this->semester->id]));
        } catch (\Exception $e) {
            $this->alert($e->getMessage())->error();
        }
        
    }
    
    public function render()
    {
        $semesters = Semester::with(['course', 'teacher'])->whereRelation('teacher', 'id', Auth::id())->get();
        $students = User::whereRelation('semesters', 'semester_id', $this->semester->id);
        $search = preg_replace('/\s*\/\s*/', '/', trim($this->search));
        if($search && mb_strlen($search) > 2){
            $students = $students->where(function($query) use ($search) {
                $query->where('national_code', 'like', "%$search%")
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"]);
            });
        }
        $students = $students->orderBy($this->sort, $this->sortDirection)->paginate($this->paginate);
        return view('livewire.dashboard.attendances.live-attendance-create', compact('semesters', 'students'))
            ->extends('layouts.panel')->section('content');
    }
}
