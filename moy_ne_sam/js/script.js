document.addEventListener('DOMContentLoaded', function() {
    // Анимация кнопок при наведении
    const buttons = document.querySelectorAll('button, .create-link, .btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function(e) {
            if (!this.classList.contains('no-hover')) {
                this.style.transform = 'translateY(-3px)';
                this.style.boxShadow = '0 8px 25px rgba(52, 152, 219, 0.5)';
            }
        });
        
        button.addEventListener('mouseleave', function(e) {
            if (!this.classList.contains('no-hover')) {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 4px 15px rgba(52, 152, 219, 0.3)';
            }
        });
    });
    
    // Анимация карточек при скролле
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Применяем к карточкам
    document.querySelectorAll('.card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(card);
    });
    
    // Валидация форм в реальном времени
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
        
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (!this.value.trim()) {
                    this.style.borderColor = '#ef4444';
                    this.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';
                } else {
                    this.style.borderColor = '#10b981';
                    this.style.boxShadow = '0 0 0 3px rgba(16, 185, 129, 0.1)';
                }
            });
            
            input.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.style.borderColor = '#3498db';
                    this.style.boxShadow = '0 0 0 3px rgba(52, 152, 219, 0.1)';
                }
            });
        });
    });
    
    // Динамическое обновление статусов в карточках
    const statusBadges = document.querySelectorAll('.status-badge, [class*="status-"]');
    statusBadges.forEach(badge => {
        const text = badge.textContent.trim().toLowerCase();
        if (text.includes('выполнено') || badge.classList.contains('status-1')) {
            badge.className = 'status-badge status-1';
        } else if (text.includes('работе') || badge.classList.contains('status-2')) {
            badge.className = 'status-badge status-2';
        } else if (text.includes('отменено') || badge.classList.contains('status-3')) {
            badge.className = 'status-badge status-3';
        }
    });
    
    // Плавный скролл для якорных ссылок
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId !== '#') {
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
    
    // Добавление лоадера для кнопок отправки форм
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.classList.contains('no-loader')) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="loading"></span> Обработка...';
                submitBtn.disabled = true;
                submitBtn.classList.add('no-hover');
                
                // Восстановление кнопки через 5 секунд на случай ошибки
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('no-hover');
                }, 5000);
            }
        });
    });
});