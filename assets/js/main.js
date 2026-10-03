document.addEventListener('DOMContentLoaded', function() {

    //МОБИЛЬНОЕ МЕНЮ
    const menuToggle = document.getElementById('mobileMenuToggle');
    const mobileMenu = document.getElementById('mobileMenu');

    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function() {
            const isOpen = mobileMenu.classList.toggle('active');
            menuToggle.setAttribute('aria-expanded', isOpen);
            menuToggle.setAttribute('aria-label', isOpen ? 'Закрыть меню' : 'Открыть меню');
            
            // Анимация бургера
            const spans = menuToggle.querySelectorAll('span');
            if (isOpen) {
                spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                spans[1].style.opacity = '0';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
            }
        });

        // Закрытие меню при клике на ссылку
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
                const spans = menuToggle.querySelectorAll('span');
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
            });
        });
    }

    // ГЛАЗИК ПАРОЛЯ
    const passwordToggles = document.querySelectorAll('.password-toggle, .field-eye');
    
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const field = this.closest('.field');
            const input = field ? field.querySelector('input[type="password"], input[type="text"]') : null;
            
            // Если не внутри .field, ищем рядом
            const passwordInput = input || document.getElementById('password');
            
            if (passwordInput) {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                const svg = this.querySelector('svg');
                if (svg) {
                    if (type === 'text') {
                        svg.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
                    } else {
                        svg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
                    }
                }
            }
        });
    });

    // ВАЛИДАЦИЯ ФОРМ
    
        // Форма входа
    const loginForm = document.querySelector('.auth-form[action*="login-process"]');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            let hasError = false;
            clearErrors(loginForm);
            
            const loginInput = loginForm.querySelector('#login');
            const passwordInput = loginForm.querySelector('#password');
            
            // Проверка логина
            const loginValue = loginInput.value.trim();
            if (!loginValue) {
                showError(loginInput, 'Введите телефон или email');
                hasError = true;
            } else {
                // Проверяем похоже на телефон?
                const phoneClean = loginValue.replace(/[^\d+]/g, '');
                const isPhone = /^\+?\d{10,15}$/.test(phoneClean);
                
                // Проверяем похоже на email?
                const isEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(loginValue);
                
                if (!isPhone && !isEmail) {
                    showError(loginInput, 'Введите телефон в формате +7 (950) 000-00-00 или email name@example.com');
                    hasError = true;
                }
            }
            
            // Проверка пароля
            if (!passwordInput.value) {
                showError(passwordInput, 'Введите пароль');
                hasError = true;
            }
            
            if (hasError) {
                e.preventDefault();
            }
        });
    }
    
    // Форма регистрации
    const registerForm = document.querySelector('.auth-form[action*="register-process"]');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            let hasError = false;
            clearErrors(registerForm);
            
            const nameInput = registerForm.querySelector('#name');
            const phoneInput = registerForm.querySelector('#phone');
            const emailInput = registerForm.querySelector('#email');
            const passwordInput = registerForm.querySelector('#password');
            const passwordConfirmInput = registerForm.querySelector('#password_confirm');
            const agreeCheckbox = registerForm.querySelector('#agree');
            
            // Проверка имени
            if (!nameInput.value.trim()) {
                showError(nameInput, 'Укажите ваше имя');
                hasError = true;
            } else if (nameInput.value.trim().length < 2) {
                showError(nameInput, 'Имя должно содержать не менее 2 символов');
                hasError = true;
            } else if (/^\d+$/.test(nameInput.value.trim())) {
                showError(nameInput, 'Имя не может состоять только из цифр');
                hasError = true;
            } else if (!/^[а-яёa-z\s\-]+$/i.test(nameInput.value.trim())) {
                showError(nameInput, 'Имя может содержать только буквы, пробелы и дефис');
                hasError = true;
            }
            
            // Проверка телефона
            if (!phoneInput.value.trim()) {
                showError(phoneInput, 'Укажите номер телефона');
                hasError = true;
            } else {
                const phoneClean = phoneInput.value.replace(/[^\d+]/g, '');
                if (!/^\+?\d{10,15}$/.test(phoneClean)) {
                    showError(phoneInput, 'Введите телефон в формате +7 (950) 000-00-00');
                    hasError = true;
                }
            }
            
            // Проверка email
            if (!emailInput.value.trim()) {
                showError(emailInput, 'Укажите email');
                hasError = true;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value)) {
                showError(emailInput, 'Введите email в формате name@example.com');
                hasError = true;
            }
            
            // Проверка пароля
            if (!passwordInput.value) {
                showError(passwordInput, 'Придумайте пароль');
                hasError = true;
            } else if (passwordInput.value.length < 8) {
                showError(passwordInput, 'Пароль должен содержать не менее 8 символов');
                hasError = true;
            } else if (!/[a-z]/.test(passwordInput.value)) {
                showError(passwordInput, 'Добавьте строчные латинские буквы (a-z)');
                hasError = true;
            } else if (!/[A-Z]/.test(passwordInput.value)) {
                showError(passwordInput, 'Добавьте заглавные латинские буквы (A-Z)');
                hasError = true;
            } else if (!/\d/.test(passwordInput.value)) {
                showError(passwordInput, 'Добавьте хотя бы одну цифру (0-9)');
                hasError = true;
            }
            
            // Проверка подтверждения пароля
            if (!passwordConfirmInput.value) {
                showError(passwordConfirmInput, 'Подтвердите пароль');
                hasError = true;
            } else if (passwordInput.value !== passwordConfirmInput.value) {
                showError(passwordConfirmInput, 'Пароли не совпадают');
                hasError = true;
            }
            
            // Проверка согласия
            if (!agreeCheckbox.checked) {
                showError(agreeCheckbox, '');
                alert('Необходимо согласиться на обработку персональных данных');
                hasError = true;
            }
            
            if (hasError) {
                e.preventDefault();
            }
        });
    }
    
    // Функция показа ошибки
    function showError(input, message) {
        // Удаляем старую ошибку
        const existingError = input.parentElement.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
        
        // Создаём новую
        const errorSpan = document.createElement('span');
        errorSpan.className = 'field-error';
        errorSpan.textContent = message;
        input.parentElement.appendChild(errorSpan);
        
        // Подсвечиваем поле
        input.style.borderBottomColor = '#C44';
        
        // Убираем подсветку при вводе
        input.addEventListener('input', function() {
            input.style.borderBottomColor = '';
            const err = input.parentElement.querySelector('.field-error');
            if (err) err.remove();
        }, { once: true });
    }
    
    // Функция очистки ошибок
    function clearErrors(form) {
        form.querySelectorAll('.field-error').forEach(err => err.remove());
        form.querySelectorAll('input').forEach(input => {
            input.style.borderBottomColor = '';
        });
    }

});