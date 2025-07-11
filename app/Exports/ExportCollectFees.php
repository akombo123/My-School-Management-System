<?php

namespace App\Exports;

use App\Models\StudentFeesModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportCollectFees implements FromCollection,WithMapping,WithHeadings
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
            "Total Amount",
            "Paid Amount",
            "Remaining Amount",
            "Payment Type"
        ];
    }

    public function map($value): array
    {
        $name = $value->student_name.''.$value->student_l_name ;
        return [
            $value->id,
            $name,
            $value->class_name,
            'Ksh'.number_format($value->total_amount,2),
            'Ksh'.number_format($value->paid_amount,2),
            'Ksh'.number_format($value->remaining_amount,2),
            $value->payment_type

        ];
    }

    public function collection()
    {
        $remove_pagination = 1;
        return StudentFeesModel::getRecord($remove_pagination);
    }
}
