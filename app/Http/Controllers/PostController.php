<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use App\Category;
use Carbon\Carbon;
use App\Http\Requests\{CreateBlogPostRequest ,UpdateBlogPostRequest, DeleteBlogPostRequest};
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    protected $limit = 3;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = \Auth::user();

        $posts = Post::with('author')
                    ->createdFirst()
                    ->byThisUser($user)
                    ->simplePaginate($this->limit);
        
        return view("blog.myposts", compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view("blog.new", compact('categories'));
    }

    public function save(CreateBlogPostRequest $request)
    {
        $user = \Auth::user();
        $category = Category::findOrFail($request->get('category'));

        $image = $request->file('img');
        $uploadedImage = null;

        if($image && $image->isValid()){
            $uploadedImage = rand(0, 100).'_'.$image->getClientOriginalName();
            Storage::disk('public_uploads')->put($uploadedImage, 
            file_get_contents($image->getRealPath()));
        }

        $post = new Post([
          'title' => $request->get('title'),
          'slug'=> $request->get('slug'),
          'excerpt'=> $request->get('excerpt'),
          'body'=> $request->get('body'),
          'image' => $uploadedImage
        ]);

        $post->author()->associate($user);
        $post->category()->associate($category);
        $post->save();
        return redirect('/myposts')->with('success', 'New post has been saved');
    }

    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::all();
        $selectedCat = $post->category_id;
        return view('blog.edit', compact('post', 'categories', 'selectedCat'));
    }

    public function update(UpdateBlogPostRequest $request, $id)
    {
        $post = Post::find($id);

        $image = $request->file('img');
        $uploadedImage = null;

        if($image && $image->isValid()){
            $uploadedImage = rand(0, 100).'_'.$image->getClientOriginalName();
            Storage::disk('public_uploads')->put($uploadedImage, 
            file_get_contents($image->getRealPath()));
        }
        
        $post->title = $request->get('title');
        $post->slug = $request->get('slug');
        $post->excerpt= $request->get('excerpt');
        $post->body= $request->get('body');

        if($uploadedImage != null){
            $post->image = $uploadedImage;
        }

        $category = Category::findOrFail($request->get('category'));
        $post->category()->associate($category);
        $post->save();

        return redirect('/myposts')->with('success', 'Post has been updated');
    }

    public function delete(DeleteBlogPostRequest $request, $id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect('/myposts')->with('success', 'Post has been deleted successfully');
    }

    public function publish($id) 
    {
        $post = Post::findOrFail($id);

        if(is_null($post->published_at)){
            $post->published_at = Carbon::now();
        }else{
            $post->published_at = null;
        }

        $post->save();
        return redirect('/myposts')->with('success', 'Post status has been updated successfully');
    }
}
