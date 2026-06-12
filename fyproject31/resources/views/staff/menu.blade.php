@extends('layouts.app')

@section('title', 'Menu')
@section('page-title', 'Manage Menu')

@section('content')
<div class="data-card">
    <div class="tab-nav" style="display: flex; gap: 0; margin-bottom: 20px; border-bottom: 2px solid #e0e0e0;">
        <button class="tab-btn" data-tab="menu-items" onclick="switchTab('menu-items')" style="padding: 10px 24px; background: none; border: none; border-bottom: 3px solid transparent; cursor: pointer; font-weight: 600; color: #666; transition: all 0.2s; margin-bottom: -2px;">
            Menu Items
        </button>
        <button class="tab-btn" data-tab="discounts" onclick="switchTab('discounts')" style="padding: 10px 24px; background: none; border: none; border-bottom: 3px solid transparent; cursor: pointer; font-weight: 600; color: #666; transition: all 0.2s; margin-bottom: -2px;">
            Discounts
        </button>
    </div>

    <div id="tab-menu-items" class="tab-panel">
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
                    <th>Discount</th>
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
                    <td>
                        @php $effPrice = $item->effective_price; @endphp
                        @if($effPrice < $item->price)
                            <span style="text-decoration: line-through; color: #999;">RM {{ number_format($item->price, 2) }}</span>
                            <span style="color: #dc3545; font-weight: 600;">RM {{ number_format($effPrice, 2) }}</span>
                        @else
                            RM {{ number_format($item->price, 2) }}
                        @endif
                    </td>
                    <td>
                        @php $discPct = $item->discount_percentage; @endphp
                        @if($discPct > 0)
                            <span style="background: #28a745; color: #fff; padding: 2px 8px; border-radius: 10px; font-size: 0.8rem; font-weight: 600;">-{{ $discPct }}%</span>
                        @else
                            <span style="color: #999; font-size: 0.85rem;">—</span>
                        @endif
                    </td>
                    <td>
                        <select onchange="toggleStatus('{{ $item->id }}', this.value)" style="padding: 6px 10px; background: #f5f5f5; color: #222; border: 1px solid #ddd; border-radius: 6px; font-size: 0.85rem;">
                            <option value="available" {{ $item->status == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="unavailable" {{ $item->status == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                        </select>
                    </td>
                    <td>
                        <button onclick="openEditModal('{{ $item->id }}')" style="background: #ffc107; color: #222; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; margin-right: 4px;">Edit</button>
                        <button onclick="deleteMenuItem('{{ $item->id }}', '{{ $item->name }}')" style="background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="tab-discounts" class="tab-panel" style="display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="margin: 0;">Discounts</h3>
            <button onclick="openAddDiscountModal()" style="padding: 8px 16px; background: #420C09; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">+ Add Discount</button>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Percentage</th>
                    <th>Applied To</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($discounts as $discount)
                <tr>
                    <td>{{ $discount->name }}</td>
                    <td>{{ $discount->percentage }}%</td>
                    <td style="max-width: 300px; white-space: normal;">
                        @php $names = $discount->menuItems->pluck('name')->toArray(); @endphp
                        @if(count($names) > 0)
                            {{ implode(', ', $names) }}
                        @else
                            <span style="color: #999;">No items selected</span>
                        @endif
                    </td>
                    <td>
                        @if($discount->is_active)
                            <span style="background: #28a745; color: #fff; padding: 2px 10px; border-radius: 10px; font-size: 0.8rem;">Active</span>
                        @else
                            <span style="background: #dc3545; color: #fff; padding: 2px 10px; border-radius: 10px; font-size: 0.8rem;">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <button onclick="openEditDiscountModal({{ $discount->id }})" style="background: #ffc107; color: #222; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; margin-right: 4px;">Edit</button>
                        <button onclick="deleteDiscount({{ $discount->id }}, '{{ $discount->name }}')" style="background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #999; padding: 24px;">No discounts created yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
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
                <label style="display: block; margin-bottom: 6px; font-size: 0.9rem; color: #555;">Item Image <span style="color: #dc3545;">*</span></label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" required style="width: 100%; padding: 8px; margin-bottom: 12px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; color: #222;">
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
<div id="editMenuModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: #fff; padding: 24px; border-radius: 12px; width: 90%; max-width: 420px; border: 2px solid #420C09;">
        <h3 style="margin-bottom: 16px; color: #420C09;">Edit Menu Item</h3>
        <form id="editMenuForm" onsubmit="submitEditMenu(event)">
            <input type="hidden" name="id" id="editId">
            <input type="text" name="name" id="editName" placeholder="Item Name" required style="width: 100%; padding: 10px; margin-bottom: 12px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; color: #222;">
            <div id="editDescriptionContainer">
                <textarea name="description" id="editDescription" placeholder="Description" rows="2" style="width: 100%; padding: 10px; margin-bottom: 12px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; color: #222;"></textarea>
            </div>
            <input type="number" name="price" id="editPrice" step="0.01" min="0" placeholder="Price (RM)" required style="width: 100%; padding: 10px; margin-bottom: 12px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; color: #222;">
            <select name="category" id="editCategory" required onchange="toggleEditAddOnFields()" style="width: 100%; padding: 10px; margin-bottom: 12px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; color: #222;">
                <option value="ala_carte">Ala Carte</option>
                <option value="combo_set">Combo Set</option>
                <option value="mix">Mix</option>
                <option value="nasi_lemak">Nasi Lemak</option>
                <option value="kicap">Kicap Edition</option>
                <option value="set_family">Set Family</option>
                <option value="minuman">Minuman</option>
                <option value="add_on">Add-On</option>
            </select>
            <select name="status" id="editStatus" style="width: 100%; padding: 10px; margin-bottom: 12px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; color: #222;">
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
            </select>
            <div id="editImageUploadContainer">
                <label style="display: block; margin-bottom: 6px; font-size: 0.9rem; color: #555;">Item Image</label>
                <div id="editImagePreview" style="margin-bottom: 8px;"></div>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" style="width: 100%; padding: 8px; margin-bottom: 12px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; color: #222;">
                <p style="margin: -8px 0 12px; font-size: 0.8rem; color: #888;">Max 2MB. Leave empty to keep current image.</p>
            </div>
            <div id="editAddonSelectionContainer" style="margin-bottom: 12px;">
                <label style="display: block; margin-bottom: 6px; font-size: 0.9rem; color: #555;">Link Add-Ons</label>
                <div style="max-height: 150px; overflow-y: auto; padding: 8px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px;">
                    @forelse($addOns as $addon)
                        <label style="display: flex; align-items: center; gap: 8px; padding: 4px 0; font-size: 0.85rem; color: #222; cursor: pointer;">
                            <input type="checkbox" name="linked_addons[]" value="{{ $addon->id }}" class="edit-linked-addon">
                            {{ $addon->name }} 
                            @if($addon->group_name)
                                <span style="color: #888; font-size: 0.8rem;">({{ $addon->group_name }})</span>
                            @endif
                        </label>
                    @empty
                        <span style="color: #999; font-size: 0.85rem;">No add-ons available.</span>
                    @endforelse
                </div>
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="closeEditModal()" style="flex: 1; padding: 10px; background: #f0f0f0; color: #222; border: 1px solid #ddd; border-radius: 6px; cursor: pointer;">Cancel</button>
                <button type="submit" style="flex: 1; padding: 10px; background: #420C09; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">Save</button>
            </div>
        </form>
    </div>
</div>
<div id="addDiscountModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: #fff; padding: 24px; border-radius: 12px; width: 90%; max-width: 480px; border: 2px solid #420C09; max-height: 90vh; overflow-y: auto;">
        <h3 style="margin-bottom: 16px; color: #420C09;">Add Discount</h3>
        <form id="addDiscountForm" method="POST" action="{{ url('staff/discounts/add') }}">
            @csrf
            <input type="text" name="name" placeholder="Discount Name" required style="width: 100%; padding: 10px; margin-bottom: 12px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; color: #222;">
            <div style="position: relative; margin-bottom: 12px;">
                <input type="number" name="percentage" step="0.01" min="0" max="100" placeholder="Percentage" required style="width: 100%; padding: 10px; padding-right: 30px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; color: #222;">
                <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #888;">%</span>
            </div>
            <label style="display: block; margin-bottom: 6px; font-size: 0.9rem; color: #555;">Apply to Menu Items <span style="color: #888; font-weight: normal;">(excludes add-ons)</span></label>
            <div style="margin-bottom: 6px;">
                <label style="font-size: 0.85rem; color: #420C09; cursor: pointer; user-select: none;">
                    <input type="checkbox" onchange="toggleDiscountCheckboxes(this, 'discountItemCheckboxes')"> Select All
                </label>
            </div>
            <div id="discountItemCheckboxes" style="max-height: 200px; overflow-y: auto; padding: 8px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; margin-bottom: 12px;">
                <span style="color: #999; font-size: 0.85rem;">Loading items...</span>
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="closeAddDiscountModal()" style="flex: 1; padding: 10px; background: #f0f0f0; color: #222; border: 1px solid #ddd; border-radius: 6px; cursor: pointer;">Cancel</button>
                <button type="submit" style="flex: 1; padding: 10px; background: #420C09; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">Add Discount</button>
            </div>
        </form>
    </div>
</div>

<div id="editDiscountModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: #fff; padding: 24px; border-radius: 12px; width: 90%; max-width: 480px; border: 2px solid #420C09; max-height: 90vh; overflow-y: auto;">
        <h3 style="margin-bottom: 16px; color: #420C09;">Edit Discount</h3>
        <form id="editDiscountForm" method="POST">
            @csrf
            <input type="hidden" name="id" id="editDiscountId">
            <input type="text" name="name" id="editDiscountName" placeholder="Discount Name" required style="width: 100%; padding: 10px; margin-bottom: 12px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; color: #222;">
            <div style="position: relative; margin-bottom: 12px;">
                <input type="number" name="percentage" id="editDiscountPercentage" step="0.01" min="0" max="100" placeholder="Percentage" required style="width: 100%; padding: 10px; padding-right: 30px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; color: #222;">
                <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #888;">%</span>
            </div>
            <select name="is_active" id="editDiscountStatus" style="width: 100%; padding: 10px; margin-bottom: 12px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; color: #222;">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            <label style="display: block; margin-bottom: 6px; font-size: 0.9rem; color: #555;">Apply to Menu Items <span style="color: #888; font-weight: normal;">(excludes add-ons)</span></label>
            <div style="margin-bottom: 6px;">
                <label style="font-size: 0.85rem; color: #420C09; cursor: pointer; user-select: none;">
                    <input type="checkbox" onchange="toggleDiscountCheckboxes(this, 'editDiscountItemCheckboxes')"> Select All
                </label>
            </div>
            <div id="editDiscountItemCheckboxes" style="max-height: 200px; overflow-y: auto; padding: 8px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 6px; margin-bottom: 12px;">
                <span style="color: #999; font-size: 0.85rem;">Loading items...</span>
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="closeEditDiscountModal()" style="flex: 1; padding: 10px; background: #f0f0f0; color: #222; border: 1px solid #ddd; border-radius: 6px; cursor: pointer;">Cancel</button>
                <button type="submit" style="flex: 1; padding: 10px; background: #420C09; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 700;">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const csrfToken = '{{ csrf_token() }}';

function openAddModal() {
    const btn = document.querySelector('#addMenuForm button[type="submit"]');
    btn.disabled = false;
    btn.textContent = 'Add';
    document.getElementById('addMenuModal').style.display = 'flex';
    toggleAddOnFields();
}
function closeAddModal() { document.getElementById('addMenuModal').style.display = 'none'; document.getElementById('addMenuForm').reset(); toggleAddOnFields(); }

function toggleAddOnFields() {
    const cat = document.getElementById('addCategory').value;
    const isAddOn = cat === 'add_on';
    const imgInput = document.querySelector('#imageUploadContainer input[type="file"]');
    document.getElementById('imageUploadContainer').style.display = isAddOn ? 'none' : 'block';
    document.getElementById('descriptionContainer').style.display = isAddOn ? 'none' : 'block';
    document.getElementById('addonSelectionContainer').style.display = isAddOn ? 'none' : 'block';
    if (isAddOn) { imgInput.required = false; } else { imgInput.required = true; }
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
    const btn = form.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.textContent = 'Adding...';
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
            refreshAddOns();
            refreshMenu();
        } else {
            alert('Error adding item. Please check your input.');
            btn.disabled = false;
            btn.textContent = 'Add';
        }
    })
    .catch(() => {
        alert('Error adding item. Please try again.');
        btn.disabled = false;
        btn.textContent = 'Add';
    });
}

function openEditModal(id) {
    fetch(`/api/menu/${id}`)
        .then(res => res.json())
        .then(data => {
            const item = data.item;
            document.getElementById('editId').value = item.id;
            document.getElementById('editName').value = item.name;
            document.getElementById('editDescription').value = item.description || '';
            document.getElementById('editPrice').value = item.price;
            document.getElementById('editCategory').value = item.category;
            document.getElementById('editStatus').value = item.status;
            toggleEditAddOnFields();

            const preview = document.getElementById('editImagePreview');
            if (item.category !== 'add_on') {
                const imgUrl = item.image ? `/images/menu/${item.image}` : '/images/menu/ayam-goreng-kunyit.jpg';
                preview.innerHTML = `<img src="${imgUrl}" alt="Current" style="width:60px;height:60px;object-fit:cover;border-radius:6px;border:1px solid #ddd;">`;
            } else {
                preview.innerHTML = '';
            }

            document.querySelectorAll('#editAddonSelectionContainer .edit-linked-addon').forEach(cb => {
                cb.checked = data.linked_addon_ids.includes(parseInt(cb.value));
            });

            document.getElementById('editMenuModal').style.display = 'flex';
        })
        .catch(() => alert('Failed to load item data.'));
}

function closeEditModal() {
    document.getElementById('editMenuModal').style.display = 'none';
    document.getElementById('editMenuForm').reset();
    document.getElementById('editImagePreview').innerHTML = '';
}

function toggleEditAddOnFields() {
    const cat = document.getElementById('editCategory').value;
    const isAddOn = cat === 'add_on';
    document.getElementById('editImageUploadContainer').style.display = isAddOn ? 'none' : 'block';
    document.getElementById('editDescriptionContainer').style.display = isAddOn ? 'none' : 'block';
    document.getElementById('editAddonSelectionContainer').style.display = isAddOn ? 'none' : 'block';
}

function submitEditMenu(e) {
    e.preventDefault();
    const form = e.target;
    const id = document.getElementById('editId').value;
    const data = new FormData(form);
    fetch(`/api/menu/${id}/update`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: data
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            closeEditModal();
            refreshMenu();
        } else {
            alert('Error updating item. Please check your input.');
        }
    })
    .catch(() => alert('Error updating item. Please try again.'));
}

