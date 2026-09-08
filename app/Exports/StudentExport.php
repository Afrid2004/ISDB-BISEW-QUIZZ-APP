<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements WithHeadings, FromCollection
{
    public function headings(): array
    {
        return [
            'round_id',
            'batch_id',
            'name',
            'email',
            'phone',
            'dob',
            'photo',
            'status',
        ];
    }

    public function collection()
    {
        return collect([
            [
                '71',
                'PWAD/CCSL-M/71/01',
                'Faisal Munna',
                'faisal@gmail.com',
                '01700000000',
                '2000-01-15',
                'student.jpg',
                'active',
            ],
        ]);
    }
}
