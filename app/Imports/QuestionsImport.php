<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\Module;
use App\Models\CompetencyUnit;
use App\Models\Element;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class QuestionsImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    /**
     * Define validation rules for each row.
     */
    public function rules(): array
    {
        return [
            'course_code'   => 'required|exists:courses,code', // এটি আবার চালু করুন
            'question_text' => 'required',
            'question_type' => 'required',
            'marks'         => 'required|numeric',
            'option_1'      => 'required',
            'option_2'      => 'required',
        ];
    }

    /**
     * Process the collection of rows after validation passes.
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $course = Course::where('code', trim($row['course_code']))->first();



            $module = null;

         

            if (!empty($row['module_name'])) {
                $module = Module::firstOrCreate(
                    [
                         'name' => trim($row['module_name']),
                         'course_id' => $course->id,           
                    ],
                    [
                        'module_number' => $row['module_number'] ?? 1,
                        'is_active'    => 1,
                    ]
                );
            }

            // Find or create Competency Unit
            $unit = null;
            if (!empty($row['unit_name']) && $module) {
                $unit = CompetencyUnit::firstOrCreate(
                    [
                     'module_id' => $module->id,
                     'course_id' =>  $course->id,
                     'code' => $row['unit_name']  
                     
                     ],
                     
                    [
                    'is_active' => 1
                    ]
                );
            }

            // Find or create Element
            $element = null;
            if (!empty($row['element_name']) && $unit) {
                $element = Element::firstOrCreate(
                    [
                        'competency_unit_id' => $unit->id, 
                        'name' => trim($row['element_name'])
                        ],
                        ['is_active' => 1]
                );
            }

            // Create or fetch Question
            $question = Question::firstOrCreate(
                [
                    'question_text' => trim($row['question_text']),
                    'course_code'           => $course->id,
                    'module_code'           => $module?->id,
                    'unit_code'             =>$unit?->id,
                    'element_id'            => $element?->id,
                
                ],
                [
                   
                    'question_type'      => $row['question_type'] ?? 'mcq',
                    'marks'              => $row['marks'] ?? 1.00,
                    'difficulty'         => $row['difficulty'] ?? 'medium',
                    'explanation'        => $row['explanation'] ?? null,
                    'is_active'          => 1,
                    'created_by'         => auth()->id()?? 1,
                ]
            );

           // Insert options (1 to 4)
            for ($i = 1; $i <= 4; $i++) {
                if (!empty($row["option_{$i}"])) {
                    Option::updateOrCreate(
                        [
                            'question_id' => $question->id
                            ],

                        [
                            'option_text' => trim($row["option_{$i}"]),
                            'is_correct' => (bool)($row["is_correct_{$i}"] ?? 0)
                        ]
                    );
                }
            }
        }
    }
}
