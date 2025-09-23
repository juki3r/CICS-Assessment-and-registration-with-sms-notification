<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12 d-flex justify-content-center">
        <div class="border rounded w-75 mt-5 p-3 shadow bg-white">

            {{-- Unread Notifications --}}
            <h4>Unread Notifications</h4>
            @if($unreadNotifications->isEmpty())
                <p class="text-center text-muted">No unread notifications 🎉</p>
            @else
                <table class="table table-bordered table-striped mb-5">
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
                        @foreach($unreadNotifications as $index => $notif)
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

            {{-- Read Notifications --}}
            <h4 class="mt-4">Read Notifications</h4>
            @if($readNotifications->isEmpty())
                <p class="text-center text-muted">No read notifications yet.</p>
            @else
                <table class="table table-bordered table-striped">
                    <thead class="table-secondary">
                        <tr>
                            <th>#</th>
                            <th>Message</th>
                            <th>Faculty</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($readNotifications as $index => $notif)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $notif->action ?? 'No message' }}</td>
                                <td>{{ $notif->actor ?? '' }}</td>
                                <td>{{ $notif->created_at->format('M d, Y h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>
</x-app-layout>
