<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\CustomUser;

class UserController extends Controller
{
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
}
