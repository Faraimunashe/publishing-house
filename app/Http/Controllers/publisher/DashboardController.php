<?php

namespace App\Http\Controllers\publisher;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $books = Book::where('status', 2)->get();
        return view('publisher.dashboard', [
            'books' => $books
        ]);
    }
}
