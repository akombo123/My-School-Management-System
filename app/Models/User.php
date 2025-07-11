<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\MarksRegisterModel;
use App\Models\StudentFeesModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Request;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    static public function getCollectFeesStudent()
    {
        $return = User::select('users.*', 'class.name as class_name','class.amount as amount')
            ->join('class', 'class.id', '=', 'users.class_id')
            ->where('users.user_type', 3)
            ->where('users.is_delete', 0);

            if(!empty(Request::get('class_id'))){
                $return = $return->where('users.class_id', '=',Request::get('class_id'));
            }

            if(!empty(Request::get('f_name'))){
                $return = $return->where('users.name', 'like', '%'.Request::get('f_name').'%');
            }
            if(!empty(Request::get('l_name'))){
                $return = $return->where('users.l_name', 'like', '%'.Request::get('l_name').'%');
            }


            if(!empty(Request::get('adm_no'))){
                $return = $return->where('users.adm_no', 'like', '%'.Request::get('adm_no').'%');
            }
        $return = $return->orderBy('users.id', 'desc')
                ->paginate(100);
                return $return;
    }


    static public function getAdmin()
    {
        $return = User::select('users.*')
            ->where('user_type', 1)
            ->where('is_delete', 0);

            if(!empty(Request::get('email'))){
                $return = $return->where('email', 'like', '%'.Request::get('email').'%');
            }

            if(!empty(Request::get('name'))){
                $return = $return->where('name', 'like', '%'.Request::get('name').'%');
            }
        $return = $return->orderBy('id', 'desc')
                ->paginate(50);
                return $return;
    }

    static public function getTeacher()
    {
        $return = User::select('users.*', 'class.name as class_name')
            ->join('class', 'class.id', '=', 'users.class_id', 'left')
            ->where('users.user_type', 2)
            ->where('users.is_delete', 0);

            if(!empty(Request::get('email'))){
                $return = $return->where('users.email', 'like', '%'.Request::get('email').'%');
            }

            if(!empty(Request::get('mobile'))){
                $return = $return->where('users.mobile', '=', Request::get('mobile'));
            }

            if(!empty(Request::get('name'))){
                $return = $return->where('users.name', 'like', '%'.Request::get('name').'%');
            }
        $return = $return->orderBy('users.id', 'desc')
                ->paginate(50);
                return $return;
    }

    static public function getTeacherStudent($teacher_id){
        $return = User::select('users.*', 'class.name as class_name')
            ->join('class', 'class.id', '=', 'users.class_id','left')
            ->join('assign_teacher','assign_teacher.class_id', '=', 'users.class_id','left')
            ->where('assign_teacher.teacher_id', $teacher_id)
            ->where('assign_teacher.status','=', 0)
            ->where('assign_teacher.is_delete','=', 0)
            ->where('users.user_type', 3)
            ->where('users.is_delete', 0);
        $return = $return->orderBy('users.id', 'desc')
                ->groupBy('users.id')
                ->paginate(50);
                return $return;
    }

    static public function getTeacherClass()
    {
        $return = User::select('users.*', 'class.name as class_name')
            ->join('class', 'class.id', '=', 'users.class_id', 'left')
            ->where('users.user_type', 2)
            ->where('users.is_delete', 0);

            if(!empty(Request::get('email'))){
                $return = $return->where('users.email', 'like', '%'.Request::get('email').'%');
            }

            if(!empty(Request::get('mobile'))){
                $return = $return->where('users.mobile', '=', Request::get('mobile'));
            }

            if(!empty(Request::get('name'))){
                $return = $return->where('users.name', 'like', '%'.Request::get('name').'%');
            }
        $return = $return->orderBy('users.id', 'desc')
                ->paginate(50);
                return $return;
    }

    static public function getStudent()
    {
        $return = User::select('users.*', 'class.name as class_name', 'parent.name as parent_name','parent.l_name as parent_l_name')
            ->join('class', 'class.id', '=', 'users.class_id','left')
            ->join('users as parent', 'parent.id', '=', 'users.parent_id', 'left')
            ->where('users.user_type', 3)
            ->where('users.is_delete', 0);

            if(!empty(Request::get('email'))){
                $return = $return->where('users.email', 'like', '%'.Request::get('email').'%');
            }

            if(!empty(Request::get('name'))){
                $return = $return->where('users.name', 'like', '%'.Request::get('name').'%');
            }


            if(!empty(Request::get('adm_no'))){
                $return = $return->where('users.adm_no', 'like', '%'.Request::get('adm_no').'%');
            }
        $return = $return->orderBy('users.id', 'desc')
                ->paginate(50);
                return $return;
    }

    static public function getStudentClass($class_id)
    {
        return  User::select('users.id','users.name','users.l_name')
            ->join('class', 'class.id', '=', 'users.class_id','left')
            ->join('users as parent', 'parent.id', '=', 'users.parent_id', 'left')
            ->where('users.user_type', 3)
            ->where('users.is_delete', 0)
            ->where('users.class_id','=',$class_id)
            ->orderBy('users.id', 'desc')
            ->get();
    }

    static public function getParent()
    {
        $return = User::select('users.*')
            ->where('users.user_type', 4)
            ->where('users.is_delete', 0);

            if(!empty(Request::get('email'))){
                $return = $return->where('users.email', 'like', '%'.Request::get('email').'%');
            }

            if(!empty(Request::get('name'))){
                $return = $return->where('users.name', 'like', '%'.Request::get('name').'%');
            }


            if(!empty(Request::get('mobile'))){
                $return = $return->where('users.mobile', '=', Request::get('mobile'));
            }
        $return = $return->orderBy('users.id', 'desc')
                ->paginate(50);
                return $return;
    }

    static public function getSearchStudent(){
         if(!empty(Request::get('adm_no')) || !empty(Request::get('name'))|| !empty(Request::get('email'))||!empty(Request::get('mobile'))){
            $return = User::select('users.*', 'class.name as class_name', 'parent.name as parent_name','parent.l_name as parent_l_name')
                ->join('class', 'class.id', '=', 'users.class_id', 'left')
                ->join('users as parent', 'parent.id', '=', 'users.parent_id', 'left')
                ->where('users.user_type', 3)
                ->where('users.is_delete', 0);

                if(!empty(Request::get('adm_no'))){
                    $return = $return->where('users.adm_no', '=', Request::get('adm_no'));
                }

                if(!empty(Request::get('name'))){
                    $return = $return->where('users.name', 'like', '%'.Request::get('name').'%');
                }

                if(!empty(Request::get('email'))){
                    $return = $return->where('users.email', 'like', '%'.Request::get('email').'%');
                }

                if(!empty(Request::get('mobile'))){
                    $return = $return->where('users.mobile', '=', Request::get('mobile'));
                }
            return $return->orderBy('users.id', 'desc')
               ->limit(100)
                    ->get();
         }
         else{
            return [];
         }

    }

   static public function getMyStudent($parent_id){
        $return = User::select('users.*', 'class.name as class_name')
            ->join('class', 'class.id', '=', 'users.class_id','left')
            ->where('users.user_type', 3)
            ->where('users.is_delete', 0)
            ->where('users.parent_id', $parent_id);

        return $return->orderBy('users.id', 'desc')
                ->paginate(50);
    }

    static public function getSingle($id)
    {
        return User::find($id);
    }

    static public function getSingleClass($id)
    {
        return User::select('users.*', 'class.amount as amount','class.name as class_name')
            ->join('class', 'class.id', '=', 'users.class_id','left')
            ->where('users.id', $id)
            ->first();
    }

    public function getProfile(){
        if(!empty($this->profile_pic && file_exists('uploads/profile/'.$this->profile_pic))){
            return url('uploads/profile/'.$this->profile_pic);
        }
        else{
            return url("");
        }
    }

    static public function getMark($class_id, $subject_id, $exam_id, $student_id)
    {
        return MarksRegisterModel:: CheckAlready($class_id, $subject_id, $exam_id, $student_id);

    }


    static public function getAttendance($class_id, $attendance_date, $student_id)
    {
        return AttendanceModel::CheckAlready($class_id, $attendance_date, $student_id);

    }

    static public function getUser($search)
    {
        return self::select('users.*')
            ->where(function($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('l_name', 'like', '%'.$search.'%');
            })
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();
    }

    static public function getMail($user_type)
    {
        return User::select('users.*')
            ->where('user_type', '=',$user_type)
            ->where('is_delete', 0)
            ->get();
    }

    static public function getPaidAmount($id, $class_id)
    {
        return StudentFeesModel::getPaidAmount($id, $class_id);
    }

    static public function getTotalUsers()
    {
        return User::select('users.id')
            ->count();
    }

}

