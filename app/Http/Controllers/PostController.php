<?php

namespace App\Http\Controllers;

use App\Jobs\WebsiteSubscriptionEmail;
use App\Mail\WebsiteSubcription;
use App\Mail\WebsiteSubscription;
use App\Models\Posts;
use App\Models\User_Subscription;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    public function create(Request $request){

        $saveData = $request->validate([
            "website_id" => ['required', 'integer'],
            "title" => "required",
            "description" => "required",
        ]);

        $saveData["status"] = 0;
        
        $savePost = Posts::create($saveData);

        if($savePost){
            $res = ["status" => "success", "result"=> $savePost];
            
        }else {
            $res = ["status" => "failed", "result"=> $savePost];
        }
        return response()->json($res);

    }

    public function publish(Request $request){

        $request->validate([
            "post_id" => ['required', 'integer']
        ]);

        $status  = 1;

        $updateStatus = Posts::where('id', $request->post_id)
                                ->where("status", 0)
                                ->update(["status" => $status]);

        if($updateStatus){
            $res = ["status" => "success", "result" => $updateStatus];
            
        }else {
            $res = ["status" => "failed", "result" => $updateStatus];
        }


        // finds the web id of the post id being published
        $post_id = Posts::find($request->post_id);

        $web_id =  $post_id['website_id'];
        $post_description =  $post_id['description'];

        //gets all email of the users subscribed to the website-id using the "subscription" relationship
        $web_id = Website::find($web_id);
        $subscribers = $web_id->subscription;
        // $subscribers_email = $web_id->subscription->name;
        
        foreach($subscribers as $subscriber){

            // Mail::to($subscriber['email'])->queue(new WebsiteSubscription($subscriber, $web_id, $post_description));

            WebsiteSubscriptionEmail::dispatch($subscriber, $web_id, $post_description);
            
        //    $res = ["status" => "failed", "result" => $updateStatus];
 
            return response()->json(["status" => "success"]);
        }
    

    }
}
