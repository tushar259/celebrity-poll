<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;
use App\Models\Image_file;
use App\Models\All_Tables;

class PollController extends Controller
{
    public function uploadImages(Request $request, $tableNameStartsWith){
    	// Get the image data from the request
	    $images = $request->file('images');
	    
	    // Create a folder to store images, if it doesn't exist
	    $folderPath = public_path('images');
	    if (!file_exists($folderPath)) {
	        mkdir($folderPath, 0777, true);
	    }

	    // Loop through the images and store them in the database and local storage
	    foreach ($images as $imageData) {

	        // Generate a unique file name
	        $fileName = time() . '_' . uniqid() . '.' . $imageData->getClientOriginalExtension();

	        // Check if a file with the same name exists, if so, generate a new name
	        while (file_exists($folderPath . '/' . $fileName)) {
	            $fileName = time() . '_' . uniqid() . '.' . $imageData->getClientOriginalExtension();
	        }
	        
	        // Store the image in the local storage
	        // file_put_contents($folderPath . '/' . $fileName, $imageData);
	        $imageData->move($folderPath, $fileName);

	        // Store the image path in the database
	        // $image = new Image_file();
	        // $image->uploaded_images = 'images/' . $fileName;
	        // $image->save();

	        DB::table($tableNameStartsWith.'_images')->insert([
			    'placeholder' => 'images/' . $fileName
			]);
	    }

	    return response()->json(['message' => 'Images saved successfully.']);
    }

    public function checkIfHeadlineUsed(Request $request){
    	$headline = $request->input('headline');
    	if (All_Tables::where('poll_title', $headline)->exists()) {
		    return response()->json(['message' => 'headline exist']);
		}
		else{
			return response()->json(['message' => 'headline does not exist']);
		}
    }

    public function uploadNewlyAddedPoll(Request $request){
    	
    	$headline = $request->input('headline');
    	$tableNameStartsWith = time() . '_' . uniqid();
    	
    	$imageExist = $request->input('imageExist');
    	
    	
    	$valueEntered = $request->input('valueEntered');
    	$endingDate = $request->input('endingDate');

    	if($valueEntered == "1a5b10c"){

    		try{

		        Schema::create($tableNameStartsWith.'_polls', function (Blueprint $table) {
		            $table->id();
		            $table->string('polls');
		            $table->integer('votes');
		            $table->timestamps();
		        });

		        if($imageExist == "yes"){
			        Schema::create($tableNameStartsWith.'_images', function (Blueprint $table) {
			            $table->id();
			            $table->string('placeholder');
			            $table->timestamps();
			        });
		    	}

		    	Schema::create($tableNameStartsWith.'_win', function (Blueprint $table) {
		            $table->id();
		            $table->string('title')->nullable();
		            $table->string('description')->nullable();
		            $table->integer('votes')->nullable();
		            $table->string('winners_name')->nullable();
		            $table->integer('total_votes')->nullable();
		            $table->timestamps();
		        });

		        Schema::create($tableNameStartsWith.'_users_voted', function (Blueprint $table) {
		            $table->id();
		            $table->string('email');
		            $table->timestamps();
		        });

		        $beforeDetails = $request->input('beforeDetails');
		        if($beforeDetails == ""){
		    		$beforeDetails = null;
		    	}

		    	$afterDetails = $request->input('afterDetails');
		        if($afterDetails == ""){
		    		$afterDetails = null;
		    	}

		    	$whichIndustry = $request->input('whichIndustry');

		        $allTables = new All_Tables();
		        $allTables->poll_title = $headline;
		        $allTables->table_name_starts_with = $tableNameStartsWith;
		        $allTables->before_poll_description = $beforeDetails;
		        $allTables->after_poll_description = $afterDetails;
		        $allTables->which_industry = $whichIndustry;
		        $allTables->starting_date = now();
		        $allTables->ending_date = $endingDate;
		        $allTables->winner_added = "no";
		        $allTables->save();

		        // ...........before poll ends..........
		        //title and description in "all_tables" table
		        //images in "abcd_images" table
		        //polls in "abcd_polls" table
		        //ending date in "all_tables" table
		        //.....
		        //voting information in "abcd_users_voted" table
		        // ...........before poll ends..........

		        // ...........after poll ends..........
		        //voting information in "abcd_users_voted" table
		        //winner information in "abcd_win" table
		        //poll ended information in "all_tables" table
		        //delete all tables after a month from "ending_date" of "all_tables" table
		        // ...........after poll ends..........


		        if($imageExist == "yes"){
		    		$this->uploadImages($request, $tableNameStartsWith);
		    	}
		    	$this->uploadPolls($request, $tableNameStartsWith);

	    		

		    	return response()->json(['message' => 'Successfully uploaded a poll',
		    	'success' => true]);
	    	
	    	}
	    	catch(\Exception $e){
	    		return response()->json(['message' => 'Something went wrong',
	    		'success' => false]);
	    	}
	    	
    	}
    	

    }

    public function uploadPolls(Request $request, $tableNameStartsWith){
    	$tags = $request->input('tags');

    	foreach ($tags as $tag) {
    		DB::table($tableNameStartsWith.'_polls')->insert([
			    'polls' => $tag,
			    'votes' => 0
			]);
    	}

    }

