class LoginManager {
    constructor() {
        this.init();
    }

    init() {
        this.setupPasswordToggle();
        this.setupFormValidation();
        this.setupSocialLogin();
        this.setupRememberMe();
        this.setupAnimations();
    }

    // Password Toggle Functionality
    setupPasswordToggle() {
        const passwordToggle = document.querySelector('.password-toggle');
        const passwordInput = document.querySelector('#password');

        if (passwordToggle && passwordInput) {
            passwordToggle.addEventListener('click', () => {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                const icon = passwordToggle.querySelector('i');
                if (type === 'password') {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        }
    }

    // Form Validation
    setupFormValidation() {
        const form = document.querySelector('#loginForm');
        const emailInput = document.querySelector('#email');
        const passwordInput = document.querySelector('#password');
        const submitBtn = document.querySelector('.btn-login');

        if (form) {
            form.addEventListener('submit', (e) => {
                // Hanya prevent default jika validasi gagal
                if (!this.validateForm()) {
                    e.preventDefault();
                    return false;
                }
                
                // Jika validasi berhasil, biarkan form submit normal ke Laravel
                // Tambahkan loading state
                submitBtn.classList.add('loading');
                submitBtn.textContent = 'Signing In...';
                submitBtn.disabled = true;
            });
        }

        // Real-time validation
        if (emailInput) {
            emailInput.addEventListener('blur', () => {
                this.validateEmail(emailInput);
            });
        }

        if (passwordInput) {
            passwordInput.addEventListener('blur', () => {
                this.validatePassword(passwordInput);
            });
        }
    }

    validateForm() {
        const emailInput = document.querySelector('#email');
        const passwordInput = document.querySelector('#password');
        
        let isValid = true;

        if (!this.validateEmail(emailInput)) {
            isValid = false;
        }

        if (!this.validatePassword(passwordInput)) {
            isValid = false;
        }

        return isValid;
    }

    validateEmail(input) {
        const email = input.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (!email) {
            this.showFieldError(input, 'Email is required');
            return false;
        } else if (!emailRegex.test(email)) {
            this.showFieldError(input, 'Please enter a valid email address');
            return false;
        } else {
            this.clearFieldError(input);
            return true;
        }
    }

    validatePassword(input) {
        const password = input.value;
        
        if (!password) {
            this.showFieldError(input, 'Password is required');
            return false;
        } else if (password.length < 6) {
            this.showFieldError(input, 'Password must be at least 6 characters');
            return false;
        } else {
            this.clearFieldError(input);
            return true;
        }
    }

    showFieldError(input, message) {
        this.clearFieldError(input);
        
        input.style.borderColor = '#FF6B6B';
        input.style.boxShadow = '0 0 0 0.25rem rgba(255, 107, 107, 0.25)';
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.style.color = '#FF6B6B';
        errorDiv.style.fontSize = '0.85rem';
        errorDiv.style.marginTop = '5px';
        errorDiv.style.fontWeight = '500';
        errorDiv.textContent = message;
        
        input.parentNode.appendChild(errorDiv);
    }

    clearFieldError(input) {
        input.style.borderColor = '';
        input.style.boxShadow = '';
        
        const existingError = input.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
    }

    // Form Submission - Removed simulation, let Laravel handle it

    // Social Login
    setupSocialLogin() {
        const googleBtn = document.querySelector('.btn-social.google');
        const facebookBtn = document.querySelector('.btn-social.facebook');

        if (googleBtn) {
            googleBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.showAlert('Google login functionality will be implemented soon', 'info');
            });
        }

        if (facebookBtn) {
            facebookBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.showAlert('Facebook login functionality will be implemented soon', 'info');
            });
        }
    }

    // Remember Me
    setupRememberMe() {
        const rememberCheckbox = document.querySelector('#remember');
        
        if (rememberCheckbox) {
            // Load saved preference
            const savedRemember = localStorage.getItem('rememberMe');
            if (savedRemember === 'true') {
                rememberCheckbox.checked = true;
                
                // Load saved email if exists
                const savedEmail = localStorage.getItem('savedEmail');
                if (savedEmail) {
                    document.querySelector('#email').value = savedEmail;
                }
            }

            // Save preference on change
            rememberCheckbox.addEventListener('change', () => {
                localStorage.setItem('rememberMe', rememberCheckbox.checked);
                
                if (!rememberCheckbox.checked) {
                    localStorage.removeItem('savedEmail');
                } else {
                    const email = document.querySelector('#email').value;
                    if (email) {
                        localStorage.setItem('savedEmail', email);
                    }
                }
            });
        }
    }

    // Animations
    setupAnimations() {
        // Add fade-in animation to login card
        const loginCard = document.querySelector('.login-card');
        if (loginCard) {
            loginCard.classList.add('fade-in');
        }

        // Add subtle hover effects to form inputs
        const formInputs = document.querySelectorAll('.form-control');
        formInputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.parentNode.style.transform = 'translateY(-2px)';
                input.parentNode.style.transition = 'transform 0.3s ease';
            });

            input.addEventListener('blur', () => {
                input.parentNode.style.transform = 'translateY(0)';
            });
        });
    }

    // Utility Methods
    showAlert(message, type = 'info') {
        // Remove existing alerts
        const existingAlert = document.querySelector('.alert');
        if (existingAlert) {
            existingAlert.remove();
        }

        // Create new alert
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.textContent = message;

        // Insert before form
        const form = document.querySelector('#loginForm');
        form.parentNode.insertBefore(alert, form);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }

    // Handle keyboard shortcuts
    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Enter key to submit form
            if (e.key === 'Enter' && !e.shiftKey) {
                const form = document.querySelector('#loginForm');
                if (form && document.activeElement.closest('.login-card')) {
                    e.preventDefault();
                    form.dispatchEvent(new Event('submit'));
                }
            }
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new LoginManager();
});

// Add some Easter eggs
document.addEventListener('keydown', (e) => {
    // Konami code for fun animation
    const konamiCode = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65];
    window.konamiProgress = window.konamiProgress || 0;
    
    if (e.keyCode === konamiCode[window.konamiProgress]) {
        window.konamiProgress++;
        if (window.konamiProgress === konamiCode.length) {
            // Add special animation
            document.querySelector('.login-card').style.animation = 'rainbow 2s infinite';
            setTimeout(() => {
                document.querySelector('.login-card').style.animation = '';
                window.konamiProgress = 0;
            }, 4000);
        }
    } else {
        window.konamiProgress = 0;
    }
});

// Add rainbow animation for Easter egg
const style = document.createElement('style');
style.textContent = `
    @keyframes rainbow {
        0% { filter: hue-rotate(0deg); }
        25% { filter: hue-rotate(90deg); }
        50% { filter: hue-rotate(180deg); }
        75% { filter: hue-rotate(270deg); }
        100% { filter: hue-rotate(360deg); }
    }
`;
document.head.appendChild(style);
