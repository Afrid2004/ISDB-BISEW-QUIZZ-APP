<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuestionTemplateExport implements WithHeadings, FromCollection
{
    public function headings(): array
    {
        return [
            'course_code',

            'module_number',
            'module_name',

            'unit_name',
            'element_name',
            'question_text',
            'question_type',
            'marks',
            'difficulty',


            'option_1',
            'is_correct_1',
            'option_2',
            'is_correct_2',
            'option_3',
            'is_correct_3',
            'option_4',
            'is_correct_4',
        ];
    }

    public function collection()
    {
        return collect([
            [
                'PWAD',
                '01',
                'module01',  // module_name
                'UNIT-01',                      // unit_code
                // unit_serial
                'Basic Operations',             // element_name
                'What is the output of echo 2 + 2?',
                'mcq',
                '1.00',
                'easy',
                '2 plus 2 equals 4.',
                '2',
                '0',
                '3',
                '0',
                '4',
                '1',
                '5',
                '0',
            ]
        ]);
    }
}
