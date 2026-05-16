@extends('layouts.app')

@section('title', 'Staff')
@section('page-title', 'Manage Staff')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-error">
        <ul style="margin:0;padding-left:1.2rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="data-card">
    <h3>Add New Staff</h3>
    <form action="{{ route('admin.staff.add') }}" method="POST" autocomplete="off" style="display: grid; gap: 1rem; max-width: 500px;">
        @csrf
        <div>
            <label style="display: block; color: #420C09; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Name</label>
            <input type="text" name="name" required style="width: 100%; padding: 12px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 10px; color: #222; font-size: 0.95rem; transition: all 0.3s ease;">
        </div>
        <div>
            <label style="display: block; color: #420C09; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Username</label>
            <input type="text" name="username" required style="width: 100%; padding: 12px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 10px; color: #222; font-size: 0.95rem; transition: all 0.3s ease;">
        </div>
        <div>
            <label style="display: block; color: #420C09; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Email</label>
            <input type="email" name="email" required style="width: 100%; padding: 12px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 10px; color: #222; font-size: 0.95rem; transition: all 0.3s ease;">
        </div>
        <div>
            <label style="display: block; color: #420C09; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Password</label>
            <div style="position: relative;">
                <input type="password" id="staff_password" name="password" required minlength="6" style="width: 100%; padding: 12px 45px 12px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 10px; color: #222; font-size: 0.95rem; transition: all 0.3s ease;">
                <img src="{{ asset('images/icons/show_password.png') }}" id="toggle-staff-icon" onclick="togglePassword('staff_password', 'toggle-staff-icon')" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; opacity: 0.6; width: 20px;">
            </div>
        </div>
        <div>
            <label style="display: block; color: #420C09; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Confirm Password</label>
            <div style="position: relative;">
                <input type="password" id="staff_password_confirm" name="password_confirmation" required minlength="6" style="width: 100%; padding: 12px 45px 12px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 10px; color: #222; font-size: 0.95rem; transition: all 0.3s ease;">
                <img src="{{ asset('images/icons/show_password.png') }}" id="toggle-staff-icon-confirm" onclick="togglePassword('staff_password_confirm', 'toggle-staff-icon-confirm')" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; opacity: 0.6; width: 20px;">
            </div>
        </div>

        <div>
            <label style="display: block; color: #420C09; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Phone</label>
            <div style="display: flex; align-items: center; gap: 0;">
                <span style="padding: 12px 10px 12px 15px; background: #e0e0e0; border: 1px solid #ddd; border-right: none; border-radius: 10px 0 0 10px; color: #555; font-size: 0.95rem; font-weight: 600;">+60</span>
                <input type="tel" name="phone" maxlength="10" style="flex: 1; padding: 12px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 0 10px 10px 0; color: #222; font-size: 0.95rem; transition: all 0.3s ease;" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>
        </div>
        <button type="submit" style="padding: 12px 24px; background: #420C09; color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 700; font-size: 1rem;">Add Staff</button>
    </form>
</div>

<div class="data-card" style="margin-top: 2rem;">
    <h3>Staff Members</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staff as $s)
            <tr>
                <td>{{ $s['name'] }}</td>
                <td>{{ $s['username'] }}</td>
                <td>{{ $s['email'] }}</td>
                <td><span class="badge badge-{{ $s['role'] }}">{{ ucfirst($s['role']) }}</span></td>
                <td>{{ $s['phone'] }}</td>
                <td><span class="badge badge-{{ strtolower($s['status']) }}">{{ $s['status'] }}</span></td>
                <td>
                    <button onclick="openEditStaffModal('{{ $s['id'] }}')" style="background: #ffc107; color: #222; border: none; padding: 5px 10px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; margin-right: 4px;">Edit</button>
                    <form action="{{ route('admin.staff.delete', $s['id']) }}" method="POST" onsubmit="return confirm('Delete this staff?');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="data-card" style="margin-top: 2rem;">
    <h3>Sync Database</h3>
    <p>After adding/removing staff, run this command to sync with your friend:</p>
    <code style="display: block; background: #f4f4f4; padding: 10px; margin: 10px 0;">php artisan db:sync</code>
</div>

