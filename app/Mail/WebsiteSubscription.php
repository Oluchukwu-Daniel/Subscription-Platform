<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WebsiteSubscription extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $subscriber;
    public $web_id;
    public $post_description;

    public function __construct($subscriber, $web_id, $post_description)
    {
        $this->$subscriber = $subscriber;
        $this->$web_id = $web_id;
        $this->$post_description = $post_description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.newpost')
                    ->with([
                        "subscriber" => $this->subscriber,
                        "web_id" => $this->web_id,
                        "post_description" => $this->post_description
                    ]);
        
    }
}
