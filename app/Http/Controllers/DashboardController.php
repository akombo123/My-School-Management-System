<?php

namespace App\Http\Controllers;

use App\Models\StudentFeesModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(){

        if(!empty(Auth::check())){
            $data['header_title'] = 'Dashboard';

            if(Auth::user()->user_type == 1){
                $data['getTotalFees'] = StudentFeesModel::getTotalFees();
                $data['getTotalUsers'] = User::getTotalUsers();
                $data['getTotalFeesToday'] = StudentFeesModel::getTotalFeesToday();
                return view('admin.dashboard',$data);
            }
            else if(Auth::user()->user_type == 2){
                return view('teacher.dashboard',$data);
            }
            else if(Auth::user()->user_type == 3){
                return view('student.dashboard',$data);
            }
            else if(Auth::user()->user_type == 4){
                return view('parent.dashboard',$data);
            }

        }
    }

}
