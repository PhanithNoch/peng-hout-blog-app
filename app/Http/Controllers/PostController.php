<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
class PostController extends Controller
{
    /// create post 
    public function store(Request $request){
        $data = $request->all();
        /// get current user from token 
        $data['user_id'] = auth()->user()->id;
        /// check if has image 
        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }
        $post = Post::create($data);
        return response()->json([
            'status' => 'success',
            'data' => $post
        ]);
    }
}
