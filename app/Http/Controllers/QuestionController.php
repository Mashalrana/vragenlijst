<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionsList;
use App\Models\Question;
use App\Models\Answer;

class QuestionController extends Controller
{
    // Method to get questions by category
    public function getQuestionsByCategory($category)
    {
        $questionsLists = QuestionsList::where('category', $category)->get();

        if ($questionsLists->isEmpty()) {
            return response()->json([]);
        }

        return response()->json($questionsLists);
    }

    // Method to get questions by filename
    public function getQuestionsByFilename($filename)
    {
        $questionsList = QuestionsList::where('filename', $filename)->first();

        if (!$questionsList) {
            return response()->json(['message' => 'Questions list not found'], 404);
        }

        $questions = Question::where('vragenLijstId', $questionsList->id)
            ->with('answers') // Eager load the answers
            ->get();

        return response()->json($questions);
    }

    // Method to show questions list by filename
    public function showQuestionsList($filename)
    {
        $questionsList = QuestionsList::where('filename', $filename)->first();

        if (!$questionsList) {
            return view('questions_list', ['questions' => null, 'filename' => $filename]);
        }

        $questions = Question::where('vragenLijstId', $questionsList->id)
            ->with('answers')
            ->get();

        return view('questions_list', ['questions' => $questions, 'filename' => $filename]);
    }

    // Method to get question by id (not shown in original example, but added for completeness)
    public function getQuestionById($id)
    {
        $question = Question::with('answers')->find($id);

        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }

        return response()->json($question);
    }
}
