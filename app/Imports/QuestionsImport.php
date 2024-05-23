<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionsList extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'filename',
    ];

    protected $table = 'questions_list';
}
