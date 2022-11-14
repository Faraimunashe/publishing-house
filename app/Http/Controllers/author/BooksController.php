<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Comment;
use App\Models\Liked;
use App\Models\Paynowlog;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

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
            $book->status = 2;
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

    public function download(Request $request)
    {
        $request->validate([
            'book_id' => ['required', 'integer'],
            'phone' => ['required', 'digits:10', 'starts_with:07']
        ]);

        $book = Book::find($request->book_id);
        if(is_null($book)){
            return redirect()->back()->with('error', 'Book was not found');
        }

        $wallet = "ecocash";

        //get all data ready
        $email = "faraimunashe.m11@gmail.com";
        $phone = $request->phone;
        $amount = $book->price;

        /*determine type of wallet*/
        if (strpos($phone, '071') === 0) {
            $wallet = "onemoney";
        }

        $paynow = new \Paynow\Payments\Paynow(
            "11336",
            "1f4b3900-70ee-4e4c-9df9-4a44490833b6",
            route('author-download-book'),
            route('author-download-book'),
        );

        // Create Payments
        $invoice_name = "publishing-hub-" . time();
        $payment = $paynow->createPayment($invoice_name, $email);

        $payment->add("Buy Book", $amount);

        $response = $paynow->sendMobile($payment, $phone, $wallet);


        // Check transaction success
        if ($response->success()) {

            $timeout = 9;
            $count = 0;

            while (true) {
                sleep(3);
                // Get the status of the transaction
                // Get transaction poll URL
                $pollUrl = $response->pollUrl();
                $status = $paynow->pollTransaction($pollUrl);


                //Check if paid
                if ($status->paid()) {
                    // Yay! Transaction was paid for
                    // You can update transaction status here
                    // Then route to a payment successful
                    $info = $status->data();

                    $paynowdb = new Paynowlog();
                    $paynowdb->reference = $info['reference'];
                    $paynowdb->paynow_reference = $info['paynowreference'];
                    $paynowdb->amount = $info['amount'];
                    $paynowdb->status = $info['status'];
                    $paynowdb->poll_url = $info['pollurl'];
                    $paynowdb->hash = $info['hash'];
                    $paynowdb->save();

                    //transaction update
                    $trans = new Transaction();
                    $trans->user_id = Auth::id();
                    $trans->book_id = $request->book_id;
                    $trans->reference = $info['paynowreference'];
                    $trans->method = "paynow";
                    $trans->amount = $info['amount'];
                    $trans->status = 1;
                    $trans->save();

                    $filepath = public_path('documents/'.$book->document);
                    return Response::download($filepath);
                }


                $count++;
                if ($count > $timeout) {
                    $info = $status->data();

                    $paynowdb = new Paynowlog();
                    $paynowdb->reference = $info['reference'];
                    $paynowdb->paynow_reference = $info['paynowreference'];
                    $paynowdb->amount = $info['amount'];
                    $paynowdb->status = $info['status'];
                    $paynowdb->poll_url = $info['pollurl'];
                    $paynowdb->hash = $info['hash'];
                    $paynowdb->save();

                    $trans_status = 2;
                    if($info['status'] != 'sent')
                    {
                        $trans_status = 0;
                    }
                    //transaction update
                    $trans = new Transaction();
                    $trans->user_id = Auth::id();
                    $trans->book_id = $request->book_id;
                    $trans->reference = $info['paynowreference'];
                    $trans->method = "paynow";
                    $trans->amount = $info['amount'];
                    $trans->status = $trans_status;
                    $trans->save();

                    return redirect()->back()->with('error', 'Taking too long wait a moment and refresh');
                } //endif
            } //endwhile
        } //endif

        //total fail
        return redirect()->back()->with('error', 'Cannot perform transaction at the moment');
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
            return redirect()->back();
        }catch(Exception $e){
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }

    public function apply()
    {
        $author = Author::where('user_id', Auth::id())->first();
        if(is_null($author)){
            $author = new Author();
            $author->user_id = Auth::id();
            $author->reference = rand(111111111,999999999);
            $author->status = 2;
            $author->save();

            return redirect()->back()->with('success', 'You successfully applied');
        }

        return redirect()->back()->with('error', 'You cannot apply at the moment!');
    }

}
