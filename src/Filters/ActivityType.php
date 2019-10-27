<?php

namespace Sashalenz\NovaActivitylog\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use Spatie\Activitylog\Models\Activity;

class ActivityType extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->where('description', $value);
    }

    /**
     * Get the filter's available options.
     *
     * TODO Refactor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return Activity::distinct()
            ->orderBy('description', 'ASC')
            ->get(['description'])
            ->filter(function ($row) {
                return is_array(__('nova-activitylog::display'))
                    && array_key_exists($row->description, __('nova-activitylog::display'));
            })
            ->mapWithKeys(function ($row) {
                return [
                    __('nova-activitylog::display.'.$row->description) => $row->description
                ];
            })
            ->toArray();
    }
}
