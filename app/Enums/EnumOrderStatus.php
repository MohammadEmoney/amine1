<?php

namespace App\Enums;


class EnumOrderStatus extends BaseEnum
{
    const CREATED = 'created';
    const PENDING_PAYMENT = 'pending_payment';
    const PROCESSING = 'processing';
    const COMPELETED = 'compeleted';
}
