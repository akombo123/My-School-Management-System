<?php

namespace App\Http\Controllers;

use App\Models\AssignSubjectModel;
use App\Models\AssignTeacherModel;
use App\Models\ClassModel;
use App\Models\HomeworkModel;
use App\Models\HomeworkSubmitModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HomeworkController extends Controller
{
    public function homeworkReport(){
        $data['getRecord'] = HomeworkSubmitModel::getHomeworkReport();
        $data['header_title'] = 'Homework Report';

        if(Auth::user()->user_type == 1){
            return view('admin.homework.report',$data);
        }
        elseif(Auth::user()->user_type == 2){
            return view('teacher.homework.report',$data);
        }
    }

    public function homework(){
        if(Auth::user()->user_type == 1){
            $data['getRecord'] = HomeworkModel::getRecord();
            $data['header_title'] = 'Homework List';
            return view('admin.homework.list',$data);
        }
        elseif(Auth::user()->user_type == 2){
            $class_ids = [];
            $class_id = AssignTeacherModel::getMysubjectClass(Auth::user()->id);
            foreach($class_id as $class){
                $class_ids[] = $class->class_id;
            }
            $data['getRecord'] = HomeworkModel::getRecordTeacher($class_ids);
            $data['header_title'] = 'Homework List';
            return view('teacher.homework.list',$data);
        }
        elseif(Auth::user()->user_type == 3){
            $data['header_title'] = 'My Homework List';
            return view('student.homework.list',$data);
        }
        elseif(Auth::user()->user_type == 4){
            $data['header_title'] = 'My Student Homework List';
            return view('parent.homework.list',$data);
        }

    }

    public function add(){
        $data['header_title'] = 'Add New';
        if(Auth::user()->user_type == 1){
            $data['getClass'] = ClassModel::getClass();
            return view('admin.homework.add',$data);
        }
        elseif(Auth::user()->user_type == 2){
            $data['getClass'] = AssignTeacherModel::getMysubjectClassGroup(Auth::user()->id);
            return view('teacher.homework.add',$data);
        }
    }

    public function get_subject_ajax(Request $request){
        $class_id = $request->class_id;
        $getSubject = AssignSubjectModel::getMysubject($class_id);
        $html = '';
        $html .= '<option value="">Select Subject</option>';
        if(!empty($getSubject)){
            foreach($getSubject as $subject){
                $html .= '<option value="'.$subject->subject_id.'">'.$subject->subject_name.'</option>';
            }
        }
        return response()->json(['html'=>$html]);
    }

    public function insert(Request $request){
        $save = new HomeworkModel;
        $save->class_id = $request->class_id;
        $save->subject_id = $request->subject_id;
        $save->homework_date = $request->homework_date;
        $save->submission_date = $request->submission_date;
        $save->description = $request->description;
        $save->created_by = Auth::user()->id;

        if(!empty($request->file('document_file'))){
            if(!empty($save->document_file) && file_exists('uploads/homework/'.$save->document_file)){
                unlink('uploads/homework/'.$save->document_file);
            }
            $ext = $request->file('document_file')->getClientOriginalExtension();
            $file = $request->file('document_file');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('uploads/homework/',$filename);
            $save->document_file = $filename;
        }

        $save->save();
        if(Auth::user()->user_type == 1){
            return redirect('admin/homework/homework')->with('success','Homework added successfully');
        }
        elseif(Auth::user()->user_type == 2){
            return redirect('teacher/homework/homework')->with('success','Homework added successfully');
        }

    }

    public function edit($id){
        $getRecord = HomeworkModel::getSingle($id);
        $data['getSubject'] = AssignSubjectModel::getMysubject($getRecord->class_id);
        $data['getRecord'] = $getRecord;
        if(!empty($data['getRecord'])){
            if(Auth::user()->user_type == 1){
                $data['getClass'] = ClassModel::getClass();
                return view('admin.homework.edit',$data);
            }
            elseif(Auth::user()->user_type == 2){
                $class_ids = [];
                $class_id = AssignTeacherModel::getMysubjectClass(Auth::user()->id);
                foreach($class_id as $class){
                    $class_ids[] = $class->class_id;
                }
                $data['getClass'] = HomeworkModel::getRecordTeacher($class_ids);
                return view('teacher.homework.edit',$data);
            }

        }

    }

    public function update($id,Request $request){
        $save = HomeworkModel::getSingle($id);
        $save->class_id = $request->class_id;
        $save->subject_id = $request->subject_id;
        $save->homework_date = $request->homework_date;
        $save->submission_date = $request->submission_date;
        $save->description = $request->description;

        if(!empty($request->file('document_file'))){
            if(!empty($save->document_file) && file_exists('uploads/homework/'.$save->document_file)){
                unlink('uploads/homework/'.$save->document_file);
            }
            $ext = $request->file('document_file')->getClientOriginalExtension();
            $file = $request->file('document_file');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('uploads/homework/',$filename);
            $save->document_file = $filename;
        }

        $save->save();
        if(Auth::user()->user_type == 1){
            return redirect('admin/homework/homework')->with('success','Homework added successfully');
        }
        elseif(Auth::user()->user_type == 2){
            return redirect('teacher/homework/homework')->with('success','Homework added successfully');
        }
    }

    public function delete($id){
        $user = HomeworkModel::getSingle($id);
        $user->is_delete = 1;
        $user->save();
        return redirect()->back()->with('success','Homework Deleted successfully');
    }

    public function Submitted($id){
        $homework_id = HomeworkModel::getSingle($id);
        if(!empty($homework_id)){
            $data['getRecord'] = HomeworkSubmitModel::getRecordAdmin($homework_id->id);
            $data['header_title'] = 'Homework View';
            if(Auth::user()->user_type == 1){
                return view('admin.homework.view',$data);
            }
            elseif(Auth::user()->user_type == 2){
                return view('teacher.homework.view',$data);
            }

        }
        else{

        }

    }

    public function homeworkStudent(){
        $data['getRecord'] = HomeworkModel::getRecordStudent(Auth::user()->class_id,Auth::user()->id);
        return view('student.homework.list',$data);
    }

    public function homeworkParent($id){
        $getStudent = User::getSingle($id);
        $data['getUser'] = $getStudent;
        $data['getRecord'] = HomeworkModel::getRecordStudent($getStudent->class_id,$getStudent->id);
        return view('parent.homework.list',$data);
    }

    //student homework submit
    public function homeworkSubmit($id){
        $data['getRecord'] = HomeworkModel::getSingle($id);
        $data['header_title'] = 'Homework Submit';
        return view('student.homework.submit',$data);
    }

    public function homeworkSubmitInsert($id,Request $request){
        $save = new HomeworkSubmitModel;
        $save->homework_id = $id;
        $save->student_id = Auth::user()->id;
        $save->description = $request->description;
        if(!empty($request->file('document_file'))){
            if(!empty($save->document_file) && file_exists('uploads/homework/'.$save->document_file)){
                unlink('uploads/homework/'.$save->document_file);
            }
            $ext = $request->file('document_file')->getClientOriginalExtension();
            $file = $request->file('document_file');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('uploads/homework/',$filename);
            $save->document_file = $filename;
        }
        $save->save();
        return redirect('student/my-homework')->with('success','Homework Submit successfully');
    }

    public function homeworkSubmitList(){
        $data['getRecord'] = HomeworkSubmitModel::getRecord(Auth::user()->id);
        return view('student.homework.submit_list',$data);
    }

    public function SubmithomeworkParent($id){
        $getStudent = User::getSingle($id);
        $data['getUser'] = $getStudent;
        $data['getRecord'] = HomeworkSubmitModel::getRecord($getStudent->id);
        return view('parent.homework.submit_list',$data);
    }

}
