<?php

namespace App\Http\Controllers;

use App\Exports\ExportAttendance;
use App\Models\AssignSubjectModel;
use App\Models\AssignTeacherModel;
use App\Models\AttendanceModel;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Expr\Assign;

class AttendanceController extends Controller
{
    public function studentAttendance(Request $request){
        $data['header_title'] = 'Student Attendance Register';
        $data['getClass'] = ClassModel::getClass();

        if(!empty($request->get('class_id')) && !empty($request->get('attendance_date'))){
            $data['getStudentClass'] = User::getStudentClass($request->get('class_id'));
        }

        return view('admin.attendance.student',$data);
    }

    public function SavestudentAttendance(Request $request){
        $student_attendance = AttendanceModel::checkAlready($request->class_id, $request->attendance_date, $request->student_id);
        if(!empty($student_attendance)){
            $save = $student_attendance;
        }
        else{
            $save = new AttendanceModel();
            $save->class_id = $request->class_id;
            $save->attendance_type = $request->attendance_type;
            $save->attendance_date = $request->attendance_date;
            $save->student_id = $request->student_id;
            $save->created_by = Auth::user()->id;
        }

        $save->attendance_type = $request->attendance_type;
        $save->save();

        $json['message'] = "Attendance Register Succesfully Updated";

        echo json_encode($json);
    }

    public function AttendanceReport(Request $request){
        $data['header_title'] = 'Student Attendance Report';
        $data['getClass'] = ClassModel::getClass();

            $data['getStudentClass'] = User::getStudent();
            $data['getRecord'] = AttendanceModel::getRecord();


        return view('admin.attendance.report',$data);
    }

    public function AttendanceReportExport(Request $request){
        return Excel::download(new ExportAttendance,'Attendance Report '.date('Y-m-d').'.xlsx');
    }

    //teacher attendance side
    public function studentAttendanceTeacher(Request $request){
        $data['header_title'] = 'Student Attendance Register';
        $data['getClass'] = AssignTeacherModel::getMysubjectClassGroup(Auth::user()->id);

        if(!empty($request->get('class_id')) && !empty($request->get('attendance_date'))){
            $data['getStudentClass'] = User::getStudentClass($request->get('class_id'));
        }

        return view('teacher.attendance.student',$data);
    }

    public function AttendanceReportTeacher(Request $request){
        $data['header_title'] = 'Student Attendance Report';
        $getClass= AssignTeacherModel::getMysubjectClassGroup(Auth::user()->id);
        $class_array = [];
        foreach ($getClass as $value) {
            $class_array[] = $value->class_id;
        }
        $data['getClass'] = $getClass;
        $data['getRecord'] = AttendanceModel::getRecordTeacher($class_array);
        return view('teacher.attendance.report',$data);
    }

    public function AttendanceReportStudent(Request $request){
        $data['header_title'] = 'My Attendance';
        $data['getRecord'] = AttendanceModel::getRecordStudent(Auth::user()->id);
        $data['getClass'] = AttendanceModel::getClassStudent(Auth::user()->class_id);
        return view('student.my_attendance',$data);
    }

    // Parent Attendance side
    public function ParentStudentAttendance($student_id){
        $data['header_title'] = 'My Attendance';
        $data['getStudent'] = User::getSingle($student_id);
        $data['getRecord'] = AttendanceModel::getRecordStudent($student_id);
        $data['getClass'] = AttendanceModel::getClassStudent($student_id);
        return view('parent.my_attendance',$data);
    }
}
