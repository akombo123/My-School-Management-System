<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class MarksGradeModel extends Model
{
    protected $table = 'marks_grade';

    static public function getRecord()
    {
        return  self::select('marks_grade.*','users.name as created_by_name')
            ->join('users','users.id', '=', 'marks_grade.created_by')
            ->where('marks_grade.is_delete','=', 0)
            ->orderBy('marks_grade.id', 'desc')
                ->get();

    }

    static public function getGrade($percent)
    {
        $return = self::select('marks_grade.*')
            ->where('marks_grade.is_delete','=', 0)
            ->where('percent_from','<=', $percent)
            ->where('percent_to','>=', $percent)
                ->first();
        return !empty($return->name) ? $return->name : null;
    }


    static public function getClass()
    {
        $return = self::select('class.*')
            ->where('class.is_delete','=', 0)
            ->where('class.status','=', 0)
            ->orderBy('class.name', 'asc')
                ->get();
                return $return;
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }
}
