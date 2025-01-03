<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BlogController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Blogs', only: ['index']),
            new Middleware('permission:Edit Blogs', only: ['edit']),
            new Middleware('permission:Create Blogs', only: ['create']),
            new Middleware('permission:Delete Blogs', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('blogs.index' ,compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blogs.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate( 
            [
                'name'=>'required',
                'author'=>'required',
            ]
            );
            $blog = new Blog();
            $blog->name = $request->name;
            $blog->author = $request->author;
            $blog->text = $request->text;
            $blog->save();

            return to_route('blog.index')->with('success','Blog Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('blogs.edit',compact('blog'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
       $validated =  $request->validate( 
            [
                'name'=>'required',
                'text'=>'',
                'author'=>'required',
            ]
            );

            $blog->update($validated);


        return to_route('blog.index')->with('success','Blog Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return to_route('blog.index')->with('danger','Blog Deleted Successfully');

    }
}
