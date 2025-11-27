<?php

namespace App\Enums;

enum AccessRuleEnums: string
{
    case OWNER = 'owner';
    case AUTHOR = 'author';
    case MEMBER = 'member';
}
