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
                    <h1>Mathematics Exam</h1>
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
                </div>  
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
