<?php

namespace App\Http\Controllers;

use App\Models\AssignSubjectModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectTimetableModel;
use App\Models\SubjectModel;
use App\Models\User;
use App\Models\WeekModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassTimetableController extends Controller
{
    public function list(Request $request){
        $data['header_title'] = 'Class Timetable';
        if(!empty($request->class_id)){
            $data['getSubject'] = AssignSubjectModel::getMysubject($request->class_id);
        }
        $getWeek = WeekModel::getRecord();
        $week = [];
        foreach($getWeek as $value){
            $dataW = [];
            $dataW['id'] = $value->id;
            $dataW['week_name'] = $value->name;
            if(!empty($request->class_id) && $request->subject_id)
            {
                $classSubject = ClassSubjectTimetableModel::getRecord($request->class_id,$request->subject_id,$value->id);
                if(!empty($classSubject)){
                    $dataW['start_time'] = $classSubject->start_time;
                    $dataW['end_time'] = $classSubject->end_time;
                    $dataW['room_number'] = $classSubject->room_number;
                }
                else{
                    $dataW['start_time'] = '';
                    $dataW['end_time'] = '';
                    $dataW['room_number'] = '';
                }
            }
            else{
                $dataW['start_time'] = '';
                $dataW['end_time'] = '';
                $dataW['room_number'] = '';
            }
            $week[] = $dataW;
        }
        $data['week'] = $week;
        $data['getClass'] = ClassModel::getClass();
        return view('admin.class_timetable.list',$data);
    }

    public function getSubject(Request $request){
        $getSubject = AssignSubjectModel::getMysubject($request->class_id);
        $html = '<option value="">--Select Subject--</option>';
        if(!empty($getSubject)){
            foreach($getSubject as $subject){
                $html .= '<option value="'.$subject->subject_id.'">'.$subject->subject_name.'</option>';
            }
        }
        else
        {
            $html .= '<option value="">No Subject Found</option>';
        }
        return response()->json(['html'=>$html]);
    }

    public function insertUpdate(Request $request){
        ClassSubjectTimetableModel::where('class_id','=',$request->class_id)->where('subject_id','=',$request->subject_id)->delete();
        foreach($request->class_timetable as $timetable)
        {
            if(!empty($timetable['id']) && !empty($timetable['start_time']) && !empty($timetable['end_time']) && !empty($timetable['room_number']))
            {
                $save = new ClassSubjectTimetableModel;
                $save->class_id = $request->class_id;
                $save->subject_id = $request->subject_id;
                $save->week_id = $timetable['id'];
                $save->start_time = $timetable['start_time'];
                $save->end_time = $timetable['end_time'];
                $save->room_number = $timetable['room_number'];
                $save->save();
            }
        }
        return redirect()->back()->with('success','Timetable added successfully');
    }

    //MyTimetable student
    public function MyTimetable(Request $request){
        $data['header_title'] = 'My Timetable';
        $result = [];
        $getRecord = AssignSubjectModel::getMysubject(Auth::user()->class_id);
        foreach($getRecord as $value){
            $dataS['name'] = $value->subject_name;
            $getWeek = WeekModel::getRecord();
            $week = [];
            foreach($getWeek as $valueW){
                $dataW = [];
                $dataW['week_name'] = $valueW->name;
                $classSubject = ClassSubjectTimetableModel::getRecord($value->class_id,$value->subject_id,$valueW->id);
                if(!empty($classSubject)){
                    $dataW['start_time'] = $classSubject->start_time;
                    $dataW['end_time'] = $classSubject->end_time;
                    $dataW['room_number'] = $classSubject->room_number;
                }
                else{
                    $dataW['start_time'] = '';
                    $dataW['end_time'] = '';
                    $dataW['room_number'] = '';
                }
                $week[] = $dataW;
            }
            $dataS['week'] = $week;
            $result[]= $dataS;
        }
        $data['getRecord'] = $result;
        return view('student.timetable',$data);
    }

    //MyTimetable teacher
    public function MyTimetableTeacher($class_id,$subject_id){
        $data['getClass'] = ClassModel::getSingle($class_id);
        $data['getSubject'] = SubjectModel::getSingle($subject_id);
        $data['header_title'] = 'Class Timetable';
        $getWeek = WeekModel::getRecord();
        foreach($getWeek as $value){
            $dataW = [];
            $dataW['id'] = $value->id;
            $dataW['week_name'] = $value->name;

                $classSubject = ClassSubjectTimetableModel::getRecord($class_id,$subject_id,$value->id);
                if(!empty($classSubject)){
                    $dataW['start_time'] = $classSubject->start_time;
                    $dataW['end_time'] = $classSubject->end_time;
                    $dataW['room_number'] = $classSubject->room_number;
                }
                else{
                    $dataW['start_time'] = '';
                    $dataW['end_time'] = '';
                    $dataW['room_number'] = '';
                }
                $result[] = $dataW;
            }
        $data['getRecord'] = $result;
        return view('teacher.timetable',$data);


    }

    //parent side work
    public function MyTimetableParent($class_id,$subject_id,$student_id){
        $data['getClass'] = ClassModel::getSingle($class_id);
        $data['getSubject'] = SubjectModel::getSingle($subject_id);
        $data['getUser'] = User::getSingle($student_id);
        $data['header_title'] = 'Class Timetable';
        $getWeek = WeekModel::getRecord();
        foreach($getWeek as $value){
            $dataW = [];
            $dataW['id'] = $value->id;
            $dataW['week_name'] = $value->name;

                $classSubject = ClassSubjectTimetableModel::getRecord($class_id,$subject_id,$value->id);
                if(!empty($classSubject)){
                    $dataW['start_time'] = $classSubject->start_time;
                    $dataW['end_time'] = $classSubject->end_time;
                    $dataW['room_number'] = $classSubject->room_number;
                }
                else{
                    $dataW['start_time'] = '';
                    $dataW['end_time'] = '';
                    $dataW['room_number'] = '';
                }
                $result[] = $dataW;
            }
        $data['getRecord'] = $result;
        return view('parent.timetable',$data);
    }

}
