<?php

namespace App\Http\Controllers;

use App\Models\AssignSubjectModel;
use App\Models\AssignTeacherModel;
use App\Models\ClassModel;
use App\Models\ExamModel;
use App\Models\ExamSceduleModel;
use App\Models\MarksGradeModel;
use App\Models\MarksRegisterModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExaminationsController extends Controller
{
    public function list(){
        $data['getRecord'] = ExamModel::getRecord();
        $data['header_title'] = 'Exams List';
        return view('admin.exams.list',$data);
    }

    public function add(){
        $data['header_title'] = 'Add New';
        return view('admin.exams.add',$data);
    }

    public function insert(Request $request){
        $save = new ExamModel();
        $save->name = $request->name;
        $save->note = $request->note;
        $save->created_by = Auth::user()->id;
        $save->save();
        return redirect('admin/exams/list')->with('success','Exam added successfully');
    }

    public function edit($id){
        $data['getRecord'] = ExamModel::getSingle($id);
        if(!empty($data['getRecord'])){
            $data['header_title'] = 'Edit Exam Details';
            return view('admin.exams.edit',$data);
        }
        else
        {
            return redirect('admin/exams/list')->with('error','Exam not found');
        }

    }

    public function update($id,Request $request){

        $save = ExamModel::getSingle($id);
        if(!empty($save)){
            $save->name = $request->name;
            $save->note = $request->note;
            $save->save();
            return redirect('admin/exams/list')->with('success','Admin updated successfully');
        }
        else
        {
            return redirect('admin/exams/list')->with('error','Exam not found');
        }
    }

    public function delete($id){
        $user = ExamModel::getSingle($id);
        $user->is_delete = 1;
        $user->save();
        return redirect()->back()->with('success','Exam deleted successfully');
    }

    //marks-grade
    public function marks_grade(){
        $data['getRecord'] = MarksGradeModel::getRecord();
        $data['header_title'] = 'Marks Grade List';
        return view('admin.exams.marks_grade.list',$data);
    }

    public function add_marks_grade(){
        $data['header_title'] = 'Add New';
        return view('admin.exams.marks_grade.add',$data);
    }

    public function insert_marks_grade(Request $request){
        $save = new MarksGradeModel();
        $save->name = $request->name;
        $save->percent_from = $request->percent_from;
        $save->percent_to = $request->percent_to;
        $save->created_by = Auth::user()->id;
        $save->save();
        return redirect('admin/exams/marks-grade')->with('success','Marks Grade added successfully');
    }

    public function edit_marks_grade($id){
        $data['getRecord'] = MarksGradeModel::getSingle($id);
        if(!empty($data['getRecord'])){
            $data['header_title'] = 'Edit Marks Grade Details';
            return view('admin.exams.marks_grade.edit',$data);
        }
        else
        {
            return redirect('admin/exams/marks-grade')->with('error','Marks Grade not found');
        }

    }

    public function update_marks_grade($id,Request $request){

        $save = MarksGradeModel::getSingle($id);
        if(!empty($save)){
            $save->name = $request->name;
            $save->percent_from = $request->percent_from;
            $save->percent_to = $request->percent_to;
            $save->save();
            return redirect('admin/exams/marks-grade')->with('success','Marks Grade added successfully');
        }
        else
        {
            return redirect('admin/exams/marks-grade')->with('error','Marks Grade not found');
        }
    }

    public function delete_marks_grade($id){
        $user = MarksGradeModel::getSingle($id);
        $user->is_delete = 1;
        $user->save();
        return redirect()->back()->with('success','Marks Grade Deleted Successfully');
    }



    public function exam_schedule(Request $request){
        $data['header_title'] = 'Exam Schedule';
        $data['getClass'] = ClassModel::getClass();
        $data['getExam'] = ExamModel::getExam();
        $result = [];
        if(!empty($request->get('exam_id')) && !empty($request->get('class_id'))){
            $getSubject = AssignSubjectModel::getMysubject($request->get('class_id'));
            foreach($getSubject as $value){
                $dataS = [];
                $dataS['subject_id'] = $value->subject_id;
                $dataS['class_id'] = $value->class_id;
                $dataS['subject_name'] = $value->subject_name;
                $dataS['subject_type'] = $value->subject_type;

                $getRecordSingle = ExamSceduleModel::getRecordSingle($request->get('class_id'),$value->subject_id,$request->get('exam_id'));
                if(!empty($getRecordSingle)){
                    $dataS['start_time'] = $getRecordSingle->start_time;
                    $dataS['end_time'] = $getRecordSingle->end_time;
                    $dataS['room_number'] = $getRecordSingle->room_number;
                    $dataS['exam_date'] = $getRecordSingle->exam_date;
                    $dataS['full_marks'] = $getRecordSingle->full_marks;
                    $dataS['passing_marks'] = $getRecordSingle->passing_marks;
                    $dataS['full_marks'] = $getRecordSingle->full_marks;
                }
                else{
                    $dataS['start_time'] = '';
                    $dataS['end_time'] = '';
                    $dataS['room_number'] = '';
                    $dataS['exam_date'] = '';
                    $dataS['full_marks'] = '';
                    $dataS['passing_marks'] = '';
                    $dataS['full_marks'] = '';
                }
                $result[] = $dataS;
            }
        }
        $data['getRecord'] = $result;

        return view('admin.exams.exam_schedule',$data);
    }

    public function exam_schedule_update(Request $request){
        ExamSceduleModel::where('class_id','=',$request->get('class_id'))->where('exam_id','=',$request->get('exam_id'))->delete();
        foreach($request->class_timetable as $timetable)
        {
            if(!empty($timetable['subject_id']) && !empty($timetable['start_time']) && !empty($timetable['exam_date']) && !empty($timetable['end_time']) && !empty($timetable['room_number'])&& !empty($timetable['full_marks'])&& !empty($timetable['passing_marks']))
            {
                $save = new ExamSceduleModel;
                $save->class_id = $request->class_id;
                $save->exam_id = $request->exam_id;
                $save->subject_id = $timetable['subject_id'];
                $save->start_time = $timetable['start_time'];
                $save->end_time = $timetable['end_time'];
                $save->exam_date = $timetable['exam_date'];
                $save->full_marks = $timetable['full_marks'];
                $save->passing_marks = $timetable['passing_marks'];
                $save->room_number = $timetable['room_number'];
                $save->save();
            }
        }
        return redirect()->back()->with('success','Schedule Updated successfully');
    }

    //student exam schedule
    public function MyExamSchedule(Request $request){
        $data['header_title'] = 'My Exam Schedule';
        $class_id = Auth::user()->class_id;
        $getExam = ExamSceduleModel::getExam($class_id);
        $result = [];
        foreach($getExam as $value){
            $dataE = [];
            $dataE['exam_name'] = $value->exam_name;
            $getExamTimetable = ExamSceduleModel::getExamTimetable($class_id,$value->exam_id);
            $resultS = [];
            if(!empty($getExamTimetable)){
                foreach($getExamTimetable as $valueT){
                    $dataT = [];
                    $dataT['subject_name'] = $valueT->subject_name;
                    $dataT['subject_type'] = $valueT->subject_type;
                    $dataT['start_time'] = $valueT->start_time;
                    $dataT['end_time'] = $valueT->end_time;
                    $dataT['room_number'] = $valueT->room_number;
                    $dataT['full_marks'] = $valueT->full_marks;
                    $dataT['passing_marks'] = $valueT->passing_marks;
                    $dataT['exam_date'] = date('d-m-Y',strtotime($valueT->exam_date));
                    $resultS[] = $dataT;
                }
                $dataE['exam'] = $resultS;
                $result[] = $dataE;
            }

        }
        $data['getRecord'] = $result;
        return view('student.my_exam_schedule',$data);
    }

    //student exam results
    public function examResult(){
        $data['header_title'] = 'My Exam Result';
        $result = [];
        $getExam = MarksRegisterModel::getExam(Auth::user()->id);

        foreach($getExam as $value){
            $dataE = [];
            $dataE['exam_id'] = $value->exam_id;
            $dataE['exam_name'] = $value->exam_name;
            $getExamSubject = MarksRegisterModel::getExamSubject(Auth::user()->id,$value->exam_id);
            $resultS = [];
            if(!empty($getExamSubject)){
                foreach($getExamSubject as $valueT){
                    $dataT = [];
                    $total_marks = $valueT->homework + $valueT->classwork + $valueT->exam_marks + $valueT->test_work;
                    $dataT['subject_name'] = $valueT['subject_name'];
                    $dataT['subject_type'] = $valueT['subject_type'];
                    $dataT['full_marks'] = $valueT['full_marks'];
                    $dataT['homework'] = $valueT['homework'];
                    $dataT['classwork'] = $valueT['classwork'];
                    $dataT['test_work'] = $valueT['test_work'];
                    $dataT['exam_marks'] = $valueT['exam_marks'];
                    $dataT['total_marks'] = $total_marks;
                    $dataT['passing_marks'] = $valueT['passing_marks'];
                    $dataT['full_marks'] = $valueT['full_marks'];
                    $dataT['exam_date'] = date('d-m-Y',strtotime($valueT['exam_date']));
                    $resultS[] = $dataT;
                }
                $dataE['exam'] = $resultS;
                $result[] = $dataE;
            }

        }
        $data['getRecord'] = $result;
        return view('student.exam_result',$data);
    }

    public function examResultPrint(Request $request){
        $exam_id = $request->exam_id;
        $student_id =$request->student_id;
        $data['getExam'] = ExamModel::getSingle($exam_id);
        $data['getUser'] = User::getSingle($student_id);
        $data['getClass'] = MarksRegisterModel::getClass($student_id,$exam_id);

        $getExamSubject = MarksRegisterModel::getExamSubject($student_id,$exam_id);
            $resultS = [];
                foreach($getExamSubject as $valueT){
                    $dataT = [];
                    $total_marks = $valueT->homework + $valueT->classwork + $valueT->exam_marks + $valueT->test_work;
                    $dataT['subject_name'] = $valueT['subject_name'];
                    $dataT['subject_type'] = $valueT['subject_type'];
                    $dataT['full_marks'] = $valueT['full_marks'];
                    $dataT['homework'] = $valueT['homework'];
                    $dataT['classwork'] = $valueT['classwork'];
                    $dataT['test_work'] = $valueT['test_work'];
                    $dataT['exam_marks'] = $valueT['exam_marks'];
                    $dataT['total_marks'] = $total_marks;
                    $dataT['passing_marks'] = $valueT['passing_marks'];
                    $dataT['full_marks'] = $valueT['full_marks'];
                    $dataT['exam_date'] = date('d-m-Y',strtotime($valueT['exam_date']));
                    $resultS[] = $dataT;
                }
                $data['exam'] = $resultS;

        return view('print_result',$data);
    }

    //teacher exam schedule
    public function MyExamScheduleTeacher(){
        $getClass = AssignTeacherModel::getMysubjectClassGroup(Auth::user()->id);
        $result = [];
        foreach($getClass as $value){
            $dataC = [];
            $dataC['class_name'] = $value->class_name;
            $dataC['class_id'] = $value->class_id;
            $getExam = ExamSceduleModel::getExam($value->class_id);
            $examArray = [];
            foreach($getExam as $exam){
                $dataE = [];
                $dataE['exam_name'] = $exam->exam_name;
                $getExamTimetable = ExamSceduleModel::getExamTimetable($value->class_id,$exam->exam_id);
                $subjectArray = [];
                if(!empty($getExamTimetable)){
                    foreach($getExamTimetable as $valueT){
                        $dataT = [];
                        $dataT['subject_name'] = $valueT->subject_name;
                        $dataT['subject_type'] = $valueT->subject_type;
                        $dataT['start_time'] = $valueT->start_time;
                        $dataT['end_time'] = $valueT->end_time;
                        $dataT['room_number'] = $valueT->room_number;
                        $dataT['full_marks'] = $valueT->full_marks;
                        $dataT['passing_marks'] = $valueT->passing_marks;
                        $dataT['exam_date'] = date('d-m-Y',strtotime($valueT->exam_date));
                        $subjectArray[] = $dataT;
                    }
                    $dataE['subject'] = $subjectArray;
                    $examArray[] = $dataE;
                }
                $dataC['exam'] = $examArray;
            }
            $result[] = $dataC;
        }
        // dd($result);
        $data['getRecord'] = $result;
        $data['header_title'] = 'My Exam Schedule';
        return view('teacher.my_exam_schedule',$data);

    }

    //parent-student exam schedule
    public function ParentStudentExam($student_id){
        $data['header_title'] = 'Exam Schedule';
        $getStudent = User::getSingle($student_id);
        $data['getStudent'] = $getStudent;
        $class_id = $getStudent->class_id;
        $getExam = ExamSceduleModel::getExam($class_id);
        $result = [];
        foreach($getExam as $value){
            $dataE = [];
            $dataE['exam_name'] = $value->exam_name;
            $getExamTimetable = ExamSceduleModel::getExamTimetable($class_id,$value->exam_id);
            $resultS = [];
            if(!empty($getExamTimetable)){
                foreach($getExamTimetable as $valueT){
                    $dataT = [];
                    $dataT['subject_name'] = $valueT->subject_name;
                    $dataT['subject_type'] = $valueT->subject_type;
                    $dataT['start_time'] = $valueT->start_time;
                    $dataT['end_time'] = $valueT->end_time;
                    $dataT['room_number'] = $valueT->room_number;
                    $dataT['full_marks'] = $valueT->full_marks;
                    $dataT['passing_marks'] = $valueT->passing_marks;
                    $dataT['exam_date'] = date('d-m-Y',strtotime($valueT->exam_date));
                    $resultS[] = $dataT;
                }
                $dataE['exam'] = $resultS;
                $result[] = $dataE;
            }

        }
        $data['getRecord'] = $result;
        return view('parent.my_exam_schedule',$data);
    }

    //parent-student exam results
    public function ParentStudentExamResult($student_id){
        $data['header_title'] = 'My Exam Result';
        $data['getUser'] = User::getSingle($student_id);
        $result = [];
        $getExam = MarksRegisterModel::getExam($student_id);

        foreach($getExam as $value){
            $dataE = [];
            $dataE['exam_id'] = $value->exam_id;
            $dataE['exam_name'] = $value->exam_name;
            $getExamSubject = MarksRegisterModel::getExamSubject($student_id,$value->exam_id);
            $resultS = [];
            if(!empty($getExamSubject)){
                foreach($getExamSubject as $valueT){
                    $dataT = [];
                    $total_marks = $valueT->homework + $valueT->classwork + $valueT->exam_marks + $valueT->test_work;
                    $dataT['subject_name'] = $valueT['subject_name'];
                    $dataT['subject_type'] = $valueT['subject_type'];
                    $dataT['full_marks'] = $valueT['full_marks'];
                    $dataT['homework'] = $valueT['homework'];
                    $dataT['classwork'] = $valueT['classwork'];
                    $dataT['test_work'] = $valueT['test_work'];
                    $dataT['exam_marks'] = $valueT['exam_marks'];
                    $dataT['total_marks'] = $total_marks;
                    $dataT['passing_marks'] = $valueT['passing_marks'];
                    $dataT['full_marks'] = $valueT['full_marks'];
                    $dataT['exam_date'] = date('d-m-Y',strtotime($valueT['exam_date']));
                    $resultS[] = $dataT;
                }
                $dataE['exam'] = $resultS;
                $result[] = $dataE;
            }

        }
        $data['getRecord'] = $result;
        return view('parent.exam_result',$data);
    }

    public function marks_register(Request $request){
        $data['header_title'] = 'Marks Register';
        $data['getClass'] = ClassModel::getClass();
        $data['getExam'] = ExamModel::getExam();
        if(!empty($request->get('exam_id')) && !empty($request->get('class_id'))){
            $data['getSubject'] = ExamSceduleModel::getMysubject($request->get('class_id'),$request->get('exam_id'));
            $data['getStudentClass'] = User::getStudentClass($request->get('class_id'));
        }
        return view('admin.exams.marks_register',$data);
    }

    public function marks_registerT_teacher(Request $request){
        $data['header_title'] = 'Marks Register';
        $data['getClass'] = AssignTeacherModel::getMysubjectClassGroup(Auth::user()->id);
        $data['getExam'] = ExamSceduleModel::getExamTeacher(Auth::user()->id);;
        if(!empty($request->get('exam_id')) && !empty($request->get('class_id'))){
            $data['getSubject'] = ExamSceduleModel::getMysubject($request->get('class_id'),$request->get('exam_id'));
            $data['getStudentClass'] = User::getStudentClass($request->get('class_id'));
        }
        return view('teacher.marks_register',$data);
    }

    public function submit_marks_register(Request $request){
        $validation = 0;
        if(!empty($request->marks)){
            foreach($request->marks as $marks)
            {
                    $getExamSchedule = ExamSceduleModel::getSingle($marks['id']);
                    $full_marks = $getExamSchedule->full_marks;

                    $homework = !empty($marks['homework']) ? $marks['homework'] :0;
                    $classwork = !empty($marks['classwork']) ? $marks['classwork'] :0;
                    $exam_marks = !empty($marks['exam_marks']) ? $marks['exam_marks'] :0;
                    $test_work = !empty($marks['test_work']) ? $marks['test_work'] :0;

                    $passing_marks = !empty($marks['passing_marks']) ? $marks['passing_marks'] :0;
                    $full = !empty($marks['full_marks']) ? $marks['full_marks'] :0;

                    $total_marks = $homework + $classwork + $exam_marks + $test_work;

                    if($full_marks >= $total_marks){
                    $getMarks = MarksRegisterModel::CheckAlready($request->class_id,$marks['subject_id'],$request->exam_id,$request->student_id);
                    if(!empty($getMarks)){
                        $save = $getMarks;
                    }
                    else{
                        $save = new MarksRegisterModel;
                        $save->created_by = Auth::user()->id;
                    }
                    $save->class_id = $request->class_id;
                    $save->subject_id = $marks['subject_id'];
                    $save->test_work = $test_work;
                    $save->student_id = $request->student_id;
                    $save->exam_id = $request->exam_id;
                    $save->classwork = $classwork;
                    $save->homework = $homework;
                    $save->exam_marks = $exam_marks;

                    $save->passing_marks = $passing_marks;
                    $save->full_marks = $full;

                    $save->save();
                }

                else{
                    $validation = 1;
                }
            }
        }
        if($validation == 0){
        $json['message'] = "Marks Succesfully Updated";
        }
        else{
            $json['message'] = "Marks Succesfully Updated but Some Mark going Greater than Full Marks";
        }
         echo json_encode($json);
    }

    public function single_submit_marks_register(Request $request){
        $id = $request->id;
        $getExamSchedule = ExamSceduleModel::getSingle($id);
        $full_marks = $getExamSchedule->full_marks;

        $homework = !empty($request->homework) ? $request->homework :0;
        $classwork = !empty($request->classwork) ? $request->classwork :0;
        $exam_marks = !empty($request->exam_marks) ? $request->exam_marks :0;
        $test_work = !empty($request->test_work) ? $request->test_work :0;

        $passing_marks = !empty($request->passing_marks) ? $request->passing_marks :0;
        $full = !empty($request->full_marks) ? $request->full_marks :0;

        $total_marks = $homework + $classwork + $exam_marks + $test_work;

        if($full_marks >= $total_marks){
            $getMarks = MarksRegisterModel::CheckAlready($request->class_id,$request->subject_id,$request->exam_id,$request->student_id);
            if(!empty($getMarks)){
                $save = $getMarks;
            }
            else{
                $save = new MarksRegisterModel;
                $save->created_by = Auth::user()->id;
            }
            $save->class_id = $request->class_id;
            $save->subject_id = $request->subject_id;
            $save->test_work = $test_work;
            $save->student_id = $request->student_id;
            $save->exam_id = $request->exam_id;
            $save->classwork = $classwork;
            $save->homework = $homework;
            $save->exam_marks = $exam_marks;

            $save->passing_marks = $passing_marks;
            $save->full_marks = $full;

            $save->save();

            $json['message'] = "Subject Marks Succesfully Updated";
        }
        else{
            $json['message'] = "Invalid Entry";
        }
            echo json_encode($json);
    }

}
