<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    public function userPosts($userId){
        try {
            $user = User::findOrFail($userId);
            return view('user-post', ['userId' => $userId]);
        } catch (\Exception $e) {
            return Redirect::to('/');
        }
    }
    public function addPost(){
        return view('add-post');
    }

}
