<x-app-layout>
    <div class="pagetitle" style="padding-top: 25px;" id="space">
        <h1>Sales</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Sales</li>
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
                                        <h5 class="card-title">Sales</h5>
                                    </div>
                                    <form action="{{route('admin-download-sales')}}" method="POST">
                                        @csrf
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-success">Print Report</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">

                                    <div class="dataTable-container">
                                        <table class="table table-borderless datatable dataTable-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" data-sortable="" >
                                                        <a href="#" class="dataTable-sorter">Reference#</a>
                                                    </th>
                                                    <th scope="col" data-sortable="">
                                                        <a href="#" class="dataTable-sorter">Method</a>
                                                    </th>
                                                    <th scope="col" data-sortable="">
                                                        <a href="#" class="dataTable-sorter">Amount</a>
                                                    </th>
                                                    <th scope="col" data-sortable="">
                                                        <a href="#" class="dataTable-sorter">Status</a>
                                                    </th>
                                                    <th scope="col" data-sortable="">
                                                        <a href="#" class="dataTable-sorter">User</a>
                                                    </th>
                                                    <th scope="col" data-sortable="">
                                                        <a href="#" class="dataTable-sorter">Book</a>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $count = 0;
                                                @endphp
                                                @foreach ($sales as $sale)
                                                    <tr>
                                                        @php
                                                            $status = get_status($sale->status);
                                                        @endphp
                                                        <th scope="row">
                                                            <a href="#">{{$sale->reference}}</a>
                                                        </th>
                                                        <td>{{$sale->method}}</td>
                                                        <td>
                                                            ${{$sale->amount}}
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-{{$status->badge}}">{{$status->label}}</span>
                                                        </td>
                                                        <td>
                                                            {{get_user($sale->user_id)->name}}
                                                        </td>
                                                        <td>
                                                            {{get_book($sale->book_id)->title}}
                                                        </td>
                                                    </tr>
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
