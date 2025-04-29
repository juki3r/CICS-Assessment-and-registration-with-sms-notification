<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verify phone number') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-center">
                        {{-- STUDENT DASHBOARD --}}
                        @if(Auth::user()->role == "student")
                        <div class="">
                            <h2 class="text-2xl font-bold mb-4 text-center">Verify OTP</h2>
                        
                            @if (session('message'))
                                <div class="mb-4 text-green-600 font-semibold">
                                    {{ session('message') }}
                                </div>
                            @elseif (session('error'))
                            <div class="mb-4 text-danger font-semibold">
                                {{ session('error') }}
                            </div>
                            @endif
                        
                            <form method="POST" action="{{route('go.verify')}}">
                                @csrf
                        
                                <div class="mb-4">
                                    <label for="otp" class="block font-semibold">Enter OTP</label>
                                    <input type="text" name="otp" id="otp" maxlength="6"
                                           class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring"
                                           required autofocus placeholder="Enter OTP">
                                </div>
                        
                                <button type="submit"
                                        class="w-full bg-primary text-white py-2 rounded hover:bg-blue-700 transition">
                                    Verify
                                </button>
                            </form>
                        
                            <form method="POST" action="" class="mt-4 text-center">
                                @csrf
                                <button type="submit" class="text-blue-500 hover:underline">
                                    Resend OTP
                                </button>
                            </form>
                        </div>
                            

                        @elseif(Auth::user()->role == "instructor")
                        
                        @elseif(Auth::user()->role == "admin")
                        
                        @endif
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
