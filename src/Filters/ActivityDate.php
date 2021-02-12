<?php

namespace Sashalenz\NovaActivitylog\Filters;

use Ampeco\Filters\DateRangeFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ActivityDate extends DateRangeFilter
{
    public $name = 'Activity date range';

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
        $from = Carbon::parse($value[0])->startOfDay();
        $to = Carbon::parse($value[1])->endOfDay();

        return $query->whereBetween('created_at', [$from, $to]);
    }
}
