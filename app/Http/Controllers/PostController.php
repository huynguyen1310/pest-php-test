<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create() {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'title'   => 'required',
            'body'    => 'required',
            'status'  => 'required'
        ]);

        auth()->user()->posts()->create($validated);

        return response('success', 200);
    }
}
