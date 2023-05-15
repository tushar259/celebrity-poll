<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\CustomUser;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
	public function _construct(){
		$this->middleware('auth:api', ['except'=>['createAccount', 'loginAccount', 'checkIfUserLoggedIn']]);
	}

    public function createCustomAccount(Request $request){
    	
    	$request->validate([
	        'email' => 'required|email|unique:custom_users,email',
	        'password' => 'required|min:5|max:20',
	        'selectedQuestion' => 'required',
	        'selectedAnswer' => 'required',
	        'isChecked' => 'required'
	    ]);

    	$email = $request->input("email");
    	$password = $request->input("password");
    	$selectedQuestion = $request->input("selectedQuestion");
    	$selectedAnswer = $request->input("selectedAnswer");
    	$isChecked = $request->input("isChecked");

    	if($isChecked == true){
	    	$customUser = new CustomUser();
	    	$customUser->email = $email;
	    	$customUser->password = bcrypt($password);
	    	$customUser->password_recovery_ques = $selectedQuestion;
	    	$customUser->password_recovery_ans = $selectedAnswer;
	    	if($customUser->save()){

	    		return response()->json([
		    		'message' => 'Account created',
		    		'success' => true]);
	    	}
	    	else{
	    		return response()->json([
		    		'message' => 'Account counld not be created',
		    		'success' => false]);
	    	}
    	}
    	else{
    		return response()->json([
	    		'message' => 'Account counld not be created',
	    		'success' => false]);
    	}
    }

    public function loginCustomUser(Request $request){
	    // $credentials = $request->only('email', 'password');

	    $email = $request->input("email");
	    $password = $request->input("password");

	    $customUserPassword = CustomUser::select("password")
	    	->where("email", $email)
	    	->first();

	    if(Hash::check($password, $customUserPassword->password)){
	    	return "success";
	    }
	    else{
	    	return "failed";
	    }

	    // (Hash::check($password, $hashedPassword))

	    // $credentials = ['email' => $email,'password' => bcrypt($password)];

	    // if($token = auth()->attempt($credentials)){
	    //     return response()->json(['token' => $token]);
	    // }

	    // return response()->json(['error' => 'Unauthorized'], 401);


	}

	public function createAccount(Request $request){
		return $this->createCustomAccount($request);
	}

	public function loginAccount(Request $request){
		$request->validate([
	        'email' => 'required|email',
	        'password' => 'required|min:5|max:20'
	    ]);

	    $credentials = $request->only('email', 'password');
	    $token = "";
	    
	    if($token = JWTAuth::attempt($credentials)){
	        return response()->json([
	        	'token' => $token,
				'userEmail' => $request->input("email"),
				'token_type' => 'bearer',
				'message' => 'User verified',
				'success' => true]);
	    }
	    else{
	        return response()->json([
	        	'error' => 'Invalid credentials',
	        	'message' => 'Invalid user',
	        	'success' => false]);
	    }

	    // if($token = auth()->attempt($credentials)){
	    // 	return $token;
	    // }
	    // else{
	    // 	return "failed";
	    // }

	    // return $this->createToken($token);
	}

	public function createToken($token){
		return response()->json([
			'access_token' => $token,
			'token_type' => 'bearer',
    		'message' => 'User verified',
    		// 'expires_in' => auth()->factory()->getTTL()*60,
    		'success' => true]);
	}

	public function checkIfUserLoggedIn(Request $request){
		$token = $request->header('Authorization');
		$user = JWTAuth::parseToken()->authenticate();
		
		if($user){
			return response()->json([
				'userInfoFromTk' => $user,
	    		'message' => 'User logged in',
	    		'success' => true]);
		}
		else{
			return response()->json([
	    		'message' => 'User is not logged in',
	    		'success' => false]);
		}
	}
}
