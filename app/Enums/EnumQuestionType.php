<?php

namespace App\Enums;


class EnumQuestionType extends BaseEnum
{
    const MULTICHOICE = 'multiple_choice';
    const MATCHING = 'matching';
    const TRUE_OR_FALSE = 'true_or_false';
    const DESCRIPTION = 'description';
}
