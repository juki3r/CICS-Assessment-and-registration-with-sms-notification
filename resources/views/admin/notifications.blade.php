<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12 d-flex justify-content-center">
        <div class="border rounded w-75 mt-5 p-3 shadow bg-white">
            
            @if($notifications->isEmpty())
                <p class="text-center text-muted">No unread notifications 🎉</p>
            @else
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Message</th>
                            <th>Faculty</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notifications as $index => $notif)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $notif->action ?? 'No message' }}</td>
                                <td>{{ $notif->actor ?? '' }}</td>
                                <td>{{ $notif->created_at->format('M d, Y h:i A') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.notifications.markRead', $notif->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            Mark as Read
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>
</x-app-layout>
