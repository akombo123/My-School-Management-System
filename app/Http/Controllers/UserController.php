<?php

namespace App\Http\Controllers;

use App\Models\SettingModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function my_settings()
    {
        $data['header_title'] = 'My Settings';
        $data['getRecord'] = SettingModel::getSingle();
        return view('admin.setting',$data);

    }

    public function post_my_settings(Request $request)
    {
        $data['header_title'] = 'My Settings';
        $setting = SettingModel::getSingle();
        $setting->paypal_email = trim($request->paypal_email);
        $setting->save();
        return redirect()->back()->with('success','Settings updated successfully');
    }

    public function my_account()
    {
        $data['header_title'] = 'My Account';
        $data['getRecord'] = User::getSingle(Auth::user()->id);
        if(Auth::user()->user_type == 1){
            return view('admin.my_account',$data);
        }else if(Auth::user()->user_type == 2){
            return view('teacher.my_account',$data);
        }else if(Auth::user()->user_type == 3){
            return view('student.my_account',$data);
        }else if(Auth::user()->user_type == 4){
            return view('parent.my_account',$data);
        }

    }

    public function post_my_account(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'profile_pic' => 'mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        $user = User::getSingle($id);
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->l_name = $request->l_name;

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

        $user->save();
        return redirect()->back()->with('success','Profile Updated successfully');
    }

    public function post_my_account_admin(Request $request){
        $id = Auth::user()->id;
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
        $user->mobile = $request->mobile;
        $user->email = $request->email;

        $user->save();
        return redirect()->back()->with('success','Account Details updated successfully');
    }

    public function post_my_account_student(Request $request)
    {
        $id = Auth::user()->id;
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
        $user->mobile = $request->mobile;
        $user->email = $request->email;

        $user->save();
        return redirect()->back()->with('success','Account Details updated successfully');
    }

    public function post_my_account_parent(Request $request)
    {
        $id = Auth::user()->id;
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
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->save();
        return redirect()->back()->with('success','Account Details Updated successfully');
    }

    public function change_password(){
        $data['header_title'] = 'Change Password';
        $data['getRecord'] = User::getAdmin();
        return view('profile.change_password',$data);
    }

    public function post_change_password(Request $request){

        $user = User::getSingle(Auth::user()->id);
        if(Hash::check($request->old_password, $user->password)){
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->back()->with('success','Password changed successfully');
        }
        else{
            return redirect()->back()->with('error','Old password is incorrect');
        }
    }

}
