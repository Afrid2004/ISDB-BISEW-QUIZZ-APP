<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuestionTemplateExport implements WithHeadings, FromCollection
{
    /**
     * Excel column headings.
     */
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

    /**
     * Sample Excel row.
     */
    public function collection()
    {
        return collect([
            [
                'PWAD',
                1,
                'module01',
                'UNIT-01',
                'Basic Operations',
                'What is the output of echo 2 + 2?',
                'single_choice',
                2.00,
                'easy',

                '2',
                '0',

                '3',
                '0',

                '4',
                '1',

                '5',
                '0',
            ],
        ]);
    }
}
