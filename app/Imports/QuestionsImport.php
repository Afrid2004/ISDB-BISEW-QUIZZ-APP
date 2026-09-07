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
     * Define validation rules for each Excel row.
     */
    public function rules(): array
    {
        return [
            'course_code' => [
                'required',
                'exists:courses,code',
            ],

            'module_name' => [
                'required',
                'string',
            ],

            'unit_name' => [
                'required',
                'string',
            ],

            'element_name' => [
                'required',
                'string',
            ],

            'question_text' => [
                'required',
                'string',
            ],

            'question_type' => [
                'required',
                'in:single_choice,multiple_choice',
            ],

            'marks' => [
                'required',
                'numeric',
                'min:0',
            ],

            'difficulty' => [
                'nullable',
                'in:easy,medium,hard',
            ],

            'option_1' => [
                'required',
            ],

            'option_2' => [
                'required',
            ],

            'option_3' => [
                'nullable',
            ],

            'option_4' => [
                'nullable',
            ],
        ];
    }

    /**
     * Process the Excel rows.
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            /*
            |--------------------------------------------------------------------------
            | 1. Find Course
            |--------------------------------------------------------------------------
            */

            $course = Course::where(
                'code',
                trim($row['course_code'])
            )->first();

            if (!$course) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | 2. Find or Create Module
            |--------------------------------------------------------------------------
            */

            $module = Module::firstOrCreate(
                [
                    'course_id' => $course->id,
                    'module_number' => $row['module_number'] ?? 1,
                ],
                [
                    'name' => trim($row['module_name']),
                    'is_active' => true,
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | 3. Find or Create Competency Unit
            |--------------------------------------------------------------------------
            */

            // 3. Find or Create Competency Unit

            $unitName = trim($row['unit_name']);

            // UNIT-01 → 1
            $unitSerial = (int) preg_replace('/[^0-9]/', '', $unitName);

            // STC + PWAD + 1 + 01
            $unitCode = 'STC'
                . $course->code
                . $module->module_number
                . str_pad($unitSerial, 2, '0', STR_PAD_LEFT);

            $unit = CompetencyUnit::firstOrCreate(
                [
                    'code' => $unitCode,
                ],
                [
                    'module_id' => $module->id,
                    'prefix' => 'STC',
                    'serial' => $unitSerial,
                    'is_active' => true,
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | 4. Find or Create Element
            |--------------------------------------------------------------------------
            */

            $element = Element::firstOrCreate(
                [
                    'competency_unit_id' => $unit->id,
                    'name' => trim($row['element_name']),
                ],
                [
                    'is_active' => true,
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | 5. Create or Get Question
            |--------------------------------------------------------------------------
            */

            $question = Question::firstOrCreate(
                [
                    'question_text' => trim($row['question_text']),
                    'course_id' => $course->id,
                    'module_id' => $module->id,
                    'competency_unit_id' => $unit->id,
                    'element_id' => $element->id,
                ],
                [
                    'question_type' => $row['question_type'] ?? 'single_choice',

                    'marks' => $row['marks'] ?? 2.00,

                    'difficulty_level' => $row['difficulty'] ?? 'medium',

                    'is_active' => true,

                    'created_by' => auth()->id(),
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | 6. Insert Options
            |--------------------------------------------------------------------------
            */

            for ($i = 1; $i <= 4; $i++) {

                $optionText = $row["option_{$i}"] ?? null;

                if (empty($optionText)) {
                    continue;
                }

                Option::updateOrCreate(
                    [
                        'question_id' => $question->id,
                        'option' => trim($optionText),
                    ],
                    [
                        'is_correct' => $this->convertToBoolean(
                            $row["is_correct_{$i}"] ?? false
                        ),
                    ]
                );
            }
        }
    }

    /**
     * Convert Excel boolean values to true/false.
     */
    private function convertToBoolean($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        $value = strtolower(trim((string) $value));

        return in_array($value, [
            '1',
            'true',
            'yes',
            'y',
        ]);
    }
}
