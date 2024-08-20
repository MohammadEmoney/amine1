<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\HomeController;
use App\Livewire\Admin\Attendances\LiveAttendanceIndex;
use App\Livewire\Admin\Attendances\LiveAttendanceShow;
use App\Livewire\Admin\Books\LiveBookCreate;
use App\Livewire\Admin\Books\LiveBookEdit;
use App\Livewire\Admin\Books\LiveBookIndex;
use App\Livewire\Admin\Evaluations\LiveEvaluationCreate;
use App\Livewire\Admin\Evaluations\LiveEvaluationEdit;
use App\Livewire\Admin\Evaluations\LiveEvaluationIndex;
use App\Livewire\Admin\LessonPlans\LiveLessonPlanCreate;
use App\Livewire\Admin\LessonPlans\LiveLessonPlanEdit;
use App\Livewire\Admin\LessonPlans\LiveLessonPlanIndex;
use App\Livewire\Admin\Messages\LiveMessageCreate;
use App\Livewire\Admin\Messages\LiveMessageIndex;
use App\Livewire\Admin\Orders\LiveOrderCreate;
use App\Livewire\Admin\Orders\LiveOrderEdit;
use App\Livewire\Admin\Orders\LiveOrderIndex;
use App\Livewire\Admin\Orders\LiveOrderShow;
use App\Livewire\Admin\Questions\LiveQuestionCreate;
use App\Livewire\Admin\Questions\LiveQuestionEdit;
use App\Livewire\Admin\Questions\LiveQuestionIndex;
use App\Livewire\Admin\Semesters\LiveSemesterCreate;
use App\Livewire\Admin\Semesters\LiveSemesterEdit;
use App\Livewire\Admin\Semesters\LiveSemesterIndex;
use App\Livewire\Admin\Users\LiveDeletedUsers;
use App\Livewire\Admin\Users\LiveUserPassword;
use App\Livewire\Dashboard\Classes\LiveClassIndex;
use App\Livewire\Dashboard\Classes\LiveClassShow;
use App\Livewire\Dashboard\Classes\LiveStudentIndex;
use App\Livewire\Dashboard\Courses\LiveCourseSelect;
use App\Livewire\Front\Classes\LiveClassIndex as ClassesLiveClassIndex;
use App\Livewire\Front\Classes\LiveClassShow as ClassesLiveClassShow;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/** Admin Routes */

