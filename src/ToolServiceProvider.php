<?php

namespace Sashalenz\NovaActivitylog;

use Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Sashalenz\NovaActivitylog\Policies\ActivityPolicy;
use Sashalenz\NovaActivitylog\Resources\Activity;
use Spatie\Activitylog\ActivitylogServiceProvider;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws \Spatie\Activitylog\Exceptions\InvalidConfiguration
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'nova-activitylog');
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/nova-activitylog'),
        ], 'nova-activitylog-views');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'nova-activitylog');
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/nova-activitylog'),
        ], 'nova-activitylog-lang');

        $this->publishes([
            __DIR__.'/../config/nova-activitylog.php' => config_path('nova-activitylog.php'),
        ], 'nova-activitylog-config');

        $this->app->booted(function () {
            Nova::resources([
                Activity::class,
            ]);
        });

        Gate::policy(ActivitylogServiceProvider::determineActivityModel(), ActivityPolicy::class);

        Nova::serving(function (ServingNova $event) {
            activity()->enableLogging();
        });

        if (config('nova-activitylog.store-request', null)) {
            Activity::newModel()->saving(function ($model) {
                $model->request = collect([
                    'ip_address' => request()->getClientIp(),
                    'country_code' => request()->header('CF-IPCountry', null),
                    'user_agent' => request()->userAgent(),
                ])->toJson();
            });
            $timestamp = date('Y_m_d_His', time());
            $this->publishes([
                __DIR__.'/../migrations/add_request_field_to_activity_log_table.php.stub' => database_path("/migrations/{$timestamp}_add_request_field_to_activity_log_table.php"),
            ], 'nova-activitylog-migrations');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
