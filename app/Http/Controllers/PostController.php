<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Image;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Post::paginate(20);
        return view('posts.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->toArray();
        return view('posts.create',compact('categories'));
    }


    public function store(Request $request)
    {
        $this->validate($request, array(
            'title' => 'required',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required',
            'puplish_date' => 'required',
        ));
        $post = new Post();
        $post->title_post= $request->input('title');
        $post->content_post= $request->input('content');
        $post->category_id= $request->input('category_id');
        $post->puplish_date= $request->input('puplish_date');

        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time() .'.' . $image->getClientOriginalExtension();
           Image::make($image)->resize(300, 300)->save( public_path('/uploads/' . $filename ) );
            $post->image = $filename;
            $post->save();
        }

        $post->save();

        return redirect()->route('post.index')
            ->with('success','Item created successfully');    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model =Post::findOrFail($id);
        return view('posts.edit',compact('model'));    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $record = Post::findOrFail($id);
        $record->update($request->all());
        flash()->success('<p class="text-center" style="font-size:20px; font-weight:900;font-family:Arial" >لقـــد تـــــــم التحــديــــــــث بنــجـــــــاح</p>');
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Post::findOrFail($id);
        $record->delete();
        flash()->error('<p class="text-center" style="font-size:20px; font-weight:900;font-family:Arial" >تـــم الحــذف </p>');
        return back();
    }
}
