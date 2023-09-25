<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{

    public function store(Request $request, $objectIndex, $objectId, $commentId)
    {
        $comment = new Comment();
        $comment->id = Comment::max('id') +1;
        if(Auth::user()){
            $comment->user_id = Auth::user()->id;
            $comment->user_name = Auth::user()->name;

        }
        else{
            $comment->user_id = 0;
            $comment->user_name = "guest";

        }
        $comment->object_id = $objectId;
        $comment->object_index = $objectIndex;
        $comment->text = $request->comment;
        $comment->reply_comment_id = $commentId;

        $comment->save();

        return redirect()->back();

    }
    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        $comment->text = $request->comment;
        $comment->update();
        return redirect()->back();
    }
    public function delete(Request $request, $id)
    {
        $comment = Comment::find($id);
        $childComments = Comment::where('reply_comment_id', $id)->get();
        foreach($childComments as $childComment){
            $childComment->delete();
        }
        $comment->delete();
        return redirect()->back();
    }
}
