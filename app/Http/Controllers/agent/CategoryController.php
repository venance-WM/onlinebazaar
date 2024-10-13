<?php

namespace App\Http\Controllers\agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(2);

        return view('agent.categories.index', compact('categories'));
    }
    public function create()
    {
        return view('agent.categories.create');

    }
    public function store(Request $request)
    {
        $request->validate([
            'category-name' => 'required|string|max:255',
            'category-description' => 'nullable|string',
        ]);

        $category = new Category();
        $category->name = $request->input('category-name');
        $category->description = $request->input('category-description');
        $category->save();

        return redirect()->route('agent.categories.index')->with('success', 'Category added successfully!');
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('agent.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category-name' => 'required|string|max:255',
            'category-description' => 'nullable|string',
        ]);
    
        $category = Category::findOrFail($id);
        $category->name = $request->input('category-name');
        $category->description = $request->input('category-description');
        $category->save();
    
        return redirect()->route('agent.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('agent.categories.index')->with('success', 'Category deleted successfully.');
    }
}