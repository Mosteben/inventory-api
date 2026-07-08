<?php

namespace App\Enums;

class ActivityAction
{
    public const CREATE = 'CREATE';

    public const UPDATE = 'UPDATE';

    public const DELETE = 'DELETE';

    public const LOGIN = 'LOGIN';

    public const LOGOUT = 'LOGOUT';

    public const STOCK_IN = 'STOCK_IN';

    public const STOCK_OUT = 'STOCK_OUT';

    public const ORDER_CREATE = 'ORDER_CREATE';

    public const ORDER_CANCEL = 'ORDER_CANCEL';

    public static function values(): array
    {
        return [

            self::CREATE,

            self::UPDATE,

            self::DELETE,

            self::LOGIN,

            self::LOGOUT,

            self::STOCK_IN,

            self::STOCK_OUT,

            self::ORDER_CREATE,

            self::ORDER_CANCEL

        ];
    }
}