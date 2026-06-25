@extends('layouts.app')

@section('title', 'Studio Members — ' . $studio->name)

@section('content')
<style>
    /* ... all your styles ... */
</style>

<div class="members-page">
    <!-- ... all your HTML content ... -->
</div>

{{-- Add Member Modal --}}
<div class="modal-backdrop" id="addMemberModal" onclick="handleModalClick(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 class="modal-title">Add Team Member</h3>
            <button class="modal-close" onclick="closeAddMemberModal()">✕</button>
        </div>

        <form method="POST" action="{{ route('studios.members.add', $studio) }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-input"
                    placeholder="teammate@email.com" required>
                <p style="font-size:0.7rem;color:var(--slate-mid);margin-top:4px;">
                    The user must have a creator profile to be added.
                </p>
            </div>

            <div class="form-group">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="member">Member</option>
                    <option value="admin">Admin</option>
                </select>
                <p style="font-size:0.7rem;color:var(--slate-mid);margin-top:4px;">
                    Admins can manage studio settings and members.
                </p>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-cancel" onclick="closeAddMemberModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Member</button>
            </div>
        </form>
    </div>
</div>

{{-- Change Role Modal --}}
<div class="modal-backdrop" id="changeRoleModal" onclick="handleModalClick(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 class="modal-title">Change Member Role</h3>
            <button class="modal-close" onclick="closeChangeRoleModal()">✕</button>
        </div>

        <form id="changeRoleForm" method="POST" action="">
            @csrf
            <div class="form-group">
                <label class="form-label">New Role</label>
                <select name="role" class="form-select" required>
                    <option value="member">Member</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-cancel" onclick="closeChangeRoleModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Update Role</button>
            </div>
        </form>
    </div>
</div>

{{-- Remove Member Form --}}
<form id="removeMemberForm" method="POST" action="" style="display:none;">
    @csrf
</form>

<script>
    // Store base URLs with placeholders
    const changeRoleBaseUrl = '{{ route("studios.members.role", ["studio" => $studio, "userId" => "__USER_ID__"]) }}';
    const removeMemberBaseUrl = '{{ route("studios.members.remove", ["studio" => $studio, "userId" => "__USER_ID__"]) }}';

    function openAddMemberModal() {
        document.getElementById('addMemberModal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeAddMemberModal() {
        document.getElementById('addMemberModal').classList.remove('open');
        document.body.style.overflow = '';
    }

    function openChangeRoleModal(userId, currentRole) {
        const modal = document.getElementById('changeRoleModal');
        const form = document.getElementById('changeRoleForm');
        const select = form.querySelector('select[name="role"]');

        // Replace placeholder with actual userId
        form.action = changeRoleBaseUrl.replace('__USER_ID__', userId);
        select.value = currentRole;

        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeChangeRoleModal() {
        document.getElementById('changeRoleModal').classList.remove('open');
        document.body.style.overflow = '';
    }

    function confirmRemoveMember(userId) {
        if (confirm('Are you sure you want to remove this member from the studio?')) {
            const form = document.getElementById('removeMemberForm');
            form.action = removeMemberBaseUrl.replace('__USER_ID__', userId);
            form.submit();
        }
    }

    function handleModalClick(e) {
        if (e.target === e.currentTarget) {
            closeAddMemberModal();
            closeChangeRoleModal();
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAddMemberModal();
            closeChangeRoleModal();
        }
    });
</script>

@endsection