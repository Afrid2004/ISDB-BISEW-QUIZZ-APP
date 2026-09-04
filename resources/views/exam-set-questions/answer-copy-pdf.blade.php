<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Answer Copy</title>

    <style>
        @font-face {
            font-family: 'Poppins';
            src: url('{{ public_path('assets/fonts/Poppins-Regular.ttf') }}') format('truetype');
            font-weight: 400;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('{{ public_path('assets/fonts/Poppins-Bold.ttf') }}') format('truetype');
            font-weight: 700;
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0 0 8px 0;
            font-size: 20px;
        }

        .header h2 {
            margin: 0 0 10px 0;
            font-size: 16px;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
        }

        .question {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .question-text {
            margin-bottom: 8px;
            line-height: 1.6;
        }

        .option {
            margin: 5px 0;
            padding-left: 15px;
        }

        .answer {
            margin-top: 8px;
            padding: 7px 10px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="header">

        <h1>Answer Copy</h1>

        <h2>{{ $examSet->exam->title }}</h2>

        <p>
            Exam Set: {{ $examSet->name }}
        </p>

        <p>
            Total Marks: {{ $examSet->total_marks }}
        </p>

    </div>

    @foreach ($generatedQuestions as $index => $examSetQuestion)
        <div class="question">

            <div class="question-text">
                <strong>
                    {{ $index + 1 }}. {{ $examSetQuestion->question->question_text }}
                </strong>
                @if ($examSetQuestion->question->question_type === 'multiple_choice')
                    <div style="margin-top: 4px; margin-bottom: 8px; font-size: 11px; font-weight: bold;">
                        Select {{ $examSetQuestion->question->options->where('is_correct', true)->count() }} answers
                    </div>
                @endif
            </div>


            @foreach ($examSetQuestion->question->options as $option)
                <div class="option">
                    {{ chr(65 + $loop->index) }}.
                    {{ $option->option }}
                </div>
            @endforeach

            <div class="answer">
                Correct Answer:

                @foreach ($examSetQuestion->question->options as $option)
                    @if ($option->is_correct)
                        {{ chr(65 + $loop->index) }}. {{ $option->option }}
                    @endif
                @endforeach

            </div>

        </div>
    @endforeach

    <div class="footer">
        Answer Copy
    </div>

</body>

</html>
