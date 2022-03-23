<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\User;
use App\Models\Website;
use App\Notifications\UserPostnotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendUserPostNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $post_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post_id)
    {
        $this->post_id = $post_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $post = Post::query()->find($this->post_id);
        $website = Website::query()->find($post->website_id);
        $users = $website->users;
        $count = count($users);
        if (count($users) > 0)
        {
            foreach ($users as $user)
            {
                $data = [
                    'name' => $user->name,
                    'body' => "We have published a new post titled {$post->title} with description {$post->description}.
                \n Enjoy A beautiful read",
                    'thanks' => 'Thank you',
                    'text' => 'click to read',
                    'url' => url("/posts/{$post->id}"),
                    'post_id' => $post->id
                ];
                $user->notify(new UserPostnotification($data));
//                Notification::send($user, new UserPostnotification($data));
            }
        } else {
            \Log::debug("There are no subscribers for this website.");
        }

/**
 *
$billData = [
'name' => '#007 Bill',
'body' => 'You have received a new bill.',
'thanks' => 'Thank you',
'text' => '$600',
'offer' => url('/'),
'bill_id' => 30061
];

Notification::send($data, new BillingNotification($billData));
 *
 * ->name($this->data['name'])
->line($this->data['body'])
->action($this->data['text'], $this->data['url'])
->line($this->data['thanks']);
 */
    }
}
