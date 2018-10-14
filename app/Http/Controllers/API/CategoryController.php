<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
    	$categories = Category::all();

    	return response()->json($categories,200);
    }

    public function fetch($id)
    {
    	$category = Category::find($id);

    	$events = $category->events()->get();

    	return response()->json(['category'=>$category->name, 'events'=>$events], 200);
    }
}
