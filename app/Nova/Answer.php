<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

class Answer extends Resource
{
    public static $model = \App\Models\Answer::class;

    public static $title = 'id';

    public static $search = [
        'id'
    ];

    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            BelongsTo::make('Question'),
            Text::make('Option 1'),
            Text::make('Option 2'),
            Text::make('Option 3'),
            Text::make('Option 4')
        ];
    }
}
