<?php
    $pageTitle = "Отпуска | Админ";
    
    session_start();
    if (!isset($_SESSION['admin_id']) || $_SESSION['admin_role'] !== 'director') {
        header('Location: /beauty-salon/pages/admin/index.php');
        exit;
    }
    
    if (!isset($basePath)) {
        $basePath = '/beauty-salon';
    }
    
    require_once __DIR__ . '/../../config/db.php';
    
    // Добавление отпуска
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
        $masterId = $_POST['master_id'];
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];
        $reason = trim($_POST['reason'] ?? '');
        
        if ($masterId && $startDate && $endDate) {
            $stmt = $pdo->prepare("INSERT INTO master_vacations (master_id, start_date, end_date, reason) VALUES (?, ?, ?, ?)");
            $stmt->execute([$masterId, $startDate, $endDate, $reason]);
        }
    }
    
    // Удаление отпуска
    if (isset($_GET['delete'])) {
        $stmt = $pdo->prepare("DELETE FROM master_vacations WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
        header('Location: ' . $basePath . '/pages/admin/vacations.php');
        exit;
    }
    
    $masters = $pdo->query("SELECT * FROM masters ORDER BY name")->fetchAll();
    $vacations = $pdo->query("
        SELECT v.*, m.name AS master_name 
        FROM master_vacations v 
        JOIN masters m ON v.master_id = m.id 
        WHERE v.end_date >= CURDATE()
        ORDER BY v.start_date ASC
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
.vacation-form { background: var(--white); border: 1px solid var(--border); padding: 28px; margin-bottom: 40px; }
.vacation-form h3 { font-family: var(--font-accent); font-size: 20px; color: var(--dark); margin-bottom: 20px; }
.vacation-form-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; align-items: end; margin-bottom: 16px; }
.vacation-form label { font-size: 10px; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); display: block; margin-bottom: 6px; font-weight: 500; }
.vacation-form select, .vacation-form input { width: 100%; padding: 10px 14px; border: 1px solid var(--border); font-family: var(--font-main); font-size: 13px; outline: none; }
.vacation-form select:focus, .vacation-form input:focus { border-color: var(--gold); }
.admin-table-wrap { overflow-x: auto; }
.admin-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.admin-table th { text-align: left; padding: 14px 18px; font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: var(--text-light); border-bottom: 1px solid var(--border); font-weight: 600; }
.admin-table td { padding: 14px 18px; border-bottom: 1px solid var(--border-light); color: var(--text); }
</style>

<section class="admin-section">
    <div class="container">
        
        <div class="admin-header">
            <div>
                <span class="section-eyebrow">Управление</span>
                <h1>Календарь отпусков</h1>
            </div>
            <a href="<?php echo $basePath; ?>/pages/admin/index.php" class="btn btn-ghost btn-sm">← К календарю</a>
        </div>
        
        <nav class="admin-nav">
            <a href="<?php echo $basePath; ?>/pages/admin/index.php">Календарь</a>
            <a href="<?php echo $basePath; ?>/pages/admin/manage-masters.php">Исследователи</a>
            <a href="<?php echo $basePath; ?>/pages/admin/manage-services.php">Протоколы</a>
            <a href="<?php echo $basePath; ?>/pages/admin/vacations.php" class="active">Отпуска</a>
            <a href="<?php echo $basePath; ?>/pages/admin/statistics.php">Статистика</a>
        </nav>
        
        <!-- Форма добавления отпуска -->
        <div class="vacation-form">
            <h3>Добавить отпуск</h3>
            <form method="POST">
                <input type="hidden" name="action" value="add">
                <div class="vacation-form-row">
                    <div>
                        <label>Исследователь</label>
                        <select name="master_id" required>
                            <option value="">Выберите</option>
                            <?php foreach ($masters as $m): ?>
                                <option value="<?php echo $m['id']; ?>"><?php echo htmlspecialchars($m['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label>Начало</label>
                        <input type="date" name="start_date" required min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div>
                        <label>Конец</label>
                        <input type="date" name="end_date" required min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-gold" style="width: 100%;">Добавить</button>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Таблица отпусков -->
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Исследователь</th>
                        <th>Начало</th>
                        <th>Конец</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vacations as $v): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($v['master_name']); ?></strong></td>
                            <td><?php echo date('d.m.Y', strtotime($v['start_date'])); ?></td>
                            <td><?php echo date('d.m.Y', strtotime($v['end_date'])); ?></td>
                            <td>
                                <a href="?delete=<?php echo $v['id']; ?>" style="color: #C44; font-size: 12px;" onclick="return confirm('Удалить отпуск?')">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($vacations)): ?>
                        <tr>
                            <td colspan="4" style="color: var(--text-light); text-align: center; padding: 40px;">Нет запланированных отпусков</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
    </div>
</section>

<?php include 'admin-footer.php'; ?>