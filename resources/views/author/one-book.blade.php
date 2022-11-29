<x-app-layout>
    <div class="mt-4 mb-5">
        <div class="container">
            <!--Grid row-->
            <div class="row">
                <div class="col-md-12">
                    @if (Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <!--Grid column-->
                <div class="col-md-8 mb-4">
                <!--Section: Post data-mdb-->
                    <section class="border-bottom mb-4">
                        <img src="{{asset('images')}}/{{$book->cover}}" class="img-fluid shadow-2-strong rounded-5 mb-4" alt="" />

                        <div class="row align-items-center mb-4">
                            <div class="col-lg-6 text-center text-lg-start mb-3 m-lg-0">
                                <span class="rounded-5 shadow-1-strong me-2" height="35" alt="" loading="lazy">
                                    <i class="bi bi-person"></i>
                                </span>
                                <span> Published <u>{{$book->created_at}}</u> by</span>
                                <a href="" class="text-dark">{{get_user($book->user_id)->name}}</a>

                                <span class="badge bg-{{book_status($book->status)->badge}}">
                                    <i class="bi bi-check-circle me-1"></i>
                                    {{book_status($book->status)->label}}
                                </span>
                            </div>
                        

                            <div class="col-lg-6 text-center text-lg-end">
                                <form method="POST" action="{{route('author-like')}}">
                                    @csrf
                                    <input type="hidden" value="{{Auth::id()}}" name="userid" required>
                                    <input type="hidden" value="{{$book->id}}" name="bookid" required>
                                    <button type="submit" class="btn btn-primary px-3 me-1" style="background-color: #3b5998;">
                                        <i class="bi bi-hand-thumbs-up"></i>
                                        {{count_likes($book->id)}}
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary px-3 me-1" style="background-color: #55acee;">
                                    <i class="bi bi-chat-right"></i>
                                    {{count_comments($book->id)}}
                                </button>
                                <button type="button" class="btn btn-primary px-3 me-1" style="background-color: #0082ca;">
                                    <i class="bi bi-download"></i>
                                    {{count_downloads($book->id)}}
                                </button>
                            </div>
                        </div>
                    </section>
                <!--Section: Post data-mdb-->

                <!--Section: Text-->
                <section>
                    <p>{{$book->description}}</p>
                </section>
                <!--Section: Text-->
                <!--Section: Comments-->
                <section class="border-bottom mb-3">
                    <p class="text-center"><strong>Comments: {{count_comments($book->id)}}</strong></p>

                    <!-- Comment -->
                    @foreach ($comments as $comment)
                        <div class="row mb-4">
                            <div class="col-2">
                                <img src="{{asset('assets/img/profile-pic.jpg')}}" class="img-fluid shadow-1-strong rounded-5" alt="" />
                            </div>

                            <div class="col-10">
                                <p class="mb-2">
                                    <strong>{{get_user($comment->user_id)->name}}</strong>
                                    @if ($comment->user_id === $book->user_id)
                                        <span class="badge bg-dark"><i class="bi bi-emoji-wink me-1"></i>Author</span>
                                    @endif
                                </p>
                                <p>{{$comment->message}}</p>
                            </div>
                        </div>
                    @endforeach
                </section>
                <!--Section: Comments-->

                <!--Section: Reply-->
                <section id="comment">
                    <p class="text-center"><strong>Leave a comment</strong></p>

                    <form action="{{route('author-comment')}}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{$book->id}}" required>
                        <!-- Message input -->
                        <div class="form-outline mb-4">
                            <textarea class="form-control" name="comment" id="form4Example3" rows="4" required></textarea>
                            <label class="form-label" for="form4Example3">Message</label>
                        </div>
                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-block mb-4">
                            Comment
                        </button>
                    </form>
                </section>
                <!--Section: Reply-->
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-md-4 mb-4">
                    <section class="sticky-top" style="top: 80px;">
                        <section class="text-center border-bottom pb-4 mb-4">
                            <h4>Categories</h4>
                            @foreach (categories() as $category)
                                <hr/>
                                    <a href="#">
                                        {{$category->name}} ({{count_books_in_category($category->id)}})
                                    </a>
                            @endforeach
                        </section>
                    </section>
                </div>
                <!--Grid column-->
            </div>
            <!--Grid row-->
        </div>
    </div>
</x-app-layout>
