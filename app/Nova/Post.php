<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Datetime;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Http\Requests\NovaRequest;

use Illuminate\Support\Facades\Auth;

class Post extends Resource
{
    public static function indexQuery(NovaRequest $request, $query)
    {
        if(Auth::user()->role_id != 1){
            // return $query->where('user_id', $request->user()->id );
            return $query->where('user_id', Auth::id());
        }
    }
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Post::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','title'
    ];

    public function title(){
        return $this->title .'.'.$this->category->title;
    }
    public function subtitle(){
        return $this->user->name;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('標題','title')->sortable()->placeholder('請輸入標題'),
            Trix::make('內文','body')->withFiles('public'),
            // Select::make('分類','category')->options([
            //     'test' => '測試',
            //     'tech' => '科技'
            // ]),
            Boolean::make('發布','is_published')->default(false),
            Datetime::make('發布日期','publish_at')->nullable(),
            BelongsTo::make('作者','user','App\Nova\User')->default(Auth::id())->exceptOnForms(),
            Hidden::make('user_id')->default(Auth::id()),

            BelongsTo::make('category'),
            BelongsToMany::make('tags')

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new Filters\PostPublished,
            new Filters\PostCategories,
            new Filters\PublishDate('publish_at'),
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            new Actions\PublishPost,
            new Actions\UnpublishPost
        ];
    }
}
