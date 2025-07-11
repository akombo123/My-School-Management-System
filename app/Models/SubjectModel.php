<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class SubjectModel extends Model
{
    protected $table = 'subject';

    static public function getRecord()
    {
        $return = self::select('subject.*','users.name as created_by_name')
            ->join('users','users.id', '=', 'subject.created_by')
            ->where('subject.is_delete','=', 0);

            if(!empty(Request::get('name'))){
                $return = $return->where('subject.name', 'like', '%'.Request::get('name').'%');
            }
        $return = $return->orderBy('subject.id', 'desc')
                ->paginate(50);
                return $return;
    }


    static public function getSubject()
    {
        $return = self::select('subject.*')
            ->where('subject.is_delete','=', 0)
            ->where('subject.status','=', 0)
            ->orderBy('subject.id', 'desc')
                ->get();
                return $return;
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }
}
