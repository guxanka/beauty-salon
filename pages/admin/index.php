<?php
    $pageTitle = "Управление | Лаборатория красоты";
    
    session_start();
    if (!isset($_SESSION['admin_id'])) {
        header('Location: /beauty-salon/pages/admin/login.php');
        exit;
    }
    
    if (!isset($basePath)) {
        $basePath = '/beauty-salon';
    }
    
    require_once __DIR__ . '/../../config/db.php';
    
    // Выбранная дата (из GET или сегодня)
    $date = $_GET['date'] ?? date('Y-m-d');
    
    // Получаем записи на выбранную дату
    $stmt = $pdo->prepare("
        SELECT b.*, s.name AS service_name, s.price, 
               m.name AS master_name, 
               c.name AS client_name, c.phone AS client_phone
        FROM bookings b
        JOIN services s ON b.service_id = s.id
        LEFT JOIN masters m ON b.master_id = m.id
        JOIN clients c ON b.client_id = c.id
        WHERE b.booking_date = ?
        ORDER BY b.booking_time ASC
    ");
    $stmt->execute([$date]);
    $bookings = $stmt->fetchAll();
    
    include 'admin-header.php';
?>

<style>
.admin-section { padding: 50px 0 80px; min-height: calc(100vh - 200px); background: var(--bg); }
.admin-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; flex-wrap: wrap; gap: 20px; }
.admin-header h1 { font-family: var(--font-accent); font-size: 34px; color: var(--dark); margin-top: 6px; }
.admin-user-row { display: flex; align-items: center; gap: 16px; }
.admin-role { font-size: 13px; color: var(--gold); font-weight: 500; letter-spacing: 0.5px; }
.admin-nav { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 36px; border-bottom: 1px solid var(--border); padding-bottom: 16px; }
.admin-nav a { padding: 10px 20px; font-size: 11px; letter-spacing: 1.5px; text-transform: uppercase; border: 1px solid transparent; color: var(--text-muted); transition: all var(--transition); font-weight: 500; }
.admin-nav a:hover { color: var(--gold); border-bottom: 2px solid var(--gold); margin-bottom: -17px; }
.admin-nav a.active { color: var(--gold); border-bottom: 2px solid var(--gold); margin-bottom: -17px; }
.admin-date-picker { display: flex; align-items: center; gap: 12px; margin-bottom: 32px; flex-wrap: wrap; }
.admin-date-picker label { font-size: 12px; letter-spacing: 1px; text-transform: uppercase; color: var(--text-muted); font-weight: 500; }
.admin-date-picker input { padding: 10px 16px; border: 1px solid var(--border); font-family: var(--font-main); font-size: 14px; color: var(--dark); background: var(--white); outline: none; }
.admin-date-picker input:focus { border-color: var(--gold); }
.admin-date-picker .btn { padding: 10px 20px; }
.admin-table-wrap { overflow-x: auto; }
.admin-table { width: 100%; border-collapse: collapse; font-size: 13px; min-width: 800px; }
.admin-table th { text-align: left; padding: 14px 18px; font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: var(--text-light); border-bottom: 1px solid var(--border); font-weight: 600; }
.admin-table td { padding: 16px 18px; border-bottom: 1px solid var(--border-light); color: var(--text); vertical-align: middle; }
.admin-table tbody tr:hover td { background: var(--gold-pale); }
.admin-badge { display: inline-block; padding: 4px 12px; font-size: 10px; font-weight: 500; letter-spacing: 0.8px; text-transform: uppercase; }
.admin-badge-new { background: #FDF6EE; color: #B8935A; }
.admin-badge-confirmed { background: #EDF7F0; color: #3C7A4D; }
.admin-badge-cancelled { background: #FDF2F2; color: #C44; }
.admin-badge-completed { background: var(--bg-warm); color: var(--text-light); }
.admin-actions { display: flex; gap: 10px; }
.admin-action-link { font-size: 11px; font-weight: 500; letter-spacing: 0.5px; transition: color var(--transition); }
.admin-action-confirm { color: #3C7A4D; }
.admin-action-confirm:hover { color: #2A5A38; }
.admin-action-cancel { color: #C44; }
.admin-action-cancel:hover { color: #A33; }
.admin-empty { text-align: center; padding: 80px 20px; color: var(--text-muted); font-size: 15px; }
.admin-empty-icon { font-size: 40px; margin-bottom: 16px; opacity: 0.4; }
</style>

<section class="admin-section">
    <div class="container">
        
        <!-- Заголовок -->
        <div class="admin-header">
            <div>
                <span class="section-eyebrow">Панель управления</span>
                <h1>Календарь записей</h1>
            </div>
            <div class="admin-user-row">
                <span class="admin-role"><?php echo $_SESSION['admin_role'] === 'director' ? 'Директор' : 'Администратор'; ?></span>
                <a href="<?php echo $basePath; ?>/pages/admin/logout.php" class="btn btn-ghost btn-sm">Выйти</a>
            </div>
        </div>
        
        <!-- Навигация -->
                <nav class="admin-nav">
            <a href="<?php echo $basePath; ?>/pages/admin/index.php" class="active">Календарь</a>
            <a href="<?php echo $basePath; ?>/pages/admin/manage-masters.php">Исследователи</a>
            <a href="<?php echo $basePath; ?>/pages/admin/manage-services.php">Протоколы</a>
            <?php if ($_SESSION['admin_role'] === 'director'): ?>
                <a href="<?php echo $basePath; ?>/pages/admin/vacations.php">Отпуска</a>
                <a href="<?php echo $basePath; ?>/pages/admin/statistics.php">Статистика</a>
            <?php endif; ?>
        </nav>
        
        <!-- Выбор даты -->
        <form method="GET" class="admin-date-picker">
            <label for="date">Дата:</label>
            <input type="date" id="date" name="date" value="<?php echo $date; ?>">
            <button type="submit" class="btn btn-gold btn-sm">Показать</button>
            <a href="<?php echo $basePath; ?>/pages/admin/index.php" class="btn btn-ghost btn-sm">Сегодня</a>
        </form>
        
        <!-- Таблица записей -->
                <!-- Неподтверждённые записи (красный блок) -->
        <?php
            $stmtPending = $pdo->query("
                SELECT b.*, s.name AS service_name, s.price, 
                       m.name AS master_name, 
                       c.name AS client_name, c.phone AS client_phone
                FROM bookings b
                JOIN services s ON b.service_id = s.id
                LEFT JOIN masters m ON b.master_id = m.id
                JOIN clients c ON b.client_id = c.id
                WHERE b.status = 'new'
                ORDER BY b.booking_date ASC, b.booking_time ASC
                LIMIT 10
            ");
            $pendingBookings = $stmtPending->fetchAll();
        ?>
        
        <?php if (!empty($pendingBookings)): ?>
            <div style="background: #FFFBF2; border: 1px solid #F0D78C; padding: 24px 28px; margin-bottom: 40px;">
                <h3 style="font-family: var(--font-accent); font-size: 20px; color: var(--dark); margin-bottom: 16px;">
                    ⏳ Требуют подтверждения (<?php echo count($pendingBookings); ?>)
                </h3>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Время</th>
                                <th>Клиент</th>
                                <th>Телефон</th>
                                <th>Протокол</th>
                                <th>Цена</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendingBookings as $b): ?>
                                <tr>
                                    <td><strong><?php echo date('d.m.Y', strtotime($b['booking_date'])); ?></strong></td>
                                    <td><?php echo date('H:i', strtotime($b['booking_time'])); ?></td>
                                    <td><?php echo htmlspecialchars($b['client_name']); ?></td>
                                    <td><?php echo htmlspecialchars($b['client_phone']); ?></td>
                                    <td><?php echo htmlspecialchars($b['service_name']); ?></td>
                                    <td><?php echo number_format($b['price'], 0, '', ' '); ?> ₽</td>
                                    <td>
                                        <div class="admin-actions">
                                            <a href="<?php echo $basePath; ?>/scripts/admin/update-booking.php?id=<?php echo $b['id']; ?>&action=confirm" class="admin-action-link admin-action-confirm">Подтвердить</a>
                                            <a href="<?php echo $basePath; ?>/scripts/admin/update-booking.php?id=<?php echo $b['id']; ?>&action=cancel" class="admin-action-link admin-action-cancel" onclick="return confirm('Отменить запись?')">Отменить</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Таблица записей на выбранную дату -->
        <?php if (empty($bookings)): ?>
            <div class="admin-empty">
                <div class="admin-empty-icon">📋</div>
                <p>На <?php echo date('d.m.Y', strtotime($date)); ?> записей пока нет.</p>
            </div>
        <?php else: ?>
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Время</th>
                            <th>Клиент</th>
                            <th>Телефон</th>
                            <th>Протокол</th>
                            <th>Исследователь</th>
                            <th>Цена</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $b): ?>
                            <tr>
                                <td><strong><?php echo date('H:i', strtotime($b['booking_time'])); ?></strong></td>
                                <td><?php echo htmlspecialchars($b['client_name']); ?></td>
                                <td><?php echo htmlspecialchars($b['client_phone']); ?></td>
                                <td><?php echo htmlspecialchars($b['service_name']); ?></td>
                                <td><?php echo $b['master_name'] ? htmlspecialchars($b['master_name']) : '<span style="color: var(--text-light);">Не назначен</span>'; ?></td>
                                <td><?php echo number_format($b['price'], 0, '', ' '); ?> ₽</td>
                                <td>
                                    <span class="admin-badge admin-badge-<?php echo $b['status']; ?>">
                                        <?php 
                                            $statuses = [
                                                'new' => 'Новая',
                                                'confirmed' => 'Подтверждена',
                                                'cancelled' => 'Отменена',
                                                'completed' => 'Выполнена'
                                            ];
                                            echo $statuses[$b['status']] ?? $b['status'];
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="admin-actions">
                                        <?php if ($b['status'] === 'new'): ?>
                                            <a href="<?php echo $basePath; ?>/scripts/admin/update-booking.php?id=<?php echo $b['id']; ?>&action=confirm&date=<?php echo $date; ?>" class="admin-action-link admin-action-confirm">Подтвердить</a>
                                            <a href="<?php echo $basePath; ?>/scripts/admin/update-booking.php?id=<?php echo $b['id']; ?>&action=cancel&date=<?php echo $date; ?>" class="admin-action-link admin-action-cancel" onclick="return confirm('Отменить запись?')">Отменить</a>
                                        <?php elseif ($b['status'] === 'confirmed'): ?>
                                            <a href="<?php echo $basePath; ?>/scripts/admin/update-booking.php?id=<?php echo $b['id']; ?>&action=cancel&date=<?php echo $date; ?>" class="admin-action-link admin-action-cancel" onclick="return confirm('Отменить запись?')">Отменить</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

<?php include 'admin-footer.php'; ?>