<div class=""> 
    <!-- Sidebar / Navbar -->
    <nav class=" bg-black text-light  flex-column align-items-center  h-100 d-none d-lg-flex px-3">
        
        @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->role == "admin")
            <a href="{{ route('admin.dashboard') }}" >
                <img src="{{ asset('logo.png') }}" alt="" style="width:120px;">
            </a>
        @else
            <a href="{{ route('dashboard') }}" >
                <img src="{{ asset('logo.png') }}" alt="" style="width:120px;">
            </a>
        @endif

       

        @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->role == "admin")
            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="my-2 text-light mt-5">
                {{ __('Dashboard') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.user')" class="my-2 text-light">
                {{ __('User Account') }}
            </x-nav-link>
            <x-nav-link :href="route('entrance_exam')" :active="request()->routeIs('entrance_exam')" class="my-2 text-light">
                {{ __('Registration') }}
            </x-nav-link>
            <x-nav-link :href="route('students', ['course' => 'bsit'])" :active="request()->routeIs('students') && in_array(request()->route('course'), ['bsit', 'bscs', 'blis'])" class="my-2 text-light">
                {{ __('Students') }}
            </x-nav-link>
            <x-nav-link :href="route('exam_results', ['course' => 'bsit'])" :active="request()->routeIs('exam_results') && in_array(request()->route('course'), ['bsit', 'bscs', 'blis'])" class="my-2 text-light">
                {{ __('Exam Results') }}
            </x-nav-link>
            
            <x-nav-link :href="route('show.questions')" :active="request()->routeIs('show.questions')" class="my-2 text-light">
                {{ __('Questionaire') }}
            </x-nav-link>
        @else
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="my-2 text-light mt-5">
                {{ __('Dashboard') }}
            </x-nav-link>

        @endif


  
    </nav>
    <nav class="navbar navbar-expand-lg bg-body-tertiary d-block d-lg-none p-3">
        <div class="container-fluid">
            <a href="{{ route('dashboard') }}" >
                <img src="{{asset('logo.png')}}" alt="logo" class="" style="width:80px">
            </a>
            <button class="navbar-toggler custom-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <div class="toggler-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

              
          <div class="collapse navbar-collapse text-center mt-3" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-dark text-center">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="my-2">
                    {{ __('Dashboard') }}
                </x-nav-link>
            </ul>

          </div>
        </div>
      </nav>
    </div>