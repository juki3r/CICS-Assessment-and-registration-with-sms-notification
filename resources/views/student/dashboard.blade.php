<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exam</title>
    <link rel="shortcut icon" href="{{asset('logo.png')}}" type="image/x-icon">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/css/app.css')
</head>
<body style="display:flex; justify-content:center; height:100vh;width:100vw; flex-direction:column; align-items:center">

        <div>
            <h1 class="fs-2 mb-5">Welcome, <strong class="text-capitalize">{{$name}}</strong></h1>
            <h2 class="fs-4 mb-2 fw-bold">Exam Instructions:</h2>
            <p class="mb-3">Welcome to your exam. Please read the instructions below carefully before starting:</p>
            <ul>
                <li>1. This exam contains multiple-choice questions.</li>
                <li>2. Choose the best and correct answer.</li>
                <li>3. The exam must be completed in one sitting—you cannot pause and resume later.</li>
                <li>4. You will have [time limit] minutes to finish the exam.</li>
                <li>5. Do not refresh the page to avoid technical disqualification.</li>
            </ul>
            <p class="my-4">Click the Start Exam below when you're ready to begin. Goodluck!</p>
            <form method="POST" action="{{ route('student.logout') }}">
                @csrf
                <span>If your not ready to take the exam, just click</span>
                <button type="submit" class="text-danger ">
                    Exit.
                </button>
            </form>
        
           <a href="{{ route('exam.start', ['name' => $name]) }}" class="btn btn-primary my-4">Start exam</a>

        </div>
        
</body>
</html>



