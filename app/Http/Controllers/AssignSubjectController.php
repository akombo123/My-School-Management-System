<?php

namespace App\Http\Controllers;

use App\Models\AssignSubjectModel;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Assign;

class AssignSubjectController extends Controller
{
    public function list(){
        $data['getRecord'] = AssignSubjectModel::getRecord();
        $data['header_title'] = 'Assign Subject List';
        return view('admin.assign_subject.list',$data);
    }

    public function add(){
        $data['getClass'] = ClassModel::getClass();
        $data['getSubject'] = SubjectModel::getSubject();
        $data['header_title'] = 'Add New';
        return view('admin.assign_subject.add',$data);
    }

    public function insert(Request $request){

        if(!empty($request->subject_id)){
            foreach($request->subject_id as $subject_id){

                $getAlredyFist = AssignSubjectModel::getAlredyFist($request->class_id,$subject_id);
                if(!empty($getAlredyFist)){
                    $getAlredyFist->status = $request->status;
                    $getAlredyFist->save();
                }

                else{
                    $save = new AssignSubjectModel;
                    $save->class_id = $request->class_id;
                    $save->subject_id = $subject_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }
            return redirect('admin/assign_subject/list')->with('success','Subject successfully Assigned');
        }
        else{
            return redirect('admin/assign_subject/add')->with('error','Please select subject');
        }
    }

    public function edit($id){
        $getRecord = AssignSubjectModel::getSingle($id);
        if(!empty($getRecord)){
            $data['getRecord'] = $getRecord;
            $data['getAssignSubjectID'] = AssignSubjectModel::getAssignSubjectID($getRecord->class_id);
            $data['getClass'] = ClassModel::getClass();
            $data['getSubject'] = SubjectModel::getSubject();
            $data['header_title'] = 'Edit Subject Details';
            return view('admin.assign_subject.edit',$data);
        }
        else
        {
            return redirect('admin/assign_subject/list')->with('error','Record not found');
        }

    }

    public function update(Request $request){

        AssignSubjectModel::deleteSubject($request->class_id);
        if(!empty($request->subject_id)){
            foreach($request->subject_id as $subject_id){

                $getAlredyFist = AssignSubjectModel::getAlredyFist($request->class_id,$subject_id);
                if(!empty($getAlredyFist)){
                    $getAlredyFist->status = $request->status;
                    $getAlredyFist->save();
                }

                else{
                    $save = new AssignSubjectModel;
                    $save->class_id = $request->class_id;
                    $save->subject_id = $subject_id;
                    $save->status = $request->status;
                    $save->save();
                }
            }
        }
        return redirect('admin/assign_subject/list')->with('success','Subject updated successfully');
    }

    public function edit_single($id){
        $getRecord = AssignSubjectModel::getSingle($id);
        if(!empty($getRecord)){
            $data['getRecord'] = $getRecord;
            $data['getClass'] = ClassModel::getClass();
            $data['getSubject'] = SubjectModel::getSubject();
            $data['header_title'] = 'Edit Subject Details';
            return view('admin.assign_subject.edit_single',$data);
        }
        else
        {
            return redirect('admin/assign_subject/list')->with('error','Record not found');
        }

    }

    public function update_single($id,Request $request){

        $getAlredyFist = AssignSubjectModel::getAlredyFist($request->class_id,$request->subject_id);
                if(!empty($getAlredyFist)){
                    $getAlredyFist->status = $request->status;
                    $getAlredyFist->save();
                    return redirect('admin/assign_subject/list')->with('success','Status updated successfully');
                }

                else{
                    $save = AssignSubjectModel::getSingle($id);
                    $save->class_id = $request->class_id;
                    $save->subject_id = $request->subject_id;
                    $save->status = $request->status;
                    $save->save();
                    return redirect('admin/assign_subject/list')->with('success','Subject updated successfully');
                }
    }


    public function delete($id){
        $save = AssignSubjectModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();
        return redirect()->back()->with('success','Record deleted successfully');
    }


}
