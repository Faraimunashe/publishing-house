<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Transaction::join('books', 'books.id', '=', 'transactions.book_id')
            ->where('books.user_id', Auth::id())
            ->select('transactions.id', 'transactions.reference', 'transactions.method', 'transactions.amount', 'transactions.status', 'transactions.book_id')
            ->get();

        return view('author.sales', [
            'sales' => $sales
        ]);
    }
}
