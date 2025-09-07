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
        .nav-link{
            font-size: 22px;
        }
    </style>
</head>
<body class="d-flex flex-column vh-100 p-0">
    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
    <header class="">
        <div class="p-2 px-3">
            {{ $header }}
        </div>
    </header>
    @endisset

    <!-- Page Content -->
    <main class="flex-grow-1 p-2 px-3">
        {{ $slot }}
    </main>
    
    <!-- Sticky Footer -->
    <footer class="text-center py-2">
         &copy; NISU {{ date('Y') }}
    </footer>
</body>
</html>
