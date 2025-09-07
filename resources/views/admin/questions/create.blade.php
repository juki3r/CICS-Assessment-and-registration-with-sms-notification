<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('New Question') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h1 class="fs-3 mb-3">Add New Question</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif
                
                    <form method="POST" action="{{ route('questions.store') }}">
                        @csrf
                        @include('admin.questions.form')
                        <button type="submit" class="btn btn-success">Save</button>
                        <a href="{{ route('questions.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>          
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

