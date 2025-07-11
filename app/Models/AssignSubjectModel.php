<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class AssignSubjectModel extends Model
{
    protected $table = 'asssign_subject';

    static public function getRecord()
    {
        $return = self::select('asssign_subject.*','users.name as created_by_name','class.name as class_name','subject.name as subject_name')
            ->join('users','users.id', '=', 'asssign_subject.created_by')
            ->join('class','class.id', '=', 'asssign_subject.class_id')
            ->join('subject','subject.id', '=', 'asssign_subject.subject_id')
            ->where('asssign_subject.is_delete','=', 0);

            if(!empty(Request::get('teacher_name'))){
                $return = $return->where('user.name', 'like', '%'.Request::get('teacher_name').'%');
            }

            if(!empty(Request::get('class_name'))){
                $return = $return->where('class.name', 'like', '%'.Request::get('class_name').'%');
            }

           $return = $return->orderBy('asssign_subject.id', 'desc')
                ->paginate(50);
        return $return;
    }

    static public function getMysubject($class_id){
        return  self::select('asssign_subject.*','subject.name as subject_name','subject.type as subject_type','subject.id as subject_id')
        ->join('subject','subject.id', '=', 'asssign_subject.subject_id')
        ->where('asssign_subject.is_delete','=', 0)
        ->where('asssign_subject.status','=', 0)
        ->where('asssign_subject.class_id','=', $class_id)
        ->orderBy('asssign_subject.id', 'desc')
            ->get();

    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getAlredyFist($class_id,$subject_id)
    {
        return self::where('class_id','=',$class_id)
               ->where('subject_id','=',$subject_id)
               ->first();
    }

    static public function getAssignSubjectID($class_id)
    {
        return self::where('class_id','=',$class_id)
                ->where('is_delete','=',0)
               ->get();
    }

    static public function deleteSubject($class_id)
    {
        return self::where('class_id','=',$class_id)
               ->delete();
    }
}
