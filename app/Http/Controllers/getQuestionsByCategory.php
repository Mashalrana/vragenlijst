<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionsList;

class QuestionController extends Controller
{
    public function getQuestionsByCategory($category)
    {
        $questionsLists = QuestionsList::where('category', $category)->get();

        if ($questionsLists->isEmpty()) {
            return response()->json([]);
        }

        return response()->json($questionsLists);
    }

    public function getQuestionsByFilename($filename)
    {
        $questionsList = QuestionsList::where('filename', $filename)->first();

        if (!$questionsList) {
            return response()->json(['message' => 'Questions list not found'], 404);
        }

        $questions = $questionsList->questions; // Assuming you have a relationship set up

        return response()->json($questions);
    }
}
