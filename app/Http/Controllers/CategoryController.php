<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $all_categories = Category::all();
        return view('content.projects.categories', compact('all_categories'));
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $categoryInput = Category::create($request->all());
        return redirect()->back()->with('success', 'Data Berhasil Disimpan');
    }

    public function show(Category $category)
    {

    }

    public function edit(Category $category)
    {

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();
        return redirect()->route('category.index')->with('success', 'Data Berhasil Diupdate');
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Data Berhasil Dihapus');
    }
}
