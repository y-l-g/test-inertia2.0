<?php

namespace App\Enum;

enum RolesEnum: string
{
    case Admin = 'admin';
    case Commenter = 'commenter';
    case User = 'user';

    public static function toArray(): array
    {
        return array_reduce(self::cases(), function ($acc, $case) {
            $acc[$case->name] = $case->value;
            return $acc;
        }, []);
    }

}
