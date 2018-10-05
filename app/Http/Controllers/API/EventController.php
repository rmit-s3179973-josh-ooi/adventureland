<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\User; 
use App\Event;

class EventController extends Controller
{
    public function create(Request $request)
    {
    	$validator = Validator::make($request->all(),[
    		'title'=>'required',
    		'start_date'=>'required|date|after:tomorrow',
    		'end_date' =>'required|date|after_or_equal:start_date'
    	]);

    	if ($validator->fails()) { 
	        return response()->json(['error'=>$validator->errors()], 401);            
	    }

	    $event = Event::create([
	    	'event_title' => $request->get('title'),
	    	'event_description' => $request->get('title'),
	    	'event_startdate' => $request->get('title'),
	    	'event_enddate' => $request->get('title'),
	    	'event_location' => $request->get('title'),
	    	'event_title' => $request->get('title'),
	    	'is_active'=>true,
	    ]);

	    $user = Auth::user();

	    $event->setEventCreator($user);

	    $success["message"] = "successfully created.";
	    $succeds["event"] = $event;
	    return response()->json(['success'=>$success], 200); 
    }
}
