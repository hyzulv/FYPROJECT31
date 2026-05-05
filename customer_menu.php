<?php
$tableRaw = isset($_GET['table']) ? trim((string)$_GET['table']) : '';
$tableSafe = htmlspecialchars($tableRaw, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mat Rock Customer Menu</title>
    <style>
        :root {
            --bg: #0e0e0e;
            --card: #1b1b1b;
            --card2: #232323;
            --line: #353535;
            --text: #f4f4f4;
            --muted: #b0b0b0;
            --red: #ff0000;
            --red-dark: #c70000;
            --ok: #2e7d32;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            padding-bottom: 92px;
        }
        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            background: linear-gradient(180deg, #1a1a1a, #131313);
            border-bottom: 2px solid var(--red);
            padding: 12px 14px;
        }
        .brand {
            font-weight: 700;
            font-size: 1.05rem;
            margin: 0 0 6px;
        }
        .table-line {
            font-size: 0.9rem;
            color: var(--muted);
            margin: 0;
        }
        .wrap {
            padding: 12px;
            max-width: 760px;
            margin: 0 auto;
        }
        .section-title {
            margin: 14px 0 10px;
            font-size: 1.08rem;
            color: #fff;
            border-left: 4px solid var(--red);
            padding-left: 8px;
        }
        .chips {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 6px;
        }
        .chip {
            border: 1px solid var(--line);
            background: #1c1c1c;
            color: #fff;
            border-radius: 999px;
            padding: 8px 12px;
            white-space: nowrap;
            font-size: 0.84rem;
            cursor: pointer;
        }
        .chip.active {
            background: var(--red);
            border-color: var(--red);
        }
        .menu-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
            margin-top: 12px;
        }
        .item {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 12px;
        }
        .item h3 {
            margin: 0 0 4px;
            font-size: 0.98rem;
            color: #fff;
        }
        .meta {
            color: var(--muted);
            font-size: 0.84rem;
            margin-bottom: 8px;
        }
        .item-foot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
        }
        .price {
            color: #ff6d6d;
            font-weight: 700;
            font-size: 0.98rem;
        }
        .btn {
            border: none;
            border-radius: 7px;
            padding: 9px 11px;
            font-weight: 700;
            cursor: pointer;
            font-size: 0.85rem;
            font-family: inherit;
        }
        .btn-add { background: var(--red); color: #fff; }
        .btn-add:hover { background: var(--red-dark); }
        .bottom-nav {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 30;
            background: #141414;
            border-top: 1px solid var(--line);
            display: grid;
            grid-template-columns: repeat(6, 1fr);
        }
        .nav-btn {
            background: transparent;
            color: #ddd;
            border: none;
            padding: 10px 6px;
            font-size: 0.78rem;
            cursor: pointer;
        }
        .nav-btn.active { color: #fff; background: #232323; }
        .view { display: none; }
        .view.active { display: block; }
        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 12px;
            margin-top: 10px;
        }
        .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }
        .cart-item {
            padding: 9px 0;
            border-bottom: 1px dashed #3f3f3f;
        }
        .qty-wrap {
            display: inline-flex;
            align-items: center;
            border: 1px solid var(--line);
            border-radius: 6px;
            overflow: hidden;
        }
        .qty-wrap button {
            border: none;
            background: #2a2a2a;
            color: #fff;
            width: 28px;
            height: 28px;
            cursor: pointer;
        }
        .qty-wrap span {
            min-width: 28px;
            text-align: center;
            font-size: 0.86rem;
        }
        input, select, textarea {
            width: 100%;
            background: #101010;
            color: #fff;
            border: 1px solid var(--line);
            border-radius: 7px;
            padding: 10px;
            font-family: inherit;
            margin-top: 4px;
            margin-bottom: 10px;
        }
        .btn-full {
            width: 100%;
            background: var(--red);
            color: #fff;
        }
        .ok {
            color: #9be79f;
            font-weight: 700;
        }
        .muted { color: var(--muted); }
    </style>
