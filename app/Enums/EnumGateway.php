<?php

namespace App\Enums;

class EnumGateway extends BaseEnum
{
    const Mellat = 'behpardakht';
    const Zarinpal = 'zarinpal';
    const Saman = "saman";
    const Parsian = "parsian";

    /**
     * Get Direction Site
     * @param string $key
     * @return string
     */
    public static function icon(string $key):string
    {
        $namespace = explode('\\', static::class);
        return  __('admin/enums/' . end($namespace) . ".icon.$key");
    }
}