<div id="editStaffModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: #fff; padding: 24px; border-radius: 12px; width: 90%; max-width: 420px; border: 2px solid #420C09; max-height: 90vh; overflow-y: auto;">
        <h3 style="margin-bottom: 16px; color: #420C09;">Edit Staff</h3>
        <form id="editStaffForm" onsubmit="submitEditStaff(event)" autocomplete="off" style="display: grid; gap: 1rem;">
            <input type="hidden" id="editStaffId" name="id">
            <div>
                <label style="display: block; color: #420C09; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Name</label>
                <input type="text" id="editStaffName" name="name" required style="width: 100%; padding: 12px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 10px; color: #222; font-size: 0.95rem;">
            </div>
            <div>
                <label style="display: block; color: #420C09; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Username</label>
                <input type="text" id="editStaffUsername" name="username" required style="width: 100%; padding: 12px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 10px; color: #222; font-size: 0.95rem;">
            </div>
            <div>
                <label style="display: block; color: #420C09; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Email</label>
                <input type="email" id="editStaffEmail" name="email" required style="width: 100%; padding: 12px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 10px; color: #222; font-size: 0.95rem;">
            </div>
            <div>
                <label style="display: block; color: #420C09; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Phone</label>
                <div style="display: flex; align-items: center; gap: 0;">
                    <span style="padding: 12px 10px 12px 15px; background: #e0e0e0; border: 1px solid #ddd; border-right: none; border-radius: 10px 0 0 10px; color: #555; font-size: 0.95rem; font-weight: 600;">+60</span>
                    <input type="tel" id="editStaffPhone" name="phone" maxlength="10" style="flex: 1; padding: 12px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 0 10px 10px 0; color: #222; font-size: 0.95rem;" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
            </div>
            <div>
                <label style="display: block; color: #420C09; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Status</label>
                <select id="editStaffStatus" name="status" style="width: 100%; padding: 12px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 10px; color: #222; font-size: 0.95rem;">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div>
                <label style="display: block; color: #420C09; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">New Password <span style="font-weight: 400; color: #888; font-size: 0.8rem;">(leave blank to keep current)</span></label>
                <div style="position: relative;">
                    <input type="password" id="editStaffPassword" name="password" minlength="6" style="width: 100%; padding: 12px 45px 12px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 10px; color: #222; font-size: 0.95rem;">
                    <img src="{{ asset('images/icons/show_password.png') }}" id="toggle-edit-staff-icon" onclick="togglePassword('editStaffPassword', 'toggle-edit-staff-icon')" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; opacity: 0.6; width: 20px;">
                </div>
            </div>
            <div>
                <label style="display: block; color: #420C09; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Confirm New Password</label>
                <div style="position: relative;">
                    <input type="password" id="editStaffPasswordConfirm" name="password_confirmation" style="width: 100%; padding: 12px 45px 12px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 10px; color: #222; font-size: 0.95rem;">
                    <img src="{{ asset('images/icons/show_password.png') }}" id="toggle-edit-staff-icon-confirm" onclick="togglePassword('editStaffPasswordConfirm', 'toggle-edit-staff-icon-confirm')" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; opacity: 0.6; width: 20px;">
                </div>
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="closeEditStaffModal()" style="flex: 1; padding: 12px; background: #f0f0f0; color: #222; border: 1px solid #ddd; border-radius: 10px; cursor: pointer; font-weight: 600;">Cancel</button>
                <button type="submit" style="flex: 1; padding: 12px; background: #420C09; color: #fff; border: none; border-radius: 10px; cursor: pointer; font-weight: 700;">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(inputId, iconId) {
    var input = document.getElementById(inputId);
    var icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.src = "{{ asset('images/icons/hide_password.png') }}";
    } else {
        input.type = 'password';
        icon.src = "{{ asset('images/icons/show_password.png') }}";
    }
}

document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
    document.querySelector('form[action="{{ route('admin.staff.add') }}"]')?.reset();
    @endif
});

function openEditStaffModal(id) {
    const parts = id.split('_');
    const type = parts[0];
    const realId = parts.slice(1).join('_');

    document.getElementById('editStaffId').value = id;

    fetch(`/admin/staff/${id}/edit`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('editStaffName').value = data.name;
            document.getElementById('editStaffUsername').value = data.username;
            document.getElementById('editStaffEmail').value = data.email;
            const phone = data.phone ? data.phone.replace(/^\+60/, '') : '';
            document.getElementById('editStaffPhone').value = phone;
            document.getElementById('editStaffStatus').value = data.status.toLowerCase();
            document.getElementById('editStaffModal').style.display = 'flex';
        })
        .catch(() => alert('Failed to load staff data.'));
}

function closeEditStaffModal() {
    document.getElementById('editStaffModal').style.display = 'none';
    document.getElementById('editStaffForm').reset();
}

function submitEditStaff(e) {
    e.preventDefault();
    const id = document.getElementById('editStaffId').value;
    const form = e.target;
    const data = new FormData(form);

    fetch(`/admin/staff/${id}/update`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: data
    })
    .then(res => {
        if (res.redirected) {
            window.location.href = res.url;
        } else {
            res.json().then(r => {
                if (r.errors) {
                    alert(Object.values(r.errors).flat().join('\n'));
                } else {
                    alert('Error updating staff.');
                }
            });
        }
    })
    .catch(() => alert('Error updating staff.'));
}
</script>
@endsection
