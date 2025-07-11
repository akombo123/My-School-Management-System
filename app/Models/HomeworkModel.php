<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class HomeworkModel extends Model
{
    protected $table = 'homework';

    static public function getRecord()
    {
        $return = self::select('homework.*','class.name as class_name','subject.name as subject_name','users.name as created_by_name')
            ->join('class','class.id', '=', 'homework.class_id')
            ->join('users','users.id', '=', 'homework.created_by')
            ->join('subject','subject.id', '=', 'homework.subject_id')
            ->where('homework.is_delete','=', 0)
            ->paginate(50);
            return $return;
    }

    static public function getRecordTeacher($class_ids)
    {
        $return = self::select('homework.*','class.name as class_name','subject.name as subject_name','users.name as created_by_name')
            ->join('class','class.id', '=', 'homework.class_id')
            ->join('users','users.id', '=', 'homework.created_by')
            ->join('subject','subject.id', '=', 'homework.subject_id')
            ->where('homework.is_delete','=', 0)
            ->whereIn('homework.class_id',$class_ids)
            ->paginate(50);
            return $return;
    }

    static public function getRecordStudent($class_ids,$student_id)
    {
        $return = self::select('homework.*','class.name as class_name','subject.name as subject_name','users.name as created_by_name')
            ->join('class','class.id', '=', 'homework.class_id')
            ->join('users','users.id', '=', 'homework.created_by')
            ->join('subject','subject.id', '=', 'homework.subject_id')
            ->where('homework.is_delete','=', 0)
            ->where('homework.class_id','=',$class_ids)
            ->whereNotIn('homework.id',function($query) use ($student_id) {

                $query->select('homework_submit.homework_id')
                ->where('homework_submit.student_id','=', $student_id)
                    ->from('homework_submit');

             })
            ->paginate(50);
            return $return;
    }


    static public function getClass()
    {
        $return = self::select('class.*')
            ->where('class.is_delete','=', 0)
            ->where('class.status','=', 0)
            ->orderBy('class.name', 'asc')
                ->get();
                return $return;
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    public function getDocument(){
        if(!empty($this->document_file) && file_exists(public_path('uploads/homework/'.$this->document_file))){
            return asset('uploads/homework/'.$this->document_file);
        }
        else{
            return asset('uploads/homework/default.png');
        }
    }
}
