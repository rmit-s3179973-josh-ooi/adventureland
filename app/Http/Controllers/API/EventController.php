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
	        return response()->json(['error'=>$validator->errors()], 400);            
	    }

	    $event = Event::create([
	    	'event_title' => $request->get('title'),
	    	'event_description' => $request->get('description'),
	    	'start_datetime' => $request->get('start_date'),
	    	'end_datetime' => $request->get('end_date'),
	    	'event_location' => $request->get('location'),	    	
	    	'is_active'=>true,
	    ]);

	    $user = Auth::user();

	    $event->setEventCreator($user);

	    $success["message"] = "successfully created.";
	    $success["event"] = $event;

	    return response()->json(['success'=>$success], 201); 
    }

    public function join($id)
    {
    	
    	$event = Event::find($id);	
    	
    	if(!$event) {
    		return response()->json(['error'=>"Not Found"], 404); 
    	}
    	
    	$user = Auth::user();
    	
    	$success["message"] = "Already a member of this event.";
    	if(!$event->hasUser($user))
    	{
    		$event->addUser($user);
    		$success["message"] = "Successfully Join Event.";
    	}
    	
    	$success["event"] = $event;

    	return response()->json(['success'=>$success], 200); 
    }

    public function view($id)
    {
    	$event = Event::find($id);	
    	
    	if(!$event) {
    		return response()->json(['error'=>"Not Found"], 404); 
    	}

    	$success["event"] = $event;
    	return response()->json(['success'=>$success], 200); 
    }

    public function exit($id)
    {
    	$event = Event::find($id);	
    	
    	if(!$event) {
    		return response()->json(['error'=>"Not Found"], 404); 
    	}

    	$user = Auth::user();

    	if($event->hasUser($user))
    	{
    		$event->removeUser($user);
    	}else{
    		return response()->json(['error'=>"Forbidden"], 403); 
    	}
    	
    	$success["message"] = "Successfully exit Event.";
    	$success["event"] = $event;

    	return response()->json(['success'=>$success], 200); 
    }
}
