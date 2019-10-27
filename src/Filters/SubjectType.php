<?php

namespace Sashalenz\NovaActivitylog\Filters;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Nova;
use Spatie\Activitylog\Models\Activity;

class SubjectType extends Filter
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
        return $query->where('subject_type', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return Activity::distinct()
            ->orderBy('subject_type', 'ASC')
            ->get(['subject_type'])
            ->mapWithKeys(function ($row) {
                if ($morphResource = Nova::resourceForModel(Relation::getMorphedModel($row->subject_type) ?? $row->subject_type)) {
                    return [
                        $morphResource::label() => $row->subject_type
                    ];
                }
                return [];
            })
            ->toArray();
    }
}
