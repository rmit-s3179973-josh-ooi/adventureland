<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\User; 
use App\Event;
use App\Category;

class EventController extends Controller
{
	public function index(Request $request)
	{
		$events = Event::with(['category','users'])->get();		
		$success['events'] = $events->toJson();
		return response()->json($events,200);

	}

    public function create(Request $request)
    {
    	$validator = Validator::make($request->all(),[
    		'title'=>'required',
    		'start_date'=>'required|date|after:tomorrow',
    		'end_date' =>'required|date|after_or_equal:start_date',
            'category' =>'required'
    	]);

    	if ($validator->fails()) { 
	        return response()->json(['error'=>$validator->errors()], 400);            
	    }

        $cat = Category::find($request->get('category'));

	    $event = Event::create([
	    	'event_title' => $request->get('title'),
	    	'event_description' => $request->get('description'),
	    	'start_datetime' => $request->get('start_date'),
	    	'end_datetime' => $request->get('end_date'),
	    	'event_location' => $request->get('location'),
            'category_id' =>$cat->id,  	
	    	'is_active'=>true,
	    ]);

	    $user = Auth::user();

	    $event->setEventCreator($user);

	    $success["message"] = "successfully created.";
	    $event = Event::with(['category','users'])->find($event->id);

	    return response()->json(['event'=>$event], 201); 
    }

    public function join($id)
    {
    	
    	$event = Event::find($id);	
    	
    	if(!$event) {
    		return response()->json(['error'=>"Not Found"], 404); 
    	}
    	
    	$user = Auth::user();
    	
    	$message = "Already a member of this event.";
    	if(!$event->hasUser($user))
    	{
    		$event->addUser($user);
    		$message = "Successfully Join Event.";
    	}
    	    	
        $event = Event::with(['category','users'])->find($id);

    	return response()->json(['event'=>$event, 'message'=>$message], 200); 
    }

    public function view($id)
    {
    	$event = Event::with(['category','users'])->find($id);        

    	if(!$event) {
    		return response()->json(['error'=>"Not Found"], 404); 
    	}
    	
    	return response()->json(['event'=>$event], 200); 
    }

    public function exit($id)
    {
    	$event = Event::with(['category','users'])->find($id);	
    	
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
    	
    	$message = "Successfully exit Event.";
    	$event = Event::with(['category','users'])->find($id);

    	return response()->json(['message'=>$message, 'event'=>$event], 200); 
    }
}
