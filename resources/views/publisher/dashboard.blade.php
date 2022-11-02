<x-app-layout>
    <div class="pagetitle" style="padding-top: 25px;" id="space">
        <h1>Dashboard</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </nav>
    </div>
    <section class="section dashboard" id="space">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <!-- Revenue Card -->
                    <div class="col-md-4">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Revenue <span>| this month</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>${{calculate_revenue()}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Revenue Card -->
                    <!-- Sales Card -->
                    <div class="col-md-4">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Books <span>| approved</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-book"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{count_approved_books()}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Customers Card -->
                    <div class="col-xl-4">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Authors <span>| approved</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{count_approved_authors()}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Customers Card -->

                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Recent Books <span>| pending</span></h5>
                                <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                                    <div class="dataTable-top">
                                        <div class="dataTable-dropdown">
                                            <label><select class="dataTable-selector"><option value="5">5</option><option value="10" selected="">10</option><option value="15">15</option><option value="20">20</option><option value="25">25</option></select> entries per page</label>
                                        </div>
                                        <div class="dataTable-search">
                                            <input class="dataTable-input" placeholder="Search..." type="text">
                                        </div>
                                    </div>
                                    <div class="dataTable-container">
                                        <table class="table table-borderless datatable dataTable-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" data-sortable="" >
                                                        <a href="#" class="dataTable-sorter">#</a>
                                                    </th>
                                                    <th scope="col" data-sortable="">
                                                        <a href="#" class="dataTable-sorter">Title</a>
                                                    </th>
                                                    <th scope="col" data-sortable="">
                                                        <a href="#" class="dataTable-sorter">Price</a>
                                                    </th>
                                                    <th scope="col" data-sortable="">
                                                        <a href="#" class="dataTable-sorter">Author</a>
                                                    </th>
                                                    <th scope="col" data-sortable="">
                                                        <a href="#" class="dataTable-sorter">Status</a>
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
                                                        <td>{{$book->title}}</td>
                                                        <td>
                                                            <a href="#" class="text-primary">${{$book->price}}</a>
                                                        </td>
                                                        <td>{{$book->user_id}}</td>
                                                        <td>
                                                            <span class="badge bg-{{$status->badge}}">{{$status->label}}</span>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-success btn-sm">
                                                                option
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="dataTable-bottom">
                                        <div class="dataTable-info">Showing 1 to 5 of 5 entries</div>
                                        <nav class="dataTable-pagination">
                                            <ul class="dataTable-pagination-list">
                                            </ul>
                                        </nav>
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
