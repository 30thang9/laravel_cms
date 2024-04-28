<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostApiController extends Controller
{
    public function list()
    {
        try {
            $posts = Post::all();

            return response()->json([
                'status' => true,
                'data' => $posts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getByUserId($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $user->posts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'description' => 'required|string',
                'user_id' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                throw new \Exception('Validation failed', 422);
            }

            $post = Post::create($request->only(['title', 'description', 'user_id']));

            return response()->json([
                'status' => true,
                'data' => $post
            ], 201);
        } catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'errors' => $statusCode === 422 ? $validator->errors() : null
            ], $statusCode);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'description' => 'required|string'
            ]);

            if ($validator->fails()) {
                throw new \Exception('Validation failed', 422);
            }

            $post = Post::findOrFail($id);

            $post->update($request->only(['title', 'description']));

            return response()->json([
                'status' => true,
                'data' => $post
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'errors' => $e->getCode() === 422 ? $validator->errors() : null
            ], $e->getCode());
        }
    }


    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);

            $post->delete();

            return response()->json([
                'status' => true,
                'message' => 'Post deleted successfully'
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
