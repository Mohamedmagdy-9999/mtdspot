/**
 * Wishlist Management Utility
 * Handles wishlist operations
 */

const Wishlist = {
    items: JSON.parse(localStorage.getItem('wishlist')) || [],
    
    init() {
        this.updateWishlistCount();
        this.loadWishlistItems();
    },
    
    add(productId) {
        if (!this.items.includes(productId)) {
            this.items.push(productId);
            this.save();
            this.updateWishlistCount();
            this.showNotification('Added to wishlist');
        }
    },
    
    remove(productId) {
        this.items = this.items.filter(id => id !== productId);
        this.save();
        this.updateWishlistCount();
        this.loadWishlistItems();
    },
    
    toggle(productId) {
        if (this.items.includes(productId)) {
            this.remove(productId);
        } else {
            this.add(productId);
        }
    },
    
    isInWishlist(productId) {
        return this.items.includes(productId);
    },
    
    save() {
        localStorage.setItem('wishlist', JSON.stringify(this.items));
    },
    
    updateWishlistCount() {
        const countElements = document.querySelectorAll('.wishlist-count');
        const count = this.items.length;
        countElements.forEach(el => {
            if (count > 0) {
                el.textContent = count;
                el.style.display = 'flex';
            } else {
                el.style.display = 'none';
            }
        });
    },
    
    loadWishlistItems() {
        const event = new CustomEvent('wishlistUpdated', { detail: this.items });
        document.dispatchEvent(event);
    },
    
    showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.innerHTML = `<i class="fas fa-heart"></i> ${message}`;
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
