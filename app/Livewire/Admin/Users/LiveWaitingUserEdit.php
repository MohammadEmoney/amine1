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
use Morilog\Jalali\Jalalian;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LiveWaitingUserEdit extends Component
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

    public function mount(User $user)
    {
        $this->user = $user;
        $this->type = $this->user->userInfo->type;
        $permissions = Permission::all();
        $this->allFalsePermissions = $permissions->pluck('id', 'id')->map(function ($item) {
            return false;
        })->toArray();
        $rolePermissions = $this->user->permissions()->pluck('id', 'id')->map(function ($item) {
            return true;
        })->toArray();
        $this->allTruePermissions = $permissions->pluck('id', 'id')->map(function ($item) {
            return true;
        })->toArray();
        $this->allAssignedPermissions = $permissions->pluck('id', 'id')->map(function ($item) {
            return true;
        })->toArray();
        $meregedArray = $rolePermissions + $this->allFalsePermissions;
        $this->data['direct_permissions'] = $meregedArray;
        $this->data['role'] = $this->user->getRoleNames()->first();

        $this->loadData();
    }

    public function loadData()
    {
        $this->isForeigner = $this->user->is_foreigner ? true : false;
        $this->data['first_name'] = $this->user->first_name;
        $this->data['last_name'] = $this->user->last_name;
        $this->data['national_code'] = $this->user->national_code;
        $this->data['gender'] = $this->user->userInfo->gender;
        $this->data['father_name'] = $this->user->userInfo->father_name;
        $this->data['birth_date'] = Jalalian::fromDateTime($this->user->userInfo->birth_date)->format('Y-m-d');
        $this->data['register_date'] = Jalalian::fromDateTime($this->user->userInfo->register_date)->format('Y-m-d');
        $this->data['landline_phone'] = $this->user->userInfo->landline_phone;
        $this->data['mobile_1'] = $this->user->userInfo->mobile_1;
        $this->data['mobile_2'] = $this->user->userInfo->mobile_2;
        $this->data['address'] = $this->user->userInfo->address;
        $this->data['job'] = $this->user->userInfo->job;
        $this->data['education'] = $this->user->userInfo->education;
        $this->data['preferd_course'] = $this->user->userInfo->preferd_course;
        $this->data['initial_level'] = $this->user->userInfo->initial_level;
        $this->data['email'] = $this->user->userInfo->email;
        $this->data['refferal_name'] = $this->user->userInfo->refferal_name;
        $this->data['refferal_national_code'] = $this->user->userInfo->refferal_national_code;
        $this->data['refferal_phone'] = $this->user->userInfo->refferal_phone;
        $this->data['mariage_status'] = $this->user->userInfo->mariage_status;
        $this->data['military_status'] = $this->user->userInfo->military_status;

        $this->data['national_card_image'] = $this->user->getFirstMedia('national_card');
        $this->data['personal_image'] = $this->user->getFirstMedia('personal_image');
        $this->data['id_first_page_image'] = $this->user->getFirstMedia('id_first_page');
        $this->data['id_second_page_image'] = $this->user->getFirstMedia('id_second_page');
        $this->data['document_image_1'] = $this->user->getFirstMedia('document_1');
        $this->data['document_image_2'] = $this->user->getFirstMedia('document_2');
        $this->data['document_image_3'] = $this->user->getFirstMedia('document_3');
        $this->data['document_image_4'] = $this->user->getFirstMedia('document_4');
        $this->data['document_image_5'] = $this->user->getFirstMedia('document_5');
        $this->data['document_image_6'] = $this->user->getFirstMedia('document_6');
        $this->data['document_image_7'] = $this->user->getFirstMedia('document_7');
        $this->data['document_image_8'] = $this->user->getFirstMedia('document_8');

        foreach($this->user->jobReferences as $job)
            $this->tempJobs[$job->id] = $job->toArray();
    }

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
            $user = $this->user;
            DB::beginTransaction();
            $user->update([
                'first_name' => $this->data['first_name'] ?? null,
                'last_name' => $this->data['last_name'] ?? null,
                'national_code' => $this->data['national_code'] ?? null,
                'email' => $this->data['email'] ?? null,
                'phone' => $this->data['phone'] ?? null,
                'is_foreigner' => $this->isForeigner ? true : false,
            ]);

            $user->userInfo()->update([
                'father_name' => $this->data['father_name'] ?? null,
                // 'birth_date' => isset($this->data['birth_date']) ? $this->convertToGeorgianDate($this->data['birth_date']) : null,
                'landline_phone' => $this->data['landline_phone'] ?? null,
                'mobile_1' => $this->data['mobile_1'] ?? null,
                'mobile_2' => $this->data['mobile_2'] ?? null,
                'address' => $this->data['address'] ?? null,
                'job' => $this->data['job'] ?? null,
                'education' => $this->data['education'] ?? null,
                'email' => $this->data['email'] ?? null,
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

            DB::commit();
            $this->alert('دانش آموز با موفقیت ثبت شد.')->success();
            return redirect()->to(route('admin.users.waiting.index'));   
        } catch (ValidationException $e) {
            $this->alert($e->getMessage())->error();
        } catch(Exception $e) {
            $this->alert($e->getMessage())->error();
        }
    }

    public function addToUsers()
    {
        $this->user;
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
        return view('livewire.admin.users.live-waiting-user-edit', 
            compact('initialLevels', 'courses', 'educations', 'roles', 'permissions', 'militaryStatuses', 'dropoutReasons'))
            ->extends('layouts.admin-panel')
            ->section('content');
    }
}
