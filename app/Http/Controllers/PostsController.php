<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use DB;
class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     * for a user to access the post manipulation pages
     * they have to be authenticated otherwise, BLOCKEDT.
     * except some views- index and show
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //$posts = Post::all();
      //$posts = Post::orderBy('title', 'desc')->get();
      //return Post::where('title', 'Post Two')->get();
       //$posts= DB::select('select * from posts');
      //$posts = Post::orderBy('title', 'desc')->take(1)->get(); -- show 1 post
        $posts = Post::orderBy('created_at', 'desc')->paginate(3);
        return view('posts.index')->with('posts', $posts);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' =>'required',
            'cover_image' => 'image|nullable|max:1999'
            //should be an image, can be nullable and max is 1999 bytes - max for
            //apache servers is 2mb
        ]);

        //handle file upload
        if($request->hasFile('cover_image')){
            //get file name with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //just get filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //just get extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            //upload image
            //cover_images folder stored in storage/app/public - inaccessible through browser
            //set symlink to public folder through: php artisan storage:link
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);

        }else{ //if no image is uploaded
            $filenameToStore = 'noimage.jpg';

        }

        //Create Post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image =  $filenameToStore;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        //prevents unauthorised users from editing and deletingby redirecting
        if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error', 'Unauthorised Page');
        }

        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' =>'required',
        ]);

        //handle file upload
        if($request->hasFile('cover_image')){
            //get file name with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //just get filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //just get extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            //upload image
            //cover_images folder stored in storage/app/public - inaccessible through browser
            //set symlink to public folder through: php artisan storage:link
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);

        }
        //Update Post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')){
            $post->cover_image = $filenameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error', 'Unauthorised Page');
        }

        if($post->cover_image != 'noimage.jpg'){
            //delete image
            Storage::delete('public/cover_images/'.$post->cover_image);

        }

        $post->delete();
        return redirect('/posts')->with('success', 'Post Deleted');

    }
}
