<!DOCTYPE html>
<html>
<head>
    <title>Antwoorden</title>
    <link rel="stylesheet" href="{{ asset('css/AnswerPage.css') }}">
</head>
<body>
    <div class="answer-page">
        <h1>Antwoorden voor vraag:</h1>
        <div class="answers-container">
            @if ($answers)
                @foreach ($answers as $answer)
                    <div class="answer-card">
                        @if ($answer->option_1) <p>{{ $answer->option_1 }}</p> @endif
                        @if ($answer->option_2) <p>{{ $answer->option_2 }}</p> @endif
                        @if ($answer->option_3) <p>{{ $answer->option_3 }}</p> @endif
                        @if ($answer->option_4) <p>{{ $answer->option_4 }}</p> @endif
                    </div>
                @endforeach
            @else
                <p>Geen antwoorden gevonden</p>
            @endif
        </div>
    </div>
</body>
</html>
