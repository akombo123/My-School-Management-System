<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class ClassModel extends Model
{
    protected $table = 'class';

    static public function getRecord()
    {
        $return = self::select('class.*','users.name as created_by_name')
            ->join('users','users.id', '=', 'class.created_by')
            ->where('class.is_delete','=', 0);

            if(!empty(Request::get('name'))){
                $return = $return->where('class.name', 'like', '%'.Request::get('name').'%');
            }
        $return = $return->orderBy('class.id', 'desc')
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
}
