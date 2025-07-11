<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class HomeworkSubmitModel extends Model
{
    protected $table = 'homework_submit';

    static public function getHomeworkReport()
    {
        $return = self::select('homework_submit.*','class.name as class_name','subject.name as subject_name','users.name as f_name','users.l_name as l_name')
            ->join('homework','homework.id', '=', 'homework_submit.homework_id')
            ->join('class','class.id', '=', 'homework.class_id')
            ->join('users','users.id','=','homework_submit.student_id')
            ->join('subject','subject.id', '=', 'homework.subject_id');
        $return = $return->orderBy('homework_submit.id', 'desc')
                ->paginate(50);
                return $return;
    }

    static public function getRecord($student_id)
    {
        $return = self::select('homework_submit.*','class.name as class_name','subject.name as subject_name')
            ->join('homework','homework.id', '=', 'homework_submit.homework_id')
            ->join('class','class.id', '=', 'homework.class_id')
            ->join('subject','subject.id', '=', 'homework.subject_id')
            ->where('homework_submit.student_id','=', $student_id);
        $return = $return->orderBy('homework_submit.id', 'desc')
                ->paginate(50);
                return $return;
    }

    static public function getRecordAdmin($homework_id)
    {
        $return = self::select('homework_submit.*','class.name as class_name','subject.name as subject_name')
            ->join('homework','homework.id', '=', 'homework_submit.homework_id')
            ->join('class','class.id', '=', 'homework.class_id')
            ->join('subject','subject.id', '=', 'homework.subject_id')
            ->where('homework_submit.homework_id','=', $homework_id);
        $return = $return->orderBy('homework_submit.id', 'desc')
                ->paginate(50);
                return $return;
    }


    public function getHomework()
    {
        return $this->belongsTo(HomeworkModel::class,"homework_id");
    }

    public function getStudent()
    {
        return $this->belongsTo(User::class,"student_id");
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
