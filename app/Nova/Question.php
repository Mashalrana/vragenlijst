<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

class Question extends Resource
{
    public static $model = \App\Models\Question::class;

    public static $title = 'content';

    public static $search = [
        'id', 'content'
    ];

    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('Content'),
            BelongsTo::make('QuestionsList', 'questionsList'),
            HasMany::make('Answers')
        ];
    }
}
