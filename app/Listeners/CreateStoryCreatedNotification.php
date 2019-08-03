<?php

namespace App\Listeners;

use App\Events\StoryCreated;
use App\Notifications\StoryCreatedNotification;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateStoryCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  StoryCreated  $event
     * @return void
     */
    public function handle(StoryCreated $event)
    {
        //
        $eventData = $event->data;
        $storyData = array_get($eventData, 'newStory');
        // check if user exist
        $user = User::find($storyData->user_id);
//        dd($user);
        if(!$user){
            return;
        }
        $user->notify(new StoryCreatedNotification($storyData));
    }
}
