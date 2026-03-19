/**
 * Main JavaScript Module
 * Entry point for application initialization
 * Loads all utilities and components
 */

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', () => {
    // Initialize utilities
    if (typeof Cart !== 'undefined') Cart.init();
    if (typeof Wishlist !== 'undefined') Wishlist.init();
    if (typeof ScrollAnimation !== 'undefined') ScrollAnimation.init();
    if (typeof QuantitySelector !== 'undefined') QuantitySelector.init();
    if (typeof Modal !== 'undefined') Modal.init();
    
    // Initialize UI components
    if (typeof Slider !== 'undefined') {
        document.querySelectorAll('.slider').forEach(slider => {
            Slider.init(slider);
        });
    }
    
    if (typeof Tabs !== 'undefined') {
        document.querySelectorAll('.tabs').forEach(tabs => {
            Tabs.init(tabs);
        });
    }
    
    // Initialize form validators
    if (typeof FormValidator !== 'undefined') {
        document.querySelectorAll('.form').forEach(form => {
            FormValidator.init(form);
        });
    }
    
    // Add to cart buttons
    document.querySelectorAll('[data-add-to-cart]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            if (typeof Cart !== 'undefined') {
                const productId = btn.dataset.addToCart;
                const quantity = parseInt(btn.dataset.quantity) || 1;
                Cart.add(productId, quantity);
            }
        });
    });
    
    // Wishlist toggle buttons
    document.querySelectorAll('[data-wishlist-toggle]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            if (typeof Wishlist !== 'undefined') {
                const productId = btn.dataset.wishlistToggle;
                Wishlist.toggle(productId);
                btn.classList.toggle('active', Wishlist.isInWishlist(productId));
            }
        });
    });
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
