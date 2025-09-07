<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CICS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .nav-link {
            font-size: 18px !important;
            color: #000; /* or your preferred default color */
            padding-bottom: 5px;
        }

        .nav-link.active-nav {
            border-bottom: 3px solid #ffc107; /* yellow border for active */
            font-weight: bold;
            color: #ffc107 !important;
        }

    </style>
</head>
<body class="d-flex flex-column vh-100 p-0">

    <div class="d-flex justify-content-center py-3 bg-dark text-light shadow">
        <div class="pe-4 text-center">
            <img src="{{asset('logo.png')}}" alt="" width="100px">
        </div>
        <div class="">
            <h6 class="text-center">Republic of the Philippines</h6>
            <h3 class="fs-3 text-center">
                NORTHERN ILOILO STATE UNIVERSITY
            </h3>
            <h6 class="text-center" style="font-weight: light !important">
                NISU Main Campus, V Cudilla Sr. Ave, Estancia, Iloilo
            </h6>
        </div>
        <div class="ps-4 text-center">
           <img src="{{asset('cics.png')}}" alt="" width="100px">
        </div>
    </div>




    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
    {{-- <header class="">
        <div class="p-2 px-3">
            {{ $header }}
        </div>
    </header> --}}
    @endisset

    <!-- Page Content -->
    <main class="flex-grow-1 p-2 px-3 ">
        {{ $slot }}
    </main>
    
    <!-- Sticky Footer -->
    <footer class="text-center py-2">
         &copy; NISU {{ date('Y') }}
    </footer>
</body>
</html>