Route::prefix('admin')->name('admin.')->group(function(){
    Route::post('upload', [ImageController::class, 'upload'])->name('image_upload');
    Route::get('login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'login'])->name('login');
    Route::redirect('/', '/admin/dashboard');
    Route::middleware('auth')->group(function(){
        Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Settings
        Route::get('settings', \App\Livewire\Admin\Settings\LiveSettings::class)->name('settings.general')->middleware('can:general_settings');

        Route::prefix('users')->name('users.')->group(function(){

            Route::get('password', LiveUserPassword::class)->name('password');
            Route::get('trash', LiveDeletedUsers::class)->name('trash');

            Route::get('dropouts', App\Livewire\Admin\Dropouts\LiveDropoutIndex::class)->name('dropouts.index')->middleware('can:student_dropout_show');
            Route::get('dropouts/{dropout}/edit', App\Livewire\Admin\Dropouts\LiveDropoutEdit::class)->name('dropouts.edit')->middleware('can:student_dropout_edit');

            // Students
            Route::get('student', [\App\Http\Controllers\Admin\Users\UserController::class, 'index'])->name('student.index')->middleware('can:user_student_access');
            Route::get('student/create', [\App\Http\Controllers\Admin\Users\UserController::class, 'create'])->name('student.create')->middleware('can:user_student_create');
            Route::get('student/{user}', [\App\Http\Controllers\Admin\Users\UserController::class, 'show'])->name('student.show')->middleware('can:user_student_show');
            Route::get('student/{user}/edit', [\App\Http\Controllers\Admin\Users\UserController::class, 'edit'])->name('student.edit')->middleware('can:user_student_edit');

            // Waring
            Route::get('waiting', \App\Livewire\Admin\Users\LiveWaitingUserIndex::class)->name('waiting.index')->middleware('can:user_waiting_access');
            Route::get('waiting/create', \App\Livewire\Admin\Users\LiveWaitingUserCreate::class)->name('waiting.create')->middleware('can:user_waiting_create');
            Route::get('waiting/{user}', \App\Livewire\Admin\Users\LiveWaitingUserShow::class)->name('waiting.show')->middleware('can:user_waiting_show');
            Route::get('waiting/{user}/edit', \App\Livewire\Admin\Users\LiveWaitingUserEdit::class)->name('waiting.edit')->middleware('can:user_waiting_edit');

            // Staff
            Route::get('staff', [\App\Http\Controllers\Admin\Users\UserController::class, 'index'])->name('staff.index')->middleware('can:user_access');
            Route::get('staff/create', [\App\Http\Controllers\Admin\Users\UserController::class, 'create'])->name('staff.create')->middleware('can:user_create');
            Route::get('staff/{user}', [\App\Http\Controllers\Admin\Users\UserController::class, 'show'])->name('staff.show')->middleware('can:user_show');
            Route::get('staff/{user}/edit', [\App\Http\Controllers\Admin\Users\UserController::class, 'edit'])->name('staff.edit')->middleware('can:user_edit');
        });
       

        Route::get('courses', [\App\Http\Controllers\Admin\CourseController::class, 'index'])->name('courses.index')->middleware('can:course_access');
        Route::get('courses/create', [\App\Http\Controllers\Admin\CourseController::class, 'create'])->name('courses.create')->middleware('can:course_create');
        // Route::get('courses/{course}', [\App\Http\Controllers\Admin\CourseController::class, 'show'])->name('courses.show');
        Route::get('courses/{course}/edit', [\App\Http\Controllers\Admin\CourseController::class, 'edit'])->name('courses.edit')->middleware('can:course_edit');

        Route::get('semesters', LiveSemesterIndex::class)->name('semesters.index')->middleware('can:semester_access');
        Route::get('semesters/create', LiveSemesterCreate::class)->name('semesters.create')->middleware('can:semester_create');
        Route::get('semesters/{semester}/edit', LiveSemesterEdit::class)->name('semesters.edit')->middleware('can:semester_edit');

        Route::get('lesson-plans', LiveLessonPlanIndex::class)->name('lesson-plans.index');
        Route::get('lesson-plans/create', LiveLessonPlanCreate::class)->name('lesson-plans.create');
        Route::get('lesson-plans/{lesson_plan}/edit', LiveLessonPlanEdit::class)->name('lesson-plans.edit');

        Route::get('books', LiveBookIndex::class)->name('books.index')->middleware('can:book_access');
        Route::get('books/create', LiveBookCreate::class)->name('books.create')->middleware('can:book_create');
        Route::get('books/{book}/edit', LiveBookEdit::class)->name('books.edit')->middleware('can:book_edit');

        Route::get('orders', LiveOrderIndex::class)->name('orders.index')->middleware('can:order_access');;
        Route::get('orders/create', LiveOrderCreate::class)->name('orders.create')->middleware('can:order_create');;
        Route::get('orders/{order}/edit', LiveOrderEdit::class)->name('orders.edit')->middleware('can:order_edit');;
        Route::get('orders/{order}', LiveOrderShow::class)->name('orders.show')->middleware('can:order_show');

        Route::get('messages', LiveMessageIndex::class)->name('messages.index')->middleware('can:message_index');
        Route::get('messages/students/create', LiveMessageCreate::class)->name('messages.students.create')->middleware('can:message_create');
        Route::get('messages/class/create', LiveMessageCreate::class)->name('messages.class.create')->middleware('can:message_create');

        
        Route::get('evaluations', LiveEvaluationIndex::class)->name('evaluations.index')->middleware('can:evaluation_access');
        Route::get('evaluations/create', LiveEvaluationCreate::class)->name('evaluations.create')->middleware('can:evaluation_create');
        Route::get('evaluations/{evaluation}/edit', LiveEvaluationEdit::class)->name('evaluations.edit')->middleware('can:evaluation_edit');

        Route::prefix('evaluations')->name('evaluations.')->group(function () {
            Route::get('/', LiveEvaluationIndex::class)->name('index')->middleware('can:evaluation_access');
            Route::get('/create', LiveEvaluationCreate::class)->name('create')->middleware('can:evaluation_create');
            Route::get('/{evaluation}/edit', LiveEvaluationEdit::class)->name('edit')->middleware('can:evaluation_edit');
        });
        Route::prefix('questions')->name('questions.')->group(function () {
            Route::get('/{evaluation}', LiveQuestionIndex::class)->name('index')->middleware('can:evaluation_access');
            Route::get('/{evaluation}/create', LiveQuestionCreate::class)->name('create')->middleware('can:evaluation_create');
            Route::get('/{evaluation}/{question}/edit', LiveQuestionEdit::class)->name('edit')->middleware('can:evaluation_edit');
        });
        Route::prefix('attendances')->name('attendances.')->group(function () {
            Route::get('/', LiveAttendanceIndex::class)->name('index')->middleware('can:attendance_access');
            Route::get('/{semester}', LiveAttendanceShow::class)->name('show')->middleware('can:attendance_show');
            Route::get('/{attendance}/edit', LiveQuestionEdit::class)->name('edit')->middleware('can:attendance_edit');
        });

        // Role and Permissions
        // Route::get('roles', \App\Livewire\Admin\Roles\LiveRoleIndex::class)->name('roles.index');
        Route::get('roles/permissions', \App\Livewire\Admin\Roles\LiveRolePermission::class)->name('roles.permissions');
    });
});


/**  Front Routes */
Route::redirect('/home', '/');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/classes', ClassesLiveClassIndex::class)->name('classes.index');
Route::get('/classes/{semester}', ClassesLiveClassShow::class)->name('classes.show');

Route::middleware('auth')->prefix('dashboard')->name('profile.')->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/edit-profile', [DashboardController::class, 'edit'])->name('edit');
    Route::get('/courses', LiveCourseSelect::class)->name('courses.select')->middleware('register-complete');
    Route::get('/classes', LiveClassIndex::class)->name('classes.index')->middleware('register-complete');
    Route::get('/classes/{semester}', LiveClassShow::class)->name('classes.show')->middleware('register-complete');
    Route::get('/classes/{semester}/students', LiveStudentIndex::class)->name('classes.show')->middleware('register-complete');
    Route::get('/orders', \App\Livewire\Dashboard\Orders\LiveOrderIndex::class)->name('orders.index');
    Route::get('/orders/create', \App\Livewire\Dashboard\Orders\LiveOrderCreate::class)->name('orders.create');
    Route::get('/orders/{order}', \App\Livewire\Dashboard\Orders\LiveOrderShow::class)->name('orders.show');
    Route::get('/checkout', \App\Livewire\Dashboard\Payments\LiveCheckout::class)->name('checkout.index');
    // Route::get('/cart', \App\Livewire\Dashboard\Payments\LiveCheckout::class)->name('checkout.index');

    Route::prefix('evaluations')->name('evaluations.')->group(function () {
        Route::get('/', \App\Livewire\Dashboard\Evaluations\LiveEvaluationIndex::class)->name('index');
        Route::get('/create', \App\Livewire\Dashboard\Evaluations\LiveEvaluationCreate::class)->name('create');
        Route::get('/{evaluation}/edit', \App\Livewire\Dashboard\Evaluations\LiveEvaluationEdit::class)->name('edit');
    });
    Route::prefix('questions')->name('questions.')->group(function () {
        Route::get('/{evaluation}', \App\Livewire\Dashboard\Questions\LiveQuestionIndex::class)->name('index');
        Route::get('/{evaluation}/create', \App\Livewire\Dashboard\Questions\LiveQuestionCreate::class)->name('create');
        Route::get('/{evaluation}/{question}/edit', \App\Livewire\Dashboard\Questions\LiveQuestionEdit::class)->name('edit');
    });
    Route::prefix('attendances')->name('attendances.')->group(function () {
        Route::get('/classes', \App\Livewire\Dashboard\Attendances\LiveAttendanceClassIndex::class)->name('classes');
        Route::get('/{class}', \App\Livewire\Dashboard\Attendances\LiveAttendanceIndex::class)->name('index');
        Route::get('/{class}/create', \App\Livewire\Dashboard\Attendances\LiveAttendanceCreate::class)->name('create');
        Route::get('/{attendance}/edit', \App\Livewire\Dashboard\Attendances\LiveAttendanceEdit::class)->name('edit');
    });
});

