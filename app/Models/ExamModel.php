<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class ExamModel extends Model
{
    protected $table = 'exams';

    static public function getRecord()
    {
        $return = self::select('exams.*','users.name as created_by_name')
            ->join('users','users.id', '=', 'exams.created_by')
            ->where('exams.is_delete','=', 0);

            if(!empty(Request::get('name'))){
                $return = $return->where('exams.name', 'like', '%'.Request::get('name').'%');
            }

        $return = $return->orderBy('exams.id', 'desc')
                ->paginate(50);
                return $return;
    }

    static public function getExam()
    {
        $return = self::select('exams.*')
            ->where('exams.is_delete','=', 0)
                ->orderBy('exams.name', 'asc')
                ->get();
        return $return;
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
