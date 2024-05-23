<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;

class AnswerController extends Controller
{
    public function getAnswersByQuestion($questionId)
    {
        $answers = Answer::where('question_id', $questionId)->get();

        if ($answers->isEmpty()) {
            return view('answers', ['answers' => null]);
        }

        return view('answers', ['answers' => $answers]);
    }
}
