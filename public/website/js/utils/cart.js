/**
 * Cart Management Utility
 * Handles shopping cart operations
 */

const Cart = {
    items: JSON.parse(localStorage.getItem('cart')) || [],
    
    init() {
        this.updateCartCount();
        this.loadCartItems();
    },
    
    add(productId, quantity = 1, options = {}) {
        const existingItem = this.items.find(item => 
            item.id === productId && 
            JSON.stringify(item.options) === JSON.stringify(options)
        );
        
        if (existingItem) {
            existingItem.quantity += quantity;
        } else {
            this.items.push({
                id: productId,
                quantity,
                options,
                addedAt: new Date().toISOString()
            });
        }
        
        this.save();
        this.updateCartCount();
        this.showNotification('Item added to cart');
    },
    
    remove(itemIndex) {
        this.items.splice(itemIndex, 1);
        this.save();
        this.updateCartCount();
        this.loadCartItems();
    },
    
    updateQuantity(itemIndex, quantity) {
        if (quantity <= 0) {
            this.remove(itemIndex);
            return;
        }
        this.items[itemIndex].quantity = quantity;
        this.save();
        this.loadCartItems();
    },
    
    clear() {
        this.items = [];
        this.save();
        this.updateCartCount();
        this.loadCartItems();
    },
    
    getTotalItems() {
        return this.items.reduce((sum, item) => sum + item.quantity, 0);
    },
    
    save() {
        localStorage.setItem('cart', JSON.stringify(this.items));
    },
    
    updateCartCount() {
        const countElements = document.querySelectorAll('.header__badge:not(.wishlist-count)');
        const count = this.getTotalItems();
        countElements.forEach(el => {
            if (count > 0) {
                el.textContent = count;
                el.style.display = 'flex';
            } else {
                el.style.display = 'none';
            }
        });
    },
    
    loadCartItems() {
        const event = new CustomEvent('cartUpdated', { detail: this.items });
        document.dispatchEvent(event);
    },
    
    showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: #10b981;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            z-index: 10000;
            animation: slideIn 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
};
