<?php

namespace App\Livewire\Admin\Users;

use App\Enums\EnumCourseTypes;
use App\Enums\EnumDropoutReasons;
use App\Enums\EnumEducationTypes;
use App\Enums\EnumInitialLevels;
use App\Enums\EnumMilitaryStatus;
use App\Enums\EnumUserRoles;
use App\Enums\EnumUserType;
use App\Models\Course;
use App\Models\Transaction;
use App\Models\User;
use App\Rules\JDate;
use App\Rules\ValidNationalCode;
use App\Traits\AlertLiveComponent;
use App\Traits\DateTrait;
use App\Traits\DropoutTrait;
use App\Traits\JobsTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LiveUserCreate extends Component
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
    public $dropout = false;
    public $allFalsePermissions = [];
    public $allTruePermissions = [];
    public $allAssignedPermissions = [];

    public function requiredFields()
    {
        if($this->type == 'student'){
            return [
                'data.first_name' => 'required',
                'data.last_name' => 'required',
                'data.father_name' => 'required',
                'data.birth_date' => 'required',
                'data.national_code' => 'required',
                'data.mobile_1' => 'required',
                'data.address' => 'required',
                'data.preferd_course' => 'required',
                'data.initial_level' => 'required',
                'data.register_date' => 'required',
                'data.personal_image' => 'required',
                'data.national_card_image' => 'required',
            ];
        }elseif($this->type == 'staff'){
            return [
                'data.first_name' => 'required',
                'data.last_name' => 'required',
                'data.father_name' => 'required',
                'data.birth_date' => 'required',
                'data.national_code' => 'required',
                'data.mobile_1' => 'required',
                'data.address' => 'required',
                'data.email' => 'required',
                'data.password' => 'required',
                'data.mariage_status' => 'required',
                'data.gender' => 'required',
                'data.national_card_image' => 'required',
                'data.personal_image' => 'required',
                'data.id_first_page_image' => 'required',
                'data.id_second_page_image' => 'required',
                'data.document_image_1' => 'required',
                'data.document_image_2' => 'required',
            ];
        }else{
            return [];
        }
    }

    public function rules() 
    {
        if($this->type == 'student'){
            return [
                'data.first_name' => 'required|string|max:255',
                'data.last_name' => 'required|string|max:255',
                'data.father_name' => 'required|string|max:255',
                'data.birth_date' => ['required', 'string', 'max:255', new JDate()],
                'data.national_code' => ['required', 'string', 'max:255', $this->isForeigner ? "digits_between:10,255|regex:/^\d+$/" : new ValidNationalCode(), 'unique:users,national_code,' . $this->user?->id],
                'data.landline_phone' => 'nullable|regex:/^0[0-9]{10}$/',
                'data.mobile_1' => 'required|regex:/^09[0-9]{9}$/|unique:user_infos,mobile_1',
                'data.mobile_2' => 'nullable|regex:/^09[0-9]{9}$/|different:data.mobile_1',
                'data.address' => 'required|string|max:2550',
                'data.job' => 'nullable|string|max:255',
                'data.education' => 'nullable|string|max:255',
                'data.preferd_course' => 'required|string|max:255',
                'data.initial_level' => 'required|string|max:255',
                'data.register_date' => ['required', 'max:255', new JDate()],
                'data.email' => 'nullable|email|unique:users,email|max:255',
                'data.personal_image' => 'required|image|max:2048',
                'data.national_card_image' => 'required|image|max:2048',
                'data.refferal_name' => 'nullable|string|max:255',
                'data.refferal_national_code' => ['nullable', 'string', 'max:255', $this->isForeigner ? "digits_between:10,255|regex:/^\d+$/" : new ValidNationalCode()],
                'data.refferal_phone' => 'nullable|string|max:255',
                'isForeigner' => 'nullable|boolean',
            ];
        }elseif($this->type == 'staff'){
            return [
                'data.first_name' => 'required|string|max:255',
                'data.last_name' => 'required|string|max:255',
                'data.father_name' => 'required|string|max:255',
                'data.birth_date' => ['required', 'string', 'max:255', new JDate()],
                'data.national_code' => ['required', 'string', 'max:255', $this->isForeigner ? "" : new ValidNationalCode(), 'unique:users,national_code,' . $this->user?->id],
                'data.landline_phone' => 'nullable|regex:/^0[0-9]{10}$/',
                'data.mobile_1' => 'required|regex:/^09[0-9]{9}$/|unique:user_infos,mobile_1',
                'data.mobile_2' => 'required|regex:/^09[0-9]{9}$/|different:data.mobile_1',
                'data.address' => 'required|string|max:2550',
                'data.job' => 'nullable|string|max:255',
                'data.education' => 'nullable|string|max:255',
                'data.email' => 'required|email|max:255|unique:users,email',
                'data.password' => 'required|confirmed|min:8|max:255',
                'data.mariage_status' => 'required|boolean|max:255',
                'data.gender' => 'required|in:male,female|max:255',
                'data.military_status' => 'required_if:data.gender,male|string|max:255',
                'data.national_card_image' => 'required|image|max:2048',
                'data.personal_image' => 'required|image|max:2048',
                'data.id_first_page_image' => 'required|image|max:2048',
                'data.id_second_page_image' => 'required|image|max:2048',
                'data.document_image_1' => 'required|image|max:2048',
                'data.document_image_2' => 'required|image|max:2048',
                'data.document_image_3' => 'nullable|image|max:2048',
                'data.document_image_4' => 'nullable|image|max:2048',
                'data.document_image_5' => 'nullable|image|max:2048',
                'data.document_image_6' => 'nullable|image|max:2048',
                'data.document_image_7' => 'nullable|image|max:2048',
                'data.document_image_8' => 'nullable|image|max:2048',
                'data.role' =>  auth()->user()->hasRole('super-admin') ? 'required|exists:roles,name' : 'nullable',
                'isForeigner' => 'nullable|boolean',
            ];
        }else{
            return [];
        }
    }

    public function mount()
    {
        $permissions = Permission::all();
        $this->allFalsePermissions = $permissions->pluck('id', 'id')->map(function ($item) {
            return false;
        })->toArray();
        $this->allTruePermissions = $permissions->pluck('id', 'id')->map(function ($item) {
            return true;
        })->toArray();
        $this->data['direct_permissions'] = $this->allFalsePermissions;

        $this->data['gender'] = \App\Enums\EnumUserGender::MALE;
    }

    public function selectAll()
    {
        if(isset($this->data['direct_permissions']) && $this->selectedAll){
            $this->data['direct_permissions'] = $this->allTruePermissions;
        }else{
            $this->data['direct_permissions'] = $this->allFalsePermissions;
        }
    }

    public function studentValidation()
    {
        $this->validate([
            'data.first_name' => 'required|string|max:255',
            'data.last_name' => 'required|string|max:255',
            'data.father_name' => 'required|string|max:255',
            'data.birth_date' => ['required', 'string', 'max:255', new JDate()],
            'data.national_code' => ['required', 'string', 'max:255', $this->isForeigner ? "" : new ValidNationalCode(), 'unique:users,national_code,' . $this->user?->id],
            'data.landline_phone' => 'nullable|regex:/^0[0-9]{10}$/',
            'data.mobile_1' => 'required|regex:/^09[0-9]{9}$/|unique:user_infos,mobile_1',
            'data.mobile_2' => 'nullable|regex:/^09[0-9]{9}$/|different:data.mobile_1',
            'data.address' => 'required|string|max:2550',
            'data.job' => 'nullable|string|max:255',
            'data.education' => 'nullable|string|max:255',
            'data.preferd_course' => 'required|string|max:255',
            'data.initial_level' => 'required|string|max:255',
            'data.register_date' => ['required', 'max:255', new JDate()],
            'data.email' => 'nullable|email|unique:users,email|max:255',
            'data.personal_image' => 'nullable|image|max:2048',
            'data.national_card_image'  ?? null=> 'nullable|image|max:2048',
            'data.refferal_name' => 'nullable|string|max:255',
            'data.refferal_national_code' => ['nullable', 'string', 'max:255', $this->isForeigner ? "" : new ValidNationalCode()],
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

    public function staffValidation()
    {
        $this->validate([
            'data.first_name' => 'required|string|max:255',
            'data.last_name' => 'required|string|max:255',
            'data.father_name' => 'required|string|max:255',
            'data.birth_date' => ['required', 'string', 'max:255', new JDate()],
            'data.national_code' => ['required', 'string', 'max:255', $this->isForeigner ? "" : new ValidNationalCode(), 'unique:users,national_code,' . $this->user?->id],
            'data.landline_phone' => 'nullable|regex:/^0[0-9]{10}$/',
            'data.mobile_1' => 'required|regex:/^09[0-9]{9}$/|unique:user_infos,mobile_1',
            'data.mobile_2' => 'nullable|regex:/^09[0-9]{9}$/|different:data.mobile_1',
            'data.address' => 'required|string|max:2550',
            'data.job' => 'nullable|string|max:255',
            'data.education' => 'nullable|string|max:255',
            'data.email' => 'required|email|max:255|unique:users,email',
            'data.password' => 'required|confirmed|min:8|max:255',
            'data.mariage_status' => 'required|boolean|max:255',
            'data.gender' => 'required|in:male,female|max:255',
            'data.military_status' => 'required_if:data.gender,male|string|max:255',
            'data.national_card_image'  ?? null=> 'required|image|max:2048',
            'data.personal_image' => 'required|image|max:2048',
            'data.id_first_page_image' => 'required|image|max:2048',
            'data.id_second_page_image' => 'required|image|max:2048',
            'data.document_image_1' => 'required|image|max:2048',
            'data.document_image_2' => 'required|image|max:2048',
            'data.document_image_3' => 'nullable|image|max:2048',
            'data.document_image_4' => 'nullable|image|max:2048',
            'data.document_image_5' => 'nullable|image|max:2048',
            'data.document_image_6' => 'nullable|image|max:2048',
            'data.document_image_7' => 'nullable|image|max:2048',
            'data.document_image_8' => 'nullable|image|max:2048',
            'data.role' =>  auth()->user()->hasRole('super-admin') ? 'required|exists:roles,name' : 'nullable',
            'isForeigner' => 'nullable|boolean',
        ],[
            'data.military_status.required_if' => 'فیلد وضعیت نظام وظیفه در صورتی که جنسیت آقا انتخاب شده باشد الزامی می باشد.'
        ],[
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
            'data.register_date' => 'تاریخ عضو یت',
            'data.national_card_image'  ?? null=> 'تصویر کارت ملی',
            'data.personal_image' => 'تصویر عکس پرسنلی',
            'data.refferal_name' => 'نام معرف',
            'data.refferal_national_code' => 'شماره ملی معرف',
            'data.refferal_phone' => 'شماره تماس معرف',
            'data.mariage_status' => 'وضعیت تاهل',
            'data.military_status' => 'وضعیت نظام وظیفه',
            'data.id_first_page_image' => 'بارگذاری شناسنامه ص 1',
            'data.id_second_page_image' => 'بارگذاری شناسنامه ص 2',
            'data.document_image_1' => 'بارگذاری مدارک 1',
            'data.document_image_2' => 'بارگذاری مدارک 2',
            'data.document_image_3' => 'بارگذاری مدارک 3',
            'data.document_image_4' => 'بارگذاری مدارک 4',
            'data.document_image_5' => 'بارگذاری مدارک 5',
            'data.document_image_6' => 'بارگذاری مدارک 6',
            'data.document_image_7' => 'بارگذاری مدارک 7',
            'data.document_image_8' => 'بارگذاری مدارک 8',
            'data.role' => 'نقش کاربر',
            'data.gender' => 'جنسیت',
            'data.password' => 'رمز عبور',
        ]);
    }

    public function updatedData($value, $key)
    {
        $this->disabledCreate = true;
        if($this->type == 'student')
            $this->studentValidation();
        elseif($this->type == 'staff')
            $this->staffValidation();

        $this->disabledCreate = false;
    }

    public function updated($key, $value)
    {
        $this->validateOnly($key); 
        $this->nextField($key, 'national_code', 'father_name');
        $this->nextField($key, 'landline_phone', 'mobile_1');
        $this->nextField($key, 'mobile_1', 'mobile_2');
        $this->nextField($key, 'mobile_2', 'student-address');

        if($key === 'dropout'){
            $this->dispatch('loadDatePicker');
        }
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
            if($this->dropout){
                $this->dropoutRules();
            }
            DB::beginTransaction();
            $this->user = $user = User::create([
                'first_name' => $this->data['first_name'] ?? null,
                'last_name' => $this->data['last_name'] ?? null,
                'national_code' => $this->data['national_code'] ?? null,
                'email' => $this->data['email'] ?? null,
                'phone' => $this->data['mobile_1'] ?? null,
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

            $user->assignRole('student');

            if($this->dropout){
                $this->createDropout($user);
            }
            DB::commit();
            $this->alert('دانش آموز با موفقیت ثبت شد.')->success();
            return redirect()->to(route('admin.users.student.index'));   
        } catch (ValidationException $e) {
            $this->alert($e->getMessage())->error();
        } catch(Exception $e) {
            $this->alert($e->getMessage())->error();
        }
    }

    public function submitStaff()
    {
        try {
            $this->authorize('user_create');
            $this->dispatch('autoFocus');
            $this->staffValidation();
            DB::beginTransaction();
            $this->user = $user = User::create([
                'first_name' => $this->data['first_name'] ?? null,
                'last_name' => $this->data['last_name'] ?? null,
                'national_code' => $this->data['national_code'] ?? null,
                'email' => $this->data['email'] ?? null,
                'phone' => $this->data['mobile_1'] ?? null,
                'password' => isset($this->data['password']) ? Hash::make($this->data['password']) : null,
                'is_foreigner' => $this->isForeigner ? true : false,
            ]);

            $user->userInfo()->create([
                'type' => EnumUserType::STAFF,
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

            $this->saveJobs($user);

            $this->createImages($user);

            $user->assignRole($this->data['role'] ?? EnumUserRoles::TEACHER);
            $selectedPermissions = collect($this->data['direct_permissions'])->map(function($value, $key){
                if($value)
                    return $key;
            })->filter();
            $permissions = Permission::whereIn('id', $selectedPermissions)->pluck('name');
            $user->givePermissionTo($permissions);
            DB::commit();
            $this->alert('کاربر با موفقیت ثبت شد.')->success();
            return redirect()->to(route('admin.users.staff.index'));
        } catch (ValidationException $e) {
            $this->alert($e->getMessage())->error();
        } catch(Exception $e) {
            $this->alert($e->getMessage())->error();
        }
    }

    protected function createImages(User $user)
    {
        $user
            ->addMedia($this->data['national_card_image']->getRealPath())
            ->usingName($this->data['national_card_image']->getClientOriginalName())
            ->toMediaCollection('national_card');
        $this->data['national_card_image'] = null;
        $user
            ->addMedia($this->data['personal_image']->getRealPath())
            ->usingName($this->data['personal_image']->getClientOriginalName())
            ->toMediaCollection('personal_image');
        $this->data['personal_image'] = null;
        $user
            ->addMedia($this->data['id_first_page_image']->getRealPath())
            ->usingName($this->data['id_first_page_image']->getClientOriginalName())
            ->toMediaCollection('id_first_page');
        $this->data['id_first_page_image'] = null;
        $user
            ->addMedia($this->data['id_second_page_image']->getRealPath())
            ->usingName($this->data['id_second_page_image']->getClientOriginalName())
            ->toMediaCollection('id_second_page');
        $this->data['id_second_page_image'] = null;
        $user
            ->addMedia($this->data['document_image_1']->getRealPath())
            ->usingName($this->data['document_image_1']->getClientOriginalName())
            ->toMediaCollection('document_1');
        $this->data['document_image_1'] = null;
        $user
            ->addMedia($this->data['document_image_2']->getRealPath())
            ->usingName($this->data['document_image_2']->getClientOriginalName())
            ->toMediaCollection('document_2');
        $this->data['document_image_2'] = null;
        $user
            ->addMedia($this->data['document_image_3']->getRealPath())
            ->usingName($this->data['document_image_3']->getClientOriginalName())
            ->toMediaCollection('document_3');
        $this->data['document_image_3'] = null;
        if(isset($this->data['document_image_4']) && !is_null($this->data['document_image_4'])){
            $user
                ->addMedia($this->data['document_image_4']->getRealPath())
                ->usingName($this->data['document_image_4']->getClientOriginalName())
                ->toMediaCollection('document_4');
            $this->data['document_image_4'] = null;
        }
        if(isset($this->data['document_image_5']) && !is_null($this->data['document_image_5'])){
            $user
                ->addMedia($this->data['document_image_5']->getRealPath())
                ->usingName($this->data['document_image_5']->getClientOriginalName())
                ->toMediaCollection('document_5');
            $this->data['document_image_5'] = null;
        }
        if(isset($this->data['document_image_6']) && !is_null($this->data['document_image_6'])){
            $user
                ->addMedia($this->data['document_image_6']->getRealPath())
                ->usingName($this->data['document_image_6']->getClientOriginalName())
                ->toMediaCollection('document_6');
            $this->data['document_image_6'] = null;
        }
        if(isset($this->data['document_image_7']) && !is_null($this->data['document_image_7'])){
            $user
                ->addMedia($this->data['document_image_7']->getRealPath())
                ->usingName($this->data['document_image_7']->getClientOriginalName())
                ->toMediaCollection('document_7');
            $this->data['document_image_7'] = null;
        }
        if(isset($this->data['document_image_8']) && !is_null($this->data['document_image_8'])){
            $user
                ->addMedia($this->data['document_image_8']->getRealPath())
                ->usingName($this->data['document_image_8']->getClientOriginalName())
                ->toMediaCollection('document_8');
            $this->data['document_image_8'] = null;
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
        return view('livewire.admin.users.live-user-create', compact('initialLevels', 'courses', 'educations', 'roles', 'permissions', 'militaryStatuses', 'dropoutReasons'));
    }
}
