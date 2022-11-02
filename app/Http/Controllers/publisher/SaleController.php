<?php

namespace App\Http\Controllers\publisher;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Transaction::latest()->get();

        return view('publisher.sales', [
            'sales' => $sales
        ]);
    }

    public function download()
    {
        return redirect()->back();
    }
}
