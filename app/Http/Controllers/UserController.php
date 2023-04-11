<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function edit(){
        $user = Auth::user();

        $user_images = [];
        foreach($user->images as $image){
            $user_images[] = Storage::url($image->path);
        }
        $user->image_paths = $user_images;

        return Inertia::render('Sitter/Info', [
            'user' => $user,
        ]);
    }

    public function update(UpdateUserRequest $request){
        $user = Auth::user();
        $user->description = $request->description;
        $user->save();

        foreach($request->images as $request_image){
            $image = new Image();
            $path = $request_image->store('sitters', 'public');
            $image->path = $path;
            $image->user_id = $user->id;
            $image->save();
        }

        return to_route('sitter.edit')->with('message', 'Info bijgewerkt!');
    }

    public function show($id){
       $sitter = User::findOrFail($id);

       $user_images = [];
       foreach($sitter->images as $image){
           $user_images[] = Storage::url($image->path);
       }

       $sitter->image_paths = $user_images;
       $sitter->reviews = $sitter->reviews;

        return Inertia::render('Owner/Sitter', [
            'sitter' => $sitter,
        ]);
    }

    public function index(){
        $users = User::all()->map(function($user){
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'status' => $user->status == 0 ? 'Geblokkeerd' : 'Normaal'
            ];
        });

        return Inertia::render('Admin/Users', [
            'users' => $users,
        ]);
    }

    public function blockUser($id){
        if(Auth::user()->role->value == Role::Admin->value){
            $user = User::findOrFail($id);
            $user->status = 0;
            $user->save();
        }
        return to_route('users.index');
    }

    public function logout(){
        Auth::logout();
        return to_route('login');
    }
}
