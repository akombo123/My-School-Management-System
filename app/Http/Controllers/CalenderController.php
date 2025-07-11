<?php

namespace App\Http\Controllers;

use App\Models\AssignSubjectModel;
use App\Models\AssignTeacherModel;
use App\Models\ClassSubjectTimetableModel;
use App\Models\ExamSceduleModel;
use App\Models\User;
use App\Models\WeekModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CalenderController extends Controller
{
    public function MyCalender(){
        $data['header_title'] = 'My Calender';
        $data['getClassTimeTable'] = $this->classTimetable(Auth::user()->class_id);
        $data['getExamTimeTable'] = $this->getExamTimeTable(Auth::user()->class_id);
        return view('student.calender',$data);
    }

    public function classTimetable($class_id){
        $result = [];
        $getRecord = AssignSubjectModel::getMysubject($class_id);
        foreach($getRecord as $value){
            $dataS['name'] = $value->subject_name;
            $getWeek = WeekModel::getRecord();
            $week = [];
            foreach($getWeek as $valueW){
                $dataW = [];
                $dataW['week_name'] = $valueW->name;
                $dataW['fullcalendar_day'] = $valueW->fullcalendar_day;
                $classSubject = ClassSubjectTimetableModel::getRecord($value->class_id,$value->subject_id,$valueW->id);
                if(!empty($classSubject)){
                    $dataW['start_time'] = $classSubject->start_time;
                    $dataW['end_time'] = $classSubject->end_time;
                    $dataW['room_number'] = $classSubject->room_number;
                    $week[] = $dataW;
                }
            }
            $dataS['week'] = $week;
            $result[]= $dataS;
        }
        return $result;
    }

    public function getExamTimeTable($class_id){
        $getExam = ExamSceduleModel::getExam($class_id);
        $result = [];
        foreach($getExam as $value){
            $dataE = [];
            $dataE['exam_name'] = $value->exam_name;
            $getExamTimetable = ExamSceduleModel::getExamTimetable($class_id,$value->exam_id);
            $resultS = [];
                foreach($getExamTimetable as $valueT){
                    $dataT = [];
                    $dataT['subject_name'] = $valueT->subject_name;
                    $dataT['subject_type'] = $valueT->subject_type;
                    $dataT['start_time'] = $valueT->start_time;
                    $dataT['end_time'] = $valueT->end_time;
                    $dataT['room_number'] = $valueT->room_number;
                    $dataT['full_marks'] = $valueT->full_marks;
                    $dataT['passing_marks'] = $valueT->passing_marks;
                    $dataT['exam_date'] = date('Y-m-d',strtotime($valueT->exam_date));
                    $resultS[] = $dataT;
                }
                $dataE['exam'] = $resultS;
                $result[] = $dataE;

        }
        return $result;
    }

    //parent side
    public function ParentStudentCalender($student_id){
        $getStudent =  User::getSingle($student_id);
        $data['getClassTimeTable'] = $this->classTimetable($getStudent->class_id);
        $data['getExamTimeTable'] = $this->getExamTimeTable($getStudent->class_id);
        $data['getStudent'] = $getStudent;
        $data['header_title'] = 'My Calender';
        return view('parent.calender',$data);
    }

    // teacher side
    public function MyCalenderTeacher(){
        $data['header_title'] = 'My Calender';
        $teacher_id = Auth::user()->id;
        $data['getClassTimeTable'] = AssignTeacherModel::getCalendarTeacher($teacher_id);
        $data['getExamTimeTable'] = ExamSceduleModel::getExamTimetableTeacher($teacher_id);
        // dd($data['getExamTimeTable']);
        return view('teacher.calender',$data);
    }

}
