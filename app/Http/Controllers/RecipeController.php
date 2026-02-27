<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with('category')->latest()->get();
        return response()->json(['recipes'=>$recipes],200);
    }




    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'title'=>'required',
            'category_id'=>'required|exists:categories,id',
            'ingridients'=>'required',
            'method'=>'required',
            'tips'=>'required',
            'energy'=>'required|numeric',
            'carbohydrate'=>'required|numeric',
            'protein'=>'required|numeric'


        ]);
        if($validator->fails())
            {
                return response()->json([
                    'message'=>$validator->messages()
                ],422);
            }
        
        Recipe::create([
            'title'=>$request->title,
            'slug'=>str($request->title)->slug,
            'ingridients'=>$request->ingridients,
            'method'=>$request->method,
            'tips'=>$request->tips,
            'energy'=>$request->energy,
            'carbohydrate'=>$request->carbohydrate,
            'protein'=>$request->protein,
            'user_id'=>$request->user()->id,
            'category_id'=>$request->category_id,
        ]);
        return response()->json(['message'=>'created success'],200);
        
        
    }

    public function show($slug)
    {
        $recipes = Recipe::with('category','ratings.user','comments.user')->where('slug',$slug)->first();
        if(!$recipes)
            {
                return response()->json(['message'=>'Recipe not found'],404);
            }
        return response()->json(['recipes'=>$recipes],200);
    }


    public function destroy($slug)
    {
        $recipes = Recipe::where('slug',$slug)->first();
        if(!$recipes)
            {
                return response()->json([
                    'message'=>'recipe not found'
                ],404);
            }
        
        $recipes->delete();
        return response()->json(['message'=>'recipe deleted successful'],200);
        


    }
}
