/**
 * Form Validation Utility
 * Handles form validation logic
 */

const FormValidator = {
    validate(formSelector) {
        const form = document.querySelector(formSelector);
        if (!form) return false;
        
        const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;
        
        inputs.forEach(input => {
            const group = input.closest('.form__group');
            if (!this.validateField(input)) {
                isValid = false;
                group?.classList.add('form__group--error');
            } else {
                group?.classList.remove('form__group--error');
            }
        });
        
        return isValid;
    },
    
    validateField(field) {
        const value = field.value.trim();
        const type = field.type;
        
        if (field.hasAttribute('required') && !value) {
            return false;
        }
        
        if (type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(value);
        }
        
        if (type === 'password' && value) {
            return value.length >= 8;
        }
        
        return true;
    },
    
    init(formSelector) {
        const form = document.querySelector(formSelector);
        if (!form) return;
        
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                const group = input.closest('.form__group');
                if (this.validateField(input)) {
                    group?.classList.remove('form__group--error');
                } else {
                    group?.classList.add('form__group--error');
                }
            });
        });
    }
};
