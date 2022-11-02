<?php

namespace App\Http\Controllers\publisher;

use App\Http\Controllers\Controller;
use App\Models\Author;
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
}
