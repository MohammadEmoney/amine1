<?php

namespace App\Livewire\Admin\Attendances;

use App\Models\Attendance;
use App\Models\Semester;
use Livewire\Component;
use Morilog\Jalali\Jalalian;

class LiveAttendanceShow extends Component
{
    public $semester;
    public $dates;
    public $students;
    public $attendances;

    public function mount(Semester $semester)
    {
        $this->semester = $semester->load('attendances.students');
        $this->dates = $this->semester->attendances->pluck('date')->map(function($item, $key){
            return Jalalian::fromDateTime($item)->format('Y-m-d');
        });
        $attendances = [];
        // foreach($this->semester->attendances as $attendance){
        //     foreach($attendance->students as $student){
        //         $attendances[$attendance->date->format('Y-m-d')][] = [
        //             'id' => $student->id,
        //             'name' => $student->full_name,
        //             'present' => $student->pivot->present,
        //             'date' => Jalalian::fromDateTime($attendance->date)->format('Y-m-d')
        //         ];
        //     }
        // }
        // Create an entry for each student
        foreach ($this->semester->students as $student) {
            $attendances[$student->id]['name'] = $student->full_name;
            // Initialize attendance for each date as blank
            foreach ($this->dates as $date) {
                $attendances[$student->id]['attendance'][$date] = null; // Use null or '' for blank
            }
        }

        // Fill in the actual attendance records
        foreach ($this->semester->attendances as $attendance) {
            foreach ($attendance->students as $student) {
                $attendances[$student->id]['attendance'][Jalalian::fromDateTime($attendance->date)->format('Y-m-d')] = $student->pivot->present;
            }
        }
        $this->attendances = $attendances;
    }

    public function render()
    {
        return view('livewire.admin.attendances.live-attendance-show')->extends('layouts.admin-panel')->section('content');
    }
}
