</main><!-- /site-main -->

<footer class="site-footer">
    <div class="container footer-inner">
        
        <!-- Колонка бренда -->
        <div class="footer-col footer-col-brand">
            <a href="<?php echo $basePath; ?>/" class="footer-logo">
                <span class="footer-logo-mark">◈</span>
                <span class="footer-logo-text">Лаборатория красоты</span>
            </a>
            <p class="footer-desc">Персональная формула стиля в Юрге. Изучаем вас, чтобы создать образ, который не повторяется дважды.</p>
        </div>
        
        <!-- Колонка навигации -->
        <div class="footer-col">
            <h5 class="footer-col-title">Разделы</h5>
            <ul class="footer-links">
                <li><a href="<?php echo $basePath; ?>/pages/services.php">Протоколы красоты</a></li>
                <li><a href="<?php echo $basePath; ?>/pages/masters.php">Исследователи</a></li>
                <li><a href="<?php echo $basePath; ?>/pages/contacts.php">Контакты</a></li>
                <li><a href="<?php echo $basePath; ?>/pages/booking.php">Зарезервировать время</a></li>
            </ul>
        </div>
        
        <!-- Колонка контактов -->
        <div class="footer-col">
            <h5 class="footer-col-title">Контактная информация</h5>
            <ul class="footer-links">
                <li>ул. Машиностроителей, 16-1, Юрга</li>
                <li><a href="tel:+79502664890">+7 (950) 266-48-90</a></li>
                <li><a href="mailto:yrgastyle@yandex.ru">yrgastyle@yandex.ru</a></li>
            </ul>
        </div>
        
        <!-- Колонка режима -->
        <div class="footer-col">
            <h5 class="footer-col-title">Часы работы</h5>
            <ul class="footer-schedule">
                <li><span>Понедельник – Пятница</span> <span>10:00 – 20:00</span></li>
                <li><span>Суббота</span> <span>10:00 – 18:00</span></li>
                <li><span>Воскресенье</span> <span>выходной</span></li>
            </ul>
            <p class="footer-note">Запись онлайн — круглосуточно</p>
        </div>
        
    </div>
    
    <div class="footer-bottom">
        <div class="container footer-bottom-inner">
            <span>&copy; 2015–<?php echo date('Y'); ?> Лаборатория красоты, Юрга</span>
            <a href="<?php echo $basePath; ?>/pages/admin/login.php" target="_blank" rel="noopener noreferrer" class="admin-entry-link" title="Панель управления — откроется в новой вкладке" aria-label="Администратор">
                <svg width="10" height="10" viewBox="0 0 12 12" fill="none">
                    <path d="M6 0L12 6L6 12L0 6L6 0Z" fill="currentColor"/>
                </svg>
            </a>
            <span>Формула вашего стиля</span>
        </div>
    </div>
</footer>

<script src="<?php echo $basePath; ?>/assets/js/main.js"></script>
</body>
</html>