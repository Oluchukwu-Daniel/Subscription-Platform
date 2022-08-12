<?php

namespace App\Http\Controllers;

use App\Jobs\WebsiteSubscriptionEmailJob;
use App\Models\Post;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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
        
        $savePost = Post::create($saveData);

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

        $updateStatus = Post::where('id', $request->post_id)
                                // ->where("status", 0)
                                ->update(["status" => $status]);
                        
                                
        if($updateStatus){
            $res =  ["status" => "published", "result" => $request->post_id];
            Artisan::call('mails:send', ['post-id' => $request->post_id]);
            return response()->json($res);

        }else {
            $res =  ["status" => "not-published", "result" => $request->post_id];
            $sendmail = "Could not send mail as post was not published";
            return response()->json($res);
        }

    }

}
