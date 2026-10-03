<?php
    $pageTitle = "Запись создана | Лаборатория красоты";
    include 'header.php';
?>

<section class="section" style="min-height: calc(100vh - 300px); display: flex; align-items: center;">
    <div class="container" style="text-align: center; max-width: 560px;">
        <div style="font-size: 48px; margin-bottom: 24px;">◈</div>
        
        <?php if (isset($_SESSION['booking_success'])): ?>
            <span class="section-eyebrow">Запись создана</span>
            <h2 style="font-family: var(--font-accent); font-size: 36px; color: var(--dark); margin-bottom: 16px;">
                Время зарезервировано
            </h2>
            <p style="font-size: 15px; color: var(--text-muted); line-height: 1.7; margin-bottom: 12px;">
                <?php echo htmlspecialchars($_SESSION['booking_success']); ?>
            </p>
            <p style="font-size: 13px; color: var(--text-light); margin-bottom: 36px;">
                Администратор подтвердит запись в ближайшее время. Вы можете отслеживать статус в личном кабинете.
            </p>
            
            <?php if (isset($_SESSION['client_id'])): ?>
                <a href="<?php echo $basePath; ?>/pages/account/cabinet.php" class="btn btn-gold btn-lg">Перейти в кабинет</a>
            <?php else: ?>
                <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 20px;">
                    Ваш кабинет создан автоматически. Пароль отправлен на указанный email.
                </p>
                <a href="<?php echo $basePath; ?>/" class="btn btn-gold btn-lg">На главную</a>
            <?php endif; ?>
        <?php else: ?>
            <p>Нет информации о записи.</p>
            <a href="<?php echo $basePath; ?>/pages/booking.php" class="btn btn-gold">Записаться</a>
        <?php endif; ?>
    </div>
</section>

<?php 
    unset($_SESSION['booking_success'], $_SESSION['booking_errors']);
    include 'footer.php'; 
?>