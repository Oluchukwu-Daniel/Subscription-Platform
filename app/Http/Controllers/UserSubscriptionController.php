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
            $res = ["status" => "success", "result" => $saveUser];
            
        }else {
            $res = ["status" => "failed", "result" => $saveUser];
        }

        return response()->json($res);
    }


}
