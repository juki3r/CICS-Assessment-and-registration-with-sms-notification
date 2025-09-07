<div class="row w-100 py-2 shadow bg-dark text-light">
        {{-- LOGO --}}
        <div class="col-1 d-flex justify-content-center ">
           <img src="{{ asset('cics.png') }}" alt="Logo" style="width:100px">
        </div>
        {{-- NAV --}}
        <div class="col d-flex align-items-center">
           <a href="{{route('admin.dashboard')}}" :active="request()->routeIs('admin.dashboard')" class="nav-link mx-3">
                Dashboard
           </a>
           <a href="{{route('admin.users')}}" class="nav-link mx-3">
                User accounts
           </a>
           <a href="{{route('admin.registrations')}}" class="nav-link mx-3">
                Registration
           </a>
           <a href="{{route('admin.interview')}}" class="nav-link mx-3">
                Interview
           </a>
           <a href="{{route('show.questions')}}" class="nav-link mx-3">
                Test Questionaires
           </a>
           <a href="{{route('show.questions')}}" class="nav-link mx-3">
                Reports
           </a>
           <a href="{{route('show.questions')}}" class="nav-link mx-3">
                Sms Logs
           </a>
           <a href="" class="m-auto me-0 text-warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901"/>
            </svg>
           </a>
        </div>

        {{-- USER --}}
           <div class="col-1 d-flex justify-content-center align-items-center">
            <a href=""  class="text-light">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>
            </a>
           </div>
       </div>