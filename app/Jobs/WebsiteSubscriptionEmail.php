<?php

namespace App\Jobs;

use App\Mail\WebsiteSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class WebsiteSubscriptionEmail implements ShouldQueue
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

    protected $signature = 'emails:send';

    protected $description = 'Sending emails to a user';

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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $email = new WebsiteSubscription($subscriber, $web_id, $post_description);
        // Mail::to($this->details['email'])->send($email);

        Mail::to($this->subscriber['email'])->send(new WebsiteSubscription($this->subscriber, $this->web_id, $this->post_description));
    }
}
