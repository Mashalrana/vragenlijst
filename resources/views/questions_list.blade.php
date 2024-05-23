<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vragenlijst - {{ $filename }}</title>
    <link rel="stylesheet" href="{{ asset('css/QuestionsListPage.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ url('/vragen') }}" class="back-button"><i class="fas fa-arrow-left"></i> Terug</a>
            <h1>{{ $filename }}</h1>
        </div>
        <div class="questions-container">
            @if ($questions)
                @foreach ($questions as $question)
                    <div class="question-card">
                        <div class="question-content">
                            <p>{{ $question->content }}</p>
                        </div>
                        <div class="answers-container">
                            @foreach ($question->answers as $answer)
                                <div class="answer-card">
                                    @if ($answer->option_1) <p>{{ $answer->option_1 }}</p> @endif
                                    @if ($answer->option_2) <p>{{ $answer->option_2 }}</p> @endif
                                    @if ($answer->option_3) <p>{{ $answer->option_3 }}</p> @endif
                                    @if ($answer->option_4) <p>{{ $answer->option_4 }}</p> @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <p class="no-questions-message">Geen vragen gevonden</p>
            @endif
        </div>
    </div>
</body>
</html>
