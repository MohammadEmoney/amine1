<?php

namespace App\Livewire\Admin\Users;

use App\Enums\EnumDropoutReasons;
use App\Enums\EnumEducationTypes;
use App\Enums\EnumInitialLevels;
use App\Enums\EnumMilitaryStatus;
use App\Enums\EnumUserRoles;
use App\Enums\EnumUserType;
use App\Models\Course;
use App\Models\User;
use App\Rules\JDate;
use App\Rules\ValidNationalCode;
use App\Traits\AlertLiveComponent;
use App\Traits\DateTrait;
use App\Traits\DropoutTrait;
use App\Traits\JobsTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LiveWaitingUserCreate extends Component
{
    use AlertLiveComponent;
    use WithFileUploads;
    use DateTrait;
    use JobsTrait;
    use DropoutTrait;

    public $edit = false;
    public $type;
    public $nextField;
    public $data = [];
    public $firstname;
    public $user;
    public $currentTab = 'student';
    public $disabledCreate = true;
    public $disabledEdit = true;
    public $selectedAll = false;
    public $isForeigner = false;
    public $allFalsePermissions = [];
    public $allTruePermissions = [];
    public $allAssignedPermissions = [];

    public function requiredFields()
    {
        return [
            'data.first_name' => 'required',
            'data.last_name' => 'required',
            'data.national_code' => 'required',
            'data.mobile_1' => 'required',
            'data.preferd_course' => 'required',
            'data.initial_level' => 'required',
        ];
    }

    public function rules() 
    {
        return [
            'data.first_name' => 'required|string|max:255',
            'data.last_name' => 'required|string|max:255',
            'data.father_name' => 'nullable|string|max:255',
            'data.birth_date' => ['nullable', 'string', 'max:255', new JDate()],
            'data.national_code' => ['required', 'string', 'max:255', $this->isForeigner ? "digits_between:10,255|regex:/^\d+$/" : new ValidNationalCode(), 'unique:users,national_code,' . $this->user?->id],
            'data.landline_phone' => 'nullable|regex:/^0[0-9]{10}$/',
            'data.mobile_1' => 'required|regex:/^09[0-9]{9}$/|unique:users,phone',
            'data.mobile_2' => 'nullable|regex:/^09[0-9]{9}$/|different:data.mobile_1',
            'data.address' => 'nullable|string|max:2550',
            'data.job' => 'nullable|string|max:255',
            'data.education' => 'nullable|string|max:255',
            'data.preferd_course' => 'required|string|max:255',
            'data.initial_level' => 'required|string|max:255',
            'data.register_date' => ['nullable', 'max:255', new JDate()],
            'data.email' => 'nullable|email|unique:users,email|max:255',
            'data.personal_image' => 'nullable|image|max:2048',
            'data.national_card_image' => 'nullable|image|max:2048',
            'data.refferal_name' => 'nullable|string|max:255',
            'data.refferal_national_code' => ['nullable', 'string', 'max:255', $this->isForeigner ? "digits_between:10,255|regex:/^\d+$/" : new ValidNationalCode()],
            'data.refferal_phone' => 'nullable|string|max:255',
            'isForeigner' => 'nullable|boolean',
        ];
    }

    public function mount()
    {
        $this->data['gender'] = \App\Enums\EnumUserGender::MALE;
    }

    public function studentValidation()
    {
        $this->validate([
            'data.first_name' => 'required|string|max:255',
            'data.last_name' => 'required|string|max:255',
            'data.father_name' => 'nullable|string|max:255',
            'data.birth_date' => ['nullable', 'string', 'max:255', new JDate()],
            'data.national_code' => ['required', 'string', 'max:255', $this->isForeigner ? "digits_between:10,255|regex:/^\d+$/" : new ValidNationalCode(), 'unique:users,national_code,' . $this->user?->id],
            'data.landline_phone' => 'nullable|regex:/^0[0-9]{10}$/',
            'data.mobile_1' => 'required|regex:/^09[0-9]{9}$/|unique:users,phone',
            'data.mobile_2' => 'nullable|regex:/^09[0-9]{9}$/|different:data.mobile_1',
            'data.address' => 'nullable|string|max:2550',
            'data.job' => 'nullable|string|max:255',
            'data.education' => 'nullable|string|max:255',
            'data.preferd_course' => 'required|string|max:255',
            'data.initial_level' => 'required|string|max:255',
            'data.register_date' => ['nullable', 'max:255', new JDate()],
            'data.email' => 'nullable|email|unique:users,email|max:255',
            'data.personal_image' => 'nullable|image|max:2048',
            'data.national_card_image' => 'nullable|image|max:2048',
            'data.refferal_name' => 'nullable|string|max:255',
            'data.refferal_national_code' => ['nullable', 'string', 'max:255', $this->isForeigner ? "digits_between:10,255|regex:/^\d+$/" : new ValidNationalCode()],
            'data.refferal_phone' => 'nullable|string|max:255',
            'isForeigner' => 'nullable|boolean',
        ],[],[
            'data.first_name' => 'نام',
            'data.last_name' => 'نام خانوادگی',
            'data.email' => 'پست الکترونیکی',
            'data.father_name' => 'نام پدر',
            'data.birth_date' => 'تاریخ تولد',
            'data.national_code' => 'کد ملی',
            'data.landline_phone' => 'شماره تلفن',
            'data.mobile_1' => 'شماره موبایل 1',
            'data.mobile_2' => 'شماره موبایل 2',
            'data.address' => 'آدرس منزل',
            'data.job' => 'شغل',
            'data.education' => 'تحصیلات',
            'data.preferd_course' => 'دوره مورد نیاز',
            'data.initial_level' => 'تعیین سطح اولیه',
            'data.register_date' => 'تاریخ عضویت',
            'data.national_card_image'  ?? null=> 'تصویر کارت ملی',
            'data.personal_image' => 'تصویر عکس پرسنلی',
            'data.refferal_name' => 'نام معرف',
            'data.refferal_national_code' => 'شماره ملی معرف',
            'data.refferal_phone' => 'شماره تماس معرف',
        ]);
    }

    public function updatedData($value, $key)
    {
        $this->disabledCreate = true;
        $this->studentValidation();
        $this->disabledCreate = false;
    }

    public function updated($key, $value)
    {
        $this->validateOnly($key); 
        $this->nextField($key, 'national_code', 'father_name');
        $this->nextField($key, 'landline_phone', 'mobile_1');
        $this->nextField($key, 'mobile_1', 'mobile_2');
        $this->nextField($key, 'mobile_2', 'student-address');
    }

    protected function nextField($key, $currentField, $nextField)
    {
        $currentField = 'data.' . $currentField;
        if ($key === $currentField && !$this->getErrorBag()->has($currentField)) {
            $this->dispatch('moveToNextField', $nextField);
        }
    }

    public function submitStudent()
    {
        try {
            $this->authorize('user_student_create');
            $this->dispatch('autoFocus');
            $this->studentValidation();
            DB::beginTransaction();
            $this->user = $user = User::create([
                'first_name' => $this->data['first_name'] ?? null,
                'last_name' => $this->data['last_name'] ?? null,
                'national_code' => $this->data['national_code'] ?? null,
                'email' => $this->data['email'] ?? null,
                'phone' => $this->data['phone'] ?? null,
                'is_foreigner' => $this->isForeigner ? true : false,
            ]);

            $user->userInfo()->create([
                'type' => 'student',
                'father_name' => $this->data['father_name'] ?? null,
                'birth_date' => isset($this->data['birth_date']) ? $this->convertToGeorgianDate($this->data['birth_date']) : null,
                'landline_phone' => $this->data['landline_phone'] ?? null,
                'mobile_1' => $this->data['mobile_1'] ?? null,
                'mobile_2' => $this->data['mobile_2'] ?? null,
                'address' => $this->data['address'] ?? null,
                'job' => $this->data['job'] ?? null,
                'education' => $this->data['education'] ?? null,
                'preferd_course' => $this->data['preferd_course'] ?? null,
                'initial_level' => $this->data['initial_level'] ?? null,
                'register_date' => isset($this->data['register_date']) ? $this->convertToGeorgianDate($this->data['register_date']) : null,
                'email' => $this->data['email'] ?? null,
                'refferal_name' => $this->data['refferal_name'] ?? null,
                'refferal_national_code' => $this->data['refferal_national_code'] ?? null,
                'refferal_phone' => $this->data['refferal_phone'] ?? null,
                'mariage_status' => $this->data['mariage_status'] ?? null,
                'military_status' => $this->data['military_status'] ?? null,
                'gender' => $this->data['gender'] ?? "male",
            ]);

            if($ncImage =  $this->data['national_card_image'] ?? null){
                $user->addMedia( $ncImage->getRealPath() )
                ->usingName($ncImage->getClientOriginalName())
                ->toMediaCollection('national_card');
            }

            if($personalImage =  $this->data['personal_image'] ?? null){
                $user->addMedia( $personalImage->getRealPath() )
                ->usingName($personalImage->getClientOriginalName())
                ->toMediaCollection('personal_image');
            }

            $user->assignRole('waiting-student');

            DB::commit();
            $this->alert('دانش آموز با موفقیت ثبت شد.')->success();
            return redirect()->to(route('admin.users.waiting.index'));   
        } catch (ValidationException $e) {
            $this->alert($e->getMessage())->error();
        } catch(Exception $e) {
            $this->alert($e->getMessage())->error();
        }
    }

    public function render()
    {
        $educations = EnumEducationTypes::getTranslatedAll();
        $courses = Course::active()->orderBy('priority')->get();
        $initialLevels = EnumInitialLevels::getTranslatedAll();
        $militaryStatuses = EnumMilitaryStatus::getTranslatedAll();
        $dropoutReasons = EnumDropoutReasons::getTranslatedAll();
        $roles = Role::get();
        $permissions = Permission::get();
        return view('livewire.admin.users.live-waiting-user-create', 
            compact('initialLevels', 'courses', 'educations', 'roles', 'permissions', 'militaryStatuses', 'dropoutReasons'))
            ->extends('layouts.admin-panel')
            ->section('content');
    }
}
