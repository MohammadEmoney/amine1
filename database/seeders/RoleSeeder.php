<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();
        DB::table('user_infos')->truncate();
        DB::table('roles')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        DB::beginTransaction();

        $superAdmin = Role::create(['name' => 'super-admin']);
        $admin = Role::create(['name' => 'admin']);
        $supervisor = Role::create(['name' => 'supervisor']);
        $management = Role::create(['name' => 'management']);
        $secretary = Role::create(['name' => 'secretary']);
        $headTeacher = Role::create(['name' => 'head-teacher']);
        $teacher = Role::create(['name' => 'teacher']);
        $accountant = Role::create(['name' => 'accountant']);
        $student = Role::create(['name' => 'student']);
        $waitingStudent = Role::create(['name' => 'waiting-student']);

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
        $user->assignRole('super-admin');

        DB::commit();
    }
}
