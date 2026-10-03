<?php 
    session_start();
    
    $pageTitle = "Войти | Лаборатория красоты";
    
    $errors = $_SESSION['login_errors'] ?? [];
    $old = $_SESSION['login_old'] ?? [];
    unset($_SESSION['login_errors'], $_SESSION['login_old']);
    
    include 'header.php'; 
?>

<section class="auth-section">
    <div class="auth-layout">
        <div class="auth-visual">
            <div class="auth-visual-inner">
                <a href="<?php echo $basePath; ?>/" class="auth-logo">
                    <span class="auth-logo-mark">◈</span>
                    <span class="auth-logo-text">Лаборатория красоты</span>
                </a>
                <p class="auth-visual-quote">Пространство, где начинается формула вашего стиля</p>
                <div class="auth-visual-decor"></div>
            </div>
        </div>
        
        <div class="auth-form-side">
            <div class="auth-form-wrapper">
                <div class="auth-form-header">
                    <span class="section-eyebrow">Личный кабинет</span>
                    <h1>Войти</h1>
                    <p>Добро пожаловать</p>
                </div>
                
                <?php if (!empty($errors['general'])): ?>
                    <div class="auth-alert auth-alert-error">
                        <?php echo htmlspecialchars($errors['general']); ?>
                    </div>
                <?php endif; ?>
                
                <form action="<?php echo $basePath; ?>/scripts/login-process.php" method="POST" class="auth-form">
                    <div class="field">
                        <input 
                            type="text" 
                            id="login" 
                            name="login" 
                            placeholder=" "
                            value="<?php echo htmlspecialchars($old['login'] ?? ''); ?>"
                            required
                            autocomplete="username"
                        >
                        <label for="login">Телефон или email</label>
                        <span class="field-hint">Например: +7 (950) 000-00-00 или name@example.com</span>
                        <?php if (!empty($errors['login'])): ?>
                            <span class="field-error"><?php echo htmlspecialchars($errors['login']); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="field">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder=" "
                            required
                            autocomplete="current-password"
                        >
                        <label for="password">Пароль</label>
                        <button type="button" class="field-eye" id="passwordToggle" aria-label="Показать пароль">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                        <?php if (!empty($errors['password'])): ?>
                            <span class="field-error"><?php echo htmlspecialchars($errors['password']); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="auth-helper">
                        <a href="#">Восстановить пароль</a>
                    </div>
                    
                    <button type="submit" class="btn btn-gold btn-lg auth-submit">Войти в кабинет</button>
                    
                    <p class="auth-switch">
                        Впервые у нас? <a href="<?php echo $basePath; ?>/pages/register.php">Создать кабинет</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>