<?php

namespace App\Jobs;

use App\Mail\WebsiteSubscriptionEmail;
use App\Models\Posts;
use App\Models\User_Subscription;
use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class WebsiteSubscriptionEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     * 
     * 
     * 
     */

    // protected $signature = 'emails:send';

    // protected $description = 'Sending emails to a user';

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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $email = new WebsiteSubscription($subscriber, $web_id, $post_description);
        // Mail::to($this->details['email'])->send($email);

        Mail::to($this->subscriber['email'])->send(new WebsiteSubscriptionEmail($this->subscriber, $this->post_title, $this->post_description));
    }
}
