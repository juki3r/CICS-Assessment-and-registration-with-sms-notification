<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Message</th>
            <th>Category</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($notifications as $notification)
            <tr 
                onclick="window.location='{{ route('admin.notification.show', ['id'=>$notification->id, 'category'=> $notification->category, 'user_id'=>$notification->user_id]) }}'" 
                style="cursor: pointer;"
                onmouseover="this.style.backgroundColor='#dbeafe';" 
                onmouseout="this.style.backgroundColor='';"
            >
                <td>{{ $notification->message }}</td>
                <td>{{ $notification->category }}</td>
                <td>{{ $notification->created_at->format('M d, Y H:i') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">No notifications found</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Pagination links -->
{{ $notifications->links('pagination::bootstrap-5') }}
