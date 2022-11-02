<?php

namespace App\Http\Controllers\publisher;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Exception;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->paginate(20);
        return view('publisher.books', [
            'books' => $books
        ]);
    }

    public function change(Request $request)
    {
        $request->validate([
            'book_id' => ['required', 'integer'],
            'status' => ['required', 'integer'],
            'price' => ['required', 'numeric']
        ]);

        $book = Book::find($request->book_id);
        if(is_null($book)){
            return redirect()->back()->with('error', 'Cannot locate specified book');
        }

        try{
            $book->status = $request->status;
            $book->save();

            return redirect()->back()->with('success', 'Successfully updated book status');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }

}
