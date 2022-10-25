<?php

use App\Models\Book;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Downloaded;
use App\Models\Liked;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

function count_books_in_category($category_id){
    return Book::where('category_id', $category_id)->count();
}

function my_books(){
    return Book::where('user_id', Auth::id())->get();
}

function categories(){
    return Category::all();
}

function count_likes($book_id){
    return Liked::where('book_id', $book_id)->count();
}

function count_downloads($book_id){
    return Downloaded::where('book_id', $book_id)->count();
}

function count_comments($book_id){
    return Comment::where('book_id', $book_id)->count();
}

function book_status($num){
    $status = new stdClass();
    if($num === 0){
        $status->label = "pending";
        $status->badge = "warning";
    }elseif($num === 1){
        $status->label = "approved";
        $status->badge = "success";
    }else{
        $status->label = "rejected";
        $status->badge = "danger";
    }

    return $status;
}

function get_category($category_id){
    return Category::find($category_id);
}

function get_user($id){
    return User::find($id);
}