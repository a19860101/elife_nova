<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

use Laravel\Nova\Notifications\NovaNotification;
use Laravel\Nova\URL;

class PublishPost extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = '發布文章';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        //
        foreach($models as $model){
            $model->update([
                'is_published' => true
            ]);
        }
        $users = \App\Models\User::all();
        $post_id = $models-> pluck('id')->implode(',');

        foreach($users as $user){
            $user->notify(
                NovaNotification::make()
                    ->message('文章已發布')//右上小鈴鐺內訊息
                    ->action('閱讀', URL::remote("http://localhost:8000/nova/resources/posts/{$post_id}"))
                    // ->icon('download')
                    ->type('info')
                );
        }

    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
