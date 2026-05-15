@extends('layouts.app')

@section('title', 'Menu')
@section('page-title', 'Manage Menu')

@section('content')
<div class="data-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h3 style="margin: 0;">Menu Items</h3>
        <button onclick="openAddModal()" class="btn-primary" style="padding: 8px 16px; background: #420C09; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">+ Add Item</button>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Image</th>
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
                <td>
                    @if($item->category !== 'add_on')
                        @php $imgFile = \App\Helpers\MenuImageHelper::getImageFilename($item->name); @endphp
                        @if($imgFile)
                            <img src="{{ asset('images/menu/' . $imgFile) }}" alt="{{ $item->name }}" style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                        @elseif($item->image)
                            <img src="{{ asset('images/menu/' . $item->image) }}" alt="{{ $item->name }}" style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                        @else
                            <img src="{{ asset('images/menu/ayam-goreng-kunyit.jpg') }}" alt="Food" style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                        @endif
                    @else
                        <span style="color:#999;font-size:0.85rem;">—</span>
                    @endif
                </td>
                <td>{{ $item->name }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $item->category)) }}</td>
                <td>RM {{ number_format($item->price, 2) }}</td>
                <td>
                    <select onchange="toggleStatus('{{ $item->id }}', this.value)" style="padding: 6px 10px; background: #f5f5f5; color: #222; border: 1px solid #ddd; border-radius: 6px; font-size: 0.85rem;">
                        <option value="available" {{ $item->status == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="unavailable" {{ $item->status == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                </td>
                <td>
                    <button onclick="deleteMenuItem('{{ $item->id }}', '{{ $item->name }}')" style="background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="addMenuModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: #fff; padding: 24px; border-radius: 12px; width: 90%; max-width: 420px; border: 2px solid #420C09;">
        <h3 style="margin-bottom: 16px; color: #420C09;">Add Menu Item</h3>
        <form id="addMenuForm" onsubmit="submitAddMenu(event)">
            <input type="text" name="name" placeholder="Item Name" required style="width: 100%; padding: 10px; margin-bottom: 12px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; color: #222;">
            <div id="descriptionContainer">
                <textarea name="description" placeholder="Description" rows="2" style="width: 100%; padding: 10px; margin-bottom: 12px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; color: #222;"></textarea>
            </div>
            <input type="number" name="price" step="0.01" min="0" placeholder="Price (RM)" required style="width: 100%; padding: 10px; margin-bottom: 12px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; color: #222;">
            <select name="category" id="addCategory" required onchange="toggleAddOnFields()" style="width: 100%; padding: 10px; margin-bottom: 12px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; color: #222;">
                <option value="ala_carte">Ala Carte</option>
                <option value="combo_set">Combo Set</option>
                <option value="mix">Mix</option>
                <option value="nasi_lemak">Nasi Lemak</option>
                <option value="kicap">Kicap Edition</option>
                <option value="set_family">Set Family</option>
                <option value="minuman">Minuman</option>
                <option value="add_on">Add-On</option>
            </select>
            <select name="status" style="width: 100%; padding: 10px; margin-bottom: 12px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; color: #222;">
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
            </select>
            <div id="imageUploadContainer">
                <label style="display: block; margin-bottom: 6px; font-size: 0.9rem; color: #555;">Item Image</label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" style="width: 100%; padding: 8px; margin-bottom: 12px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; color: #222;">
                <p style="margin: -8px 0 12px; font-size: 0.8rem; color: #888;">Max 2MB. JPEG, PNG, JPG, GIF, or WebP.</p>
            </div>
            <div id="addonSelectionContainer" style="margin-bottom: 12px;">
                <label style="display: block; margin-bottom: 6px; font-size: 0.9rem; color: #555;">Link Add-Ons</label>
                <div style="max-height: 150px; overflow-y: auto; padding: 8px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px;">
                    @forelse($addOns as $addon)
                        <label style="display: flex; align-items: center; gap: 8px; padding: 4px 0; font-size: 0.85rem; color: #222; cursor: pointer;">
                            <input type="checkbox" name="linked_addons[]" value="{{ $addon->id }}">
                            {{ $addon->name }} 
                            @if($addon->group_name)
                                <span style="color: #888; font-size: 0.8rem;">({{ $addon->group_name }})</span>
                            @endif
                        </label>
                    @empty
                        <span style="color: #999; font-size: 0.85rem;">No add-ons available. Create add-on items first.</span>
                    @endforelse
                </div>
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="closeAddModal()" style="flex: 1; padding: 10px; background: #f0f0f0; color: #222; border: 1px solid #ddd; border-radius: 6px; cursor: pointer;">Cancel</button>
                <button type="submit" style="flex: 1; padding: 10px; background: #420C09; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">Add</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const csrfToken = '{{ csrf_token() }}';

function openAddModal() { document.getElementById('addMenuModal').style.display = 'flex'; toggleAddOnFields(); }
function closeAddModal() { document.getElementById('addMenuModal').style.display = 'none'; document.getElementById('addMenuForm').reset(); toggleAddOnFields(); }

function toggleAddOnFields() {
    const cat = document.getElementById('addCategory').value;
    const isAddOn = cat === 'add_on';
    document.getElementById('imageUploadContainer').style.display = isAddOn ? 'none' : 'block';
    document.getElementById('descriptionContainer').style.display = isAddOn ? 'none' : 'block';
    document.getElementById('addonSelectionContainer').style.display = isAddOn ? 'none' : 'block';
}

function toggleStatus(id, status) {
    fetch(`/api/menu/${id}/status`, {
        method: 'PATCH',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({ status: status })
    })
    .then(res => res.json())
    .then(res => { if (!res.success) refreshMenu(); });
}

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
        } else {
            alert('Error adding item. Please check your input.');
        }
    })
    .catch(() => alert('Error adding item. Please try again.'));
}

function deleteMenuItem(id, name) {
    if (!confirm(`Delete "${name}"?`)) return;
    fetch(`/api/menu/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) refreshMenu();
    })
    .catch(() => refreshMenu());
}

function refreshMenu() {
    fetch('/api/menu/check')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('menuTableBody');
            let html = '';
            data.menu.forEach(item => {
                const imgUrl = item.image_url ? item.image_url : item.image ? `/images/menu/${item.image}` : '/images/menu/ayam-goreng-kunyit.jpg';
                html += `<tr data-id="${item.id}">
                    <td>${item.category === 'add_on' ? '<span style="color:#999;font-size:0.85rem;">—</span>' : `<img src="${imgUrl}" alt="${item.name}" style="width:50px;height:50px;object-fit:cover;border-radius:6px;">`}</td>
                    <td>${item.name}</td>
                    <td>${item.category.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}</td>
                    <td>RM ${item.price}</td>
                    <td>
                        <select onchange="toggleStatus('${item.id}', this.value)" style="padding: 6px 10px; background: #f5f5f5; color: #222; border: 1px solid #ddd; border-radius: 6px; font-size: 0.85rem;">
                            <option value="available" ${item.status === 'available' ? 'selected' : ''}>Available</option>
                            <option value="unavailable" ${item.status === 'unavailable' ? 'selected' : ''}>Unavailable</option>
                        </select>
                    </td>
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
