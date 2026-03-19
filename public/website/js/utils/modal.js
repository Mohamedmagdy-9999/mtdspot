/**
 * Modal Utility
 * Handles modal/popup functionality
 */

const Modal = {
    init() {
        // Login trigger
        document.addEventListener('click', (e) => {
            if (e.target.closest('#login-trigger')) {
                e.preventDefault();
                this.open('auth-modal');
                this.switchAuthTab('login');
            }
            
            if (e.target.closest('.modal__close') || e.target.closest('.modal__overlay')) {
                this.close();
            }
            
            if (e.target.closest('.contact-link')) {
                e.preventDefault();
                this.openContactModal();
            }
        });
        
        // Auth tab switching
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('auth-tab')) {
                const authType = e.target.dataset.auth;
                this.switchAuthTab(authType);
            }
        });
    },
    
    open(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('modal--active');
            document.body.style.overflow = 'hidden';
        }
    },
    
    close() {
        const modals = document.querySelectorAll('.modal--active');
        modals.forEach(modal => {
            modal.classList.remove('modal--active');
        });
        document.body.style.overflow = '';
    },
    
    switchAuthTab(type) {
        const tabs = document.querySelectorAll('.auth-tab');
        const forms = document.querySelectorAll('.auth-form');
        
        tabs.forEach(tab => {
            tab.classList.remove('auth-tab--active');
            if (tab.dataset.auth === type) {
                tab.classList.add('auth-tab--active');
            }
        });
        
        forms.forEach(form => {
            form.style.display = 'none';
        });
        
        const activeForm = document.getElementById(`${type}-form`);
        if (activeForm) {
            activeForm.style.display = 'block';
        }
    },
    
    openContactModal() {
        // Create contact modal dynamically
        const contactModal = document.createElement('div');
        contactModal.className = 'modal modal--active';
        contactModal.id = 'contact-modal';
        contactModal.innerHTML = `
            <div class="modal__overlay"></div>
            <div class="modal__content">
                <button class="modal__close" aria-label="Close modal">
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="auth-form__title">Contact Us</h2>
                <form class="form" id="contact-form" onsubmit="handleContact(event)">
                    <div class="form__group">
                        <label class="form__label">Name *</label>
                        <input type="text" class="form__input" name="name" required>
                    </div>
                    <div class="form__group">
                        <label class="form__label">Email *</label>
                        <input type="email" class="form__input" name="email" required>
                    </div>
                    <div class="form__group">
                        <label class="form__label">Phone</label>
                        <input type="tel" class="form__input" name="phone">
                    </div>
                    <div class="form__group">
                        <label class="form__label">Message *</label>
                        <textarea class="form__textarea" name="message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn--primary btn--lg" style="width: 100%;">
                        Send Message
                    </button>
                </form>
                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--border-color);">
                    <h3 style="margin-bottom: 1rem; font-size: 1.125rem;">Get in Touch</h3>
                    <p style="margin-bottom: 0.5rem;"><strong>Email:</strong> groshop@support.com</p>
                    <p style="margin-bottom: 0.5rem;"><strong>Phone:</strong> +80 157 0058 4567</p>
                    <p><strong>Address:</strong> Washington, New York, USA - 254230</p>
                </div>
            </div>
        `;
        document.body.appendChild(contactModal);
        document.body.style.overflow = 'hidden';
        
        // Close handlers
        contactModal.querySelector('.modal__close').addEventListener('click', () => {
            contactModal.remove();
            document.body.style.overflow = '';
        });
        contactModal.querySelector('.modal__overlay').addEventListener('click', () => {
            contactModal.remove();
            document.body.style.overflow = '';
        });
    }
};

// Global functions for forms
function handleLogin(e) {
    e.preventDefault();
    if (typeof FormValidator !== 'undefined' && !FormValidator.validate('#login-form-element')) {
        return;
    }
    
    const formData = new FormData(e.target);
    const email = formData.get('email');
    const remember = formData.get('remember');
    
    const user = {
        email,
        loginTime: new Date().toISOString()
    };
    
    if (remember) {
        localStorage.setItem('user', JSON.stringify(user));
    } else {
        sessionStorage.setItem('user', JSON.stringify(user));
    }
    
    if (typeof Modal !== 'undefined') {
        Modal.close();
    }
    
    // Show success message
    if (typeof Cart !== 'undefined') {
        Cart.showNotification('Login successful!');
    }
    
    // Redirect or update UI
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}

function handleSignup(e) {
    e.preventDefault();
    if (typeof FormValidator !== 'undefined' && !FormValidator.validate('#signup-form-element')) {
        return;
    }
    
    const formData = new FormData(e.target);
    const password = formData.get('password');
    const confirmPassword = formData.get('confirmPassword');
    
    if (password !== confirmPassword) {
        const confirmGroup = document.querySelector('#signup-form-element input[name="confirmPassword"]').closest('.form__group');
        confirmGroup.classList.add('form__group--error');
        return;
    }
    
    if (!formData.get('terms')) {
        alert('Please agree to the Terms & Conditions');
        return;
    }
    
    const user = {
        fullName: formData.get('fullName'),
        email: formData.get('email'),
        phone: formData.get('phone'),
        signupTime: new Date().toISOString()
    };
    
    localStorage.setItem('user', JSON.stringify(user));
    localStorage.setItem('profile', JSON.stringify({
        fullName: user.fullName,
        email: user.email,
        phone: user.phone
    }));
    
    if (typeof Modal !== 'undefined') {
        Modal.close();
    }
    
    if (typeof Cart !== 'undefined') {
        Cart.showNotification('Account created successfully!');
    }
    
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}

function handleContact(e) {
    e.preventDefault();
    if (typeof FormValidator !== 'undefined' && !FormValidator.validate('#contact-form')) {
        return;
    }
    
    const formData = new FormData(e.target);
    const contactData = {
        name: formData.get('name'),
        email: formData.get('email'),
        phone: formData.get('phone'),
        message: formData.get('message'),
        date: new Date().toISOString()
    };
    
    // In a real app, this would be sent to a server
    console.log('Contact form submitted:', contactData);
    
    if (typeof Cart !== 'undefined') {
        Cart.showNotification('Thank you! We will contact you soon.');
    }
    
    const contactModal = document.getElementById('contact-modal');
    if (contactModal) {
        contactModal.remove();
        document.body.style.overflow = '';
    }
}
