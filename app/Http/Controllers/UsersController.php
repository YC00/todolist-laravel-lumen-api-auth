<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Users;
class UsersController extends Controller
{
   public function __construct() 
    {
      //  $this->middleware('auth:api');
    }

    /**
     * Signup
     *
     * @return \Illuminate\Http\Response
     */
    public function signup(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        
        $checkuser = Users::where('email', $request->input('email'))->first();
        if(!empty($checkuser)){
            return response()->json(['status' => 'user exist']);
        }

        $user = Users::create([
            'name' =>  $request->input('name'),
            'email' =>  $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);
        
        if(!empty($user)){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail'],401);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $this->validate($request, [
        'email' => 'required',
        'password' => 'required'
         ]);
       $user = Users::where('email', $request->input('email'))->first();
      if(Hash::check($request->input('password'), $user->password)){
           $apikey = base64_encode(str_random(40));
           $after1hour = date('Y-m-d H:i:s', strtotime('+1 hour'));
           Users::where('email', $request->input('email'))->update(['api_key' => "$apikey",'expired_at' => $after1hour ]);
           return response()->json(['status' => 'success','token' => $apikey, 'ttl' => '3600']);
       }else{
           return response()->json(['status' => 'fail'],401);
       }
    }

    /**
     * Refresh User Token
     *
     * @return \Illuminate\Http\Response
     */
    public function refreshtoken(Request $request)
    {
        $this->validate($request, [
        'token' => 'required'
        ]);

        $user = Users::where('api_key', $request->input('token'))->first();
        if(!empty($user)){
            $apikey = base64_encode(str_random(40));
            $after1hour = date('Y-m-d H:i:s', strtotime('+1 hour'));
            Users::where('api_key', $request->input('token'))->update(['api_key' => "$apikey",'expired_at' => $after1hour]);;
            return response()->json(['status' => 'success','token' => $apikey, 'ttl' => '3600']);
        }else{
            return response()->json(['status' => 'fail'],404);
        }
    }

    /**
     * Get User Token Status
     *
     * @return \Illuminate\Http\Response
     */
    public function tokenstatus(Request $request)
    {
        $this->validate($request, [
        'token' => 'required'
        ]);

        $user = Users::where('api_key', $request->input('token'))->first();
        if(!empty($user)){
            return response()->json(['status' => 'success','expires_in' => $user['expired_at']]);
        }else{
            return response()->json(['status' => 'fail'],401);
        }
    }
}    
?>