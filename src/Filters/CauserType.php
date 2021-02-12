<?php

namespace Sashalenz\NovaActivitylog\Filters;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Nova;
use Spatie\Activitylog\Models\Activity;

class CauserType extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     * @param Request $request
     * @param $query
     * @param $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->where('causer_type', $value);
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
            ->orderBy('causer_type', 'ASC')
            ->get(['causer_type'])
            ->mapWithKeys(function ($row) {
                if ($morphResource = Nova::resourceForModel(Relation::getMorphedModel($row->causer_type) ?? $row->causer_type)) {
                    return [
                        $morphResource::label() => $row->causer_type,
                    ];
                }

                return [];
            })
            ->toArray();
    }
}
