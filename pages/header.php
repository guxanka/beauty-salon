<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($basePath)) {
        $basePath = '/beauty-salon';
    }
?>
<!DOCTYPE html>
<html lang="ru">
<?php 
    if (!isset($basePath)) {
        $basePath = '/beauty-salon';
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Лаборатория красоты — премиальная парикмахерская в Юрге. Окрашивание, стрижки, укладки, эстетика бровей. Онлайн-запись.">
    <title>Лаборатория красоты | Премиальная парикмахерская в Юрге</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo $basePath; ?>/assets/css/style.css">
</head>
<body>

<header class="site-header">
    <!-- Верхняя микро-полоска -->
    <div class="header-top">
        <div class="container header-top-inner">
            <span class="header-top-item">📍 ул. Машиностроителей, 16-1, Юрга</span>
            <span class="header-top-item">🕐 ПН–ПТ 10:00–20:00 · СБ 10:00–18:00</span>
            <a href="tel:+79502664890" class="header-top-link">📞 +7 (950) 266-48-90</a>
        </div>
    </div>
    
    <!-- Основная шапка -->
    <div class="header-main">
        <div class="container header-main-inner">
            
            <!-- Логотип -->
            <a href="<?php echo $basePath; ?>/" class="logo">
                <span class="logo-mark">◈</span>
                <div class="logo-words">
                    <span class="logo-line1">Лаборатория</span>
                    <span class="logo-line2">красоты</span>
                </div>
            </a>
            
            <!-- Навигация -->
            <nav class="main-nav" id="mainNav">
                <ul class="nav-list">
                    <li><a href="<?php echo $basePath; ?>/">Главная</a></li>
                    <li><a href="<?php echo $basePath; ?>/pages/services.php">Протоколы услуг</a></li>
                    <li><a href="<?php echo $basePath; ?>/pages/masters.php">Исследователи стиля</a></li>
                    <li><a href="<?php echo $basePath; ?>/pages/contacts.php">Контакты</a></li>
                </ul>
            </nav>
            
                        <!-- Действия -->
            <div class="header-actions">
                <?php if (isset($_SESSION['client_id'])): ?>
                    <!-- Авторизованный клиент -->
                    <a href="<?php echo $basePath; ?>/pages/account/cabinet.php" class="header-link header-user">
                        <span class="header-user-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="8" r="4"/>
                                <path d="M4 20c0-4 4-7 8-7s8 3 8 7" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <?php echo htmlspecialchars($_SESSION['client_name']); ?>
                    </a>
                    <span class="header-actions-divider"></span>
                    <a href="<?php echo $basePath; ?>/pages/booking.php" class="btn btn-gold">Зарезервировать время</a>
                <?php else: ?>
                    <!-- Неавторизованный -->
                    <a href="<?php echo $basePath; ?>/pages/login.php" class="header-link">Войти</a>
                    <span class="header-actions-divider"></span>
                    <a href="<?php echo $basePath; ?>/pages/booking.php" class="btn btn-gold">Зарезервировать время</a>
                <?php endif; ?>
            </div>
            
            <!-- Бургер -->
            <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Меню">
                <span></span><span></span>
            </button>
            
        </div>
    </div>
    
        <!-- Выдвижное мобильное меню -->
    <div class="mobile-menu" id="mobileMenu">
        <ul>
            <li><a href="<?php echo $basePath; ?>/">Главная</a></li>
            <li><a href="<?php echo $basePath; ?>/pages/services.php">Протоколы</a></li>
            <li><a href="<?php echo $basePath; ?>/pages/masters.php">Исследователи</a></li>
            <li><a href="<?php echo $basePath; ?>/pages/contacts.php">Контакты</a></li>
            <li class="mobile-menu-divider"></li>
            <?php if (isset($_SESSION['client_id'])): ?>
                <li><a href="<?php echo $basePath; ?>/pages/account/cabinet.php">👤 <?php echo htmlspecialchars($_SESSION['client_name']); ?></a></li>
                <li><a href="<?php echo $basePath; ?>/scripts/logout.php">Выйти</a></li>
            <?php else: ?>
                <li><a href="<?php echo $basePath; ?>/pages/login.php">Войти</a></li>
                <a href="<?php echo $basePath; ?>/pages/booking.php" class="btn btn-gold">Зарезервировать время</a>
            <?php endif; ?>
        </ul>
    </div>
</header>

<main class="site-main">