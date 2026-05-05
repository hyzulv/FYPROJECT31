<?php
session_start();
require_once __DIR__ . '/includes/staff_data.php';
staff_redirect_if_guest();
staff_seed_if_missing();

$username = (string)$_SESSION['user'];
$role = (string)($_SESSION['role'] ?? 'staff');
$safeUser = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
$safeRole = htmlspecialchars(strtoupper($role), ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $safeRole; ?> Dashboard</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #0d0d0d; color: #eee; }
        .topbar { background: #1a1a1a; border-bottom: 2px solid #c00; padding: 12px 18px; display: flex; justify-content: space-between; align-items: center; gap: 10px; flex-wrap: wrap; }
        .topbar h1 { margin: 0; font-size: 1.2rem; color: #fff; }
        .sub { margin-top: 4px; color: #aaa; font-size: .85rem; }
        .role-chip { display: inline-block; padding: 2px 8px; border-radius: 999px; background: #2e2e2e; border: 1px solid #505050; color: #fff; font-size: .75rem; margin-left: 8px; }
        .top-actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .pill { color: #9cf; font-size: .82rem; }
        .btn, .btn-sm, a.btn { border: none; border-radius: 6px; font-family: inherit; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn { padding: 9px 14px; font-weight: bold; font-size: .9rem; }
        .btn-primary { background: #c00; color: #fff; }
        .btn-primary:hover { background: #900; }
        .btn-muted { background: #333; color: #fff; }
        .btn-muted:hover { background: #444; }
        .btn-logout { background: #2a2a2a; color: #eee; border: 1px solid #444; }
        .layout { display: grid; grid-template-columns: 220px 1fr; min-height: calc(100vh - 74px); }
        nav.side { background: #141414; border-right: 1px solid #2a2a2a; padding: 16px 0; }
        nav.side button { width: 100%; text-align: left; padding: 12px 18px; border: none; background: transparent; color: #ccc; font-weight: bold; cursor: pointer; }
        nav.side button:hover { background: #1f1f1f; color: #fff; }
        nav.side button.active { background: #222; color: #fff; border-left: 3px solid #c00; }
        .content { padding: 18px; max-width: 1200px; }
        .panel { display: none; }
        .panel.active { display: block; }
        .card { background: #1a1a1a; border: 1px solid #2c2c2c; border-radius: 10px; padding: 16px; margin-bottom: 16px; }
        .card h2 { margin: 0 0 12px; font-size: 1.05rem; color: #fff; }
        .muted { color: #888; font-size: .85rem; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; margin-bottom: 18px; }
        .stat-card { background: #1a1a1a; border-radius: 10px; padding: 14px; border-left: 4px solid #c00; }
        .stat-card .label { font-size: .75rem; color: #999; text-transform: uppercase; }
        .stat-card .value { font-size: 1.4rem; font-weight: bold; margin-top: 6px; }
        label { display: block; font-size: .8rem; color: #aaa; margin-bottom: 4px; }
        input, textarea, select { width: 100%; max-width: 460px; padding: 10px; border-radius: 6px; border: 1px solid #444; background: #111; color: #fff; margin-bottom: 12px; font-family: inherit; }
        textarea { min-height: 80px; max-width: 100%; }
        .row2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        table { width: 100%; border-collapse: collapse; font-size: .88rem; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #2a2a2a; }
        th { background: #222; color: #bbb; }
        tr:hover td { background: #1f1f1f; }
        .table-wrap { overflow-x: auto; }
        .actions { display: flex; gap: 6px; flex-wrap: wrap; }
        .btn-sm { padding: 6px 10px; font-size: .8rem; font-weight: bold; }
        .edit { background: #2d4ea3; color: #fff; }
        .del { background: #7a2323; color: #fff; }
        #toast { position: fixed; bottom: 18px; right: 18px; background: #252525; border: 1px solid #444; padding: 10px 14px; border-radius: 8px; display: none; z-index: 60; max-width: 340px; }
        .backdrop { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.55); z-index: 100; align-items: center; justify-content: center; padding: 16px; }
        .backdrop.show { display: flex; }
        .modal { background: #1c1c1c; border: 1px solid #383838; border-radius: 12px; width: min(560px, 100%); max-height: 90vh; overflow: auto; padding: 18px; }
        .modal h3 { margin: 0 0 14px; color: #fff; }
        .modal-actions { margin-top: 14px; display: flex; gap: 10px; flex-wrap: wrap; }
        @media (max-width: 760px) {
            .layout { grid-template-columns: 1fr; }
            nav.side { display: flex; flex-wrap: wrap; gap: 4px; padding: 8px; border-right: none; border-bottom: 1px solid #2a2a2a; }
            nav.side button { width: auto; flex: 1 1 45%; border-left: none !important; border-radius: 6px; }
            nav.side button.active { border: 1px solid #c00; }
            .row2 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<header class="topbar">
    <div>
        <h1><?php echo $safeRole; ?> dashboard <span class="role-chip"><?php echo $safeRole; ?></span></h1>
        <div class="sub">Signed in as <strong><?php echo $safeUser; ?></strong></div>
    </div>
    <div class="top-actions">
        <span class="pill" id="syncText">Loading…</span>
        <button class="btn btn-primary" id="btnSync" type="button">Refresh data</button>
        <a class="btn btn-logout" href="logout.php">Sign out</a>
    </div>
</header>

<div class="layout">
    <nav class="side" id="tabs"></nav>
    <div class="content">
        <section class="panel active" id="panel-overview">
            <div class="stats-grid">
                <article class="stat-card"><div class="label">Orders Today</div><div class="value" id="statOrdersToday">—</div></article>
                <article class="stat-card"><div class="label">Revenue Today (RM)</div><div class="value" id="statRevenue">—</div></article>
                <article class="stat-card"><div class="label">Pending / Active</div><div class="value" id="statPending">—</div></article>
                <article class="stat-card"><div class="label">Avg Prep (mins)</div><div class="value" id="statAvgPrep">—</div></article>
            </div>
            <p class="muted">Dashboard is split by role. Admin has extra staff management tools.</p>
        </section>

        <section class="panel" id="panel-profile">
            <div class="card">
                <h2>View / Edit profile</h2>
                <form id="formProfile">
                    <label for="pfName">Display name</label><input id="pfName" type="text">
                    <label for="pfEmail">Email</label><input id="pfEmail" type="email">
                    <label for="pfPhone">Phone</label><input id="pfPhone" type="text">
                    <label for="pfNotes">Notes</label><textarea id="pfNotes"></textarea>
                    <button class="btn btn-primary" type="submit">Save profile</button>
                </form>
            </div>
            <div class="card">
                <h2>Change password</h2>
                <form id="formPassword">
                    <label for="pwCurrent">Current password</label><input id="pwCurrent" type="password" required>
                    <label for="pwNew">New password</label><input id="pwNew" type="password" required>
                    <button class="btn btn-muted" type="submit">Change password</button>
                </form>
            </div>
        </section>

        <section class="panel" id="panel-orders">
            <div class="card" id="ordersAddCard">
                <h2>Add order</h2>
                <form id="formOrderAdd" class="row2">
                    <div><label for="oaChannel">Channel / table</label><input id="oaChannel" type="text" required></div>
                    <div><label for="oaCustomer">Customer</label><input id="oaCustomer" type="text"></div>
                    <div style="grid-column:1/-1"><label for="oaItems">Items</label><textarea id="oaItems" required></textarea></div>
                    <div><label for="oaTotal">Total (RM)</label><input id="oaTotal" type="text" value="0.00"></div>
                    <div><label for="oaStatus">Status</label><select id="oaStatus"></select></div>
                    <div style="grid-column:1/-1"><button class="btn btn-primary" type="submit">Create order</button></div>
                </form>
            </div>
            <div class="card">
                <h2>View / Edit / Delete order</h2>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>ID</th><th>Channel</th><th>Customer</th><th>Items</th><th>Status</th><th>Placed</th><th>Total</th><th>Actions</th></tr></thead>
                        <tbody id="ordersBody"></tbody>
                    </table>
                </div>
            </div>
        </section>

        <section class="panel" id="panel-menu">
            <div class="card" id="menuAddCard">
                <h2>Add menu</h2>
                <form id="formMenuAdd" class="row2">
                    <div><label for="maName">Name</label><input id="maName" type="text" required></div>
                    <div><label for="maCategory">Category</label><select id="maCategory"><option>Food</option><option>Drink</option><option>Dessert</option></select></div>
                    <div><label for="maPrice">Price (RM)</label><input id="maPrice" type="text" value="0.00"></div>
                    <div><label for="maAvail">Available</label><select id="maAvail"><option value="1">Yes</option><option value="0">No</option></select></div>
                    <div style="grid-column:1/-1"><label for="maDesc">Description</label><textarea id="maDesc"></textarea></div>
                    <div style="grid-column:1/-1"><button class="btn btn-primary" type="submit">Add menu item</button></div>
                </form>
            </div>
            <div class="card">
                <h2>View / Edit / Delete menu</h2>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Available</th><th>Description</th><th>Actions</th></tr></thead>
                        <tbody id="menuBody"></tbody>
                    </table>
                </div>
            </div>
        </section>

        <section class="panel" id="panel-feedback">
            <div class="card">
                <h2>View feedback</h2>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>When</th><th>Name</th><th>Email</th><th>Message</th></tr></thead>
                        <tbody id="feedbackBody"></tbody>
                    </table>
                </div>
            </div>
        </section>

        <section class="panel" id="panel-staff">
            <div class="card">
                <h2>Add staff</h2>
                <form id="formStaffAdd" class="row2">
                    <div><label for="saUsername">Username</label><input id="saUsername" type="text" required></div>
                    <div><label for="saPassword">Password</label><input id="saPassword" type="password" required></div>
                    <div><label for="saRole">Role</label><select id="saRole"><option value="staff">Staff</option><option value="admin">Admin</option></select></div>
                    <div><label for="saDisplayName">Display name</label><input id="saDisplayName" type="text"></div>
                    <div><label for="saEmail">Email</label><input id="saEmail" type="email" required></div>
                    <div><label for="saPhone">Phone</label><input id="saPhone" type="text"></div>
                    <div style="grid-column:1/-1"><button class="btn btn-primary" type="submit">Add account</button></div>
                </form>
            </div>
            <div class="card">
                <h2>View / Edit / Delete staff</h2>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>Username</th><th>Role</th><th>Name</th><th>Email</th><th>Verified</th><th>Phone</th><th>Actions</th></tr></thead>
                        <tbody id="staffBody"></tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>

<div id="toast"></div>

<div class="backdrop" id="orderModal"><div class="modal">
    <h3>Edit order</h3>
    <form id="formOrderEdit">
        <input id="oeId" type="hidden">
        <label for="oeChannel">Channel</label><input id="oeChannel" type="text" required>
        <label for="oeCustomer">Customer</label><input id="oeCustomer" type="text">
        <label for="oeItems">Items</label><textarea id="oeItems" required></textarea>
        <label for="oePlaced">Placed</label><input id="oePlaced" type="datetime-local">
        <label for="oeTotal">Total</label><input id="oeTotal" type="text">
        <label for="oeStatus">Status</label><select id="oeStatus"></select>
        <div class="modal-actions"><button class="btn btn-primary" type="submit">Save</button><button class="btn btn-muted" type="button" id="oeCancel">Cancel</button></div>
    </form>
</div></div>

<div class="backdrop" id="menuModal"><div class="modal">
    <h3>Edit menu</h3>
    <form id="formMenuEdit">
        <input id="meId" type="hidden">
        <label for="meName">Name</label><input id="meName" type="text" required>
        <label for="meCategory">Category</label><select id="meCategory"><option>Food</option><option>Drink</option><option>Dessert</option></select>
        <label for="mePrice">Price</label><input id="mePrice" type="text">
        <label for="meAvail">Available</label><select id="meAvail"><option value="1">Yes</option><option value="0">No</option></select>
        <label for="meDesc">Description</label><textarea id="meDesc"></textarea>
        <div class="modal-actions"><button class="btn btn-primary" type="submit">Save</button><button class="btn btn-muted" type="button" id="meCancel">Cancel</button></div>
    </form>
</div></div>

<div class="backdrop" id="staffModal"><div class="modal">
    <h3>Edit staff account</h3>
    <form id="formStaffEdit">
        <input id="seUsername" type="hidden">
        <label for="seRole">Role</label><select id="seRole"><option value="staff">Staff</option><option value="admin">Admin</option></select>
        <label for="seDisplayName">Display name</label><input id="seDisplayName" type="text">
        <label for="seEmail">Email</label><input id="seEmail" type="email">
        <label for="sePhone">Phone</label><input id="sePhone" type="text">
        <label for="sePassword">Reset password (optional)</label><input id="sePassword" type="password">
        <div class="modal-actions"><button class="btn btn-primary" type="submit">Save</button><button class="btn btn-muted" type="button" id="seCancel">Cancel</button></div>
    </form>
</div></div>

<script>
(function () {
    var state = { csrf: '', role: '<?php echo addslashes($role); ?>', permissions: [], orders: [], menu: [], feedback: [], staff: [], profile: {}, stats: {} };
    var STATUSES = ['New', 'Preparing', 'Ready', 'Served', 'Cancelled'];
    function $(id) { return document.getElementById(id); }
    function has(p) { return state.permissions.indexOf(p) >= 0; }
    function esc(s) { return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;'); }
    function toast(msg, err) { var t = $('toast'); t.textContent = msg; t.style.display = 'block'; t.style.borderColor = err ? '#a33' : '#444'; clearTimeout(toast._t); toast._t = setTimeout(function(){ t.style.display = 'none'; }, 3000); }
    function fmt(iso) { try { return new Date(iso).toLocaleString(); } catch (e) { return iso; } }
    function toInput(d) { if (!d) return ''; var x = new Date(String(d).replace(' ', 'T')); if (isNaN(x)) return ''; var p = function(n){return (n<10?'0':'')+n;}; return x.getFullYear()+'-'+p(x.getMonth()+1)+'-'+p(x.getDate())+'T'+p(x.getHours())+':'+p(x.getMinutes()); }
    function fromInput(v){ if(!v) return ''; var d = new Date(v); if (isNaN(d)) return ''; var p=function(n){return (n<10?'0':'')+n;}; return d.getFullYear()+'-'+p(d.getMonth()+1)+'-'+p(d.getDate())+' '+p(d.getHours())+':'+p(d.getMinutes())+':'+p(d.getSeconds()); }

    function fillStatus(sel){ sel.innerHTML = STATUSES.map(function(s){ return '<option>'+esc(s)+'</option>'; }).join(''); }
    fillStatus($('oaStatus')); fillStatus($('oeStatus'));

    function setupTabs() {
        var defs = [
            { key: 'overview', label: 'View dashboard', perm: 'view.dashboard' },
            { key: 'profile', label: 'View / Edit profile', perm: 'view.profile' },
            { key: 'orders', label: 'View order', perm: 'view.order' },
            { key: 'menu', label: 'View menu', perm: 'view.menu' },
            { key: 'feedback', label: 'View feedback', perm: 'view.feedback' },
            { key: 'staff', label: 'Manage staff', perm: 'view.staff' }
        ];
        var html = defs.filter(function(d){ return has(d.perm); }).map(function(d){
            return '<button type="button" class="tab-btn'+(d.key==='overview'?' active':'')+'" data-tab="'+d.key+'">'+d.label+'</button>';
        }).join('');
        $('tabs').innerHTML = html;
        $('tabs').querySelectorAll('.tab-btn').forEach(function(btn){
            btn.addEventListener('click', function(){
                var tab = btn.getAttribute('data-tab');
                $('tabs').querySelectorAll('.tab-btn').forEach(function(b){ b.classList.toggle('active', b===btn); });
                document.querySelectorAll('.panel').forEach(function(p){ p.classList.toggle('active', p.id === 'panel-' + tab); });
            });
        });
        if (!has('view.staff')) { $('panel-staff').style.display = 'none'; }
        if (!has('add.menu')) { $('menuAddCard').style.display = 'none'; }
        if (!has('edit.order')) { $('ordersAddCard').style.display = 'none'; }
    }

    function renderStats(){
        $('statOrdersToday').textContent = state.stats.ordersToday ?? '—';
        $('statRevenue').textContent = state.stats.revenueToday ?? '—';
        $('statPending').textContent = state.stats.pendingOrders ?? '—';
        $('statAvgPrep').textContent = state.stats.avgPrepMins ?? '—';
        $('syncText').textContent = 'Updated ' + fmt(state.stats.updatedAt || new Date().toISOString());
    }
    function renderProfile(){
        $('pfName').value = state.profile.displayName || '';
        $('pfEmail').value = state.profile.email || '';
        $('pfPhone').value = state.profile.phone || '';
        $('pfNotes').value = state.profile.notes || '';
    }
    function renderOrders(){
        var tb = $('ordersBody');
        if (!state.orders.length) { tb.innerHTML = '<tr><td colspan="8" class="muted">No orders.</td></tr>'; return; }
        tb.innerHTML = state.orders.map(function(o){
            var statusSel = STATUSES.map(function(s){ return '<option'+(o.status===s?' selected':'')+'>'+esc(s)+'</option>'; }).join('');
            var actions = '';
            if (has('edit.order')) actions += '<button class="btn-sm edit" type="button" data-edit-order="'+esc(o.id)+'">Edit</button>';
            if (has('delete.order')) actions += '<button class="btn-sm del" type="button" data-del-order="'+esc(o.id)+'">Delete</button>';
            return '<tr><td>'+esc(o.id)+'</td><td>'+esc(o.channel)+'</td><td>'+esc(o.customer||'')+'</td><td>'+esc(o.items)+'</td><td>' +
                (has('update.order.status') ? '<select data-status-id="'+esc(o.id)+'">'+statusSel+'</select>' : esc(o.status)) +
                '</td><td>'+esc(o.placed)+'</td><td>'+esc(o.total)+'</td><td class="actions">'+actions+'</td></tr>';
        }).join('');

        tb.querySelectorAll('[data-status-id]').forEach(function(sel){
            sel.addEventListener('change', function(){ api('order.setStatus', { id: sel.getAttribute('data-status-id'), status: sel.value }).then(afterAction); });
        });
        tb.querySelectorAll('[data-edit-order]').forEach(function(btn){
            btn.addEventListener('click', function(){
                var id = btn.getAttribute('data-edit-order'); var o = state.orders.find(function(x){return x.id===id;}); if (!o) return;
                $('oeId').value=o.id; $('oeChannel').value=o.channel; $('oeCustomer').value=o.customer||''; $('oeItems').value=o.items; $('oePlaced').value=toInput(o.placed); $('oeTotal').value=o.total; $('oeStatus').value=o.status;
                $('orderModal').classList.add('show');
            });
        });
        tb.querySelectorAll('[data-del-order]').forEach(function(btn){
            btn.addEventListener('click', function(){ var id = btn.getAttribute('data-del-order'); if(!confirm('Delete '+id+'?')) return; api('order.delete',{id:id}).then(afterAction); });
        });
    }
    function renderMenu(){
        var tb = $('menuBody');
        if (!state.menu.length) { tb.innerHTML = '<tr><td colspan="7" class="muted">No menu.</td></tr>'; return; }
        tb.innerHTML = state.menu.map(function(m){
            var actions = '';
            if (has('edit.menu')) actions += '<button class="btn-sm edit" type="button" data-edit-menu="'+esc(m.id)+'">Edit</button>';
            if (has('delete.menu')) actions += '<button class="btn-sm del" type="button" data-del-menu="'+esc(m.id)+'">Delete</button>';
            return '<tr><td>'+esc(m.id)+'</td><td>'+esc(m.name)+'</td><td>'+esc(m.category)+'</td><td>'+esc(m.price)+'</td><td>'+(m.available?'Yes':'No')+'</td><td>'+esc(m.description||'')+'</td><td class="actions">'+actions+'</td></tr>';
        }).join('');

        tb.querySelectorAll('[data-edit-menu]').forEach(function(btn){
            btn.addEventListener('click', function(){
                var id = btn.getAttribute('data-edit-menu'); var m = state.menu.find(function(x){return x.id===id;}); if(!m)return;
                $('meId').value=m.id; $('meName').value=m.name; $('meCategory').value=m.category; $('mePrice').value=m.price; $('meAvail').value=m.available?'1':'0'; $('meDesc').value=m.description||'';
                $('menuModal').classList.add('show');
            });
        });
        tb.querySelectorAll('[data-del-menu]').forEach(function(btn){
            btn.addEventListener('click', function(){ var id = btn.getAttribute('data-del-menu'); if(!confirm('Delete '+id+'?')) return; api('menu.delete',{id:id}).then(afterAction); });
        });
    }
    function renderFeedback(){
        var tb = $('feedbackBody');
        if (!state.feedback.length) { tb.innerHTML = '<tr><td colspan="4" class="muted">No feedback.</td></tr>'; return; }
        tb.innerHTML = state.feedback.map(function(f){ return '<tr><td>'+esc(f.created)+'</td><td>'+esc(f.name)+'</td><td>'+esc(f.email)+'</td><td>'+esc(f.message)+'</td></tr>'; }).join('');
    }
    function renderStaff(){
        if (!has('view.staff')) return;
        var tb = $('staffBody');
        if (!state.staff.length) { tb.innerHTML = '<tr><td colspan="7" class="muted">No staff records.</td></tr>'; return; }
        tb.innerHTML = state.staff.map(function(s){
            var canDelete = s.username !== '<?php echo addslashes($username); ?>';
            return '<tr><td>'+esc(s.username)+'</td><td>'+esc(s.role)+'</td><td>'+esc(s.displayName||'')+'</td><td>'+esc(s.email||'')+'</td><td>'+(s.emailVerified ? 'Yes' : 'No')+'</td><td>'+esc(s.phone||'')+'</td><td class="actions">'+
                '<button class="btn-sm edit" type="button" data-edit-staff="'+esc(s.username)+'">Edit</button>' +
                (canDelete?'<button class="btn-sm del" type="button" data-del-staff="'+esc(s.username)+'">Delete</button>':'') +
                '</td></tr>';
        }).join('');
        tb.querySelectorAll('[data-edit-staff]').forEach(function(btn){
            btn.addEventListener('click', function(){
                var u = btn.getAttribute('data-edit-staff');
                var s = state.staff.find(function(x){return x.username===u;}); if(!s) return;
                $('seUsername').value=s.username; $('seRole').value=s.role; $('seDisplayName').value=s.displayName||''; $('seEmail').value=s.email||''; $('sePhone').value=s.phone||''; $('sePassword').value='';
                $('staffModal').classList.add('show');
            });
        });
        tb.querySelectorAll('[data-del-staff]').forEach(function(btn){
            btn.addEventListener('click', function(){ var u = btn.getAttribute('data-del-staff'); if(!confirm('Delete '+u+'?')) return; api('staff.delete',{username:u}).then(afterAction); });
        });
    }

    function apply(data){
        state.csrf = data.csrf || state.csrf;
        state.role = data.role || state.role;
        state.permissions = data.permissions || [];
        state.orders = data.orders || [];
        state.menu = data.menu || [];
        state.feedback = data.feedback || [];
        state.staff = data.staff || [];
        state.profile = data.profile || {};
        state.stats = data.stats || {};
        setupTabs();
        renderStats(); renderProfile(); renderOrders(); renderMenu(); renderFeedback(); renderStaff();
    }
    function bootstrap(){
        return fetch('staff_api.php?type=bootstrap', {cache:'no-store'})
            .then(function(r){ if(r.status===401){ location.href='login.php'; throw new Error('auth'); } if(!r.ok) throw new Error(); return r.json(); })
            .then(function(data){ if(!data.ok) throw new Error(data.error||'Failed'); apply(data); })
            .catch(function(){ toast('Failed to load dashboard', true); });
    }
    function api(action, payload){
        return fetch('staff_api.php', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ csrf: state.csrf, action: action, payload: payload || {} }) })
            .then(function(r){ if(r.status===401){ location.href='login.php'; return {ok:false,error:'Unauthorized'};} return r.json(); });
    }
    function afterAction(r){ if(r && r.ok){ toast('Saved'); bootstrap(); } else { toast((r && r.error) || 'Action failed', true); } }

    $('btnSync').addEventListener('click', bootstrap);
    $('formProfile').addEventListener('submit', function(e){ e.preventDefault(); api('profile.update',{ displayName:$('pfName').value,email:$('pfEmail').value,phone:$('pfPhone').value,notes:$('pfNotes').value }).then(afterAction); });
    $('formPassword').addEventListener('submit', function(e){ e.preventDefault(); api('password.change',{ currentPassword:$('pwCurrent').value,newPassword:$('pwNew').value }).then(function(r){ if(r.ok){ toast('Password changed'); $('formPassword').reset(); } else { toast(r.error||'Failed', true);} }); });
    $('formOrderAdd').addEventListener('submit', function(e){ e.preventDefault(); api('order.create',{ channel:$('oaChannel').value,customer:$('oaCustomer').value,items:$('oaItems').value,total:$('oaTotal').value,status:$('oaStatus').value }).then(function(r){ if(r.ok){ $('formOrderAdd').reset(); $('oaTotal').value='0.00'; } afterAction(r);}); });
    $('formOrderEdit').addEventListener('submit', function(e){ e.preventDefault(); api('order.update',{ id:$('oeId').value,channel:$('oeChannel').value,customer:$('oeCustomer').value,items:$('oeItems').value,placed:fromInput($('oePlaced').value),total:$('oeTotal').value,status:$('oeStatus').value }).then(function(r){ if(r.ok){ $('orderModal').classList.remove('show'); } afterAction(r);}); });
    $('oeCancel').addEventListener('click', function(){ $('orderModal').classList.remove('show'); });
    $('formMenuAdd').addEventListener('submit', function(e){ e.preventDefault(); api('menu.create',{ name:$('maName').value,category:$('maCategory').value,price:$('maPrice').value,description:$('maDesc').value,available:$('maAvail').value==='1' }).then(function(r){ if(r.ok){ $('formMenuAdd').reset(); $('maAvail').value='1'; } afterAction(r);}); });
    $('formMenuEdit').addEventListener('submit', function(e){ e.preventDefault(); api('menu.update',{ id:$('meId').value,name:$('meName').value,category:$('meCategory').value,price:$('mePrice').value,description:$('meDesc').value,available:$('meAvail').value==='1' }).then(function(r){ if(r.ok){ $('menuModal').classList.remove('show'); } afterAction(r);}); });
    $('meCancel').addEventListener('click', function(){ $('menuModal').classList.remove('show'); });
    $('formStaffAdd').addEventListener('submit', function(e){ e.preventDefault(); api('staff.create',{ username:$('saUsername').value,password:$('saPassword').value,role:$('saRole').value,displayName:$('saDisplayName').value,email:$('saEmail').value,phone:$('saPhone').value }).then(function(r){ if(r.ok){ $('formStaffAdd').reset(); } afterAction(r);}); });
    $('formStaffEdit').addEventListener('submit', function(e){ e.preventDefault(); api('staff.update',{ username:$('seUsername').value,role:$('seRole').value,displayName:$('seDisplayName').value,email:$('seEmail').value,phone:$('sePhone').value,password:$('sePassword').value }).then(function(r){ if(r.ok){ $('staffModal').classList.remove('show'); } afterAction(r);}); });
    $('seCancel').addEventListener('click', function(){ $('staffModal').classList.remove('show'); });

    ['orderModal','menuModal','staffModal'].forEach(function(id){ $(id).addEventListener('click', function(e){ if(e.target===$(id)){ $(id).classList.remove('show'); } }); });
    bootstrap().then(function(){ setInterval(bootstrap, 20000); });
})();
</script>
</body>
</html>
