<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Media;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }



    public function index()
    {
        $comment = Comment::all();

        return response()->json([JSON_PRETTY_PRINT,
        'message'=>'successful!',
        'comment' => $comment,
         ]);
    }


    public function store(Media $media)
    {
    	request()->validate([
            'content'=>'required|min:3',
        ]);

        $comment = new Comment();
        $comment->content = request('content');
        $comment->user_id = auth()->user()->id;
        $media->comments()->save($comment);

        return response()->json([JSON_PRETTY_PRINT,
        'message'=>'successful!',
        'status'=>true,
        'comment' => $comment,
         ]);
    }

    public function show($id)
    {
    	$comment = Comment::find($id);
        return response()->json([JSON_PRETTY_PRINT,
        'message'=>'successful!',
        'status'=>true,
        'comment' => $comment,
         ]);
    }


    public function update($id)
    {
        $comment = Comment::find($id);
    	request()->validate([
            'content'=>'required|min:3',
        ]);

        $comment->content = request('content');
        $comment->save();

        return response()->json([JSON_PRETTY_PRINT,
        'message'=>'successful!',
        'status'=>true,
        'comment' => $comment,
         ]);
    }


    public function destroy($id)
    {
        return Comment::destroy($id);
    }

}
