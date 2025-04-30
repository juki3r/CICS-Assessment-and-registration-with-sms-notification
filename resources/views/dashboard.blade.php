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
                    
                    <div class="flex justify-center">
                        
                        {{-- STUDENT DASHBOARD --}}
                        @if(Auth::user()->role == "student")
                            @if(Auth::user()->phone_verified == 0)
                            <div class="card p-lg-5 border-0">
                                <p class=" p-lg-5">
                                    🎉 Welcome! Congratulations on passing the general entrance exam of Northern Iloilo State University.
                                    To proceed with your enrollment, please verify your cellphone number.
                                </p>
                                <h3 class="px-lg-5 mt-5 mt-lg-0">
                                    <a href="{{route('verify.otp')}}">
                                        <button class="btn btn-primary">
                                            Verify registered number
                                        </button>
                                    </a>
                                </h3>
                            </div>
                            @elseif(Auth::user()->is_new_register == 1)
                            
                            <div class="card p-lg-5 border-0">
                                <p class=" p-lg-5">
                                    You are all set. Please wait for admin approval to start your next exam. 
                                    Please keep checking your email (.e.g spam) and phone messages because we will notify you 
                                    as soon as your account has been approved. Thanks you and have a good day.
                                </p>
                            </div>
                            @else
                                <div class="card p-lg-5 border-0">
                                    <p class=" p-lg-5">
                                        Welcome! To continue, please click start exam. Goodluck!.
                                    </p>

                                    <div class="mt-lg-5 px-lg-5 mt-5 text-center">
                                        <a href="">
                                            <div class="btn btn-primary">
                                                Start exam
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        
                        @elseif(Auth::admin()->role == "admin")
                        
                        @endif
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
