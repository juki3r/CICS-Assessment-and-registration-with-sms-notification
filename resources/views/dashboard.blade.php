<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('Dashboard') }}
        </h2>

        @if(Auth::admin()->role == "admin")
        <a href="{{route('admin.notification')}}" class="relative ms-auto text-gray-700 hover:text-gray-900 p-1">
            <!-- Bell Icon (you can use Heroicons or FontAwesome) -->
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bell-fill {{$notificationCount > 0 ? 'text-danger' : ''}}" viewBox="0 0 16 16">
                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901"/>
              </svg>
        
            <!-- Badge -->
            <span class="absolute top-0 right-0 inline-flex items-center justify-center 
                         px-1.5 text-sm font-bold leading-none 
                         transform translate-x-1/2 -translate-y-1/2 text-dark rounded-full ">
                @if($notificationCount > 0)
                    {{ $notificationCount }}
                @else()
                @endif
            </span>
        </a>
        @endif
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
