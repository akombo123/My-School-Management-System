<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class SettingModel extends Model
{
    protected $table = 'setting';

    static public function getSingle()
    {
        return self::find(1);
    }
}
