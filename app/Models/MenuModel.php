<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    public static string $menuItem = '';

    public static function setActive($controllerClass)
    {
        switch ($controllerClass){
            case 'App\Controllers\Dna\Users': {self::$menuItem = 'Users';} break;
            case 'App\Controllers\Dna\Shops': {self::$menuItem = 'Shops';} break;
            case 'App\Controllers\Dna\Cards': {self::$menuItem = 'Cards';} break;
            case 'App\Controllers\Dna\Rules': {self::$menuItem = 'Rules';} break;
            case 'App\Controllers\Dna\Templates': {self::$menuItem = 'Templates';} break;
            case 'App\Controllers\Dna\Products': {self::$menuItem = 'Products';} break;
        }
    }

    public static function getActive() : string
    {
        return self::$menuItem;
    }



}