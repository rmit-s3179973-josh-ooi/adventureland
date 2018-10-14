<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;

	public function login(Request $request){ 
		
		if(Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])){ 
            $user = Auth::user(); 
            $token =  $user->getToken();
            return response()->json(['access_token' => $token,'token_type'=>'Bearer', 'user' => $user], $this->successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    public function register(Request $request) 
	{ 

	    $validator = Validator::make($request->all(), [ 
	        'name' => 'required', 
	        'email' => 'required|email', 
	        'password' => 'required', 
	        'c_password' => 'required|same:password', 
	    ]);
		
		if ($validator->fails()) { 
	        return response()->json(['error'=>$validator->errors()], 401);            
	    }

		$input = $request->all(); 
	    $input['password'] = bcrypt($input['password']); 
	    $input = array_except($input,['c_password']);
	    
    	$user = User::where(['email'=>$input['email']])->first(); 	

	    if($user){	    	
	    	return response()->json(['error'=>"User already exist. try logging in or use another email."], 400);    
	    }else{
	    	$user = User::create($input);
	    }
	    
	    
	    $token =  $user->getToken(); 	    
		
		return response()->json(['access_token' => $token,'token_type'=>'Bearer', 'user' => $user], $this->successStatus); 
	}

	public function fetch($id)
	{
		$user = User::find($id);

		return response()->json($user,200);
	}

	public function details(Request $request)
	{
		 $user = Auth::user(); 
        return response()->json(['success' => $user], $this->successStatus);
	}

}

