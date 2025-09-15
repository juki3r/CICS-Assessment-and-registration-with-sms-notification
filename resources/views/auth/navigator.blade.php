<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class= "d-flex justify-content-center flex-column px-5">
        <a href="/admin/login" class="btn btn-md mb-3 fs-4" style="background-color: rgb(187, 161, 13)">Administrator</a>
        <a href="/subadmin/login" class="btn btn-md mb-3 fs-4" style="background-color: rgb(187, 161, 13)">Faculty</a>
        <a href="/login" class="btn btn-md  mb-3 fs-4" style="background-color: rgb(187, 161, 13)">Student</a>
    </div>
   
</x-guest-layout>
