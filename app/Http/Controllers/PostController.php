<?php
/**
 * Created by PhpStorm.
 * User: ilyadonskoj
 * Date: 11.07.18
 * Time: 15:31
 */

namespace Tugger\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use Tugger\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Tugger\Http\Controllers\Rules\EditProfile\ValidData;
use Tugger\Http\Requests;
use Auth;
use Image;
use Tugger\Post;
use Tugger\Like;
use Carbon\Carbon;

class PostController extends Controller
{
    public function create_post(Request $request)
    {
        $this->validate($request, [
           'body' => 'required|max:1000'
        ]);
        $post = new Post();
        $post->body = $request['body'];
        $message = "There was an error";
        if ($request->user()->posts()->save($post)) {
            $message = "Post was successfully created!";
        }
        return redirect()->route('post')->with('status', $message);
    }

    public function get_posts()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('pages.post', compact('posts'));
    }

    public function delete_post($id)
    {
        $post = Post::find($id);
        if (Auth::user() != $post->user) {
            return back();
        }
        $post->delete();
        return redirect()->route('post')->with('status', 'Post successfully deleted!');
    }

    public function edit_post(Request $request)
    {
        $this->validate($request, [
           'body' => 'required',
        ]);

        $post = Post::find($request['postId']);
        if (Auth::user() != $post->user) {
            return back();
        }
        $post->body = $request['body'];
        $post->update();
        return response()->json(['new_body' => $post->body], 200);
    }

    public function like_post(Request $request)
    {
        $post_id = $request['postId'];
        $is_like = $request['isLike'] === 'true';
        $updated = false;
        $post = Post::find($post_id);
        if (!$post)
            return null;
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();
        if ($like) {
            $liked = $like->like;
            $updated = true;
            if ($liked == $is_like) {
                $like->delete();
                return null;
            }
        } else {
            $like = new Like();
        }
        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        if ($updated) {
            $like->update();
        } else {
            $like->save();
        }
        return null;
    }
}