/** Payment Routes */
Route::get('payment/create', [\App\Http\Controllers\PaymentController::class, 'payment'])->name('payment.create')->middleware('auth');
Route::get('payment/verify', [\App\Http\Controllers\PaymentController::class, 'verify'])->name('payment.verify')->middleware('auth');

// Authentications
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::get('register', [RegisterController::class, 'register'])->name('register');
Route::get('get-code/{code}', [LoginController::class, 'getCode'])->name('code');



// Extra Routes
Route::get('migrate', function(){
    return Artisan::call('migrate');
});
Route::get('regenerate-admin', function(){
    $user = User::firstOrCreate(
        ['email' => 'super-admin@email.com'],
        [
            'first_name' => 'Super Admin',
            'national_code' => '0123456789',
            'phone' => '09353331760',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'password' => Hash::make('Xu181XlDwRJQzH')
        ]
    );
    $secondUser = User::firstOrCreate(
        ['email' => 'super-admin@gmail.com'],
        [
            'first_name' => 'Super Admin',
            'national_code' => '1234567890',
            'phone' => '09333333333',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'password' => Hash::make('Xu181XlDwRJQzH')
        ]
    );
    $user->assignRole('super-admin');
    $secondUser->assignRole('super-admin');
    return "Done";
});
Route::get('payments/success/{order}', function(App\Models\Order $order){
    return view('panels.payments.success',  compact('order'));
});