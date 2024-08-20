<?php

namespace App\Enums;


class EnumUserRoles extends BaseEnum
{
    const SUPER_ADMIN = 'super-admin';
    const ADMIN = 'admin';
    const SUPERVISOR = 'supervisor';
    const MANAGEMENT = 'management';
    const SECRETARY = 'secretary';
    const HEAD_TEACHER = 'head-teacher';
    const TEACHER = 'teacher';
    const ACCOUNTANT = 'accountant';
    const STUDENT = 'student';
    const WAITING_STUDENT = 'waiting-student';

    public static function getAdminRoles()
    {
        return [
            self::SUPER_ADMIN,
            self::ADMIN,
            self::SUPERVISOR,
            self::MANAGEMENT,
            self::SECRETARY,
            self::HEAD_TEACHER,
            self::ACCOUNTANT,
        ];
    }
}
