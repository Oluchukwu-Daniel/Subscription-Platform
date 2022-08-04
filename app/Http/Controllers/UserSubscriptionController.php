<?php

namespace App\Http\Controllers;

use App\Models\User_Subscription;
use Illuminate\Http\Request;

class UserSubscriptionController extends Controller
{
    //
    public function create(Request $request){

        $saveData = $request->validate([

            "name" => "required|string",
            "email" => "required|email",
            "website_id" => ['required', 'integer']

        ]);

        $saveUser = User_Subscription::create($saveData);

        if($saveUser){
            $res = ["status" => "success"];
            
        }else {
            $res = ["status" => "failed"];
        }

        return response()->json($res);
    }


}
