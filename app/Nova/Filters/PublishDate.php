<?php

namespace App\Nova\Filters;

use Illuminate\Support\Carbon;
use Laravel\Nova\Filters\DateFilter;
use Laravel\Nova\Http\Requests\NovaRequest;

class PublishDate extends DateFilter
{
    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    // public function apply(NovaRequest $request, $query, $value)
    // {
    //     $value = Carbon::parse($value)??null;

    //     return $query->where('publish_at','<=',$value);
    // }
    protected $column;

    /**
     * Create a new filter instance.
     *
     * @param  string  $column
     * @return void
     */
    public function __construct($column)
    {
        $this->column = $column;
    }

    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        return $query->where($this->column, '<=', Carbon::parse($value));
    }

    /**
     * Get the key for the filter.
     *
     * @return string
     */
    public function key()
    {
        return 'timestamp_'.$this->column;
    }
}
