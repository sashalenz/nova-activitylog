<?php

namespace Sashalenz\NovaActivitylog\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource as NovaResource;

use Sashalenz\NovaActivitylog\Filters\ActivityType;
use Sashalenz\NovaActivitylog\Filters\CauserType;

use Sashalenz\NovaActivitylog\Filters\SubjectType;
use Spatie\Activitylog\ActivitylogServiceProvider;

class Activity extends NovaResource
{
    public static $model;

    public static $title = 'id';

    public static $search = [
        'description', 'subject_id', 'subject_type', 'causer_id', 'properties', 'request',
    ];

    public static $globallySearchable = false;

    public static $displayInNavigation = false;

    public static function label()
    {
        return __('nova-activitylog::resources.label');
    }

    public static function singularLabel()
    {
        return __('nova-activitylog::resources.singular');
    }

    public static function newModel()
    {
        self::$model = ActivitylogServiceProvider::determineActivityModel();

        return new self::$model();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()
                ->sortable(),
            MorphTo::make(__('nova-activitylog::field.causer'), 'causer'),
            MorphTo::make(__('nova-activitylog::field.subject'), 'subject'),
            Text::make(__('nova-activitylog::field.description'), function () {
                return __('nova-activitylog::display.'.$this->description);
            })->canSee(function () {
                return is_array(__('nova-activitylog::display'))
                    && array_key_exists($this->description, __('nova-activitylog::display'));
            }),
            DateTime::make(__('nova-activitylog::field.created_at'), 'created_at'),
            KeyValue::make(__('nova-activitylog::field.old_values'), 'properties->old')
                ->onlyOnDetail()
                ->showOnDetail(function () {
                    return $this->properties->has('old');
                }),
            KeyValue::make(__('nova-activitylog::field.new_values'), 'properties->attributes')
                ->onlyOnDetail()
                ->showOnDetail(function () {
                    return $this->properties->has('attributes');
                }),
            KeyValue::make(__('nova-activitylog::field.request'), 'request')
                ->displayUsing(function ($value) {
                    return json_decode($value);
                })
                ->onlyOnDetail()
                ->showOnDetail(function () {
                    return config('nova-activitylog.store-request', null) && isset($this->request);
                }),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new ActivityType,
            new CauserType,
            new SubjectType,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
