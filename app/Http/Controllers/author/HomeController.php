<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $books = Book::where('status', 1)->latest()->paginate(10);
        $categories = Category::all();
        return view('author.home', [
            'books' => $books,
            'categories' => $categories
        ]);
    }
}
