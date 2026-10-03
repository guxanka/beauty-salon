<?php 
    session_start();
    
    $pageTitle = "Регистрация | Лаборатория красоты";
    
    $errors = $_SESSION['register_errors'] ?? [];
    $old = $_SESSION['register_old'] ?? [];
    unset($_SESSION['register_errors'], $_SESSION['register_old']);
    
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
                <p class="auth-visual-quote">Создайте кабинет — и формула вашего стиля всегда будет под рукой</p>
                <div class="auth-visual-decor"></div>
            </div>
        </div>
        
        <div class="auth-form-side">
            <div class="auth-form-wrapper">
                <div class="auth-form-header">
                    <span class="section-eyebrow">Создание кабинета</span>
                    <h1>Зарегистрироваться</h1>
                    <p>Всего несколько шагов — и вы в пространстве своего стиля</p>
                </div>
                
                <?php if (!empty($errors['general'])): ?>
                    <div class="auth-alert auth-alert-error">
                        <?php echo htmlspecialchars($errors['general']); ?>
                    </div>
                <?php endif; ?>
                
                <form action="<?php echo $basePath; ?>/scripts/register-process.php" method="POST" class="auth-form" novalidate>
                    <div class="field">
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            placeholder=" "
                            value="<?php echo htmlspecialchars($old['name'] ?? ''); ?>"
                            required
                            autocomplete="given-name"
                        >
                        <label for="name">Ваше имя</label>
                        <span class="field-hint">Например: Анна, Мария-Елена</span>
                        <?php if (!empty($errors['name'])): ?>
                            <span class="field-error"><?php echo htmlspecialchars($errors['name']); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="field">
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            placeholder=" "
                            value="<?php echo htmlspecialchars($old['phone'] ?? ''); ?>"
                            required
                            autocomplete="tel"
                        >
                        <label for="phone">Телефон</label>
                        <span class="field-hint">Например: +7 (950) 266-48-90</span>
                        <?php if (!empty($errors['phone'])): ?>
                            <span class="field-error"><?php echo htmlspecialchars($errors['phone']); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="field">
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            placeholder=" "
                            value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>"
                            required
                            autocomplete="email"
                        >
                        <label for="email">Email</label>
                        <span class="field-hint">Например: name@example.com</span>
                        <?php if (!empty($errors['email'])): ?>
                            <span class="field-error"><?php echo htmlspecialchars($errors['email']); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="field">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder=" "
                            required
                            autocomplete="new-password"
                        >
                        <label for="password">Пароль</label>
                        <span class="field-hint">Минимум 8 символов, заглавные и строчные буквы, цифры</span>
                        <?php if (!empty($errors['password'])): ?>
                            <span class="field-error"><?php echo htmlspecialchars($errors['password']); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="field">
                        <input 
                            type="password" 
                            id="password_confirm" 
                            name="password_confirm" 
                            placeholder=" "
                            required
                            autocomplete="new-password"
                        >
                        <label for="password_confirm">Подтвердите пароль</label>
                        <span class="field-hint">Повторите пароль ещё раз</span>
                        <?php if (!empty($errors['password_confirm'])): ?>
                            <span class="field-error"><?php echo htmlspecialchars($errors['password_confirm']); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="auth-agree">
                        <input type="checkbox" id="agree" name="agree" required>
                        <label for="agree">Я согласен на обработку персональных данных</label>
                    </div>
                    
                    <button type="submit" class="btn btn-gold btn-lg auth-submit">Создать кабинет</button>
                    
                    <p class="auth-switch">
                        Уже есть кабинет? <a href="<?php echo $basePath; ?>/pages/login.php">Войти</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>