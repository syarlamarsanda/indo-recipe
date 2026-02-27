<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    // public function index()
    // {
    //     $comments = Comment::with('recipe')->latest()->get();
    //     return response()->json(['comments'->$comments],200);
    // }

    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),
        [
            'recipe_id'=>'required|exists:recipes,id',
            'comment'=>'required'
        ]);
        if($validator->fails())
            {
                return response()->json(['message'=>$validator->messages()],422);
            }
        Comment::create([
            'recipe_id'=>$request->recipe_id,
            'user_id'=>$request->user()->id,
            'comment'=>$request->comment
        ]);
        return response()->json(['message'=>'create succesfull'],200);
    }

    public function destroy($id)
    {
        $comments = Comment::where('id',$id)->first();
        if(!$comments)
            {
                return response()->json(['message'=>'comment not found'],404);
            }
        
        $comments->delete();
        return response()->json(['message'=>'deleted successfull']);
    }
}