function deleteMenuItem(id, name) {
    if (!confirm(`Delete "${name}"?`)) return;
    fetch(`/api/menu/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) { refreshAddOns(); refreshMenu(); }
    })
    .catch(() => { refreshAddOns(); refreshMenu(); });
}

function refreshMenu() {
    fetch('/api/menu/check')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('menuTableBody');
            let html = '';
            data.menu.forEach(item => {
                const imgUrl = item.image_url ? item.image_url : item.image ? `/images/menu/${item.image}` : '/images/menu/ayam-goreng-kunyit.jpg';
                const discPct = parseFloat(item.discount_percentage) || 0;
                let priceHtml = `RM ${item.price}`;
                if (discPct > 0) {
                    priceHtml = `<span style="text-decoration: line-through; color: #999;">RM ${item.price}</span> <span style="color: #dc3545; font-weight: 600;">RM ${item.effective_price}</span>`;
                }
                let discBadge = '<span style="color: #999; font-size: 0.85rem;">—</span>';
                if (discPct > 0) {
                    discBadge = `<span style="background: #28a745; color: #fff; padding: 2px 8px; border-radius: 10px; font-size: 0.8rem; font-weight: 600;">-${discPct}%</span>`;
                }
                html += `<tr data-id="${item.id}">
                    <td>${item.category === 'add_on' ? '<span style="color:#999;font-size:0.85rem;">—</span>' : `<img src="${imgUrl}" alt="${item.name}" style="width:50px;height:50px;object-fit:cover;border-radius:6px;">`}</td>
                    <td>${item.name}</td>
                    <td>${item.category.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}</td>
                    <td>${priceHtml}</td>
                    <td>${discBadge}</td>
                    <td>
                        <select onchange="toggleStatus('${item.id}', this.value)" style="padding: 6px 10px; background: #f5f5f5; color: #222; border: 1px solid #ddd; border-radius: 6px; font-size: 0.85rem;">
                            <option value="available" ${item.status === 'available' ? 'selected' : ''}>Available</option>
                            <option value="unavailable" ${item.status === 'unavailable' ? 'selected' : ''}>Unavailable</option>
                        </select>
                    </td>
                    <td>
                        <button onclick="openEditModal('${item.id}')" style="background: #ffc107; color: #222; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; margin-right: 4px;">Edit</button>
                        <button onclick="deleteMenuItem('${item.id}', '${item.name.replace(/'/g, "\\'")}')" style="background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">Delete</button>
                    </td>
                </tr>`;
            });
            tbody.innerHTML = html;
        });
}

function refreshAddOns() {
    fetch('/api/menu/addons')
        .then(res => res.json())
        .then(data => {
            const addContainer = document.querySelector('#addonSelectionContainer > div');
            const editContainer = document.querySelector('#editAddonSelectionContainer > div');
            if (!data.addons || data.addons.length === 0) {
                const msg = '<span style="color: #999; font-size: 0.85rem;">No add-ons available. Create add-on items first.</span>';
                addContainer.innerHTML = msg;
                editContainer.innerHTML = '<span style="color: #999; font-size: 0.85rem;">No add-ons available.</span>';
                return;
            }
            let addHtml = '', editHtml = '';
            data.addons.forEach(a => {
                const label = a.group_name ? ` ${a.name} <span style="color: #888; font-size: 0.8rem;">(${a.group_name})</span>` : ` ${a.name}`;
                addHtml += `<label style="display: flex; align-items: center; gap: 8px; padding: 4px 0; font-size: 0.85rem; color: #222; cursor: pointer;"><input type="checkbox" name="linked_addons[]" value="${a.id}">${label}</label>`;
                editHtml += `<label style="display: flex; align-items: center; gap: 8px; padding: 4px 0; font-size: 0.85rem; color: #222; cursor: pointer;"><input type="checkbox" name="linked_addons[]" value="${a.id}" class="edit-linked-addon">${label}</label>`;
            });
            addContainer.innerHTML = addHtml;
            editContainer.innerHTML = editHtml;
        });
}

function switchTab(tab) {
    document.querySelectorAll('.tab-panel').forEach(p => p.style.display = 'none');
    document.querySelectorAll('.tab-btn').forEach(b => {
        b.style.color = '#666';
        b.style.borderBottomColor = 'transparent';
    });
    document.getElementById('tab-' + tab).style.display = 'block';
    const btn = document.querySelector(`.tab-btn[data-tab="${tab}"]`);
    if (btn) {
        btn.style.color = '#420C09';
        btn.style.borderBottomColor = '#420C09';
    }
    if (tab === 'discounts') {
        loadDiscountItemCheckboxes();
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    const tab = params.get('tab') || 'menu-items';
    switchTab(tab);
});

function toggleDiscountCheckboxes(selectAll, containerId) {
    document.querySelectorAll('#' + containerId + ' input[type="checkbox"]').forEach(cb => {
        cb.checked = selectAll.checked;
    });
}

function openAddDiscountModal() {
    document.getElementById('addDiscountModal').style.display = 'flex';
    loadDiscountItemCheckboxes();
}

function closeAddDiscountModal() {
    document.getElementById('addDiscountModal').style.display = 'none';
    document.getElementById('addDiscountForm').reset();
}

function loadDiscountItemCheckboxes() {
    fetch('/api/menu/non-addons')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('discountItemCheckboxes');
            const editContainer = document.getElementById('editDiscountItemCheckboxes');
            if (!data.items || data.items.length === 0) {
                const msg = '<span style="color: #999; font-size: 0.85rem;">No menu items available (excluding add-ons).</span>';
                container.innerHTML = msg;
                editContainer.innerHTML = msg;
                return;
            }
            let html = '';
            data.items.forEach(item => {
                const catName = item.category.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
                html += `<label style="display: flex; align-items: center; gap: 8px; padding: 4px 0; font-size: 0.85rem; color: #222; cursor: pointer;">
                    <input type="checkbox" name="menu_item_ids[]" value="${item.id}">
                    ${item.name} <span style="color: #888; font-size: 0.8rem;">(${catName})</span>
                </label>`;
            });
            container.innerHTML = html;
            editContainer.innerHTML = html;
        });
}

function openEditDiscountModal(id) {
    fetch('/api/menu/non-addons')
        .then(res => res.json())
        .then(data => {
            const editContainer = document.getElementById('editDiscountItemCheckboxes');
            let html = '';
            const selectedIds = @json($discounts->mapWithKeys(fn($d) => [$d->id => $d->menuItems->pluck('id')->toArray()]));
            const selected = selectedIds[id] || [];

            data.items.forEach(item => {
                const catName = item.category.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
                const checked = selected.includes(item.id) ? 'checked' : '';
                html += `<label style="display: flex; align-items: center; gap: 8px; padding: 4px 0; font-size: 0.85rem; color: #222; cursor: pointer;">
                    <input type="checkbox" name="menu_item_ids[]" value="${item.id}" ${checked}>
                    ${item.name} <span style="color: #888; font-size: 0.8rem;">(${catName})</span>
                </label>`;
            });
            editContainer.innerHTML = html;

            const discount = @json($discounts->keyBy('id'));
            const d = discount[id];
            document.getElementById('editDiscountId').value = d.id;
            document.getElementById('editDiscountName').value = d.name;
            document.getElementById('editDiscountPercentage').value = d.percentage;
            document.getElementById('editDiscountStatus').value = d.is_active ? '1' : '0';
            document.getElementById('editDiscountForm').action = `{{ url('staff/discounts') }}/${id}/update`;
            document.getElementById('editDiscountModal').style.display = 'flex';
        });
}

function closeEditDiscountModal() {
    document.getElementById('editDiscountModal').style.display = 'none';
    document.getElementById('editDiscountForm').reset();
}

function deleteDiscount(id, name) {
    if (!confirm(`Delete discount "${name}"?`)) return;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `{{ url('staff/discounts') }}/${id}`;
    form.innerHTML = `@csrf @method('DELETE')`;
    document.body.appendChild(form);
    form.submit();
}

setInterval(refreshMenu, 5000);
</script>
@endpush
