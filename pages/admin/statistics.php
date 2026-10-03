<?php
    $pageTitle = "Статистика | Админ";
    
    session_start();
    if (!isset($_SESSION['admin_id']) || $_SESSION['admin_role'] !== 'director') {
        header('Location: /beauty-salon/pages/admin/index.php');
        exit;
    }
    
    if (!isset($basePath)) {
        $basePath = '/beauty-salon';
    }
    
    require_once __DIR__ . '/../../config/db.php';
    
    // Общая статистика
    $totalBookings = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
    $totalClients = $pdo->query("SELECT COUNT(*) FROM clients")->fetchColumn();
    $totalMasters = $pdo->query("SELECT COUNT(*) FROM masters")->fetchColumn();
    $totalRevenue = $pdo->query("
        SELECT COALESCE(SUM(s.price), 0) 
        FROM bookings b 
        JOIN services s ON b.service_id = s.id 
        WHERE b.status IN ('confirmed', 'completed')
    ")->fetchColumn();
    // Отменённые записи
$cancelledBookings = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'cancelled'")->fetchColumn();
    
    // Записи по месяцам (6 месяцев)
    $monthlyStats = $pdo->query("
        SELECT DATE_FORMAT(booking_date, '%Y-%m') AS month, COUNT(*) AS count
        FROM bookings
        WHERE booking_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
        GROUP BY month
        ORDER BY month ASC
    ")->fetchAll();
    
    // Топ-услуг
    $topServices = $pdo->query("
        SELECT s.name, COUNT(*) AS count, SUM(s.price) AS revenue
        FROM bookings b
        JOIN services s ON b.service_id = s.id
        WHERE b.status IN ('confirmed', 'completed')
        GROUP BY s.id
        ORDER BY count DESC
        LIMIT 5
    ")->fetchAll();
    
    include 'admin-header.php';
?>

<style>
.admin-section { padding: 50px 0 80px; min-height: calc(100vh - 200px); background: var(--bg); }
.admin-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; flex-wrap: wrap; gap: 20px; }
.admin-header h1 { font-family: var(--font-accent); font-size: 34px; color: var(--dark); margin-top: 6px; }
.admin-nav { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 36px; border-bottom: 1px solid var(--border); padding-bottom: 16px; }
.admin-nav a { padding: 10px 20px; font-size: 11px; letter-spacing: 1.5px; text-transform: uppercase; border: 1px solid transparent; color: var(--text-muted); transition: all var(--transition); font-weight: 500; }
.admin-nav a:hover { color: var(--gold); border-bottom: 2px solid var(--gold); margin-bottom: -17px; }
.admin-nav a.active { color: var(--gold); border-bottom: 2px solid var(--gold); margin-bottom: -17px; }
.stat-cards { display: grid; grid-template-columns: repeat(5, 1fr); gap: 20px; margin-bottom: 50px; }
.stat-card { background: var(--white); border: 1px solid var(--border); padding: 28px 24px; transition: all var(--transition); }
.stat-card:hover { border-color: var(--gold); box-shadow: 0 8px 24px rgba(0,0,0,0.03); }
.stat-card-label { font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: var(--text-light); margin-bottom: 12px; font-weight: 600; }
.stat-card-value { font-family: var(--font-accent); font-size: 36px; color: var(--dark); line-height: 1; }
.stat-row { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
.stat-block { margin-bottom: 40px; }
.stat-block h3 { font-family: var(--font-accent); font-size: 22px; color: var(--dark); margin-bottom: 20px; }
.admin-table-wrap { overflow-x: auto; }
.admin-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.admin-table th { text-align: left; padding: 14px 18px; font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: var(--text-light); border-bottom: 1px solid var(--border); font-weight: 600; }
.admin-table td { padding: 14px 18px; border-bottom: 1px solid var(--border-light); color: var(--text); }
</style>

<section class="admin-section">
    <div class="container">
        
        <div class="admin-header">
            <div>
                <span class="section-eyebrow">Аналитика</span>
                <h1>Статистика</h1>
            </div>
            <a href="<?php echo $basePath; ?>/pages/admin/index.php" class="btn btn-ghost btn-sm">← К календарю</a>
        </div>
        
            <nav class="admin-nav">
            <a href="<?php echo $basePath; ?>/pages/admin/index.php">Календарь</a>
            <a href="<?php echo $basePath; ?>/pages/admin/manage-masters.php">Исследователи</a>
            <a href="<?php echo $basePath; ?>/pages/admin/manage-services.php">Протоколы</a>
            <?php if ($_SESSION['admin_role'] === 'director'): ?>
                <a href="<?php echo $basePath; ?>/pages/admin/vacations.php">Отпуска</a>
                <a href="<?php echo $basePath; ?>/pages/admin/statistics.php" class="active">Статистика</a>
            <?php endif; ?>
        </nav>
        
        <!-- Карточки -->
        <div class="stat-cards">
            <div class="stat-card">
                <div class="stat-card-label">Всего записей</div>
                <div class="stat-card-value"><?php echo $totalBookings; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-card-label">Клиентов</div>
                <div class="stat-card-value"><?php echo $totalClients; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-card-label">Исследователей</div>
                <div class="stat-card-value"><?php echo $totalMasters; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-card-label">Выручка</div>
                <div class="stat-card-value"><?php echo number_format($totalRevenue, 0, '', ' '); ?> ₽</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-label">Отменено записей</div>
                <div class="stat-card-value"><?php echo $cancelledBookings; ?></div>
            </div>
        </div>
        
        <div class="stat-row">
            <!-- По месяцам -->
            <div class="stat-block">
                <h3>Динамика по месяцам</h3>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Месяц</th>
                                <th>Записей</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($monthlyStats as $ms): ?>
                                <tr>
                                    <td><?php echo $ms['month']; ?></td>
                                    <td><strong><?php echo $ms['count']; ?></strong></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($monthlyStats)): ?>
                                <tr>
                                    <td colspan="2" style="color: var(--text-light);">Нет данных</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Топ-услуг -->
            <div class="stat-block">
                <h3>Популярные протоколы</h3>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Протокол</th>
                                <th>Записей</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($topServices as $ts): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($ts['name']); ?></td>
                                    <td><strong><?php echo $ts['count']; ?></strong></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($topServices)): ?>
                                <tr>
                                    <td colspan="2" style="color: var(--text-light);">Нет данных</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</section>

<?php include 'admin-footer.php'; ?>