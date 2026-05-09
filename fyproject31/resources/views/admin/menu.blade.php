@extends('layouts.app')

@section('title', 'Menu')
@section('page-title', 'Manage Menu')

@section('content')
<div class="data-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h3 style="margin: 0;">Menu Items</h3>
        <button onclick="openAddModal()" class="btn-primary" style="padding: 8px 16px; background: #cf2c21; color: #1a1a1a; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">+ Add Item</button>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="menuTableBody">
            @foreach($menuItems as $item)
            <tr data-id="{{ $item->id }}">
                <td>{{ $item->name }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $item->category)) }}</td>
                <td>RM {{ number_format($item->price, 2) }}</td>
                <td><span class="badge badge-{{ $item->status === 'available' ? 'completed' : 'cancelled' }}">{{ ucfirst($item->status) }}</span></td>
                <td>
                    <button onclick="deleteMenuItem('{{ $item->id }}', '{{ $item->name }}')" style="background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="addMenuModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: #1a1a1a; padding: 24px; border-radius: 12px; width: 90%; max-width: 400px;">
        <h3 style="margin-bottom: 16px; color: #cf2c21;">Add Menu Item</h3>
        <form id="addMenuForm" onsubmit="submitAddMenu(event)">
            <input type="text" name="name" placeholder="Item Name" required style="width: 100%; padding: 10px; margin-bottom: 12px; background: #2a2a2a; border: 1px solid rgba(207,44,33,0.3); border-radius: 6px; color: #fff;">
            <textarea name="description" placeholder="Description" rows="2" style="width: 100%; padding: 10px; margin-bottom: 12px; background: #2a2a2a; border: 1px solid rgba(207,44,33,0.3); border-radius: 6px; color: #fff;"></textarea>
            <input type="number" name="price" step="0.01" min="0" placeholder="Price (RM)" required style="width: 100%; padding: 10px; margin-bottom: 12px; background: #2a2a2a; border: 1px solid rgba(207,44,33,0.3); border-radius: 6px; color: #fff;">
            <select name="category" required style="width: 100%; padding: 10px; margin-bottom: 12px; background: #2a2a2a; border: 1px solid rgba(207,44,33,0.3); border-radius: 6px; color: #fff;">
                <option value="ala_carte">Ala Carte</option>
                <option value="combo_set">Combo Set</option>
                <option value="mix">Mix</option>
                <option value="food">Food</option>
                <option value="drink">Drink</option>
            </select>
            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="closeAddModal()" style="flex: 1; padding: 10px; background: #333; color: #fff; border: none; border-radius: 6px; cursor: pointer;">Cancel</button>
                <button type="submit" style="flex: 1; padding: 10px; background: #cf2c21; color: #1a1a1a; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">Add</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const csrfToken = '{{ csrf_token() }}';

function openAddModal() { document.getElementById('addMenuModal').style.display = 'flex'; }
function closeAddModal() { document.getElementById('addMenuModal').style.display = 'none'; document.getElementById('addMenuForm').reset(); }

function submitAddMenu(e) {
    e.preventDefault();
    const form = e.target;
    const data = new FormData(form);
    fetch('/api/menu/add', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: data
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            closeAddModal();
            refreshMenu();
        }
    });
}

function deleteMenuItem(id, name) {
    if (!confirm(`Delete "${name}"?`)) return;
    fetch(`/api/menu/${id}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: JSON.stringify({ _method: 'DELETE' })
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) refreshMenu();
    });
}

function refreshMenu() {
    fetch('/api/menu/check')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('menuTableBody');
            let html = '';
            data.menu.forEach(item => {
                html += `<tr data-id="${item.id}">
                    <td>${item.name}</td>
                    <td>${item.category.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}</td>
                    <td>RM ${item.price}</td>
                    <td><span class="badge badge-${item.status === 'available' ? 'completed' : 'cancelled'}">${item.status.charAt(0).toUpperCase() + item.status.slice(1)}</span></td>
                    <td>
                        <button onclick="deleteMenuItem('${item.id}', '${item.name.replace(/'/g, "\\'")}')" style="background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">Delete</button>
                    </td>
                </tr>`;
            });
            tbody.innerHTML = html;
        });
}

setInterval(refreshMenu, 5000);
</script>
@endpush
