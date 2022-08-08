<?php

namespace App\Console\Commands;

use App\Jobs\WebsiteSubscriptionEmailJob;
use App\Models\Posts;
use App\Models\Website;
use Illuminate\Console\Command;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mails:send
                            {post-id : The ID of the post}';



    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending emails to website subscribers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $post_id = $this->ask('What is your post-id ?');
        $post_id = $this->argument('post-id'); //you  can either pass your arg/parameter when defining your signature, or you can pass it as ask method.

        $post_id = Posts::find($post_id);

        $post_description =  $post_id['description'];
        $post_title =  $post_id['title'];

        // finds the website_id of the post id being published
        $web_id =  $post_id['website_id'];

        //gets all email of the users subscribed to the website-id using the "subscription" relationship
        $web_id = Website::find($web_id);
        $subscribers = $web_id->subscription;

        foreach($subscribers as $subscriber){

           $dispatchmails =  WebsiteSubscriptionEmailJob::dispatch($subscriber, $post_title, $post_description);
        }

        if($dispatchmails){    
           $info = $this->info('The mails has been sent');
           return $info;

        }else {

            $info = $this->error('The mails were not sent');
            return $info;
        }


    }



}
