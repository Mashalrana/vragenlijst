<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

class QuestionsList extends Resource
{
    public static $model = \App\Models\QuestionsList::class;

    public static $title = 'filename';

    public static $search = [
        'id', 'filename'
    ];

    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('Category'),
            Text::make('Filename'),
            HasMany::make('Questions')
        ];
    }
}
