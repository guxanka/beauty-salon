<?php 
    $basePath = '/beauty-salon';
    include 'pages/header.php'; 
?>

<!-- ==================== HERO ==================== -->
<section class="hero">
    <!-- Видео-фон -->
    <div class="hero-video-wrapper">
        <video autoplay muted loop playsinline class="hero-video">
            <source src="<?php echo $basePath; ?>/assets/video/hero-bg.mp4" type="video/mp4">
        </video>
        <div class="hero-video-overlay"></div>
    </div>
    
    <div class="hero-decor hero-decor-left"></div>
    <div class="hero-decor hero-decor-right"></div>
    
    <div class="container hero-inner">
        <div class="hero-badge">Лаборатория красоты в Юрге</div>
        
        <h1 class="hero-title">
            Формула<br>
            вашего стиля
        </h1>
        
        <p class="hero-text">
            Мы изучаем вас, чтобы создать образ,<br class="hero-text-br">
            который не повторяется дважды.
        </p>
        
        <div class="hero-actions">
            <a href="<?php echo $basePath; ?>/pages/booking.php" class="btn btn-gold btn-lg">Зарезервировать время</a>
            <a href="<?php echo $basePath; ?>/pages/services.php" class="btn btn-ghost btn-lg">Изучить протоколы</a>
        </div>
        
        <!-- Микро-факты -->
        <div class="hero-facts">
            <div class="hero-fact">
                <img src="<?php echo $basePath; ?>/assets/images/icons/hero-consultation.svg" alt="" class="hero-fact-icon" width="32" height="32">
                <span class="hero-fact-num">Персональный разбор</span>
                <span class="hero-fact-label">каждый визит начинается с консультации мастера</span>
            </div>
            <div class="hero-fact-divider"></div>
            <div class="hero-fact">
                <img src="<?php echo $basePath; ?>/assets/images/icons/hero-structure.svg" alt="" class="hero-fact-icon" width="32" height="32">
                <span class="hero-fact-num">Слепок структуры</span>
                <span class="hero-fact-label">подбираем состав под ваш тип волос индивидуально</span>
            </div>
            <div class="hero-fact-divider"></div>
            <div class="hero-fact">
                <img src="<?php echo $basePath; ?>/assets/images/icons/hero-verified.svg" alt="" class="hero-fact-icon" width="32" height="32">
                <span class="hero-fact-num">Проверено с 2015</span>
                <span class="hero-fact-label">тысячи формул и довольных гостей</span>
            </div>
        </div>
    </div>
</section>

<!-- ==================== ПРЕИМУЩЕСТВА ==================== -->
<section class="section section-light">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Лабораторный подход</span>
            <h2 class="section-heading">Что делает нас особенными</h2>
        </div>
        
        <div class="features-grid">
            <div class="feature-item">
                <img src="<?php echo $basePath; ?>/assets/images/icons/icon-consultation.svg" alt="" class="feature-icon" width="36" height="36">
                <span class="feature-num">01</span>
                <h3>Персональный разбор</h3>
                <p>Каждый визит начинается с изучения ваших пожеланий, структуры волос и овала лица. Мы не работаем по шаблону — мы создаём формулу вашего стиля.</p>
            </div>
            
            <div class="feature-item">
                <img src="<?php echo $basePath; ?>/assets/images/icons/icon-structure.svg" alt="" class="feature-icon" width="36" height="36">
                <span class="feature-num">02</span>
                <h3>Профессиональные составы</h3>
                <p>Работаем на премиальных линейках, которые подбираются под ваш тип волос. Никаких универсальных решений — только индивидуальный подход.</p>
            </div>
            
            <div class="feature-item">
                <img src="<?php echo $basePath; ?>/assets/images/icons/icon-time.svg" alt="" class="feature-icon" width="36" height="36">
                <span class="feature-num">03</span>
                <h3>Запись за 120 секунд</h3>
                <p>Забронируйте время, выберите мастера и услугу — без единого звонка. Система сама предложит удобные слоты и пришлёт подтверждение.</p>
            </div>
            
            <div class="feature-item">
                <img src="<?php echo $basePath; ?>/assets/images/icons/icon-formula.svg" alt="" class="feature-icon" width="36" height="36">
                <span class="feature-num">04</span>
                <h3>Образ, который не повторяется</h3>
                <p>Мы не тиражируем стрижки из каталога. Каждый образ создаётся под конкретного человека — ваш стиль будет только вашим.</p>
            </div>
        </div>
    </div>
</section>

