<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ParentController extends Controller
{
    public function list(){
        $data['getRecord'] = User::getParent();
        $data['header_title'] = 'Parent List';
        return view('admin.parent.list',$data);
    }

    public function add(){
        $data['getClass'] = ClassModel::getClass();
        $data['header_title'] = 'Add New';
        return view('admin.parent.add',$data);
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
        $user->gender = $request->gender;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->password = Hash::make($request->password);
        $user->user_type = 4;
        $user->save();
        return redirect('admin/parent/list')->with('success','Parent added successfully');
    }

    public function edit($id){
        $data['getRecord'] = User::getSingle($id);
        if(!empty($data['getRecord'])){
            $data['getClass'] = ClassModel::getClass();
            $data['header_title'] = 'Edit Parent Details';
            return view('admin.parent.edit',$data);
        }
        else
        {
            return redirect('admin/parent/list')->with('error','Parent not found');
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
        $user->gender = $request->gender;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->status = $request->status;

        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect('admin/parent/list')->with('success','Parent added successfully');
    }

    public function my_student($id){
        $data['getParent'] = User::getSingle($id);
        $data['parent_id'] = $id;
        $data['getSearchStudent'] = User::getSearchStudent();
        $data['getRecord'] = User::getMyStudent($id);
        $data['header_title'] = 'Parent Student List';
        return view('admin.parent.my_student',$data);
    }

    public function assign_student_parent($student_id,$parent_id){
        $user = User::getSingle($student_id);
        if(!empty($user)){
            $user->parent_id = $parent_id;
            $user->save();
            return redirect('admin/parent/my-student/'.$parent_id)->with('success','Student assigned to parent successfully');
        }
        return redirect('admin/parent/my-student/'.$parent_id)->with('error','Student not found');
    }

    public function assign_student_parent_delete($student_id){
        $user = User::getSingle($student_id);
        if(!empty($user)){
            $user->parent_id = null;
            $user->save();
            return redirect('admin/parent/my-student/'.$user->parent_id)->with('success','Student unassigned from parent successfully');
        }
        return redirect('admin/parent/my-student/'.$user->parent_id)->with('error','Student not found');
    }


    public function delete($id){
        $user = User::getSingle($id);
        if(!empty($user)){
            $user->is_delete = 1;
            $user->save();
            return redirect('admin/parent/list')->with('success','Parent deleted successfully');
        }
        return redirect('admin/parent/list')->with('error','Parent not found');

    }

    //parent side
    public function my_student_parent(){
        $id = Auth::user()->id;
        $data['getRecord'] = User::getMyStudent($id);
        $data['header_title'] = 'My Student List';
        return view('parent.my_student',$data);
    }

}
