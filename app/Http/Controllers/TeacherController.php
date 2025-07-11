<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    public function list(){
        $data['getRecord'] = User::getTeacher();
        $data['header_title'] = 'Teacher List';
        return view('admin.teacher.list',$data);
    }

    public function add(){
        $data['header_title'] = 'Add New';
        return view('admin.teacher.add',$data);
    }

    public function insert(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
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
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->password = Hash::make($request->password);
        $user->user_type = 2;
        $user->save();
        return redirect('admin/teacher/list')->with('success','Teacher added successfully');
    }

    public function edit($id){
        $data['getRecord'] = User::getSingle($id);
        if(!empty($data['getRecord'])){
            $data['getClass'] = ClassModel::getClass();
            $data['header_title'] = 'Edit Teacher Details';
            return view('admin.teacher.edit',$data);
        }
        else
        {
            return redirect('admin/teacher/list')->with('error','Teacher not found');
        }

    }

    public function update($id,Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
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
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->status = $request->status;

        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect('admin/teacher/list')->with('success','Teacher Details updated successfully');
    }

    public function delete($id){
        $user = User::getSingle($id);
        if(!empty($user)){
            $user->is_delete = 1;
            $user->save();
            return redirect('admin/teacher/list')->with('success','Teacher deleted successfully');
        }
        return redirect('admin/teacher/list')->with('error','Teacher not found');

    }

}
