<?php

namespace App\Http\Controllers;

use App\Models\User_Subscription;
use Illuminate\Http\Request;

class UserSubscriptionController extends Controller
{
    
    public function create(Request $request){

        $saveData = $request->validate([

            "website_id" => ['required', 'integer'],
            "name" => "required|string",
            "email" => "required|email",
            
        ]);

        $saveUser = User_Subscription::create($saveData);

        // dd($saveUser);
        if($saveUser){
            $res = ["status" => "success", "result" => $saveUser];
            
        }else {
            $res = ["status" => "failed", "result" => $saveUser];
        }

        return response()->json($res);
    }


}
