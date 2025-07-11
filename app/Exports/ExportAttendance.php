<?php

namespace App\Exports;

use App\Models\AttendanceModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportAttendance implements FromCollection,WithMapping,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            "#",
            "Student Name",
            "Class Name",
            "Attendance Type",
            "Attendance Date"
        ];
    }

    public function map($value): array
    {
        $name = $value->student_name.''.$value->student_l_name ;

        $attendance_type ='';
        if($value->attendance_type == 1){
            $attendance_type = "Present";
        }
        elseif($value->attendance_type == 2){
            $attendance_type = "Late";
        }
        elseif($value->attendance_type == 3){
            $attendance_type = "Absent";
        }
        elseif($value->attendance_type == 4){
            $attendance_type = "Half Day";
        }

        return [
            $value->id,
            $name,
            $value->class_name,
            $attendance_type,
            date('d-m-Y',strtotime($value->attendance_date))
        ];
    }

    public function collection()
    {
        $remove_pagination = 1;
        return AttendanceModel::getRecord();
    }
}
