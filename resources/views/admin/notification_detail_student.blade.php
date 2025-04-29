<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('Notification details') }}
        </h2>
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
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('message'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('message') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container py-4">
                        <div class="card shadow-sm p-4">
                            <div class="row">
                                <!-- Left: Profile Image -->
                                <div class="col-md-4 text-center">
                                    <img src="{{ asset('storage/' . $user->image) }}" class="img-fluid rounded-circle mb-3" style="width: 180px; height: 180px; object-fit: cover;" alt="User Photo">
                                    <h4 class="fw-bold text-capitalize">{{ $user->fullname }}</h4>
                                    <p class="text-muted uppercase">{{ $user->course }}</p>
                                </div>
                    
                                <!-- Right: Personal Information -->
                                <div class="col-md-8">
                                    <h5 class="mb-3 fs-4">Personal Information</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <th class="text-muted">Full Name:</th>
                                            <td>{{ $user->fullname }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Age:</th>
                                            <td>{{ $user->age }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Address:</th>
                                            <td>{{ $user->address }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Phone:</th>
                                            <td>{{ $user->phone_number }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Email:</th>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                    </table>
                    
                                    <!-- Action Buttons -->
                                    @if($user->is_new_register == 1)
                                    <div class="mt-4 d-flex gap-2">
                                        <form action="{{route('approve.student', $user->id)}}" method="POST">
                                            @csrf
                                            <button class="btn btn-success">✅ Approve</button>
                                        </form>
                                        <form action="{{route('deny.student', $user->id)}}" method="POST">
                                            @csrf
                                            <button class="btn btn-danger">❌ Deny</button>
                                        </form>
                                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">↩️ Cancel</a>
                                    </div>
                                    @else
                                    <div class="mt-4 d-flex gap-2 flex-column">
                                        <h4 class="text-center mb-4">✅ Approved</h4>
                                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">↩️ Back</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
