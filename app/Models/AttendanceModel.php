<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class AttendanceModel extends Model
{
    protected $table = 'student_attendance';

    static public function getRecord()
    {
        $return = self::select('student_attendance.*','users.name as created_by_name','class.name as class_name','student.name as student_name','student.l_name as student_l_name')
            ->join('users','users.id', '=', 'student_attendance.created_by')
            ->join('users as student','student.id', '=', 'student_attendance.student_id')
            ->join('class','class.id', '=', 'student_attendance.class_id');

                if(!empty(Request::get('class_id'))){
                    $return = $return->where('student_attendance.class_id', Request::get('class_id'));
                }
                if(!empty(Request::get('attendance_date'))){
                    $return = $return->where('student_attendance.attendance_date', Request::get('attendance_date'));
                }
                if(!empty(Request::get('attendance_type'))){
                    $return = $return->where('student_attendance.attendance_type', Request::get('attendance_type'));
                }

                $return = $return->orderBy('student_attendance.id', 'desc')
                ->paginate(50);
                return $return;
    }

    static public function getRecordTeacher($class_id)
    {
        if(!empty($class_id)){
            $return = self::select('student_attendance.*','users.name as created_by_name','class.name as class_name','student.name as student_name','student.l_name as student_l_name')
            ->join('users','users.id', '=', 'student_attendance.created_by')
            ->join('users as student','student.id', '=', 'student_attendance.student_id')
            ->join('class','class.id', '=', 'student_attendance.class_id')
            ->whereIn('student_attendance.class_id',$class_id);

                if(!empty(Request::get('class_id'))){
                    $return = $return->where('student_attendance.class_id', Request::get('class_id'));
                }
                if(!empty(Request::get('attendance_date'))){
                    $return = $return->where('student_attendance.attendance_date', Request::get('attendance_date'));
                }
                if(!empty(Request::get('attendance_type'))){
                    $return = $return->where('student_attendance.attendance_type', Request::get('attendance_type'));
                }

                $return = $return->orderBy('student_attendance.id', 'desc')
                ->paginate(50);
                return $return;
        }
        else{
            return "";
        }

    }

    static public function getRecordStudent($student_id)
    {
            $return = self::select('student_attendance.*','users.name as created_by_name','class.name as class_name','student.name as student_name','student.l_name as student_l_name')
            ->join('users','users.id', '=', 'student_attendance.created_by')
            ->join('users as student','student.id', '=', 'student_attendance.student_id')
            ->join('class','class.id', '=', 'student_attendance.class_id')
            ->where('student_attendance.student_id','=',$student_id);

            if(!empty(Request::get('class_id'))){
                $return = $return->where('student_attendance.class_id', Request::get('class_id'));
            }
            if(!empty(Request::get('attendance_date'))){
                $return = $return->where('student_attendance.attendance_date', Request::get('attendance_date'));
            }
            if(!empty(Request::get('attendance_type'))){
                $return = $return->where('student_attendance.attendance_type', Request::get('attendance_type'));
            }

                $return = $return->orderBy('student_attendance.id', 'desc')
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


    static public function getClassStudent($class_id)
    {
        $return = self::select('student_attendance.*','class.name as class_name','class.id as class_id')
        ->join('class','class.id', '=', 'student_attendance.class_id')
        ->where('student_attendance.class_id','=',$class_id)
            ->orderBy('student_attendance.id', 'asc')
                ->get();
                return $return;
    }

    static public function checkAlready($class_id, $attendance_date, $student_id)
    {
        return self::where('class_id', $class_id)
            ->where('attendance_date', $attendance_date)
            ->where('student_id', $student_id)
            ->first();
    }
}
