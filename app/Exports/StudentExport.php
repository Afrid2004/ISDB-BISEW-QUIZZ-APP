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
                '71',                    // round_id
                'PWAD/CCSL-M/71/01',     // batch_id
                'Faisal Munna',          // name
                'faisal@gmail.com',      // email
                '01700000000',           // phone
                '2000-01-15',             // dob
                'student.jpg',           // photo
                'active',                // status
            ]
        ]);
    }
}

