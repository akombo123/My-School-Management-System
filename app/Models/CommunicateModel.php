<?php

namespace App\Models;

use App\Models\NoticeBoardMessageModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class CommunicateModel extends Model
{
    protected $table = 'noticeboard';

    static public function getRecord()
    {
        $return = self::select('noticeboard.*','users.name as created_by_name')
            ->join('users','users.id', '=', 'noticeboard.created_by');

            if(!empty(Request::get('title'))){
                $return = $return->where('noticeboard.title', 'like', '%'.trim(Request::get('title')).'%');
            }
            if(!empty(Request::get('publish_date_from'))){
                $return = $return->where('noticeboard.publish_date', '>=', Request::get('publish_date_from'));
            }
            if(!empty(Request::get('publish_date_to'))){
                $return = $return->where('noticeboard.publish_date', '<=',Request::get('publish_date_to'));
            }
            if(!empty(Request::get('message_to'))){
                $return = $return->join('noticeboard_message','noticeboard_message.noticeboard_id', '=', 'noticeboard.id');
                $return = $return->where('noticeboard_message.message_to', '=', Request::get('message_to'));
            }

        $return = $return->orderBy('noticeboard.id', 'desc')
                ->paginate(50);
                return $return;
    }

    static public function getRecordUser($message_to)
    {
        return self::select('noticeboard.*','users.name as created_by_name')
            ->join('users','users.id', '=', 'noticeboard.created_by')
            ->join('noticeboard_message','noticeboard_message.noticeboard_id', '=', 'noticeboard.id')
            ->where('noticeboard.publish_date', '<=', date('Y-m-d'))
            ->where('noticeboard_message.message_to', '=', $message_to)
            ->orderBy('noticeboard.id', 'desc')
            ->paginate(50);
    }

    public function getMessage()
    {
        return $this->hasMany(NoticeBoardMessageModel::class, 'noticeboard_id');

    }

   public function getMessageToSingle($noticeboard_id, $message_to)
    {
        return NoticeBoardMessageModel::where('noticeboard_id','=', $noticeboard_id)->where('message_to','=', $message_to)->first();
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }
}
