<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('message'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('message') }}
                </div>
            @elseif (session('alert_message'))
                <div class="mb-4 text-red-600 font-semibold">
                    {{ session('alert_message') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                   
                <div class="container">
                    <h1 class="fs-3 mb-3">Exam</h1>
                    <div id="timer" class="mb-4 text-red-600 font-semibold text-xl"></div>
                    <form action="{{ route('exam.submit') }}" method="POST">
                        @csrf
                        @foreach ($questions as $index => $question)
                            <div class="mb-4">
                                <p><strong>Q{{ $index + 1 }}: {{ $question->question }}</strong></p>
                                <div>
                                    <label><input type="radio" name="questions[{{ $question->id }}]" value="a" required> A. {{ $question->option_a }}</label><br>
                                    <label><input type="radio" name="questions[{{ $question->id }}]" value="b"> B. {{ $question->option_b }}</label><br>
                                    <label><input type="radio" name="questions[{{ $question->id }}]" value="c"> C. {{ $question->option_c }}</label><br>
                                    <label><input type="radio" name="questions[{{ $question->id }}]" value="d"> D. {{ $question->option_d }}</label>
                                </div>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-success">Submit Exam</button>
                    </form>
                    <script>
                        let remainingTime = 3600; // 1 hour in seconds
                        const timerDisplay = document.getElementById('timer');
                    
                        const countdown = setInterval(() => {
                            const minutes = Math.floor(remainingTime / 60);
                            const seconds = remainingTime % 60;
                            timerDisplay.textContent = `Time Left: ${minutes}:${seconds.toString().padStart(2, '0')}`;
                            
                            if (remainingTime <= 0) {
                                clearInterval(countdown);
                                alert("Time's up! Submitting exam.");
                                document.querySelector('form').submit(); // auto-submit
                            }
                    
                            remainingTime--;
                        }, 1000);
                        // Disable refresh
                        window.addEventListener("keydown", function (e) {
                            if ((e.key === "F5") || (e.ctrlKey && e.key === "r")) {
                                e.preventDefault();
                                alert("Refreshing is disabled during the exam.");
                            }
                        });

                        // Warn on close or reload
                        window.onbeforeunload = function () {
                            return "Are you sure you want to leave? Your answers will be lost.";
                        };
                    </script>
                </div>  
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
