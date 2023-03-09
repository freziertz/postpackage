<?php

namespace Freziertz\PostPackage\Listeners;

use Freziertz\PostPackage\Events\PostWasCreated;

class UpdatePostTitle
{
    public function handle(PostWasCreated $event)
    {
        $event->post->update([
            'title' => 'New: ' . $event->post->title
        ]);
    }
}
