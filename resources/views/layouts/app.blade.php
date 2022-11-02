<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Publishing House</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
    <!-- MDB -->
    {{-- <link rel="stylesheet" href="css/mdb.min.css" />
    <!-- Custom styles -->
    <link rel="stylesheet" href="css/style.css" /> --}}
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
        <style>
            .footer {
                position: fixed;
                bottom: 0;
            }
            #space {
                margin-right: 80px;
                margin-left: 80px;
            }
        </style>
</head>
<body>
      <!--Main Navigation-->
    <header>
        <!-- Intro settings -->
        <style>
        #intro {
            /* Margin to fix overlapping fixed navbar */
            margin-top: 58px;
        }
        @media (max-width: 991px) {
            #intro {
            /* Margin to fix overlapping fixed navbar */
            margin-top: 45px;
            }
        }
        </style>

        <!-- Navbar -->
        @include('layouts.navigation')
        <!-- Navbar -->
        @if (Route::is('author-home'))
            <!-- Jumbotron -->
            <div id="intro" class="p-5 text-center bg-light">
                <h1 class="mb-3 h2">Search Books</h1>
                <p class="mb-3">search books by author, date & title</p>
                <form method="GET" action="">
                    @csrf
                    <input type="text" class="form" name="search" required>
                    <button class="btn btn-primary m-2" type="submit">
                        <i class="bi bi-search"></i>
                        search
                    </button>
                </form>
            </div>
            <!-- Jumbotron -->
        @endif
    </header>
  <!--Main Navigation-->

    <!--Main layout-->
    <main class="my-5 main">
        {{$slot}}
    </main>
    <!--Main layout-->

    <!--Footer-->

    <footer class="bg-light text-lg-start" style="margin-top: auto;">
        <hr class="m-0" />

        <div class="text-center py-4 align-items-center">
            <p>Online Publishing House</p>
            <a href="#" class="btn btn-primary m-1" role="button" rel="nofollow" target="_blank">
                <i class="fab fa-youtube"></i>
            </a>
            <a href="#" class="btn btn-primary m-1" role="button" rel="nofollow" target="_blank">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="btn btn-primary m-1" role="button" rel="nofollow" target="_blank">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="btn btn-primary m-1" role="button" rel="nofollow" target="_blank">
                <i class="fab fa-github"></i>
            </a>
        </div>

            <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2020 Copyright:
            <a class="text-dark" href="https://faraimunashe.me">Faraimunashe</a>
        </div>
            <!-- Copyright -->
    </footer>
    <!--Footer-->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js')}}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js')}}"></script>
</body>
</html>
