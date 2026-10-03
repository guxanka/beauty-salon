<?php 
    $pageTitle = "Контакты | Лаборатория красоты";
    include 'header.php'; 
?>

<!-- Заголовок страницы -->
<section class="page-header">
    <div class="container">
        <span class="section-eyebrow">Свяжитесь с нами</span>
        <h1 class="page-title">Контакты</h1>
        <p class="page-subtitle">Мы находимся в центре Юрги</p>
    </div>
</section>

<!-- Основная информация -->
<section class="section">
    <div class="container">
        <div class="contacts-grid">
            
            <!-- Адрес -->
            <div class="contact-card">
                <div class="contact-card-icon">📍</div>
                <h3>Адрес</h3>
                <p>Кемеровская область, г. Юрга,<br>ул. Машиностроителей, 16-1</p>
            </div>
            
            <!-- Телефон -->
            <div class="contact-card">
                <div class="contact-card-icon">📞</div>
                <h3>Телефон</h3>
                <a href="tel:+79502664890" class="contact-card-link">+7 (950) 266-48-90</a>
                <p class="contact-card-hint">Звоните в рабочее время</p>
            </div>
            
            <!-- Почта -->
            <div class="contact-card">
                <div class="contact-card-icon">✉️</div>
                <h3>Электронная почта</h3>
                <a href="mailto:yrgastyle@yandex.ru" class="contact-card-link">yrgastyle@yandex.ru</a>
                <p class="contact-card-hint">Отвечаем в течение дня</p>
            </div>
            
            <!-- Режим работы -->
            <div class="contact-card">
                <div class="contact-card-icon">🕐</div>
                <h3>Режим работы</h3>
                <div class="contact-schedule">
                    <div class="contact-schedule-row">
                        <span>Понедельник – Пятница</span>
                        <span>10:00 – 20:00</span>
                    </div>
                    <div class="contact-schedule-row">
                        <span>Суббота</span>
                        <span>10:00 – 18:00</span>
                    </div>
                    <div class="contact-schedule-row contact-schedule-dayoff">
                        <span>Воскресенье</span>
                        <span>выходной</span>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Карта -->
<section class="section section-light">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Как добраться</span>
            <h2 class="section-heading">Мы на карте</h2>
        </div>
        
        <div class="map-wrapper">
            <div class="map-container">
                <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A7550f1d099b9499c9dcb1b6bc355c9d172b3ab21c40dcab3d756b2b3d8d50c6d&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</section>

<!-- Баннер с призывом -->
<section class="cta-section">
    <div class="container cta-inner">
        <div class="cta-content">
            <h2>Остались вопросы?</h2>
            <p>Позвоните нам или запишитесь онлайн — подберём удобное время для визита.</p>
        </div>
        <div class="cta-actions">
            <a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-lg">Записаться</a>
            <a href="tel:+79502664890" class="btn btn-ghost-light btn-lg">Позвонить</a>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>