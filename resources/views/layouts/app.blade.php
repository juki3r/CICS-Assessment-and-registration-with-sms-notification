<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NISU</title>
    <link rel="shortcut icon" href="{{asset('logo.png')}}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/css/app.css')
</head>
<style>
    body{
        background-color: #f2f2f2;
    }

    .send_sms:hover{
        color: lime;
    }

    .main_wrapper{
        height: 87vh;
    }

    .custom-toggler {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        background: transparent;
        padding: 0.5rem;
        }

        .custom-toggler:focus {
        outline: none !important;
        box-shadow: none !important;
        }

        .toggler-icon {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 24px;
        height: 18px;
        }

        .toggler-icon span {
        height: 3px;
        width: 100%;
        background-color: #000; /* Change this to white or your theme color */
        border-radius: 2px;
        transition: all 0.3s ease-in-out;
        }

        /* Animate to X when expanded */
        .custom-toggler:not(.collapsed) .toggler-icon span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
        }
        .custom-toggler:not(.collapsed) .toggler-icon span:nth-child(2) {
        opacity: 0;
        }
        .custom-toggler:not(.collapsed) .toggler-icon span:nth-child(3) {
        transform: rotate(-45deg) translate(5px, -5px);
        }

        .navbar-nav .nav-link {
            font-size: 1.25rem; /* You can adjust size here (e.g., 1.5rem for bigger) */
            font-weight: 500;
        }
        .card {
            max-width: 600px;
            margin: 0 auto;
        }
        .main_wrapper{
            height: 87vh;
        }
        .package_row:hover{
            background-color: rgb(39, 50, 85);
            color: white;
        }
        #notify{
            background-color: red !important;
        }

</style>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 d-lg-flex ">
        @include('layouts.navigation')

        

        <!-- Page Content -->
        <main class=" w-100">
            <!-- Page Heading -->
            @isset($header)
                <header class="shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 d-flex">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            {{ $slot }}
        </main>

    </div>
</body>



