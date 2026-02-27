<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name','asc')->get();
        return response()->json([
            'categories'=>$categories
        ],200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'slug'=>'required|unique:categories,slug',
        ]);
        if($validator->fails())
            {
                return response()->json(['message'=>'invalid field'], 422);
            }
        
        Category::create(['name'=>$request->name, 'slug'=>$request->slug, 'user_id'=>$request->user()->id]);
        return response()->json(['message'=>'created success'],200);
    }

    public function destroy($slug)
    {
        $categories = Category::where('slug',$slug)->first();
        if(!$categories)
            {
                return response()->json(['message'=>'category not found'],404);
            }

        $categories->delete();
        return response()->json(['message'=>'deleted succesfull'], 200);
    }
}
