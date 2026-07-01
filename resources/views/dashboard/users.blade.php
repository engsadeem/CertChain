@extends('layouts.main-dashboard')

@section('title', 'CertChain - Users')
@section('page-title', 'Users')
@section('page-subtitle', 'Manage registered users and their access roles')

@section('style')
.pending-section{margin-top:18px;}
.pending-title{font-size:13px;font-weight:700;color:var(--text-1);margin-bottom:10px;display:flex;align-items:center;justify-content:space-between;}
.pending-item{background:var(--slate-50);border:1px solid var(--border);border-radius:12px;padding:14px 16px;margin-bottom:12px;display:flex;align-items:flex-start;justify-content:space-between;gap:12px;}
.pending-meta{min-width:0;}
.pending-actions{display:flex;gap:8px;}

.page-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;}
.users-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:20px;}
.role-badge{
  display:inline-flex;align-items:center;gap:5px;
  height:22px;padding:0 9px;border-radius:99px;font-size:11px;font-weight:600;
}
.role-admin{background:#EFF5FF;color:#1D4ED8;}
.role-registrar{background:#ECFDF5;color:#047857;}
.role-verifier{background:#FEF3C7;color:#B45309;}
.role-viewer{background:#F1F5F9;color:#475569;}
.user-cell{display:flex;align-items:center;gap:10px;}
.user-avatar-lg{
  width:34px;height:34px;border-radius:99px;
  background:linear-gradient(135deg,#2563EB,#6FA0F8);
  color:#fff;display:grid;place-items:center;font-weight:600;font-size:12px;flex-shrink:0;
}
.actions-cell{display:flex;gap:6px;justify-content:flex-end;align-items:center;flex-wrap:wrap;}
.actions-default{display:flex;gap:6px;justify-content:flex-end;align-items:center;flex-wrap:wrap;}
.flash-message{margin-bottom:14px;padding:11px 14px;border-radius:10px;font-size:13px;font-weight:600;}
.flash-ok{background:#ECFDF5;color:#047857;border:1px solid #A7F3D0;}
.flash-error{background:#FEF2F2;color:#B91C1C;border:1px solid #FECACA;}
.modal-overlay{
  display:none;position:fixed;inset:0;background:rgba(15,23,42,.45);
  backdrop-filter:blur(4px);z-index:100;align-items:center;justify-content:center;
}
.modal-overlay.open{display:flex;}
.modal{
  background:var(--surface);border-radius:20px;padding:32px;
  width:100%;max-width:480px;box-shadow:0 24px 64px rgba(15,23,42,.18);
}
.modal-title{font-size:17px;font-weight:600;margin-bottom:4px;}
.modal-sub{font-size:13px;color:var(--text-3);margin-bottom:24px;}
.modal-footer{display:flex;gap:10px;justify-content:flex-end;margin-top:24px;}
@endsection

@section('content')

@if(session('ok'))
  <div class="flash-message flash-ok">{{ session('ok') }}</div>
@endif

@if(session('error'))
  <div class="flash-message flash-error">{{ session('error') }}</div>
@endif

<div class="page-header">
  <div>
    <div style="font-size:13px;color:var(--text-3);">
      {{ $users->count() }} user{{ $users->count() !== 1 ? 's' : '' }} registered
    </div>
  </div>
  <button type="button" class="btn btn-primary" onclick="document.getElementById('add-user-modal').classList.add('open')">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
    Add User
  </button>
</div>

<!-- STAT CARDS -->
<div class="users-stats">
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon" style="background:var(--blue-50);color:var(--blue-600);">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="8" r="3.5"/><path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6"/><circle cx="17" cy="9" r="2.5"/><path d="M21 19.5c0-2.5-1.7-4.5-4-5"/></svg>
      </div>
    </div>
    <div class="stat-label">Total Users</div>
    <div class="stat-value">{{ $users->count() }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon" style="background:#EFF5FF;color:#1D4ED8;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l2 7h7l-6 4 2 7-5-4-5 4 2-7-6-4h7z"/></svg>
      </div>
    </div>
    <div class="stat-label">Admins</div>
    <div class="stat-value">{{ $users->where('role', 'admin')->count() }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon" style="background:var(--emerald-50);color:var(--emerald-600);">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l8 3v6c0 4.5-3.4 8-8 9-4.6-1-8-4.5-8-9V6l8-3z"/><path d="M9 12l2 2 4-4"/></svg>
      </div>
    </div>
    <div class="stat-label">Registrars</div>
    <div class="stat-value">{{ $users->where('role', 'registrar')->count() }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon" style="background:var(--slate-100);color:var(--slate-600);">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
      </div>
    </div>
    <div class="stat-label">This Month</div>
    <div class="stat-value">{{ $usersThisMonth }}</div>
  </div>
</div>

@if(isset($pendingRoleRequests) && $pendingRoleRequests->count())
<div class="pending-section">
  <div class="pending-title">
    <span>Pending verifier approvals</span>
    <span style="font-size:12px;color:var(--text-3);font-weight:600;">{{ $pendingRoleRequests->count() }} request(s)</span>
  </div>

  @foreach($pendingRoleRequests as $r)
    <div class="pending-item">
      <div class="pending-meta">
        <div style="font-weight:700;font-size:13px;">{{ $r->user->name }}</div>
        <div style="font-size:12px;color:var(--text-3);margin-top:3px;">{{ $r->user->email }}</div>
        <div style="font-size:12px;color:var(--text-4);margin-top:3px;">Created: {{ $r->created_at?->diffForHumans() }}</div>
      </div>
      <div class="pending-actions">
        <form method="POST" action="{{ route('dashboard.admin.role-requests.accept', $r->id) }}" onsubmit="return confirm('Approve verifier access for {{ addslashes($r->user->name) }}?');">
          @csrf
          <button type="submit" class="btn btn-primary btn-sm">Accept</button>
        </form>
        <form method="POST" action="{{ route('dashboard.admin.role-requests.reject', $r->id) }}" onsubmit="return confirm('Reject verifier access request for {{ addslashes($r->user->name) }}?');">
          @csrf
          <button type="submit" class="btn btn-danger btn-sm">Reject</button>
        </form>
      </div>
    </div>
  @endforeach
</div>
@endif

<!-- USERS TABLE -->
<div class="card table-card">
  <div class="table-head-row">
    <div>
      <div class="card-title">All Users</div>
      <div class="card-sub">Registered accounts and their permissions</div>
    </div>
    <div style="display:flex;gap:8px;">
      <button class="btn btn-ghost btn-sm">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 5h18l-7 9v6l-4-2v-4L3 5z"/></svg>
        Filter
      </button>
    </div>
  </div>
  <table>
    <thead>
      <tr>
        <th>User</th>
        <th>Email</th>
        <th>Role</th>
        <th>Joined</th>
        <th>Status</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $user)
      <tr>
        <td>
          <div class="user-cell">
            <div class="user-avatar-lg">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
            <div>
              <div style="font-weight:600;font-size:13px;">{{ $user->name }}</div>
            </div>
          </div>
        </td>
        <td style="color:var(--text-2);font-size:13px;">{{ $user->email }}</td>
        <td>
          <span class="role-badge role-{{ $user->role ?? 'viewer' }}">
            {{ ucfirst($user->role ?? 'viewer') }}
          </span>
        </td>
        <td style="color:var(--text-3);font-size:13px;">{{ $user->created_at->format('M d, Y') }}</td>
        <td>
          @if(($user->is_active ?? true))
            <span class="badge badge-success">
              <span class="badge-dot"></span>Active
            </span>
          @else
            <span class="badge badge-warning">
              <span class="badge-dot"></span>Pending
            </span>
          @endif
        </td>
        <td>
          <div class="actions-cell">
            @php
              $pendingReq = isset($pendingRoleRequests)
                ? $pendingRoleRequests->firstWhere('user_id', $user->id)
                : null;
            @endphp

            <div class="actions-default" id="actions-default-{{ $user->id }}">
              @if(auth()->check() && auth()->user()->role === 'admin' && $pendingReq && !($user->is_active ?? true))
                <form method="POST" action="{{ route('dashboard.admin.role-requests.accept', $pendingReq->id) }}" style="margin:0;" onsubmit="return confirm('Approve verifier access for {{ addslashes($user->name) }}?');">
                  @csrf
                  <button type="submit" class="btn btn-primary btn-sm">Accept</button>
                </form>
                <form method="POST" action="{{ route('dashboard.admin.role-requests.reject', $pendingReq->id) }}" style="margin:0;" onsubmit="return confirm('Reject verifier access request for {{ addslashes($user->name) }}?');">
                  @csrf
                  <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                </form>
              @endif

              @if(auth()->check() && auth()->user()->role === 'admin' && $user->id !== auth()->id())
                <button
                  type="button"
                  class="btn btn-secondary btn-sm"
                  onclick="openEditUserModal(this)"
                  data-update-url="{{ route('dashboard.users.update', $user->id) }}"
                  data-name="{{ e($user->name) }}"
                  data-email="{{ e($user->email) }}"
                  data-role="{{ e($user->role ?? 'viewer') }}"
                  data-active="{{ (int) (bool) ($user->is_active ?? true) }}"
                >Edit</button>
                <form method="POST" action="{{ route('dashboard.users.destroy', $user->id) }}" style="margin:0;" onsubmit="return confirm('Delete user account for {{ addslashes($user->name) }}? This action cannot be undone.')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                </form>
              @endif
            </div>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" style="text-align:center;padding:40px;color:var(--text-3);">
          No users found.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- ADD USER MODAL -->
<div class="modal-overlay" id="add-user-modal" onclick="if(event.target===this)this.classList.remove('open')">
  <form class="modal" method="POST" action="{{ route('dashboard.users.store') }}" role="dialog" aria-modal="true" aria-labelledby="add-user-title">
    @csrf
    <div class="modal-title" id="add-user-title">Add new user</div>
    <div class="modal-sub">Create an account and assign a role</div>

    <div class="grid-2">
      <div class="field">
        <label class="field-label">Full Name</label>
        <input class="input" name="name" placeholder="John Doe" value="{{ old('name') }}"/>
      </div>
      <div class="field">
        <label class="field-label">Role</label>
        <select class="select" name="role">
          <option value="verifier" {{ old('role') === 'verifier' ? 'selected' : '' }}>Verifier</option>
          <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
      </div>
    </div>
    <div class="field">
      <label class="field-label">Email Address</label>
      <input class="input" name="email" type="email" placeholder="user@university.edu" value="{{ old('email') }}"/>
    </div>
    <div class="grid-2">
      <div class="field">
        <label class="field-label">Password</label>
        <input class="input" name="password" type="password" placeholder="••••••••"/>
      </div>
      <div class="field">
        <label class="field-label">Confirm Password</label>
        <input class="input" name="password_confirmation" type="password" placeholder="••••••••"/>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" onclick="document.getElementById('add-user-modal').classList.remove('open')">Cancel</button>
      <button type="submit" class="btn btn-primary">Create User</button>
    </div>
  </form>
</div>

<!-- EDIT USER MODAL -->
<div class="modal-overlay" id="edit-user-modal" onclick="if(event.target===this)this.classList.remove('open')">
  <form class="modal" id="edit-user-form" method="POST" action="" role="dialog" aria-modal="true" aria-labelledby="edit-user-title">
    @csrf
    @method('PUT')

    <div class="modal-title" id="edit-user-title">Edit user</div>
    <div class="modal-sub">Update account role and approval status</div>

    <div class="grid-2">
      <div class="field">
        <label class="field-label" for="edit-user-name">Full Name</label>
        <input class="input" id="edit-user-name" type="text" readonly/>
      </div>
      <div class="field">
        <label class="field-label" for="edit-user-role">Role</label>
        <select class="select" id="edit-user-role" name="role">
          <option value="admin">Admin</option>
          <option value="verifier">Verifier</option>
          <option value="registrar">Registrar</option>
          <option value="viewer">Viewer</option>
        </select>
      </div>
    </div>

    <div class="field">
      <label class="field-label" for="edit-user-email">Email Address</label>
      <input class="input" id="edit-user-email" type="email" readonly/>
    </div>

    <div class="field">
      <label class="field-label" for="edit-user-active">Status</label>
      <select class="select" id="edit-user-active" name="is_active">
        <option value="1">Active</option>
        <option value="0">Pending</option>
      </select>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" onclick="document.getElementById('edit-user-modal').classList.remove('open')">Cancel</button>
      <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>
  </form>
</div>

<script>
function openEditUserModal(button) {
  const modal = document.getElementById('edit-user-modal');
  const form = document.getElementById('edit-user-form');

  form.action = button.dataset.updateUrl;
  document.getElementById('edit-user-name').value = button.dataset.name || '';
  document.getElementById('edit-user-email').value = button.dataset.email || '';
  document.getElementById('edit-user-role').value = button.dataset.role || 'viewer';
  document.getElementById('edit-user-active').value = button.dataset.active || '0';

  modal.classList.add('open');
  document.getElementById('edit-user-role').focus();
}

document.addEventListener('keydown', event => {
  if (event.key !== 'Escape') return;
  document.querySelectorAll('.modal-overlay.open').forEach(modal => modal.classList.remove('open'));
});
</script>

@endsection
