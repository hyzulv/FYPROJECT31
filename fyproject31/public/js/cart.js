const CartManager = function() {
    const CART_KEY = 'matrock_cart';

    let cart = [];

    function init() {
        const savedCart = localStorage.getItem(CART_KEY);
        if (savedCart) {
            try {
                cart = JSON.parse(savedCart);
            } catch (e) {
                cart = [];
            }
        }
        updateCartDisplay();
    }

    function save() {
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
        updateCartDisplay();
    }

    function getCart() {
        return cart;
    }

    function addItem(item) {
        const existing = cart.find(i => i.id === item.id);
        if (existing) {
            existing.quantity += 1;
        } else {
            cart.push({
                id: item.id,
                name: item.name,
                price: item.price,
                quantity: 1
            });
        }
        save();
        showAddToCartAnimation();
    }

    function removeItem(id) {
        cart = cart.filter(i => i.id !== id);
        save();
    }

    function increaseItem(id) {
        const item = cart.find(i => i.id === id);
        if (item) {
            item.quantity += 1;
            save();
        }
    }

    function decreaseItem(id) {
        const item = cart.find(i => i.id === id);
        if (item) {
            item.quantity -= 1;
            if (item.quantity <= 0) {
                removeItem(id);
            } else {
                save();
            }
        }
    }

    function clearCart() {
        cart = [];
        save();
    }

    function getTotalItems() {
        return cart.reduce((sum, item) => sum + item.quantity, 0);
    }

    function updateCartDisplay() {
        const count = getTotalItems();
        const cartCountEls = document.querySelectorAll('#cartCount, #floatingCartCount');
        cartCountEls.forEach(el => {
            if (el) {
                el.textContent = count;
                el.style.display = count > 0 ? 'flex' : 'none';
            }
        });

        const floatingCartBtn = document.getElementById('floatingCartBtn');
        if (floatingCartBtn) {
            floatingCartBtn.style.display = count > 0 ? 'flex' : 'none';
        }
    }

    function showAddToCartAnimation() {
        const floatingCartBtn = document.getElementById('floatingCartBtn');
        if (floatingCartBtn) {
            floatingCartBtn.style.transform = 'scale(1.2)';
            setTimeout(() => {
                floatingCartBtn.style.transform = '';
            }, 300);
        }
    }

    init();

    return {
        getCart,
        addItem,
        removeItem,
        increaseItem,
        decreaseItem,
        clearCart,
        getTotalItems,
        updateCartDisplay
    };
};

window.cartManager = CartManager();
