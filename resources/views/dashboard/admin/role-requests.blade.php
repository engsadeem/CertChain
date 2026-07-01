@extends('layouts.main-dashboard')

@section('title', 'CertChain - Admin Requests')
@section('page-title', 'Role Requests (Admin)')
@section('page-subtitle', 'Accept or reject new verifier accounts')

@section('content')
<div class="card" style="padding:22px;margin-bottom:18px;">
  <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;">
    <div>
      <div style="font-size:15px;font-weight:700;">Pending Requests</div>
      <div style="font-size:12px;color:var(--text-3);margin-top:4px;">{{ $requests->count() }} request(s)</div>
    </div>
  </div>
</div>

<div class="card table-card">
  <div class="table-head-row">
    <div>
      <div class="card-title">Requests</div>
      <div class="card-sub">Verifier role will be activated only after accept</div>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th>User</th>
        <th>Email</th>
        <th>Requested Role</th>
        <th>Created</th>
        <th></th>
      </tr>
    </thead>

    <tbody>
      @forelse($requests as $r)
        <tr>
          <td style="font-weight:600;">{{ $r->user->name }}</td>
          <td style="color:var(--text-2);">{{ $r->user->email }}</td>
          <td>
            <span class="badge badge-warning">{{ $r->requested_role }}</span>
          </td>
          <td style="color:var(--text-3);">{{ $r->created_at->format('M d, Y') }}</td>
          <td>
            <div style="display:flex;gap:8px;justify-content:flex-end;">
              <form method="POST" action="{{ route('admin.role-requests.accept', $r->id) }}" onsubmit="return confirm('Approve verifier access for {{ addslashes($r->user->name) }}?');">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm">Accept</button>
              </form>
              <form method="POST" action="{{ route('admin.role-requests.reject', $r->id) }}" onsubmit="return confirm('Reject verifier access request for {{ addslashes($r->user->name) }}?');">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" style="text-align:center;padding:40px;color:var(--text-3);">No pending requests</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

@endsection
