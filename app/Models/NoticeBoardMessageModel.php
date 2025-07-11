<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class NoticeBoardMessageModel extends Model
{
    protected $table = 'noticeboard_message';

    static public function getRecord()
    {
        $return = self::select('noticeboard.*','users.name as created_by_name')
            ->join('users','users.id', '=', 'noticeboard.created_by');

        $return = $return->orderBy('noticeboard.id', 'desc')
                ->paginate(50);
                return $return;
    }

    static public function DeleteRecord($id){
        return self::where('noticeboard_id', $id)->delete();
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }
}
