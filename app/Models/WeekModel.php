<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeekModel extends Model
{
    protected $table = 'week';

    static public function getRecord()
    {
        return self::get();
    }

    static public function getUsingName($weekname)
    {
        return self::where('name','=',$weekname)->first();
    }
}
