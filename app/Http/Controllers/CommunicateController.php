<?php

namespace App\Http\Controllers;

use App\Mail\CommunicateMail;
use App\Models\CommunicateModel;
use App\Models\NoticeBoardMessageModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CommunicateController extends Controller
{
    public function getUsers(Request $request){
        $json = [];
            $getUser = User::getUser($request->search);
            if(!empty($getUser)){
                foreach($getUser as $user){
                    $type = '';
                    if($user->user_type == 1){
                        $type = 'Admin';
                    }
                    elseif($user->user_type == 2){
                        $type = 'Teacher';
                    }
                    elseif($user->user_type == 3){
                        $type = 'Student';
                    }
                    elseif($user->user_type == 4){
                        $type = 'Parent';
                    }
                    $name =  $user->name.''.$user->l_name.'-'.$type;
                    $json[] = [
                        'id' => $user->id,
                        'text' => $name,
                    ];
                }
            }
        echo json_encode($json);

    }

    public function sendEmail(){
        $data['header_title'] = 'Send Email';
        return view('admin.communicate.send_email',$data);
    }

    public function UserSendEmail(Request $request){
        if(!empty($request->user_id)){
            $user = User::getSingle($request->user_id);
            $to = $user->email;
            $user->message = $request->message;
            $user->subject = $request->subject;

            Mail::to($to)->send(new CommunicateMail($user));
        }

        if(!empty($request->message_to)){
            foreach($request->message_to as $user_type){
                $getUser = User::getMail($user_type);
                foreach($getUser as $user){
                    $to = $user->email;
                    $user->message = $request->message;
                    $user->subject = $request->subject;

                Mail::to($to)->send(new CommunicateMail($user));
                }
            }
        }
        return redirect()->back()->with('success','Email sent successfully');

    }


    public function NoticeBoard(){
        $data['getRecord'] = CommunicateModel::getRecord();
        $data['header_title'] = 'Noticeboard List';
        return view('admin.communicate.noticeboard.list',$data);
    }

    public function NoticeBoardAdd(){
        $data['header_title'] = 'Add New Notice';
        return view('admin.communicate.noticeboard.add',$data);
    }

    public function NoticeBoardInsert(Request $request){
        $save =  new CommunicateModel();
        $save->title = $request->title;
        $save->notice_date = $request->notice_date;
        $save->publish_date = $request->publish_date;
        $save->message = $request->message;
        $save->created_by = Auth::user()->id;
        $save->save();

        if(!empty($request->message_to)){
        foreach($request->message_to as $message_to){
            $message = new NoticeBoardMessageModel;
            $message->message_to = $message_to;
            $message->noticeboard_id = $save->id;
            $message->save();
        }
        }

        return redirect('admin/communicate/noticeboard')->with('success','NoticeBoard added successfully');
    }

    public function edit($id){
        $data['getRecord'] = CommunicateModel::getSingle($id);
        if(!empty($data['getRecord'])){
            $data['header_title'] = 'Edit Notice';
            return view('admin.communicate.noticeboard.edit',$data);
        }
        else
        {
            return redirect('admin/communicate/noticeboard')->with('error','Notice not found');
        }

    }

    public function update($id,Request $request){
        $save = CommunicateModel::getSingle($id);
        $save->title = $request->title;
        $save->notice_date = $request->notice_date;
        $save->publish_date = $request->publish_date;
        $save->message = $request->message;
        $save->save();

        NoticeBoardMessageModel::DeleteRecord($id);
        if(!empty($request->message_to)){
        foreach($request->message_to as $message_to){
            $message = new NoticeBoardMessageModel;
            $message->message_to = $message_to;
            $message->noticeboard_id = $save->id;
            $message->save();
        }
        }

        return redirect('admin/communicate/noticeboard')->with('success','NoticeBoard Updated successfully');
    }

    public function delete($id){
        $save = CommunicateModel::getSingle($id);
        $save->delete();
        NoticeBoardMessageModel::DeleteRecord($id);
        return redirect()->back()->with('success','NoticeBoard Deleted successfully');
    }

    //student side
    public function MyNoticeBoardStudent(){
        $data['getRecord'] = CommunicateModel::getRecordUser(Auth::user()->user_type);
        // dd($data['getRecord']);
        $data['header_title'] = 'Noticeboard List';
        return view('student.noticeboard',$data);
    }

    //for parent student have getRecordUser(3).

}