<!-- ==================== УСЛУГИ ==================== -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Направления работы</span>
            <h2 class="section-heading">Изучите протоколы красоты</h2>
        </div>
        
        <div class="services-grid">
            <a href="<?php echo $basePath; ?>/pages/services.php#coloring" class="service-card">
                <img src="<?php echo $basePath; ?>/assets/images/icons/icon-coloring.svg" alt="" class="service-card-icon-img" width="40" height="40">
                <h3>Окрашивание</h3>
                <p>Авторские техники, сложное окрашивание, мелирование, тонирование.</p>
                <span class="service-card-count">9 протоколов</span>
            </a>
            
            <a href="<?php echo $basePath; ?>/pages/services.php#haircuts-women" class="service-card">
                <img src="<?php echo $basePath; ?>/assets/images/icons/icon-haircut-w.svg" alt="" class="service-card-icon-img" width="40" height="40">
                <h3>Женские стрижки</h3>
                <p>Стрижка с укладкой, экспресс-стрижка, плетение. Точная форма под ваш тип волос.</p>
                <span class="service-card-count">3 протокола</span>
            </a>
            
            <a href="<?php echo $basePath; ?>/pages/services.php#haircuts-men" class="service-card">
                <img src="<?php echo $basePath; ?>/assets/images/icons/icon-haircut-m.svg" alt="" class="service-card-icon-img" width="40" height="40">
                <h3>Мужской зал</h3>
                <p>Стрижки, оформление бороды, комплексный сервис для мужчин.</p>
                <span class="service-card-count">6 протоколов</span>
            </a>
            
            <a href="<?php echo $basePath; ?>/pages/services.php#styling" class="service-card">
                <img src="<?php echo $basePath; ?>/assets/images/icons/icon-styling.svg" alt="" class="service-card-icon-img" width="40" height="40">
                <h3>Укладки</h3>
                <p>Экспресс-сушка, вечерняя укладка, причёски для особого случая.</p>
                <span class="service-card-count">3 протокола</span>
            </a>
            
            <a href="<?php echo $basePath; ?>/pages/services.php#care" class="service-card">
                <img src="<?php echo $basePath; ?>/assets/images/icons/icon-care.svg" alt="" class="service-card-icon-img" width="40" height="40">
                <h3>Уходы</h3>
                <p>Детокс кожи головы, реконструкция, восстанавливающие процедуры.</p>
                <span class="service-card-count">2 протокола</span>
            </a>
            
            <a href="<?php echo $basePath; ?>/pages/services.php#brows" class="service-card">
                <img src="<?php echo $basePath; ?>/assets/images/icons/icon-brows.svg" alt="" class="service-card-icon-img" width="40" height="40">
                <h3>Эстетика бровей</h3>
                <p>Долговременная укладка, коррекция, окрашивание бровей и ресниц.</p>
                <span class="service-card-count">4 протокола</span>
            </a>
        </div>
    </div>
</section>

<!-- ==================== ПРОЦЕСС ЗАПИСИ ==================== -->
<section class="section section-dark">
    <div class="container">
        <div class="section-header section-header-light">
            <span class="section-eyebrow">Как это работает</span>
            <h2 class="section-heading">Запишитесь за 120 секунд</h2>
        </div>
        
        <div class="process-grid">
            <div class="process-step">
                <div class="process-step-icon">①</div>
                <h4>Выберите протокол</h4>
                <p>Ознакомьтесь с направлениями и выберите услугу.</p>
            </div>
            
            <div class="process-arrow">→</div>
            
            <div class="process-step">
                <div class="process-step-icon">②</div>
                <h4>Выберите Исследователя</h4>
                <p>Изучите профили специалистов и выберите того, кто вам ближе.</p>
            </div>
            
            <div class="process-arrow">→</div>
            
            <div class="process-step">
                <div class="process-step-icon">③</div>
                <h4>Забронируйте время</h4>
                <p>Система покажет свободные слоты — останется только выбрать.</p>
            </div>
            
            <div class="process-arrow">→</div>
            
            <div class="process-step">
                <div class="process-step-icon">④</div>
                <h4>Получите подтверждение</h4>
                <p>Мгновенное подтверждение на почту — без звонков и ожидания.</p>
            </div>
        </div>
        
        <div class="process-cta">
            <a href="<?php echo $basePath; ?>/pages/booking.php" class="btn btn-gold">Зарезервировать визит</a>
        </div>
    </div>
</section>

<!-- ==================== CTA ==================== -->
<section class="cta-section">
    <div class="container cta-inner">
        <div class="cta-content">
            <h2>Готовы к формуле своего стиля?</h2>
            <p>Забронируйте визит сейчас и получите консультацию мастера в подарок при первом посещении.</p>
        </div>
        <div class="cta-actions">
            <a href="<?php echo $basePath; ?>/pages/booking.php" class="btn btn-gold">Зарезервировать время</a>
            <a href="tel:+79502664890" class="btn btn-ghost-light btn-lg">Позвонить</a>
        </div>
    </div>
</section>

<?php include 'pages/footer.php'; ?>