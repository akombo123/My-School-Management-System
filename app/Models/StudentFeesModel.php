<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class StudentFeesModel extends Model
{
    protected $table = 'student_fee';

    static public function getRecord($remove_paginaion = 0)
    {
        $return = self::select('student_fee.*','users.name as created_by_name','class.name as class_name','student.name as student_name','student.l_name as student_l_name')
            ->join('users','users.id', '=', 'student_fee.created_by')
            ->join('users as student','student.id', '=', 'student_fee.student_id')
            ->join('class','class.id', '=', 'student_fee.class_id')
            ->where('student_fee.is_paid','=', 1);
            if(!empty(Request::get('class_id'))){
                $return = $return->where('class.id', '=', Request::get('class_id'));
            }

            if(!empty(Request::get('from_date'))){
                $return = $return->where('student_fee.created_at', '>=', Request::get('from_date'));
            }

            if(!empty(Request::get('to_date'))){
                $return = $return->where('student_fee.created_at', '<=', Request::get('to_date'));
            }


            if(!empty(Request::get('student_name'))){
                $return = $return->where('users.name', 'like', '%'.Request::get('student_name').'%');
            }

            $return = $return->orderBy('student_fee.id', 'desc');
            if(!empty($remove_paginaion)){
                $return = $return->get();
            }
            else{
                $return = $return->paginate(50);
            }
        return $return;

    }

    static public function getFees($id)
    {
        return self::select('student_fee.*','users.name as created_by_name','class.name as class_name')
            ->join('users','users.id', '=', 'student_fee.created_by')
            ->join('class','class.id', '=', 'student_fee.class_id')
            ->where('student_fee.student_id','=', $id)
            ->where('student_fee.is_paid','=', 1)
            ->orderBy('student_fee.id', 'desc')
                ->get();
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getPaidAmount($id, $class_id)
    {
        return self::where('student_fee.student_id','=', $id)
            ->where('student_fee.class_id','=', $class_id)
            ->where('student_fee.is_paid','=', 1)
            ->sum('student_fee.paid_amount');
    }

    static public function getTotalFees()
    {
        return self::select('student_fee.id')
            ->where('student_fee.is_paid','=', 1)
            ->sum('student_fee.paid_amount');
    }

    static public function getTotalFeesToday()
    {
        return self::select('student_fee.id')
            ->where('student_fee.is_paid','=', 1)
            ->whereDate('student_fee.created_at','=',date('Y-m-d'))
            ->sum('student_fee.paid_amount');
    }
}
