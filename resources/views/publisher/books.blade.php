<x-app-layout>
    <div class="pagetitle" style="padding-top: 25px;" id="space">
        <h1>Books</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Books</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard" id="space">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <!-- Categories -->
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
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="card-title">Books Available</h5>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <button class="btn btn-success" style="float: right;" data-bs-toggle="modal" data-bs-target="#largeModal">Add New</button>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">

                                    <div class="dataTable-container">
                                        <table class="table table-borderless datatable dataTable-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" data-sortable="" >
                                                        <a href="#" class="dataTable-sorter">#</a>
                                                    </th>
                                                    <th scope="col" data-sortable="">
                                                        <a href="#" class="dataTable-sorter">Category</a>
                                                    </th>
                                                    <th scope="col" data-sortable="">
                                                        <a href="#" class="dataTable-sorter">Title</a>
                                                    </th>
                                                    <th scope="col" data-sortable="">
                                                        <a href="#" class="dataTable-sorter">Price</a>
                                                    </th>
                                                    <th scope="col" data-sortable="">
                                                        <a href="#" class="dataTable-sorter">Status</a>
                                                    </th>
                                                    <th scope="col" data-sortable="">
                                                        <a href="#" class="dataTable-sorter">File</a>
                                                    </th>
                                                    <th scope="col" data-sortable="">
                                                        <a href="#" class="dataTable-sorter">Action</a>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $count = 0;
                                                @endphp
                                                @foreach ($books as $book)
                                                    <tr>
                                                        <th scope="row">
                                                            <a href="#">
                                                                @php
                                                                    $status = get_status($book->status);
                                                                    $count++;
                                                                    echo $count;
                                                                @endphp
                                                            </a>
                                                        </th>
                                                        <td>{{get_category($book->category_id)->name}}</td>
                                                        <td>{{$book->title}}</td>
                                                        <td>${{$book->price}}</td>
                                                        <td>
                                                            <span class="badge bg-{{$status->badge}}">{{$status->label}}</span>
                                                        </td>
                                                        <td>
                                                            <a href="{{route('admin-download-book', $book->id)}}" class="text text-purple-700">Download</a>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $book->id }}">
                                                                Change
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="editModal{{ $book->id }}" tabindex="-1">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <form method="POST" action="{{ route('admin-edit-book') }}">
                                                                    @csrf
                                                                    <input type="hidden" name="book_id" value="{{ $book->id }}" required>
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Update: {{$book->title}}</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row mb-3">
                                                                            <label for="inputText" class="col-sm-2 col-form-label">Price: </label>
                                                                            <div class="col-sm-10">
                                                                                <input type="text" name="price" class="form-control" value="{{ $book->price }}" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="inputText" class="col-sm-2 col-form-label">Status: </label>
                                                                            <div class="col-sm-10">
                                                                                <select name="status" class="form-control" required>
                                                                                    <option value="{{$book->status}}" selected> {{$status->label}}</option>
                                                                                    <option value="0">Rejected</option>
                                                                                    <option value="1">Accepted</option>
                                                                                </select>
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
                                                    </div><!-- End Edit Modal-->
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
