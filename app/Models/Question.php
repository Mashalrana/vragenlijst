<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'vragenLijstId',
    ];

    protected $table = 'questions';

    public function questionsList()
    {
        return $this->belongsTo(QuestionsList::class, 'vragenLijstId');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }
}
