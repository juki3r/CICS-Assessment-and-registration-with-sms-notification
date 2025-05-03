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
                    @if($user_exam->exam == NULL)
                        <div class="container">
                            <h2 class="fs-3 mb-5 fw-bold">Exam Instructions</h2>
                            <p class="mb-3">Welcome to your exam. Please read the instructions below carefully before starting:</p>
                            <ul>
                                <li>1. This exam contains multiple-choice questions.</li>
                                <li>2. Choose the best answer for each question.</li>
                                <li>3. The exam must be completed in one sitting—you cannot pause and resume later.</li>
                                <li>4. Ensure you are in a quiet environment with a stable internet connection.</li>
                                <li>5. You will have [time limit] minutes to finish the exam.</li>
                            </ul>
                            <p class="my-4">Click the button below when you're ready to begin.</p>
                        
                            <a href="{{route('exam.start')}}" class="btn btn-primary my-4">Start exam </a>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
