const CartManager = function() {
    const CART_KEY = 'matrock_cart';
    let cart = [];

    function init() {
        const savedCart = localStorage.getItem(CART_KEY);
        if (savedCart) {
            try {
                const parsed = JSON.parse(savedCart);
                cart = parsed.map(item => {
                    if (!item.key) {
                        const addons = item.addons || [];
                        item.key = generateKey(item.id, addons);
                    }
                    return item;
                });
            } catch (e) {
                cart = [];
            }
            save();
        }
        updateCartDisplay();
    }

    function save() {
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
        updateCartDisplay();
    }

    function generateKey(id, addons) {
        const addonIds = addons ? addons.map(a => a.id).sort((a, b) => a - b).join(',') : '';
        return id + '-' + addonIds;
    }

    function getCart() {
        return cart;
    }

    function addItem(item) {
        reloadFromStorage();
        const addons = item.addons || [];
        const key = generateKey(item.id, addons);
        const existing = cart.findIndex(i => i.key === key);
        if (existing >= 0) {
            cart[existing].quantity += item.quantity;
        } else {
            cart.push({
                key: key,
                id: item.id,
                name: item.name,
                price: item.price,
                quantity: item.quantity,
                addons: addons.map(a => ({ id: a.id, name: a.name, price: parseFloat(a.price) }))
            });
        }
        save();
        showAddToCartAnimation();
    }

    function removeItem(key) {
        reloadFromStorage();
        cart = cart.filter(i => i.key !== key);
        save();
    }

    function increaseItem(key) {
        reloadFromStorage();
        const item = cart.find(i => i.key === key);
        if (item) { item.quantity += 1; save(); }
    }

    function decreaseItem(key) {
        reloadFromStorage();
        const item = cart.find(i => i.key === key);
        if (item) {
            item.quantity -= 1;
            if (item.quantity <= 0) { removeItem(key); } else { save(); }
        }
    }

    function reloadFromStorage() {
        const savedCart = localStorage.getItem(CART_KEY);
        if (savedCart) {
            try {
                const parsed = JSON.parse(savedCart);
                cart = parsed.map(item => {
                    if (!item.key) {
                        const addons = item.addons || [];
                        item.key = generateKey(item.id, addons);
                    }
                    return item;
                });
            } catch (e) {
                cart = [];
            }
        } else {
            cart = [];
        }
    }

    function clearCart() {
        reloadFromStorage();
        cart = [];
        localStorage.removeItem(CART_KEY);
        updateCartDisplay();
    }

    function getTotalItems() {
        return cart.reduce((sum, item) => sum + item.quantity, 0);
    }

    function getStoredCount() {
        try {
            const savedCart = localStorage.getItem(CART_KEY);
            if (savedCart) {
                const parsed = JSON.parse(savedCart);
                return parsed.reduce((sum, item) => sum + (item.quantity || 0), 0);
            }
        } catch (e) {}
        return 0;
    }

    function updateCartDisplay() {
        reloadFromStorage();
        const count = getStoredCount();
        document.querySelectorAll('#cartCount, #floatingCartCount').forEach(el => {
            if (el) {
                el.textContent = count;
                el.style.display = count > 0 ? 'flex' : 'none';
            }
        });
        const floatingCartBtn = document.getElementById('floatingCartBtn');
        if (floatingCartBtn) {
            floatingCartBtn.style.display = count > 0 ? 'flex' : 'none';
        }
        if (typeof window.onCartUpdate === 'function') {
            window.onCartUpdate();
        }
        const cartItemsEl = document.getElementById('cartItems');
        if (cartItemsEl && typeof window.renderCartPage === 'function') {
            window.renderCartPage();
        }
    }

    function showAddToCartAnimation() {
        const btn = document.getElementById('floatingCartBtn');
        if (btn) {
            btn.style.transform = 'scale(1.2)';
            setTimeout(() => { btn.style.transform = ''; }, 300);
        }
    }

    init();

    return {
        getCart, addItem, removeItem, increaseItem, decreaseItem,
        clearCart, getTotalItems, updateCartDisplay, reloadFromStorage
    };
};

window.cartManager = CartManager();

function refreshCartDisplay() {
    window.cartManager.updateCartDisplay();
}

window.addEventListener('pageshow', refreshCartDisplay);
document.addEventListener('visibilitychange', function() {
    if (!document.hidden) {
        refreshCartDisplay();
    }
});
