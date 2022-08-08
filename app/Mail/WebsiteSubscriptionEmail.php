<?php

namespace App\Mail;

use App\Models\Posts;
use App\Models\User_Subscription;
use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WebsiteSubscriptionEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $subscriber;
    public $post_title;
    public $post_description;

    public function __construct($subscriber, $post_title, $post_description)
    {
        $this->subscriber = $subscriber;
        $this->post_title = $post_title;
        $this->post_description = $post_description;
    }

    /**
     * Build the message.
     *
     * @return $this
     * 
     */
    
    public function build()
    {
        $name = "subscription";
        $address = "subscription@gmail.com"; //or to hide it away you can use env('MAIL_FROM_ADDRESS');
        $subject = "Post notification";
        return $this->view('mail.newpost')
                    ->from($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->with([
                        "subscriber" => $this->subscriber,
                        "web_id" => $this->post_title,
                        "post_description" => $this->post_description
                    ]);
        
    }
}
