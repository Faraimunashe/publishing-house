<?php

namespace App\Http\Controllers\publisher;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('publisher.dashboard', [
            'books' => $books
        ]);
    }
}
