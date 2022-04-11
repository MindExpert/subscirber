<?php

namespace App\Jobs;

use App\Mail\NotifySubscribers;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendEmailToSubscribersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Post $post;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
       $usersSubscribed = $this->post->website?->users;

       if ($usersSubscribed->count()){
            foreach($usersSubscribed as $user){

                if (in_array($this->post->id, $user->posts()?->pluck('id')->toArray())){
                    continue;
                }
                try {
                    DB::beginTransaction();

                    Mail::to($user)->send(new NotifySubscribers($this->post, $user));

                    $user->post()->create([
                        'post_id' => $this->post->id,
                    ]);

                    DB::commit();
                } catch (\Exception $exception) {
                    report($exception);
                    DB::rollBack();
                }
            }
       }
    }
}
