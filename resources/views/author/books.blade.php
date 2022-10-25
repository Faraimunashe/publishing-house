<x-app-layout>
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
            <div class="col-md-9 mb-4">
                <section style="padding-top: 25px;">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-header">
                            My Books
                        </div>
                        <div class="card-body">
                            @if (my_books()->isEmpty())
                                You haven't published any book.
                            @endif

                            @foreach (my_books() as $book)
                                <hr/>
                                <!-- Post -->
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <div class="bg-image hover-overlay shadow-1-strong rounded ripple" data-mdb-ripple-color="light">
                                            <img src="{{asset('images')}}/{{$book->cover}}" class="img-fluid" height="50" width="300"/>
                                            <a href="#!">
                                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-md-8 mb-4">
                                        <h4>
                                            {{$book->title}}
                                        </h4>
                                        <span class="text-muted small mb-0">
                                            {{$book->created_at}}
                                            <span class="badge bg-{{book_status($book->status)->badge}}">
                                                <i class="bi bi-check-circle me-1"></i>
                                                {{book_status($book->status)->label}}
                                            </span>
                                            -${{$book->price}}
                                        </span>
                                        <p>
                                            {{$book->description}}
                                        </p>
                                        <hr/>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <a href="#!" class="link-muted me-1" style="padding-right: 20px;">
                                                    <i class="bi bi-hand-thumbs-up"></i>
                                                    {{ count_likes($book->id) }}
                                                </a>
                                                <a href="#!" class="link-muted" style="padding-right: 20px;">
                                                    <i class="bi bi-chat-right me-1"></i>
                                                    {{ count_comments($book->id) }}
                                                </a>
                                                <a href="#!" class="link-muted" style="padding-right: 20px;">
                                                    <i class="bi bi-download me-1"></i>
                                                    {{ count_downloads($book->id) }}
                                                </a>
                                            </div>
                                            <a href="#!" class="link-muted" data-bs-toggle="modal" data-bs-target="#editModal{{$book->id}}">
                                                <i class="bi bi-pencil-square me-1"></i>
                                                Edit
                                            </a>
                                            <a href="{{route('author-one-book', $book->id)}}" class="link-muted">
                                                <i class="bi bi-eye me-1"></i>
                                                More
                                            </a>
                                        </div>
                                        <hr/>
                                    </div>
                                </div>
                                <!-- Edit modal --->
                                <div class="modal fade" id="editModal{{$book->id}}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('author-edit-book') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Update Book:  {{$book->title}}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="book_id" value="{{$book->id}}" required>
                                                    <div class="row mb-3">
                                                        <label for="inputText" class="col-sm-2 col-form-label">Category: </label>
                                                        <div class="col-sm-10">
                                                            <select name="category_id" class="form-control" required>
                                                                <option selected value="{{get_category($book->category_id)->id}}">{{get_category($book->category_id)->name}}</option>
                                                                @foreach (categories() as $category)
                                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputText" class="col-sm-2 col-form-label">Title: </label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="title" value="{{$book->title}}" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputText" class="col-sm-2 col-form-label">Cover Image: </label>
                                                        <div class="col-sm-10">
                                                            <input type="file" name="cover" class="form-control" value="{{$book->cover}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputText" class="col-sm-2 col-form-label">Document: </label>
                                                        <div class="col-sm-10">
                                                            <input type="file" name="document" class="form-control" value="{{$book->document}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputText" class="col-sm-2 col-form-label">Price: </label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="price" class="form-control" value="{{$book->price}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputText" class="col-sm-2 col-form-label">Abstract: </label>
                                                        <div class="col-md-10">
                                                            <textarea class="form-control" name="description" required value="{{$book->description}}" style="height: 100px"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div><!-- End edit Modal-->

                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-3 mb-4">
                <section style="padding-top: 25px;">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-header">
                            New Publishment
                        </div>
                        <div class="card-body">
                            <div class="row mt-3">
                                <button class="btn btn-success btn-block" data-bs-toggle="modal" data-bs-target="#largeModal">
                                    Add New
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!--Grid column-->
        </div>
        <!--Grid row-->
    </div>
    <div class="modal fade" id="largeModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('author-add-book') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Book</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Category: </label>
                            <div class="col-sm-10">
                                <select name="category_id" class="form-control" required>
                                    <option selected disabled>Select Category</option>
                                    @foreach (categories() as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Title: </label>
                            <div class="col-sm-10">
                                <input type="text" name="title" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Cover Image: </label>
                            <div class="col-sm-10">
                                <input type="file" name="cover" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Document: </label>
                            <div class="col-sm-10">
                                <input type="file" name="document" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Price: </label>
                            <div class="col-sm-10">
                                <input type="text" name="price" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Abstract: </label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="description" required style="height: 100px"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- End Large Modal-->
</x-app-layout>
