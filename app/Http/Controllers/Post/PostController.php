<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index()
    {
        $posts = Post::all();

        return response()->json([JSON_PRETTY_PRINT,
        'message'=>'successful!',
        'status'=>true,
        'posts' => $posts,
         ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([JSON_PRETTY_PRINT,
        'message'=>'successful!',
        'status'=>true,
         ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $posts = Post::all();
    	$request->validate([
            'title'=>'required',
            'body'=>'required',

        ]);

        $posts = new Post();
        $posts->title = $request->title;
        $posts->body = $request->body;

        return response()->json([JSON_PRETTY_PRINT,
        'message'=>'successful!',
        'status'=>true,
        'posts' => $posts,
         ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	$posts = Post::find($id);
        return response()->json([JSON_PRETTY_PRINT, compact('posts'),
        'message'=>'successful!',
        'status'=>true,
        'posts' => $posts,
         ]);
    }

    public function update(Request $request, $id)
    {
        $posts = Post::find($id);
    	$request->validate([
            'title'=>'required',
            'body'=>'required',
        ]);

        $posts->title = $request->title;
        $posts->body = $request->body;
        $posts->save();

        return response()->json([JSON_PRETTY_PRINT,
        'message'=>'successful!',
        'status'=>true,
        'posts' => $posts,
         ]);
    }

}
