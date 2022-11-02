<?php

namespace App\Http\Controllers\publisher;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('publisher.categories', [
            'categories' => $categories
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string']
        ]);

        try{
            $category = new Category();
            $category->name = $request->name;
            $category->save();

            return redirect()->back()->with('success', 'successfully added a category');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'integer'],
            'name' => ['required', 'string']
        ]);

        try{
            $category = Category::find($request->category_id);
            if(is_null($category)){
                return redirect()->back()->with('error', 'could not locate category');
            }

            $category->name = $request->name;
            $category->save();

            return redirect()->back()->with('success', 'successfully added a category');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }
}
