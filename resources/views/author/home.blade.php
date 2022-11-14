<x-app-layout>
    <div class="container">
        <!--Grid row-->
        <div class="row">
          <!--Grid column-->
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
            <div class="col-md-9 mb-4">
                <!--Section: Content-->
                <section>
                    @foreach ($books as $book)
                        <hr/>
                        <!-- book list -->
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="bg-image hover-overlay shadow-1-strong rounded ripple" data-mdb-ripple-color="light">
                                    <img src="{{asset('images')}}/{{$book->cover}}" class="img-fluid" height="80" width="300" />
                                    <a href="#!">
                                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-8 mb-4">
                                <h5><a href="{{route('author-one-book', $book->id)}}">{{$book->title}}</a></h5>
                                <p>{{$book->description}}</p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <form id="like-form{{$book->id}}" action="{{ route('author-like') }}" method="POST">
                                            @csrf
                                            <input type="hidden" id="book_id{{$book->id}}" value="{{$book->id}}">
                                            <input type="hidden" id="user_id{{$book->id}}" value="{{Auth::id()}}">
                                        </form>
                                        <a href="#!" class="link-muted me-1" onclick="event.preventDefault();document.getElementById('like-form{{$book->id}}').submit();" style="padding-right: 20px;">
                                            <i class="bi bi-hand-thumbs-up"></i>
                                            {{ count_likes($book->id) }}
                                        </a>
                                        <a href="{{route('author-one-book', $book->id)}}#comment" class="link-muted" style="padding-right: 20px;">
                                            <i class="bi bi-chat-right me-1"></i>
                                            {{ count_comments($book->id) }}
                                        </a>
                                        <a href="#!" class="link-muted" style="padding-right: 20px;">
                                            <i class="bi bi-download me-1"></i>
                                            {{ count_downloads($book->id) }}
                                        </a>
                                    </div>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#buyBookModal{{ $book->id }}">
                                        <i class="bi bi-download"></i>
                                        ${{$book->price}}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="buyBookModal{{ $book->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="POST" action="{{route('author-download-book')}}">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}" required>
                                        <div class="modal-header">
                                            <h5 class="modal-title">Buy a copy of {{$book->title}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <label for="inputText" class="col-sm-2 col-form-label">Price: </label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="price" class="form-control" value="{{ $book->price }}" required disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="inputText" class="col-sm-2 col-form-label">Phone: </label>
                                                <div class="col-sm-10">
                                                    <input type="tel" name="phone" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Make payment</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div><!-- End Edit Modal-->
                    @endforeach
                </section>
                <!--Section: Content-->
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-3 mb-4">
                <!--Section: Sidebar-->
                <section class="sticky-top" style="top: 80px;">
                    <section class="text-center border-bottom pb-4 mb-4">
                        <h4>Categories</h4>
                        @foreach ($categories as $category)
                            <hr/>
                                <a href="#">
                                    {{$category->name}} ({{count_books_in_category($category->id)}})
                                </a>
                        @endforeach
                    </section>
                </section>
                <!--Section: Sidebar-->
            </div>
            <!--Grid column-->
        </div>
        <!--Grid row-->

        <!-- Pagination -->
        <nav class="my-4" aria-label="...">
            {{$books->links('pagination::bootstrap-4')}}
        </nav>
    </div>
</x-app-layout>
