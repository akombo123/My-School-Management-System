<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class MarksRegisterModel extends Model
{
    protected $table = 'marks_register';

    static public function CheckAlready($class_id, $subject_id, $exam_id, $student_id)
    {
        return self::where('class_id', $class_id)
            ->where('subject_id', $subject_id)
            ->where('exam_id', $exam_id)
            ->where('student_id', $student_id)
            ->first();
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getExam($student_id)
    {
        return self::select('marks_register.*','exams.name as exam_name')
            ->join('exams','exams.id', '=', 'marks_register.exam_id')
            ->where('marks_register.student_id','=',$student_id)
            ->orderBy('marks_register.id', 'desc')
            ->groupBy('marks_register.exam_id')
            ->get();
    }

    static public function getExamSubject($student_id,$exam_id)
    {
        return self::select('marks_register.*','exams.name as exam_name','subject.name as subject_name')
            ->join('exams','exams.id', '=', 'marks_register.exam_id')
            ->join('subject','subject.id', '=', 'marks_register.subject_id')
            ->where('marks_register.student_id','=',$student_id)
            ->where('marks_register.exam_id','=',$exam_id)
            ->orderBy('marks_register.id', 'desc')
            ->get();
    }

    static public function getClass($student_id,$exam_id)
    {
        return self::select('class.name as class_name')
            ->join('exams','exams.id', '=', 'marks_register.exam_id')
            ->join('class','class.id', '=', 'marks_register.class_id')
            ->join('subject','subject.id', '=', 'marks_register.subject_id')
            ->where('marks_register.student_id','=',$student_id)
            ->where('marks_register.exam_id','=',$exam_id)
            ->orderBy('marks_register.id', 'desc')
            ->first();
    }
}
