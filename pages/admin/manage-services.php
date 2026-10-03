<?php
    $pageTitle = "Протоколы | Админ";
    
    session_start();
    if (!isset($_SESSION['admin_id'])) {
        header('Location: /beauty-salon/pages/admin/login.php');
        exit;
    }
    
    if (!isset($basePath)) {
        $basePath = '/beauty-salon';
    }
    
    require_once __DIR__ . '/../../config/db.php';
    
    // Получаем услугу для редактирования
    $editService = null;
    if (isset($_GET['edit'])) {
        $stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->execute([(int)$_GET['edit']]);
        $editService = $stmt->fetch();
    }
    
    $services = $pdo->query("SELECT * FROM services ORDER BY category, name")->fetchAll();
    
    $categories = [
        'coloring' => 'Окрашивание',
        'haircuts_women' => 'Женские стрижки',
        'haircuts_men' => 'Мужской зал',
        'styling' => 'Укладки',
        'care' => 'Уходы',
        'brows' => 'Эстетика бровей'
    ];
    
    include 'admin-header.php';
?>

<style>
.admin-section { padding: 50px 0 80px; min-height: calc(100vh - 100px); background: var(--bg); }
.admin-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; flex-wrap: wrap; gap: 20px; }
.admin-header h1 { font-family: var(--font-accent); font-size: 34px; color: var(--dark); margin-top: 6px; }
.admin-nav { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 36px; border-bottom: 1px solid var(--border); padding-bottom: 16px; }
.admin-nav a { padding: 10px 20px; font-size: 11px; letter-spacing: 1.5px; text-transform: uppercase; border: 1px solid transparent; color: var(--text-muted); transition: all var(--transition); font-weight: 500; }
.admin-nav a:hover { color: var(--gold); border-bottom: 2px solid var(--gold); margin-bottom: -17px; }
.admin-nav a.active { color: var(--gold); border-bottom: 2px solid var(--gold); margin-bottom: -17px; }
.admin-form { background: var(--white); border: 1px solid var(--border); padding: 28px; margin-bottom: 40px; }
.admin-form h3 { font-family: var(--font-accent); font-size: 20px; color: var(--dark); margin-bottom: 20px; }
.admin-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
.admin-form-row.single { grid-template-columns: 1fr; }
.admin-form label { font-size: 10px; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); display: block; margin-bottom: 6px; font-weight: 500; }
.admin-form input, .admin-form select { width: 100%; padding: 10px 14px; border: 1px solid var(--border); font-family: var(--font-main); font-size: 13px; outline: none; }
.admin-form input:focus, .admin-form select:focus { border-color: var(--gold); }
.admin-form-buttons { display: flex; gap: 10px; align-items: center; }
.admin-table-wrap { overflow-x: auto; }
.admin-table { width: 100%; border-collapse: collapse; font-size: 13px; min-width: 800px; }
.admin-table th { text-align: left; padding: 14px 18px; font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: var(--text-light); border-bottom: 1px solid var(--border); font-weight: 600; }
.admin-table td { padding: 14px 18px; border-bottom: 1px solid var(--border-light); color: var(--text); }
.admin-table tbody tr:hover td { background: var(--gold-pale); }
.admin-actions { display: flex; gap: 10px; }
.admin-edit-link { color: var(--gold); font-size: 12px; }
.admin-delete-link { color: #C44; font-size: 12px; }
.admin-category-tag { display: inline-block; padding: 3px 10px; font-size: 10px; letter-spacing: 1px; text-transform: uppercase; background: var(--bg-warm); color: var(--text-muted); }
.admin-price { font-family: var(--font-accent); font-size: 15px; font-weight: 600; color: var(--dark); }
</style>

<section class="admin-section">
    <div class="container">
        
        <div class="admin-header">
            <div>
                <span class="section-eyebrow">Управление протоколами</span>
                <h1>Протоколы красоты</h1>
            </div>
            <a href="<?php echo $basePath; ?>/pages/admin/index.php" class="btn btn-ghost btn-sm">← К календарю</a>
        </div>
        
        <nav class="admin-nav">
            <a href="<?php echo $basePath; ?>/pages/admin/index.php">Календарь</a>
            <a href="<?php echo $basePath; ?>/pages/admin/manage-masters.php">Исследователи</a>
            <a href="<?php echo $basePath; ?>/pages/admin/manage-services.php" class="active">Протоколы</a>
            <?php if ($_SESSION['admin_role'] === 'director'): ?>
                <a href="<?php echo $basePath; ?>/pages/admin/vacations.php">Отпуска</a>
                <a href="<?php echo $basePath; ?>/pages/admin/statistics.php">Статистика</a>
            <?php endif; ?>
        </nav>
        
        <!-- Форма добавления/редактирования -->
        <div class="admin-form">
            <h3><?php echo $editService ? 'Редактировать протокол' : 'Добавить протокол'; ?></h3>
            <form method="POST" action="<?php echo $basePath; ?>/scripts/admin/<?php echo $editService ? 'edit-service' : 'add-service'; ?>.php">
                <?php if ($editService): ?>
                    <input type="hidden" name="id" value="<?php echo $editService['id']; ?>">
                <?php endif; ?>
                
                <div class="admin-form-row">
                    <div>
                        <label>Название</label>
                        <input type="text" name="name" required value="<?php echo $editService ? htmlspecialchars($editService['name']) : ''; ?>">
                    </div>
                    <div>
                        <label>Категория</label>
                        <select name="category" required>
                            <option value="">Выберите</option>
                            <?php foreach ($categories as $key => $name): ?>
                                <option value="<?php echo $key; ?>" <?php echo ($editService && $editService['category'] === $key) ? 'selected' : ''; ?>>
                                    <?php echo $name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="admin-form-row">
                    <div>
                        <label>Длительность (минут)</label>
                        <input type="number" name="duration_min" required min="10" value="<?php echo $editService ? $editService['duration_min'] : ''; ?>">
                    </div>
                    <div>
                        <label>Цена (₽)</label>
                        <input type="number" name="price" required min="0" step="0.01" value="<?php echo $editService ? $editService['price'] : ''; ?>">
                    </div>
                </div>
                
                <?php if ($editService): ?>
                    <div style="margin-bottom: 16px;">
                        <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 13px; color: var(--text); cursor: pointer;">
                            <input type="checkbox" name="is_active" <?php echo $editService['is_active'] ? 'checked' : ''; ?>>
                            Активна
                        </label>
                    </div>
                <?php endif; ?>
                
                <div class="admin-form-buttons">
                    <button type="submit" class="btn btn-gold">
                        <?php echo $editService ? 'Сохранить' : 'Добавить'; ?>
                    </button>
                    <?php if ($editService): ?>
                        <a href="<?php echo $basePath; ?>/pages/admin/manage-services.php" class="btn btn-ghost">Отмена</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <!-- Таблица -->
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Категория</th>
                        <th>Длит.</th>
                        <th>Цена</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $s): ?>
                        <tr>
                            <td>#<?php echo $s['id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($s['name']); ?></strong></td>
                            <td><span class="admin-category-tag"><?php echo $categories[$s['category']] ?? $s['category']; ?></span></td>
                            <td><?php echo $s['duration_min']; ?> мин</td>
                            <td><span class="admin-price"><?php echo number_format($s['price'], 0, '', ' '); ?> ₽</span></td>
                            <td><?php echo $s['is_active'] ? 'Активна' : 'Неактивна'; ?></td>
                            <td>
                                <div class="admin-actions">
                                    <a href="?edit=<?php echo $s['id']; ?>" class="admin-edit-link">Редактировать</a>
                                    <a href="<?php echo $basePath; ?>/scripts/admin/delete-service.php?id=<?php echo $s['id']; ?>" class="admin-delete-link" onclick="return confirm('Удалить протокол?')">Удалить</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
    </div>
</section>

<?php include 'admin-footer.php'; ?>