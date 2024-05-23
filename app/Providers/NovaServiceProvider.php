<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Visanduma\NovaTwoFactor\NovaTwoFactor;
use Visanduma\NovaTwoFactor\Models\TwoFa;
use App\Nova\Tools\UploadExcel\UploadExcel;
use Laravel\Nova\Events\ServingNova;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::footer(function ($request) {
            return Blade::render(
                '<p class="text-center">Made with 💛 by Metis in cooperation with <a class="text-sky-600" href="https://www.codeerbedrijf.nl" target="_blank">LemonLabs  B.V.</a></p>'
            );
        });

        Nova::withoutNotificationCenter();

        Nova::mainMenu(function (\Illuminate\Http\Request $request) {
            return [
                MenuSection::resource(\App\Nova\QuestionsList::class)->icon('document-text'),
                MenuSection::resource(\App\Nova\Question::class)->icon('question-mark-circle'),
                MenuSection::resource(\App\Nova\Answer::class)->icon('answer'),
                MenuSection::make('Custom Tools', [
                    MenuItem::make('Upload Excel', '/upload-excel')->icon('cloud-upload')
                ])->icon('tool')
            ];
        });

        Nova::userMenu(function (\Illuminate\Http\Request $request, Menu $menu) {
            $menu->prepend(
                MenuItem::make(
                    "Mijn Profiel",
                    "/admin/resources/users/{$request->user()->getKey()}"
                )
            );

            return $menu;
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return $user->role >= 0;
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new NovaTwoFactor,
            new UploadExcel
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Nova::serving(function (ServingNova $event) {
            $requestedUrl = $_SERVER['REQUEST_URI'];
            $requestMethod = $_SERVER['REQUEST_METHOD'];

            /** @var \App\Models\User|null $user */
            $user = $event->request->user();

            if (is_null($user)) {
                return;
            }

            $twoFa = TwoFa::where('user_id', $user->id)->first();

            if ($twoFa && $twoFa->google2fa_enable) {
                Nova::initialPath("/resources/users");
            } else {
                Nova::initialPath("/admin/nova-two-factor");

                if (!str_contains($requestedUrl, 'nova-two-factor') && !str_contains($requestedUrl, 'nova-api') && $requestMethod === "GET") {
                    abort(302, '', ['Location' => '/admin/nova-two-factor']);
                }
            }
        });
    }
}