    public function getPollInfo(Request $request){
    	$pollId = $request->input('pollId');
    	$tableNameStartsWith = "";
    	$pollsFromTable = "";
    	$imagesFromTable = "";
    	$numberOfImages = "";
    	$i = 0;
    	$currentDate = date('Y-m-d');
    	$imageSrc = "";
    	if($tableNameStartsWith = All_Tables::select('poll_title','table_name_starts_with','before_poll_description','after_poll_description','which_industry','starting_date','ending_date')
    		->where('table_name_starts_with', $pollId)
    		->where('ending_date','>',$currentDate)
    		->first()){
    		// return $tableNameStartsWith["table_name_starts_with"];
    		if(Schema::hasTable($tableNameStartsWith["table_name_starts_with"].'_images')){
    			// return $tableNameStartsWith["table_name_starts_with"];
    			$imagesFromTable = DB::table($tableNameStartsWith["table_name_starts_with"].'_images')
    			->select('placeholder')->get();
    			$numberOfImages = $imagesFromTable->count();
    			// return $imagesFromTable[0]->placeholder;
    			


    			$i = 0;
    			foreach ($imagesFromTable as $key) {
    				++$i;
    				if(strpos($tableNameStartsWith["before_poll_description"], "<pic$i>") >= 0){
    					$tableNameStartsWith["before_poll_description"] = str_replace("<pic$i>", "<img src=\"/../".$key->placeholder."\">", $tableNameStartsWith["before_poll_description"]);
    				}
    				if(strpos($tableNameStartsWith["after_poll_description"], "<pic$i>") >= 0){
    					$tableNameStartsWith["after_poll_description"] = str_replace("<pic$i>", "<img src=\"/../".$key->placeholder."\">", $tableNameStartsWith["after_poll_description"]);
    				}
    				
    			}



    			// return $tableNameStartsWith["before_poll_description"];
    			
    		}

    		$pollsFromTable = DB::table($tableNameStartsWith["table_name_starts_with"].'_polls')
    		->select('id','polls', 'votes')
    		->get();

    		$totalVotesGiven = DB::table($tableNameStartsWith["table_name_starts_with"].'_polls')
    		->sum('votes');

    		if($pollsFromTable->count() > 0){
    			return response()->json([
    				'title_n_other_info' => $tableNameStartsWith,
    				'polls_n_counts' => $pollsFromTable,
    				'images_uploaded' => $imagesFromTable,
    				'total_votes' => $totalVotesGiven,
    				'message' => 'Data received',
	    			'success' => true]);
    		}
    		else{
    			return response()->json(['message' => 'Found error while fetching data',
	    		'success' => false]);
    		}

    	}
    	else{
    		return response()->json(['message' => 'Poll not found',
	    		'success' => false]);
    	}
    }

    public function getAllPoll(){
    	$currentDate = date('Y-m-d');
    	$allPolls = DB::table('all_tables')->select('which_industry','poll_title','table_name_starts_with','before_poll_description','starting_date','ending_date')
    		->where('ending_date','>',$currentDate)
    		->orderBy('ending_date')
    		->skip(0)
    		->take(10)
    		->get();
    	

    	if($allPolls->count() > 0){
    		foreach($allPolls as $value){
    			$pollTags = DB::table($value->table_name_starts_with."_polls")
    				->select('id','polls','votes',DB::raw("'".$value->table_name_starts_with."' as table_name_starts_with"))
    				->get();
    			$value->poll_tags = $pollTags;
    		}
    		return response()->json([
				'all_polls' => $allPolls,
				'message' => 'Data received',
    			'success' => true]);
    	}
    	else if($allPolls->count() == 0){
    		return response()->json([
				'message' => 'No polls uploaded yet',
    			'success' => false]);
    	}
    	else{
    		return response()->json([
				'message' => 'Something went wrong',
    			'success' => false]);
    	}
    }

    public function getAllPollIndustryWise(Request $request){
    	$industryName = $request->input("industryName");
    	$currentDate = date('Y-m-d');
    	$allPolls = DB::table('all_tables')->select('which_industry','poll_title','table_name_starts_with','before_poll_description','starting_date','ending_date')
    		->where('which_industry', $industryName)
    		->where('ending_date','>',$currentDate)
    		->orderBy('ending_date')
    		->get();
    	

    	if($allPolls->count() > 0){
    		foreach($allPolls as $value){
    			$pollTags = DB::table($value->table_name_starts_with."_polls")
    				->select('id','polls','votes',DB::raw("'".$value->table_name_starts_with."' as table_name_starts_with"))
    				->get();
    			$value->poll_tags = $pollTags;
    		}
    		return response()->json([
				'all_polls' => $allPolls,
				'message' => 'Data received',
    			'success' => true]);
    	}
    	else if($allPolls->count() == 0){
    		return response()->json([
				'message' => 'No polls uploaded yet',
    			'success' => false]);
    	}
    	else{
    		return response()->json([
				'message' => 'Something went wrong',
    			'success' => false]);
    	}
    }

    public function getPollForWinningList(){
    	$currentDate = date('Y-m-d');
    	$data = DB::table("all_tables")->select("id","poll_title","table_name_starts_with","which_industry","ending_date")
    	->where("ending_date", "<=", $currentDate)
    	->where("winner_added", "=", "no")
    	->orderBy("ending_date")
    	->get();

    	if($data->count() > 0){
    		foreach($data as $value){
    			$pollsFound = DB::table($value->table_name_starts_with."_polls")
    			->select("id","polls","votes")
    			->get();

    			$value->poll_tags = $pollsFound;
    			$value->percent = 0;
    		}
    	}

    	if($data->count() > 0){
    		return response()->json([
    			'polls_finished' => $data,
				'message' => 'Data found',
    			'success' => true]);
    	}
    	else{
    		return response()->json([
				'message' => 'Data not found',
    			'success' => false]);
    	}

    }

}
