<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use App\Category;

class PostController extends Controller
{
    protected $limit = 2;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = \Auth::user();

        $posts = Post::with('author')
                    ->latestFirst()
                    ->published()
                    ->byThisUser($user)
                    ->simplePaginate($this->limit);
        
        return view("blog.myposts", compact('posts'));
    }

    public function new()
    {
        $categories = Category::all();
        return view("blog.new", compact('categories'));
    }
}