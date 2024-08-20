<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::statement("SET FOREIGN_KEY_CHECKS=0;");
        // DB::table('permissions')->truncate();
        // DB::table('role_has_permissions')->truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::beginTransaction();

        $permissions = [
            'student_status',
            'staff_status',
            'course_status',
            'orders_status',
            'dropout_student_status',
            'dropout_staff_status',
            'not_active_course_status',
            'waiting_student_status',
            'financial_access',
            'general_settings',
            'permission_access',
            'permission_create',
            'permission_edit',
            'permission_delete',
            'permission_show',
            'role_access',
            'role_create',
            'role_edit',
            'role_delete',
            'role_show',
            'user_student_access',
            'user_student_create',
            'user_student_edit',
            'user_student_delete',
            'user_student_show',
            'user_student_role',
            'user_access',
            'user_create',
            'user_edit',
            'user_delete',
            'user_show',
            'user_deleted_access',
            'user_deleted_create',
            'user_deleted_edit',
            'user_deleted_delete',
            'user_deleted_show',
            'user_waiting_access',
            'user_waiting_create',
            'user_waiting_edit',
            'user_waiting_delete',
            'user_waiting_show',
            'user_job_delete',
            'user_job_edit',
            'user_view_email',
            'user_view_phone',
            'user_view_mobile',
            'user_view_address',
            'user_view_national_code',
            'course_access',
            'course_create',
            'course_edit',
            'course_delete',
            'course_show',
            'semester_access',
            'semester_create',
            'semester_edit',
            'semester_delete',
            'semester_show',
            'book_access',
            'book_create',
            'book_edit',
            'book_delete',
            'book_show',
            'evaluation_access',
            'evaluation_create',
            'evaluation_edit',
            'evaluation_delete',
            'evaluation_show',
            'attendance_access',
            'attendance_create',
            'attendance_edit',
            'attendance_delete',
            'attendance_show',
            'order_access',
            'order_create',
            'order_edit',
            'order_delete',
            'order_show',
            'message_access',
            'message_create',
            'message_edit',
            'message_delete',
            'message_show',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        DB::commit();

    }
}
