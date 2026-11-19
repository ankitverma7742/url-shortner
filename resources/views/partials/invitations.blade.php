<h3>Pending Invitations</h3>

<table border="1" cellpadding="6">
    <tr>
        <th>Email</th>
        <th>Role</th>
        <th>Invitation Link</th>
    </tr>

    @forelse($invitations as $inv)
        <tr>
            <td>{{ $inv->email }}</td>

            <td>{{ $inv->role }}</td>

            <td>
                <input
                    type="text"
                    readonly
                    size="50"
                    value="{{ route('invitation.show', $inv->token) }}"
                    onclick="this.select()"
                >
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="3">No pending invitations</td>
        </tr>
    @endforelse
</table>