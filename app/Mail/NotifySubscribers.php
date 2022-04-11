<?php

namespace App\Mail;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifySubscribers extends Mailable
{
    use Queueable, SerializesModels;

    public Post $post;
    public User $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        $subject = "✔ New Post was submitted to Website! ";

        return $this
            ->subject($subject)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->markdown('email.subscribers.notify');
    }
}
