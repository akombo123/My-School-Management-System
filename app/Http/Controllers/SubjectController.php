<?php

namespace App\Http\Controllers;

use App\Models\AssignSubjectModel;
use App\Models\SubjectModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function list(){
        $data['getRecord'] = SubjectModel::getRecord();
        $data['header_title'] = 'Subject List';
        return view('admin.subject.list',$data);
    }

    public function add(){
        $data['header_title'] = 'Add New';
        return view('admin.subject.add',$data);
    }

    public function insert(Request $request){

        $save = new SubjectModel;
        $save->name = $request->name;
        $save->status = $request->status;
        $save->type = $request->type;
        $save->created_by = Auth::user()->id;
        $save->save();
        return redirect('admin/subject/list')->with('success','Subject added successfully');
    }

    public function edit($id){
        $data['getRecord'] = SubjectModel::getSingle($id);
        if(!empty($data['getRecord'])){
            $data['header_title'] = 'Edit Subject Details';
            return view('admin.subject.edit',$data);
        }
        else
        {
            return redirect('admin/subject/list')->with('error','Record not found');
        }

    }

    public function update($id,Request $request){
        $save = SubjectModel::getSingle($id);
        $save->name = $request->name;
        $save->status = $request->status;
        $save->type = $request->type;
        $save->save();
        return redirect('admin/subject/list')->with('success','Subject updated successfully');
    }

    public function delete($id){
        $save = SubjectModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();
        return redirect('admin/subject/list')->with('success','Subject deleted successfully');
    }

    //student side
    public function MySubject(){
        $data['getRecord'] = AssignSubjectModel::getMysubject(Auth::user()->class_id);
        $data['header_title'] = 'My Subject List';
        return view('student.my_subject',$data);
    }

    // parent side
    public function ParentStudentSubject($student_id){
        $user = User::getSingle($student_id);
        $data['getUser'] = $user;
        $data['getRecord'] = AssignSubjectModel::getMysubject($user->class_id);
        $data['header_title'] = 'Student`s Subject List';
        return view('parent.my_student_subject',$data);
    }

}
