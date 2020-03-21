<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate(5);
        return  view('admin.categories.index', compact('categories'));
    }

    /**
     * Display Trashed listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $categories = Category::orderBy('id', 'desc')->onlyTrashed()->paginate(5);
//        dd($categories);
        return  view('admin.categories.trash', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return  view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'slug' => 'required|min:5|unique:categories',
        ]);

        $categories = Category::create($request->only('title', 'description', 'slug'));
        $categories->subCategories()->attach($request->parent_id);
        return back()->with('message', 'Category Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->get();
        return  view('admin.categories.edit', ['categories' => $categories, 'category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->title = $request->title;
        $category->description = $request->description;
        $category->slug = $request->slug;


        // detach all parent categories
        $category->subCategories()->detach();
        // attach selected parent categories
        $category->subCategories()->attach($request->parent_id);
        // save current record into database
        $category->save();
        return back()->with('message', 'Category Updated Successfully!');
    }

    public function recoverCat($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        if ($category->restore())
            return back()->with('message', 'Category Successfully Restored!');
        else
            return back()->with('error', 'Error Restoring Category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->subCategories()->detach() && $category->forceDelete()) {
            return back()->with('message', 'Category Deleted Successfully!');
        } else {
            return back()->with('error', 'Error Deleting Record!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function remove(Category $category)
    {
        if ($category->delete()) {
            return back()->with('message', 'Category Successfully Trashed!');
        } else {
            return back()->with('error', 'Error Trashing Record!');
        }
    }
}
