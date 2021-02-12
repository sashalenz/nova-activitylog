<?php

namespace Sashalenz\NovaActivitylog\Filters;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Nova\Filters\DateFilter;
use Spatie\Activitylog\Models\Activity;

class ActivityType extends DateFilter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    protected string $column;

    /**
     * Create a new filter instance.
     *
     * @param string $column
     *
     * @return void
     */
    public function __construct($column)
    {
        switch ($column) {
            case 'created_at':
                $this->name = 'Created';

                break;
            case 'published_at':
                $this->name = 'Published';

                break;
            default:
        }

        $this->column = $column;
    }

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
        return $query->where($this->column, '=', Carbon::parse($value));
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [];
    }

    /**
     * Get the key for the filter.
     *
     * @return string
     */
    public function key()
    {
        return 'timestamp_' . $this->column;
    }
}