</head>
<body>
    <header class="topbar">
        <p class="brand">MAT ROCK Customer Ordering</p>
        <p class="table-line">Table: <strong id="tableLabel"><?php echo $tableSafe !== '' ? $tableSafe : 'Not set'; ?></strong></p>
    </header>

    <main class="wrap">
        <section id="view-menu" class="view active">
            <h2 class="section-title">View menu</h2>
            <div id="categoryChips" class="chips"></div>
            <div id="menuGrid" class="menu-grid"></div>
        </section>

        <section id="view-cart" class="view">
            <h2 class="section-title">View cart</h2>
            <div class="card">
                <div id="cartItems"></div>
                <div id="cartTotals"></div>
            </div>
        </section>

        <section id="view-checkout" class="view">
            <h2 class="section-title">Checkout</h2>
            <div class="card">
                <label>Name
                    <input id="customerName" type="text" placeholder="Customer name">
                </label>
                <label>Phone
                    <input id="customerPhone" type="text" placeholder="e.g. 0123456789">
                </label>
                <label>Order note
                    <textarea id="customerNote" placeholder="Less spicy, no onions, etc."></textarea>
                </label>
                <button class="btn btn-full" id="btnProceedPayment" type="button">Proceed to payment</button>
            </div>
        </section>

        <section id="view-payment" class="view">
            <h2 class="section-title">Make payment</h2>
            <div class="card">
                <label>Payment method
                    <select id="paymentMethod">
                        <option value="DuitNow QR">DuitNow QR</option>
                        <option value="Card">Card</option>
                        <option value="Cash">Cash</option>
                    </select>
                </label>
                <p class="muted">For demo, tap the button below to confirm payment.</p>
                <button class="btn btn-full" id="btnPayNow" type="button">Pay now</button>
            </div>
        </section>

        <section id="view-receipt" class="view">
            <h2 class="section-title">View receipt</h2>
            <div id="receiptBox" class="card"></div>
        </section>

        <section id="view-status" class="view">
            <h2 class="section-title">View order status</h2>
            <div id="statusBox" class="card"></div>
        </section>
        <section id="view-feedback" class="view">
            <h2 class="section-title">Submit feedback</h2>
            <div class="card">
                <label>Name
                    <input id="fbName" type="text" placeholder="Your name">
                </label>
                <label>Email
                    <input id="fbEmail" type="email" placeholder="your@email.com">
                </label>
                <label>Feedback
                    <textarea id="fbMessage" placeholder="Share your experience..." required></textarea>
                </label>
                <button class="btn btn-full" id="btnSubmitFeedback" type="button">Submit feedback</button>
                <p id="fbResult" class="muted" style="margin-top:10px;"></p>
            </div>
        </section>
    </main>

    <nav class="bottom-nav">
        <button class="nav-btn active" data-view="menu">Menu</button>
        <button class="nav-btn" data-view="cart">Cart</button>
        <button class="nav-btn" data-view="checkout">Checkout</button>
        <button class="nav-btn" data-view="receipt">Receipt</button>
        <button class="nav-btn" data-view="status">Status</button>
        <button class="nav-btn" data-view="feedback">Feedback</button>
    </nav>

    <script>
        const tableFromUrl = <?php echo json_encode($tableRaw); ?>;
        const storageKey = "matrock_customer_state";
        const menuItems = [
            { id: "F001", category: "Signature Kunyit", name: "Ayam Goreng Kunyit + Nasi", price: 10.00 },
            { id: "F002", category: "Signature Kunyit", name: "Daging Goreng Kunyit + Nasi", price: 11.50 },
            { id: "F003", category: "Signature Kunyit", name: "Sotong Goreng Kunyit + Nasi", price: 14.00 },
            { id: "F004", category: "Signature Kunyit", name: "Udang Goreng Kunyit + Nasi", price: 15.50 },
            { id: "F005", category: "Signature Kunyit", name: "Campur Ayam+Daging Kunyit", price: 13.50 },

            { id: "F006", category: "Nasi", name: "Nasi Goreng Kampung", price: 9.50 },
            { id: "F007", category: "Nasi", name: "Nasi Goreng Pattaya", price: 10.50 },
            { id: "F008", category: "Nasi", name: "Nasi Goreng Ayam", price: 9.00 },
            { id: "F009", category: "Nasi", name: "Nasi Putih", price: 2.00 },
            { id: "F010", category: "Nasi", name: "Nasi Tambah", price: 1.50 },

            { id: "F011", category: "Mee", name: "Mee Goreng Mamak", price: 8.50 },
            { id: "F012", category: "Mee", name: "Bihun Goreng", price: 8.00 },
            { id: "F013", category: "Mee", name: "Kuey Teow Goreng", price: 8.50 },
            { id: "F014", category: "Mee", name: "Maggi Goreng", price: 8.00 },
            { id: "F015", category: "Mee", name: "Mee Sup", price: 8.00 },

            { id: "F016", category: "Sides", name: "Telur Mata", price: 2.00 },
            { id: "F017", category: "Sides", name: "Telur Dadar", price: 2.50 },
            { id: "F018", category: "Sides", name: "Sambal Extra", price: 1.50 },
            { id: "F019", category: "Sides", name: "Ayam Crispy Extra", price: 5.00 },
            { id: "F020", category: "Sides", name: "Keropok", price: 2.00 },

            { id: "D001", category: "Drinks", name: "Teh Ais", price: 3.00 },
            { id: "D002", category: "Drinks", name: "Teh O Ais Limau", price: 3.50 },
            { id: "D003", category: "Drinks", name: "Kopi Ais", price: 3.50 },
            { id: "D004", category: "Drinks", name: "Sirap Limau", price: 3.00 },
            { id: "D005", category: "Drinks", name: "Milo Ais", price: 4.50 },
            { id: "D006", category: "Drinks", name: "Jus Oren", price: 5.00 },
            { id: "D007", category: "Drinks", name: "Air Mineral", price: 2.00 }
        ];

        let state = {
            table: "",
            activeCategory: "All",
            cart: [],
            order: null,
            statusText: ""
        };
        let statusTimer = null;

        function money(value) {
            return "RM " + Number(value).toFixed(2);
        }

        function loadState() {
            const raw = localStorage.getItem(storageKey);
            if (raw) {
                try { state = { ...state, ...JSON.parse(raw) }; } catch (_) {}
            }
            if (tableFromUrl) state.table = tableFromUrl;
            if (!state.table) {
                const input = prompt("Enter table number (after scan QR):", "T01");
                state.table = (input || "T01").trim().toUpperCase();
            }
            document.getElementById("tableLabel").textContent = state.table;
            saveState();
        }

        function saveState() {
            localStorage.setItem(storageKey, JSON.stringify(state));
        }

        function renderCategories() {
            const categories = ["All", ...new Set(menuItems.map(item => item.category))];
            const chips = document.getElementById("categoryChips");
            chips.innerHTML = categories.map(cat => (
                `<button class="chip ${state.activeCategory === cat ? "active" : ""}" data-cat="${cat}">${cat}</button>`
            )).join("");
            chips.querySelectorAll(".chip").forEach(chip => {
                chip.addEventListener("click", () => {
                    state.activeCategory = chip.dataset.cat;
                    saveState();
                    renderCategories();
                    renderMenu();
                });
            });
        }

        function addToCart(itemId) {
            const item = menuItems.find(x => x.id === itemId);
            if (!item) return;
            const found = state.cart.find(x => x.id === itemId);
            if (found) {
                found.qty += 1;
            } else {
                state.cart.push({ id: item.id, name: item.name, price: item.price, qty: 1 });
            }
            saveState();
            renderCart();
        }

        function renderMenu() {
            const grid = document.getElementById("menuGrid");
            const filtered = state.activeCategory === "All"
                ? menuItems
                : menuItems.filter(item => item.category === state.activeCategory);
            grid.innerHTML = filtered.map(item => `
                <article class="item">
                    <h3>${item.name}</h3>
                    <div class="meta">${item.category} • ${item.id}</div>
                    <div class="item-foot">
                        <span class="price">${money(item.price)}</span>
                        <button class="btn btn-add" data-add="${item.id}">Add to cart</button>
                    </div>
                </article>
            `).join("");
            grid.querySelectorAll("[data-add]").forEach(btn => {
                btn.addEventListener("click", () => addToCart(btn.dataset.add));
            });
        }

        function cartSubtotal() {
            return state.cart.reduce((sum, item) => sum + item.price * item.qty, 0);
        }

        function updateQty(itemId, delta) {
            const found = state.cart.find(x => x.id === itemId);
            if (!found) return;
            found.qty += delta;
            if (found.qty <= 0) state.cart = state.cart.filter(x => x.id !== itemId);
            saveState();
            renderCart();
        }

        function renderCart() {
            const list = document.getElementById("cartItems");
            const totals = document.getElementById("cartTotals");
            if (state.cart.length === 0) {
                list.innerHTML = `<p class="muted">Your cart is empty.</p>`;
                totals.innerHTML = "";
                return;
            }
            list.innerHTML = state.cart.map(item => `
                <div class="cart-item">
                    <div class="row">
                        <div>
                            <strong>${item.name}</strong><br>
                            <span class="muted">${money(item.price)} each</span>
                        </div>
                        <div class="qty-wrap">
                            <button data-minus="${item.id}">-</button>
                            <span>${item.qty}</span>
                            <button data-plus="${item.id}">+</button>
                        </div>
                    </div>
                </div>
            `).join("");
            const subtotal = cartSubtotal();
            const service = subtotal * 0.05;
            const total = subtotal + service;
            totals.innerHTML = `
                <div class="row"><span>Subtotal</span><strong>${money(subtotal)}</strong></div>
                <div class="row"><span>Service (5%)</span><strong>${money(service)}</strong></div>
                <div class="row"><span>Total</span><strong>${money(total)}</strong></div>
            `;
            list.querySelectorAll("[data-minus]").forEach(btn => btn.addEventListener("click", () => updateQty(btn.dataset.minus, -1)));
            list.querySelectorAll("[data-plus]").forEach(btn => btn.addEventListener("click", () => updateQty(btn.dataset.plus, 1)));
        }

        function switchView(viewName) {
            document.querySelectorAll(".view").forEach(v => v.classList.remove("active"));
            document.querySelectorAll(".nav-btn").forEach(v => v.classList.remove("active"));
            document.getElementById(`view-${viewName}`).classList.add("active");
            document.querySelector(`.nav-btn[data-view="${viewName}"]`).classList.add("active");
            if (viewName === "receipt") renderReceipt();
            if (viewName === "status") {
                renderStatus();
                fetchStatus();
            }
        }

        function checkoutToPayment() {
            if (state.cart.length === 0) {
                alert("Cart is empty. Please add items first.");
                return;
            }
            switchView("payment");
        }

        function buildItemsSummary() {
            return state.cart.map(item => `${item.name} x${item.qty}`).join(", ");
        }

        function fetchStatus() {
            if (!state.order || !state.order.id) return Promise.resolve();
            return fetch(`customer_api.php?action=orderStatus&id=${encodeURIComponent(state.order.id)}`, { cache: "no-store" })
                .then(r => r.json())
                .then(data => {
                    if (data.ok && data.order) {
                        state.statusText = data.order.status || "New";
                        saveState();
                        renderStatus();
                    }
                })
                .catch(() => {});
        }

        function payNow() {
            if (state.cart.length === 0) {
                alert("Cart is empty.");
                return;
            }
            const subtotal = cartSubtotal();
            const service = subtotal * 0.05;
            const total = subtotal + service;
            const customerName = document.getElementById("customerName").value || "Guest";
            const customerPhone = document.getElementById("customerPhone").value || "-";
            const note = document.getElementById("customerNote").value || "-";
            const method = document.getElementById("paymentMethod").value;
            const payload = {
                table: state.table,
                customerName,
                customerPhone,
                note,
                paymentMethod: method,
                total: total.toFixed(2),
                itemsSummary: buildItemsSummary()
            };

            fetch("customer_api.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action: "placeOrder", payload })
            })
                .then(r => r.json())
                .then(data => {
                    if (!data.ok || !data.order) {
                        alert("Payment/order failed. Please try again.");
                        return;
                    }
                    state.order = {
                        id: data.order.id,
                        table: state.table,
                        customerName,
                        customerPhone,
                        note,
                        method,
                        items: [...state.cart],
                        subtotal,
                        service,
                        total,
                        paidAt: new Date().toISOString()
                    };
                    state.statusText = data.order.status || "New";
                    state.cart = [];
                    saveState();
                    renderCart();
                    renderReceipt();
                    renderStatus();
                    switchView("receipt");
                    if (statusTimer) clearInterval(statusTimer);
                    statusTimer = setInterval(fetchStatus, 8000);
                })
                .catch(() => {
                    alert("Could not connect to server.");
                });
        }

        function submitFeedback() {
            const name = document.getElementById("fbName").value.trim() || "Guest";
            const email = document.getElementById("fbEmail").value.trim();
            const message = document.getElementById("fbMessage").value.trim();
            const result = document.getElementById("fbResult");

            if (!message) {
                result.textContent = "Please enter feedback message first.";
                result.style.color = "#ff9f9f";
                return;
            }

            fetch("customer_api.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    action: "submitFeedback",
                    payload: { name, email, message }
                })
            })
                .then(r => r.json())
                .then(data => {
                    if (!data.ok) {
                        result.textContent = data.error || "Failed to submit feedback.";
                        result.style.color = "#ff9f9f";
                        return;
                    }
                    result.textContent = "Thank you! Your feedback has been submitted.";
                    result.style.color = "#9be79f";
                    document.getElementById("fbMessage").value = "";
                })
                .catch(() => {
                    result.textContent = "Could not connect to server.";
                    result.style.color = "#ff9f9f";
                });
        }

        function renderReceipt() {
            const box = document.getElementById("receiptBox");
            if (!state.order) {
                box.innerHTML = `<p class="muted">No receipt yet. Complete payment first.</p>`;
                return;
            }
            box.innerHTML = `
                <div class="row"><span>Order ID</span><strong>${state.order.id}</strong></div>
                <div class="row"><span>Table</span><strong>${state.order.table}</strong></div>
                <div class="row"><span>Customer</span><strong>${state.order.customerName}</strong></div>
                <div class="row"><span>Payment</span><strong>${state.order.method}</strong></div>
                <hr style="border-color:#333;">
                ${state.order.items.map(item => `
                    <div class="row">
                        <span>${item.name} x ${item.qty}</span>
                        <strong>${money(item.price * item.qty)}</strong>
                    </div>
                `).join("")}
                <hr style="border-color:#333;">
                <div class="row"><span>Subtotal</span><strong>${money(state.order.subtotal)}</strong></div>
                <div class="row"><span>Service (5%)</span><strong>${money(state.order.service)}</strong></div>
                <div class="row"><span>Total Paid</span><strong>${money(state.order.total)}</strong></div>
                <p class="ok">Payment successful</p>
            `;
        }

        function renderStatus() {
            const box = document.getElementById("statusBox");
            if (!state.order) {
                box.innerHTML = `<p class="muted">No active order. Please checkout first.</p>`;
                return;
            }
            box.innerHTML = `
                <div class="row"><span>Order ID</span><strong>${state.order.id}</strong></div>
                <div class="row"><span>Table</span><strong>${state.order.table}</strong></div>
                <div class="row"><span>Current status</span><strong>${state.statusText || "New"}</strong></div>
                <hr style="border-color:#333;">
                <p class="muted">Status akan ikut kemas kini dari staff dashboard secara live.</p>
            `;
        }

        document.querySelectorAll(".nav-btn").forEach(btn => {
            btn.addEventListener("click", () => switchView(btn.dataset.view));
        });
        document.getElementById("btnProceedPayment").addEventListener("click", checkoutToPayment);
        document.getElementById("btnPayNow").addEventListener("click", payNow);
        document.getElementById("btnSubmitFeedback").addEventListener("click", submitFeedback);

        loadState();
        renderCategories();
        renderMenu();
        renderCart();
        renderReceipt();
        renderStatus();
        if (state.order && state.order.id) {
            statusTimer = setInterval(fetchStatus, 8000);
            fetchStatus();
        }
    </script>
</body>
</html>
