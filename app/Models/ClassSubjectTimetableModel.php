<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class ClassSubjectTimetableModel extends Model
{
    protected $table = 'class_subject_timetable';

    static public function getRecord($class_id,$subject_id,$week_id)
    {
       return self::where('class_id','=',$class_id)->where('subject_id','=',$subject_id)->where('week_id','=',$week_id)->first();
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }
}
