<?php
    $pageTitle = "Администратор | Лаборатория красоты";
    
    if (!isset($basePath)) {
        $basePath = '/beauty-salon';
    }
    
    require_once __DIR__ . '/../../config/db.php';
    
    $error = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = trim($_POST['login'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($login) || empty($password)) {
            $error = 'Введите логин и пароль';
        } else {
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE login = ?");
            $stmt->execute([$login]);
            $admin = $stmt->fetch();
            
            if ($admin && password_verify($password, $admin['password_hash'])) {
                session_start();
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_role'] = $admin['role'];
                header('Location: ' . $basePath . '/pages/admin/index.php');
                exit;
            } else {
                $error = 'Неверный логин или пароль';
            }
        }
    }
    
    include 'admin-header.php';
?>

<section class="auth-section">
    <div class="auth-layout">
        <div class="auth-visual">
            <div class="auth-visual-inner">
                <span style="font-size: 28px; color: var(--gold); display: block; margin-bottom: 20px;">◈</span>
                <p class="auth-visual-quote">Панель управления лабораторией</p>
                <div class="auth-visual-decor"></div>
            </div>
        </div>
        
        <div class="auth-form-side">
            <div class="auth-form-wrapper">
                <div class="auth-form-header">
                    <span class="section-eyebrow">Служебный вход</span>
                    <h1>Администратор</h1>
                    <p>Доступ только для сотрудников</p>
                </div>
                
                <?php if ($error): ?>
                    <div class="auth-alert auth-alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <form method="POST" class="auth-form">
                    <div class="field">
                        <input type="text" id="login" name="login" placeholder=" " required autocomplete="username">
                        <label for="login">Логин</label>
                    </div>
                    
                    <div class="field">
                        <input type="password" id="password" name="password" placeholder=" " required>
                        <label for="password">Пароль</label>
                    </div>
                    
                    <button type="submit" class="btn btn-gold btn-lg auth-submit">Войти</button>
                    
                    <p class="auth-switch">
                        <a href="<?php echo $basePath; ?>/">Вернуться на сайт</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'admin-footer.php'; ?>