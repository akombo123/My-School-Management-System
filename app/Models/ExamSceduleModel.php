<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class ExamSceduleModel extends Model
{
    protected $table = 'exam_schedule';

    static public function getExam($class_id)
    {
        return self::select('exam_schedule.*','exams.name as exam_name')
            ->join('exams','exams.id', '=', 'exam_schedule.exam_id')
            ->where('exam_schedule.class_id','=',$class_id)
            ->orderBy('exam_schedule.id', 'desc')
            ->groupBy('exam_schedule.exam_id')
            ->get();
    }

    static public function getExamTeacher($teacher_id)
    {
        $return = self::select('exam_schedule.*','exams.name as exam_name','exams.id as exam_id')
            ->join('exams','exams.id', '=', 'exam_schedule.exam_id')
            ->join('assign_teacher','assign_teacher.class_id','=','exam_schedule.class_id')
            ->where('assign_teacher.teacher_id','=',$teacher_id)
            ->orderBy('exam_schedule.id', 'desc')
            ->groupBy('exam_schedule.exam_id')
                ->get();
                return $return;
    }

    static public function getRecordSingle($class_id,$subject_id,$exam_id)
    {
       return self::where('class_id','=',$class_id)->where('subject_id','=',$subject_id)->where('exam_id','=',$exam_id)->first();
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getExamTimetable($class_id,$exam_id)
    {
       return self::select('exam_schedule.*','subject.name as subject_name','subject.type as subject_type')
            ->join('subject','subject.id','=','exam_schedule.subject_id')
            ->where('class_id','=',$class_id)
            ->where('exam_id','=',$exam_id)
            ->orderBy('exam_schedule.id', 'desc')
            ->get();
    }

    static public function getMysubject($class_id,$exam_id)
    {
       return self::select('exam_schedule.*','subject.name as subject_name','subject.type as subject_type')
            ->join('subject','subject.id','=','exam_schedule.subject_id')
            ->where('class_id','=',$class_id)
            ->where('exam_id','=',$exam_id)
            ->orderBy('exam_schedule.id', 'desc')
            ->get();
    }

    static public function getExamTimetableTeacher($teacher_id)
    {
       return self::select('exam_schedule.*','subject.name as subject_name','subject.type as subject_type','class.name as class_name','exams.name as exam_name')
            ->join('subject','subject.id','=','exam_schedule.subject_id')
            ->join('assign_teacher','assign_teacher.class_id','=','exam_schedule.class_id')
            ->join('exams','exams.id', '=', 'exam_schedule.exam_id')
            ->join('class','class.id', '=', 'exam_schedule.class_id')
            ->where('assign_teacher.teacher_id','=',$teacher_id)
            ->get();
    }
}
