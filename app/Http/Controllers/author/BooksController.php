<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Comment;
use App\Models\Liked;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    public function index()
    {
        return view('author.books');
    }

    public function add(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'numeric'],
            'title' => ['required'],
            'cover' => ['required', 'image', 'mimes:png,jpg,jpeg,gif', 'max:2048'],
            'document' => ['required', 'file', 'mimes:docx,pdf'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'string', 'min:80']
        ]);

        try{
            $imageName = Auth::id().'_'.time().'.'.$request->cover->extension();
            $request->cover->move(public_path('images'), $imageName);

            $docName = Auth::id().'_'.time().'.'.$request->document->extension();
            $request->document->move(public_path('documents'), $docName);

            $book = new Book();
            $book->category_id = $request->category_id;
            $book->user_id = Auth::id();
            $book->document = $docName;//book file
            $book->price = $request->price;
            $book->cover = $imageName;//cover image;
            $book->status = 0;
            $book->description = $request->description;
            $book->title = $request->title;
            $book->save();

            return redirect()->back()->with('success', 'You have successfully uploaded a new book');
        }catch(Exception $e){
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'book_id' => ['required', 'numeric'],
            'category_id' => ['required', 'numeric'],
            'title' => ['required'],
            'cover' => ['required', 'image', 'mimes:png,jpg,jpeg,gif', 'max:2048'],
            'document' => ['required', 'file', 'mimes:docx,pdf'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'string', 'min:80']
        ]);

        try{
            $book = Book::find($request->book_id);
            if(is_null($book)){
                return redirect()->back()->with('error', 'error: book cannot be found');
            }
            $imageName = Auth::id().'_'.time().'.'.$request->cover->extension();
            $request->cover->move(public_path('images'), $imageName);

            $docName = Auth::id().'_'.time().'.'.$request->document->extension();
            $request->document->move(public_path('documents'), $docName);


            $book->category_id = $request->category_id;
            $book->user_id = Auth::id();
            $book->document = $docName;//book file
            $book->price = $request->price;
            $book->cover = $imageName;//cover image;
            $book->status = 0;
            $book->description = $request->description;
            $book->title = $request->title;
            $book->save();

            return redirect()->back()->with('success', 'You have successfully uploaded a new book');
        }catch(Exception $e){
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }

    public function one($book_id)
    {
        $book = Book::find($book_id);
        if(is_null($book)){
            return redirect()->back()->with('error', 'Book was not found');
        }

        $comments = Comment::where('book_id', $book->id)->get();

        return view('author.one-book', [
            'book' => $book,
            'comments' => $comments
        ]);
    }

    public function read($book_id)
    {
        $book = Book::find($book_id);
        if(is_null($book)){
            return redirect()->back()->with('error', 'Book was not found');
        }

        $comments = Comment::where('book_id', $book->id)->get();

        return view('author.document-view', [
            'book' => $book,
            'comments' => $comments
        ]);
    }

    public function comment(Request $request)
    {
        $request->validate([
            'book_id' => ['required', 'numeric'],
            'comment' => ['required', 'string']
        ]);

        try{
            $comment = new Comment();
            $comment->user_id = Auth::id();
            $comment->book_id = $request->book_id;
            $comment->message = $request->comment;
            $comment->save();
            return redirect()->back()->with('success', 'Comment added successfully');
        }catch(Exception $e){
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }

    public function like(Request $request)
    {
        $request->validate([
            'bookid' => ['required', 'numeric'],
            'userid' => ['required', 'numeric']
        ]);

        $liked = Liked::where('user_id', $request->userid)->where('book_id', $request->bookid)->first();
        if(!is_null($liked)){
            $liked->delete();
            return redirect()->back();
        }

        try{
            $comment = new Liked();
            $comment->user_id = $request->userid;
            $comment->book_id = $request->bookid;
            $comment->save();
            return redirect()->back()->with('success', 'liked successfully');
        }catch(Exception $e){
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }

}
