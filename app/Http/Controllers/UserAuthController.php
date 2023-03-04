<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserAuthController extends Controller
{
    
    /// register user with passport 

    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        /// upload image 
        /// if has image 
        $imageName = '';
        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }
     
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'image' => $imageName ?? null
        ]);


       

        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'status' => 'success',
            'data' => $token
        ]);
    }
    /// login 
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $credentials = $request->only('email','password');
        if(auth()->attempt($credentials)){
            $token = auth()->user()->createToken('authToken')->accessToken;
            return response()->json([
                'status' => 'success',
                'data' => $token
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'data' => 'invalid credentials'
            ], 401);
        }
    }
    
    /// update user 
    public function update(Request $request, $id){
        $user = User::find($id);
        if($user){
            /// check if has image 
            if($request->hasFile('image')){
                 /// delete old image
                 if($user->image != null){
                    /// check if image exist
                    if(file_exists(public_path('images/'.$user->image))){
                        unlink(public_path('images/'.$user->image));
                    }
               
                }
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $user->image = $imageName;
               
            }
         $userUp =   User::where('id',$id)->update([
                'name' => $request->name,
                'image' => $user->image ?? null
            ]);
            

            return response()->json([
                'status' => 'success',
                'data' => $userUp
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'data' => 'user not found'
            ], 404);
        }


        
    }

    /// get me 
    public function me(Request $request){
        $user = auth()->user();
        /// get host name 
        $host = $request->getHttpHost();
        // dd($host);
        $imagePath = 'http://'.$host.'/images/'.$user->image;
        $user->image = $imagePath;
        if($user){
            return response()->json([
                'status' => 'success',
                'data' => $user
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'data' => 'user not found'
            ], 404);
        }
    }
}

