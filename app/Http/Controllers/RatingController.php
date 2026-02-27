<?php

namespace App\Http\Controllers;


use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),
        [
            'rating'=>'required|min:1|max:5',
        ]);
        if($validator->fails())
            {
                return response()->json(['message'=>$validator->messages()],422);
            }
        $ratings = Rating::create([
            'recipe_id'=>$request->recipe_id,
            'user_id'=>$request->user()->id,
            'rating'=>$request->rating,

        ]);
        return response()->json(['message'=>'created succesfull']);

    }

    public function destroy($id)
    {
        $ratings = Rating::where('id',$id);
        if(!$ratings)
            {
                return response()->json(['message'=>'ratings not found'],404);
            }
        $ratings->delete();
        return response()->json(['message'=>'create successfull']);
        
    }


}
