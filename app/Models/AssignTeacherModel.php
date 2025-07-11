<?php

namespace App\Models;

use App\Models\ClassSubjectTimetableModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class AssignTeacherModel extends Model
{
    protected $table = 'assign_teacher';

    static public function getRecord()
    {
        $return = self::select('assign_teacher.*','users.name as created_by_name','class.name as class_name','teacher.name as teacher_name','teacher.l_name as teacher_l_name')
            ->join('users','users.id', '=', 'assign_teacher.created_by')
            ->join('users as teacher','teacher.id', '=', 'assign_teacher.teacher_id')
            ->join('class','class.id', '=', 'assign_teacher.class_id')
            ->where('assign_teacher.is_delete','=', 0);

            if(!empty(Request::get('teacher_name'))){
                $return = $return->where('teacher.name', 'like', '%'.Request::get('teacher_name').'%');
            }

            if(!empty(Request::get('class_name'))){
                $return = $return->where('class.name', 'like', '%'.Request::get('class_name').'%');
            }

            if(!empty(Request::get('status'))){
                $status = (Request::get('status') == 100) ? 0: 1;
                $return = $return->where('assign_teacher.status', '=',$status);
            }

           $return = $return->orderBy('assign_teacher.id', 'desc')
                ->paginate(50);
        return $return;
    }

    static public function getMysubjectClass($teacher_id){
        return  self::select('assign_teacher.*','class.name as class_name','subject.name as subject_name','subject.type as subject_type','class.id as class_id','subject.id as subject_id')
        ->join('class','class.id', '=', 'assign_teacher.class_id')
        ->join('asssign_subject','asssign_subject.class_id', '=', 'class.id')
        ->join('subject','subject.id', '=', 'asssign_subject.subject_id')
        ->where('assign_teacher.is_delete','=', 0)
        ->where('subject.is_delete','=',0)
        ->where('subject.status','=',0)
        ->where('assign_teacher.status','=', 0)
        ->where('assign_teacher.teacher_id','=', $teacher_id)
        ->orderBy('assign_teacher.id', 'desc')
            ->get();

    }

    static public function getMysubjectClassGroup($teacher_id){
        return  self::select('assign_teacher.*','class.name as class_name','class.id as class_id')
        ->join('class','class.id', '=', 'assign_teacher.class_id')
        ->join('asssign_subject','asssign_subject.class_id', '=', 'class.id')
        ->where('assign_teacher.is_delete','=', 0)
        ->where('assign_teacher.status','=', 0)
        ->where('assign_teacher.teacher_id','=', $teacher_id)
        ->groupBy('assign_teacher.class_id')
        ->orderBy('assign_teacher.id', 'desc')
            ->get();

    }

    static public function getCalendarTeacher($teacher_id){
        return  self::select('class_subject_timetable.*','class.name as class_name','subject.name as subject_name','subject.type as subject_type','class.id as class_id','subject.id as subject_id','week.name as week_name','week.fullcalendar_day')
        ->join('class','class.id', '=', 'assign_teacher.class_id') //
        ->join('asssign_subject','asssign_subject.class_id', '=', 'class.id') //
        ->join('class_subject_timetable','class_subject_timetable.subject_id', '=', 'asssign_subject.subject_id') //
        ->join('subject','subject.id', '=', 'class_subject_timetable.subject_id') //
        ->join('week','week.id', '=', 'class_subject_timetable.week_id')//
        ->where('assign_teacher.is_delete','=', 0)
        ->where('subject.is_delete','=',0)
        ->where('subject.status','=',0)
        ->where('assign_teacher.status','=', 0)
        ->where('assign_teacher.teacher_id','=', $teacher_id)
        ->get();

    }


    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getAlredyFist($class_id,$teacher_id)
    {
        return self::where('class_id','=',$class_id)
               ->where('teacher_id','=',$teacher_id)
               ->first();
    }

    static public function getAssignTeacherID($class_id)
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

    public function getTimeTable($class_id,$subject_id){
        $getWeek = WeekModel::getUsingName(date('l'));
        return ClassSubjectTimetableModel::getRecord($class_id,$subject_id,$getWeek->id);
    }
}
