<?php

namespace App\Nova\Tools\UploadExcel;

use Laravel\Nova\Tool;
use Laravel\Nova\Nova;
use Laravel\Nova\Menu\MenuSection;
use Illuminate\Http\Request; // Ensure you import the correct Request class

class UploadExcel extends Tool
{
    public function boot()
    {
        Nova::script('upload-excel', __DIR__.'/../resources/js/tool.js');
        Nova::style('upload-excel', __DIR__.'/../resources/css/tool.css');
    }

    public function menu(Request $request)
    {
        return MenuSection::make('Upload Excel')
            ->path('/upload-excel')
            ->icon('cloud-upload');
    }

    public function renderNavigation()
    {
        return view('upload-excel::tool');
    }
}
