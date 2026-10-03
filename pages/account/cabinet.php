<?php
    $pageTitle = "Личный кабинет | Лаборатория красоты";
    
    // Проверяем авторизацию
    session_start();
    if (!isset($_SESSION['client_id'])) {
        header('Location: /beauty-salon/pages/login.php');
        exit;
    }
    
    require_once __DIR__ . '/../../config/db.php';
    
    // Получаем данные клиента
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->execute([$_SESSION['client_id']]);
    $client = $stmt->fetch();
    
    // Получаем предстоящие записи
    $stmtUpcoming = $pdo->prepare("
        SELECT b.*, s.name AS service_name, s.price, m.name AS master_name
        FROM bookings b
        JOIN services s ON b.service_id = s.id
        LEFT JOIN masters m ON b.master_id = m.id
        WHERE b.client_id = ? 
          AND b.booking_date >= CURDATE()
          AND b.status IN ('new', 'confirmed')
        ORDER BY b.booking_date ASC, b.booking_time ASC
    ");
    $stmtUpcoming->execute([$_SESSION['client_id']]);
    $upcomingBookings = $stmtUpcoming->fetchAll();
    
    // Получаем историю записей
    $stmtHistory = $pdo->prepare("
        SELECT b.*, s.name AS service_name, s.price, m.name AS master_name
        FROM bookings b
        JOIN services s ON b.service_id = s.id
        LEFT JOIN masters m ON b.master_id = m.id
        WHERE b.client_id = ? 
          AND (b.booking_date < CURDATE() OR b.status IN ('cancelled', 'completed'))
        ORDER BY b.booking_date DESC, b.booking_time DESC
        LIMIT 20
    ");
    $stmtHistory->execute([$_SESSION['client_id']]);
    $historyBookings = $stmtHistory->fetchAll();
    
    // Сообщения из сессии
    $success = $_SESSION['cabinet_success'] ?? '';
    $error = $_SESSION['cabinet_error'] ?? '';
    unset($_SESSION['cabinet_success'], $_SESSION['cabinet_error']);
    
    include '../header.php';
?>

<section class="cabinet-section">
    <div class="container">
        
        <!-- Заголовок -->
        <div class="cabinet-header">
            <div>
                <span class="section-eyebrow">Личный кабинет</span>
                <h1 class="cabinet-title"><?php echo htmlspecialchars($client['name']); ?></h1>
            </div>
            <a href="<?php echo $basePath; ?>/scripts/logout.php" class="btn btn-ghost btn-sm">Выйти</a>
        </div>
        
        <!-- Сообщения -->
        <?php if ($success): ?>
            <div class="cabinet-alert cabinet-alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="cabinet-alert cabinet-alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <div class="cabinet-grid">
            
            <!-- Боковая панель с данными -->
            <aside class="cabinet-sidebar">
                <div class="cabinet-card">
                    <h3>Контактные данные</h3>
                    <div class="cabinet-info">
                        <div class="cabinet-info-row">
                            <span class="cabinet-info-label">Телефон</span>
                            <span class="cabinet-info-value"><?php echo htmlspecialchars($client['phone']); ?></span>
                        </div>
                        <div class="cabinet-info-row">
                            <span class="cabinet-info-label">Email</span>
                            <span class="cabinet-info-value"><?php echo htmlspecialchars($client['email']); ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="cabinet-card">
                    <a href="<?php echo $basePath; ?>/pages/booking.php" class="btn btn-gold">Зарезервировать визит</a>
                </div>
            </aside>
            
            <!-- Основная часть -->
            <div class="cabinet-main">
                
                <!-- Предстоящие записи -->
                <div class="cabinet-card">
                    <h3>Предстоящие визиты</h3>
                    
                    <?php if (empty($upcomingBookings)): ?>
                        <p class="cabinet-empty">У вас пока нет предстоящих записей.</p>
                        <a href="<?php echo $basePath; ?>/pages/services.php" class="btn btn-ghost btn-sm" style="margin-top: 12px;">Изучить протоколы</a>
                    <?php else: ?>
                        <div class="cabinet-bookings">
                            <?php foreach ($upcomingBookings as $booking): ?>
                                <div class="cabinet-booking">
                                    <div class="cabinet-booking-main">
                                        <strong class="cabinet-booking-service"><?php echo htmlspecialchars($booking['service_name']); ?></strong>
                                        <div class="cabinet-booking-details">
                                            <span><?php echo date('d.m.Y', strtotime($booking['booking_date'])); ?></span>
                                            <span class="cabinet-booking-sep">·</span>
                                            <span><?php echo date('H:i', strtotime($booking['booking_time'])); ?></span>
                                            <span class="cabinet-booking-sep">·</span>
                                            <span><?php echo number_format($booking['price'], 0, '', ' '); ?> ₽</span>
                                        </div>
                                        <?php if ($booking['master_name']): ?>
                                            <div class="cabinet-booking-master">Мастер: <?php echo htmlspecialchars($booking['master_name']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="cabinet-booking-status">
                                        <span class="cabinet-status <?php echo $booking['status'] === 'confirmed' ? 'cabinet-status-confirmed' : 'cabinet-status-new'; ?>">
                                            <?php echo $booking['status'] === 'confirmed' ? 'Подтверждена' : 'Ожидает'; ?>
                                        </span>
                                        
                                        <?php
                                            $bookingDateTime = strtotime($booking['booking_date'] . ' ' . $booking['booking_time']);
                                            $hoursUntil = ($bookingDateTime - time()) / 3600;
                                        ?>
                                        <?php if ($hoursUntil > 24): ?>
                                            <a href="<?php echo $basePath; ?>/scripts/cancel-booking.php?id=<?php echo $booking['id']; ?>" 
                                               class="cabinet-cancel-link"
                                               onclick="return confirm('Вы уверены, что хотите отменить запись?')">
                                                Отменить
                                            </a>
                                        <?php else: ?>
                                            <span class="cabinet-cancel-disabled" title="Отмена возможна не позднее чем за 24 часа">
                                                Позвоните для отмены
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- История записей -->
                <?php if (!empty($historyBookings)): ?>
                    <div class="cabinet-card">
                        <h3>История визитов</h3>
                        <div class="cabinet-bookings">
                            <?php foreach ($historyBookings as $booking): ?>
                                <div class="cabinet-booking cabinet-booking-past">
                                    <div class="cabinet-booking-main">
                                        <strong class="cabinet-booking-service"><?php echo htmlspecialchars($booking['service_name']); ?></strong>
                                        <div class="cabinet-booking-details">
                                            <span><?php echo date('d.m.Y', strtotime($booking['booking_date'])); ?></span>
                                            <span class="cabinet-booking-sep">·</span>
                                            <span><?php echo date('H:i', strtotime($booking['booking_time'])); ?></span>
                                            <span class="cabinet-booking-sep">·</span>
                                            <span><?php echo number_format($booking['price'], 0, '', ' '); ?> ₽</span>
                                        </div>
                                        <?php if ($booking['master_name']): ?>
                                            <div class="cabinet-booking-master">Мастер: <?php echo htmlspecialchars($booking['master_name']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="cabinet-booking-status">
                                        <span class="cabinet-status 
                                            <?php echo $booking['status'] === 'completed' ? 'cabinet-status-done' : 'cabinet-status-cancelled'; ?>">
                                            <?php 
                                                echo $booking['status'] === 'completed' ? 'Выполнена' : 'Отменена'; 
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
            </div>
        </div>
    </div>
</section>

<?php include '../footer.php'; ?>