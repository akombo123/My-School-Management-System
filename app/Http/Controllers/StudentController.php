<?php

namespace App\Http\Controllers;

use App\Exports\ExportStudentList;
use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function list(){
        $data['getRecord'] = User::getStudent();
        $data['header_title'] = 'Admin List';
        return view('admin.student.list',$data);
    }

    public function export_list(){
        return Excel::download(new ExportStudentList,'Student List '.date('Y-m-d').'.xlsx');
    }

    public function add(){
        $data['getClass'] = ClassModel::getClass();
        $data['header_title'] = 'Add New';
        return view('admin.student.add',$data);
    }

    public function insert(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
            'class_id' => 'required',
            'profile_pic' => 'mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        $user = new User;
        $user->name = $request->name;

        if(!empty($request->file('profile_pic'))){
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('uploads/profile/',$filename);
            $user->profile_pic = $filename;
        }

        $user->l_name = $request->l_name;
        $user->class_id = $request->class_id;
        $user->adm_no = $request->adm_no;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->password = Hash::make($request->password);
        $user->user_type = 3;
        $user->save();
        return redirect('admin/student/list')->with('success','Student added successfully');
    }

    public function edit($id){
        $data['getRecord'] = User::getSingle($id);
        if(!empty($data['getRecord'])){
            $data['getClass'] = ClassModel::getClass();
            $data['header_title'] = 'Edit Student Details';
            return view('admin.student.edit',$data);
        }
        else
        {
            return redirect('admin/student/list')->with('error','Student not found');
        }

    }

    public function update($id,Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'class_id' => 'required',
            'profile_pic' => 'mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        $user = User::getSingle($id);
        $user->name = $request->name;

        if(!empty($request->file('profile_pic'))){
            if(!empty($user->profile_pic) && file_exists('uploads/profile/'.$user->profile_pic)){
                unlink('uploads/profile/'.$user->profile_pic);
            }
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('uploads/profile/',$filename);
            $user->profile_pic = $filename;
        }

        $user->l_name = $request->l_name;
        $user->class_id = $request->class_id;
        $user->adm_no = $request->adm_no;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->status = $request->status;

        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect('admin/student/list')->with('success','Student added successfully');
    }

    public function delete($id){
        $user = User::getSingle($id);
        if(!empty($user)){
            $user->is_delete = 1;
            $user->save();
            return redirect('admin/student/list')->with('success','Admin deleted successfully');
        }
        return redirect('admin/student/list')->with('error','Student not found');

    }

    //teacher side
    public function MyStudent(){
        $data['getRecord'] = User::getTeacherStudent(Auth::user()->id);
        $data['header_title'] = 'My Students List';
        return view('teacher.my-students',$data);
    }

}
