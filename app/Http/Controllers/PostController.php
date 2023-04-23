<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return Inertia::render('Posts/PostComponent', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Posts/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => ['required'],
            'body' => ['required'],
        ])->validate();
       
       
        $data = $request->all();
        Post::create($data);
    
        return redirect()->route('posts.view');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
       $post = Post::find($id);
        // dd($post);
        return Inertia::render('Posts/edit', [
            'post' => $post
        ]);
    }

   
    public function update(Request $request,$id)
    {
        Validator::make($request->all(), [
            'title' => ['required'],
            'body' => ['required'],
        ])->validate();
       
       
        $data = $request->all();
        Post::where('id', $id)->update($data);
     
        return redirect()->route('posts.view');
    }

    
    public function destroy(Request $request,$id)
    {
        $destroy = Post::where('id', $id)->delete();
            if ($destroy) {
                session()->flash('message', 'Successfully Delete');
                return redirect()->route('posts.view');
            }
    }
}
