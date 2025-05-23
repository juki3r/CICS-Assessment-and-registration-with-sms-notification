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
                        <h1 class="fs-2 fw-bold mb-5">Exam Result</h1>
                        <p class="fs-3 mb-3"><strong>Score:</strong> {{ $score }} out of {{ $total }}</p>
                    
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to dashboard</a>
                    </div
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



>