<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam</title>
    <link rel="shortcut icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/css/app.css')

    <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden; /* 🚫 Prevent scrolling */
            background-color: #f8f9fa;
        }

        .exam-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 15px 30px;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
        }

        .exam-body {
            display: flex;
            justify-content: center;  
            align-items: center;      
            height: calc(100vh - 130px); /* Viewport minus header+footer */
            margin-top: 70px; /* push below header */
            padding: 20px;
            text-align: center;
            overflow: hidden; /* 🚫 no scroll */
        }

        .exam-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #fff;
            border-top: 1px solid #ddd;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between; /* prev left / next right */
            align-items: center;
            z-index: 1000;
        }

        .question-container {
            max-width: 700px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="exam-header">
        <h2 class="m-0 fw-bold">EXAM , {{$fullname}}</h2>
        <span id="timer" class="text-danger fw-bold fs-4"></span>
    </div>

    <!-- Exam Body -->
    <div class="exam-body">
        <form action="{{ route('exam.submit', ['name' => $fullname]) }}" method="POST" id="examForm" class="w-100 d-flex flex-column align-items-center">
            @csrf
            @foreach ($questions as $index => $question)
                <div class="question-container text-center" id="question-{{ $index }}" style="{{ $index === 0 ? '' : 'display:none;' }}">
                    <p class="fs-4 fw-semibold">Question {{ $index + 1 }}</p>
                    <p class="fs-5 mt-3">{{ $question->question }}</p>

                    <!-- Display image if available -->
                    @if (!empty($question->image))
                        <div class="my-3">
                            <img src="{{ asset('storage/' . $question->image) }}" alt="Question Image" class="img-fluid" style="max-height:250px;">
                        </div>
                    @endif

                    <!-- Options -->
                    <div class="mt-4 text-start d-inline-block">
                        <label class="mb-2 d-block">
                            <input type="radio" name="questions[{{ $question->id }}]" value="a" required> 
                            A. {{ $question->option_a }}
                        </label>
                        <label class="mb-2 d-block">
                            <input type="radio" name="questions[{{ $question->id }}]" value="b"> 
                            B. {{ $question->option_b }}
                        </label>
                        <label class="mb-2 d-block">
                            <input type="radio" name="questions[{{ $question->id }}]" value="c"> 
                            C. {{ $question->option_c }}
                        </label>
                        <label class="mb-2 d-block">
                            <input type="radio" name="questions[{{ $question->id }}]" value="d"> 
                            D. {{ $question->option_d }}
                        </label>
                        @if (!empty($question->option_e))
                            <label class="mb-2 d-block">
                                <input type="radio" name="questions[{{ $question->id }}]" value="e"> 
                                E. {{ $question->option_e }}
                            </label>
                        @endif
                    </div>
                </div>
            @endforeach

        </form>
    </div>

    <!-- Navigation -->
    <div class="exam-footer">
        <button type="button" class="btn btn-secondary prev-btn" style="display:none;">Previous</button>
        <div>
            <button type="button" class="btn btn-primary next-btn">Next</button>
            <button type="submit" form="examForm" class="btn btn-success submit-btn" style="display:none;">Submit Exam</button>
        </div>
    </div>

    <script>
        // Timer
        let remainingTime = 3600; // 1 hour
        const timerDisplay = document.getElementById('timer');
        const countdown = setInterval(() => {
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
            timerDisplay.textContent = `Time Left: ${minutes}:${seconds.toString().padStart(2, '0')}`;
            if (remainingTime <= 0) {
                clearInterval(countdown);
                alert("Time's up! Submitting exam.");
                document.getElementById('examForm').submit();
            }
            remainingTime--;
        }, 1000);

        // Navigation
        const questions = document.querySelectorAll('.question-container');
        let current = 0;
        const prevBtn = document.querySelector('.prev-btn');
        const nextBtn = document.querySelector('.next-btn');
        const submitBtn = document.querySelector('.submit-btn');
        const examForm = document.getElementById('examForm');

        function showQuestion(index) {
            questions.forEach((q, i) => q.style.display = (i === index) ? 'block' : 'none');
            prevBtn.style.display = index > 0 ? 'inline-block' : 'none';
            nextBtn.style.display = index < questions.length - 1 ? 'inline-block' : 'none';
            submitBtn.style.display = index === questions.length - 1 ? 'inline-block' : 'none';
        }

        // ✅ Check if user selected an answer before moving to next
        function hasAnswer(index) {
            const radios = questions[index].querySelectorAll('input[type="radio"]');
            return Array.from(radios).some(r => r.checked);
        }

        nextBtn.addEventListener('click', () => {
            if (!hasAnswer(current)) {
                alert("⚠️ Please select an answer before proceeding.");
                return;
            }
            if (current < questions.length - 1) current++;
            showQuestion(current);
        });

        prevBtn.addEventListener('click', () => {
            if (current > 0) current--;
            showQuestion(current);
        });

        showQuestion(current);

        // Disable refresh
        window.addEventListener("keydown", function (e) {
            if ((e.key === "F5") || (e.ctrlKey && e.key === "r")) {
                e.preventDefault();
                alert("Refreshing is disabled during the exam.");
            }
        });

        submitBtn.addEventListener('click', (e) => {
            e.preventDefault(); // prevent default submission
            const confirmSubmit = confirm(
                "Are you sure you want to submit? Once you do, your answers will be saved."
            );
            if (confirmSubmit) {
                // Disable the leave warning
                window.onbeforeunload = null;
                examForm.submit(); // submit the form
            }
        });
    </script>
</body>
</html>
