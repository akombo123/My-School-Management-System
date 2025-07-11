<?php

namespace App\Http\Controllers;

use App\Models\AssignSubjectModel;
use App\Models\AssignTeacherModel;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Assign;

class AssignTeacherController extends Controller
{
    public function list(){
        $data['getRecord'] = AssignTeacherModel::getRecord();
        $data['header_title'] = 'Assign Teacher List';
        return view('admin.assign_teacher.list',$data);
    }

    public function add(){
        $data['getClass'] = ClassModel::getClass();
        $data['getTeacher'] = User::getTeacherClass();
        $data['header_title'] = 'Add New';
        return view('admin.assign_teacher.add',$data);
    }

    public function insert(Request $request){

        if(!empty($request->teacher_id)){
            foreach($request->teacher_id as $teacher_id){

                $getAlredyFist = AssignTeacherModel::getAlredyFist($request->class_id,$teacher_id);
                if(!empty($getAlredyFist)){
                    $getAlredyFist->status = $request->status;
                    $getAlredyFist->save();
                }

                else{
                    $save = new AssignTeacherModel;
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $teacher_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }
            return redirect('admin/assign_teacher/list')->with('success','Teacher successfully Assigned');
        }
        else{
            return redirect('admin/assign_teacher/add')->with('error','Please select subject');
        }
    }

    public function edit($id){
        $getRecord = AssignTeacherModel::getSingle($id);
        if(!empty($getRecord)){
            $data['getRecord'] = $getRecord;
            $data['getAssignTeacherID'] = AssignTeacherModel::getAssignTeacherID($getRecord->class_id);
            $data['getClass'] = ClassModel::getClass();
            $data['getTeacher'] = User::getTeacherClass();
            $data['header_title'] = 'Edit Teacher Class';
            return view('admin.assign_teacher.edit',$data);
        }
        else
        {
            return redirect('admin/assign_teacher/list')->with('error','Record not found');
        }

    }

    public function update(Request $request){

        AssignTeacherModel::deleteSubject($request->class_id);
        if(!empty($request->teacher_id)){
            foreach($request->teacher_id as $teacher_id){

                $getAlredyFist = AssignTeacherModel::getAlredyFist($request->class_id,$teacher_id);
                if(!empty($getAlredyFist)){
                    $getAlredyFist->status = $request->status;
                    $getAlredyFist->save();
                }

                else{
                    $save = new AssignTeacherModel;
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $teacher_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }
        }
        return redirect('admin/assign_teacher/list')->with('success','Teacher successfully Assigned');
    }

    public function edit_single($id){
        $getRecord = AssignTeacherModel::getSingle($id);
        if(!empty($getRecord)){
            $data['getRecord'] = $getRecord;
            $data['getClass'] = ClassModel::getClass();
            $data['getTeacher'] = User::getTeacherClass();
            $data['header_title'] = 'Edit Assign Teacher';
            return view('admin.assign_teacher.edit_single',$data);
        }
        else
        {
            return redirect('admin/assign_teacher/list')->with('error','Record not found');
        }

    }

    public function update_single($id,Request $request){

        $getAlredyFist = AssignTeacherModel::getAlredyFist($request->class_id,$request->teacher_id);
                if(!empty($getAlredyFist)){
                    $getAlredyFist->status = $request->status;
                    $getAlredyFist->save();
                    return redirect('admin/assign_teacher/list')->with('success','Status updated successfully');
                }

                else{
                    $save = AssignTeacherModel::getSingle($id);
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $request->teacher_id;
                    $save->status = $request->status;
                    $save->save();
                    return redirect('admin/assign_teacher/list')->with('success','Assign Teacher updated successfully');
                }
    }


    public function delete($id){
        $save = AssignTeacherModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();
        return redirect()->back()->with('success','Record deleted successfully');
    }

    //teacher side
    public function MyClassSubject(){
        $data['getRecord'] = AssignTeacherModel::getMysubjectClass(Auth::user()->id);
        $data['header_title'] = 'My Class & Subject';
        return view('teacher.my_class_subject',$data);
    }


}
