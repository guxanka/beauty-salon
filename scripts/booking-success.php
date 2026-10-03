<?php
    $pageTitle = "Запись создана | Лаборатория красоты";
    include 'header.php';
    
    $success = $_SESSION['booking_success'] ?? '';
    unset($_SESSION['booking_success']);
?>

<section class="section" style="min-height: calc(100vh - 300px); display: flex; align-items: center;">
    <div class="container" style="text-align: center; max-width: 560px;">
        <div style="font-size: 48px; margin-bottom: 24px; color: var(--gold);">◈</div>
        
        <?php if ($success): ?>
            <span class="section-eyebrow">Запись создана</span>
            <h2 style="font-family: var(--font-accent); font-size: 36px; color: var(--dark); margin-bottom: 16px;">
                Время зарезервировано
            </h2>
            <p style="font-size: 15px; color: var(--text-muted); line-height: 1.7; margin-bottom: 12px;">
                <?php echo htmlspecialchars($success); ?>
            </p>
            <p style="font-size: 13px; color: var(--text-light); margin-bottom: 36px;">
                Администратор подтвердит запись в ближайшее время. Вы можете отслеживать статус в личном кабинете.
            </p>
            <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                <?php if (isset($_SESSION['client_id'])): ?>
                    <a href="<?php echo $basePath; ?>/pages/account/cabinet.php" class="btn btn-gold btn-lg">В кабинет</a>
                <?php endif; ?>
                <a href="<?php echo $basePath; ?>/" class="btn btn-ghost btn-lg">На главную</a>
            </div>
        <?php else: ?>
            <p style="color: var(--text-muted);">Нет информации о записи.</p>
            <a href="<?php echo $basePath; ?>/pages/booking.php" class="btn btn-gold btn-lg">Записаться</a>
        <?php endif; ?>
    </div>
</section>

<?php include 'footer.php'; ?>