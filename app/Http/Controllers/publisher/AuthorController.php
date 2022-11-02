<?php

namespace App\Http\Controllers\publisher;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Exception;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::join('users', 'users.id', '=', 'authors.user_id')
            ->select('users.name', 'users.email', 'authors.id', 'authors.status', 'authors.user_id')
            ->get();

        return view('publisher.authors', [
            'authors' => $authors
        ]);
    }

    public function change(Request $request)
    {
        $request->validate([
            'author_id' => ['required', 'integer'],
            'status' => ['required', 'integer']
        ]);

        $author = Author::find($request->author_id);
        if(is_null($author)){
            return redirect()->back()->with('error', 'could not find author');
        }

        try{
            $author->status = $request->status;
            $author->save();

            return redirect()->back()->with('success', 'you have successfully updated status');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }
}
