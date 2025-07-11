<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportStudentList implements FromCollection,WithMapping,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            "#",
            "Student Name",
            "Parent Name",
            "Admission Number",
            "Date of Birth",
            "Gender",
            "Phone",
            "Email",
            "Class Name"
        ];
    }

    public function map($value): array
    {
        $name = $value->name.' '.$value->l_name ;
        $p_name = $value->parent_name.' '.$value->parent_l_name ;
        return [
            $value->id,
            $name,
            $p_name,
            $value->adm_no,
            date('d-m-Y',strtotime($value->dob)),
            $value->gender == 'Male' ? 'Male' : 'Female',
            $value->mobile,
            $value->email,
            $value->class_name
        ];
    }

    public function collection()
    {
        $remove_pagination = 1;
        return User::getStudent();
    }
}
