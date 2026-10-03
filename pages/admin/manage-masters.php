<?php
    $pageTitle = "Исследователи | Админ";
    
    session_start();
    if (!isset($_SESSION['admin_id'])) {
        header('Location: /beauty-salon/pages/admin/login.php');
        exit;
    }
    
    if (!isset($basePath)) {
        $basePath = '/beauty-salon';
    }
    
    require_once __DIR__ . '/../../config/db.php';
    
    // Получаем мастера для редактирования (если есть ID)
    $editMaster = null;
    if (isset($_GET['edit'])) {
        $stmt = $pdo->prepare("SELECT * FROM masters WHERE id = ?");
        $stmt->execute([(int)$_GET['edit']]);
        $editMaster = $stmt->fetch();
    }
    
    $masters = $pdo->query("SELECT * FROM masters ORDER BY name ASC")->fetchAll();
    
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
.admin-form input, .admin-form textarea, .admin-form select { width: 100%; padding: 10px 14px; border: 1px solid var(--border); font-family: var(--font-main); font-size: 13px; outline: none; }
.admin-form input:focus, .admin-form textarea:focus, .admin-form select:focus { border-color: var(--gold); }
.admin-form textarea { resize: vertical; min-height: 80px; }
.admin-form-buttons { display: flex; gap: 10px; align-items: center; }
.admin-table-wrap { overflow-x: auto; }
.admin-table { width: 100%; border-collapse: collapse; font-size: 13px; min-width: 800px; }
.admin-table th { text-align: left; padding: 14px 18px; font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: var(--text-light); border-bottom: 1px solid var(--border); font-weight: 600; }
.admin-table td { padding: 14px 18px; border-bottom: 1px solid var(--border-light); color: var(--text); }
.admin-table tbody tr:hover td { background: var(--gold-pale); }
.admin-actions { display: flex; gap: 10px; }
.admin-edit-link { color: var(--gold); font-size: 12px; }
.admin-delete-link { color: #C44; font-size: 12px; }
</style>

<section class="admin-section">
    <div class="container">
        
        <div class="admin-header">
            <div>
                <span class="section-eyebrow">Управление составом</span>
                <h1>Исследователи</h1>
            </div>
            <a href="<?php echo $basePath; ?>/pages/admin/index.php" class="btn btn-ghost btn-sm">← К календарю</a>
        </div>
        
        <nav class="admin-nav">
            <a href="<?php echo $basePath; ?>/pages/admin/index.php">Календарь</a>
            <a href="<?php echo $basePath; ?>/pages/admin/manage-masters.php" class="active">Исследователи</a>
            <a href="<?php echo $basePath; ?>/pages/admin/manage-services.php">Протоколы</a>
            <?php if ($_SESSION['admin_role'] === 'director'): ?>
                <a href="<?php echo $basePath; ?>/pages/admin/vacations.php">Отпуска</a>
                <a href="<?php echo $basePath; ?>/pages/admin/statistics.php">Статистика</a>
            <?php endif; ?>
        </nav>
        
               <!-- Форма добавления/редактирования -->
        <div class="admin-form">
            <h3><?php echo $editMaster ? 'Редактировать исследователя' : 'Добавить исследователя'; ?></h3>
            <form method="POST" action="<?php echo $basePath; ?>/scripts/admin/<?php echo $editMaster ? 'edit-master' : 'add-master'; ?>.php" enctype="multipart/form-data">
                <?php if ($editMaster): ?>
                    <input type="hidden" name="id" value="<?php echo $editMaster['id']; ?>">
                <?php endif; ?>
                
                <div class="admin-form-row">
                    <div>
                        <label>Имя</label>
                        <input type="text" name="name" required value="<?php echo $editMaster ? htmlspecialchars($editMaster['name']) : ''; ?>">
                    </div>
                    <div>
                        <label>Специализация</label>
                        <input type="text" name="specialization" required value="<?php echo $editMaster ? htmlspecialchars($editMaster['specialization']) : ''; ?>">
                    </div>
                </div>
                
                <div class="admin-form-row single">
                    <div>
                        <label>Описание</label>
                        <textarea name="description"><?php echo $editMaster ? htmlspecialchars($editMaster['description']) : ''; ?></textarea>
                    </div>
                </div>
                
                <div class="admin-form-row">
                    <div>
                        <label>Фото</label>
                        <input type="file" name="photo" accept="image/jpeg,image/png,image/webp" style="padding: 8px;">
                        <?php if ($editMaster && $editMaster['photo']): ?>
                            <div style="margin-top: 10px;">
                                <img src="<?php echo $basePath; ?>/assets/images/masters/<?php echo $editMaster['photo']; ?>" 
                                     alt="" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 1px solid var(--border);">
                                <p style="font-size: 11px; color: var(--text-muted); margin-top: 6px;">Оставьте поле пустым, чтобы сохранить текущее фото</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if ($editMaster): ?>
                    <div style="margin-bottom: 16px;">
                        <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 13px; color: var(--text); cursor: pointer;">
                            <input type="checkbox" name="is_active" <?php echo $editMaster['is_active'] ? 'checked' : ''; ?>>
                            Активен
                        </label>
                    </div>
                <?php endif; ?>
                
                <div class="admin-form-buttons">
                    <button type="submit" class="btn btn-gold">
                        <?php echo $editMaster ? 'Сохранить' : 'Добавить'; ?>
                    </button>
                    <?php if ($editMaster): ?>
                        <a href="<?php echo $basePath; ?>/pages/admin/manage-masters.php" class="btn btn-ghost">Отмена</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <!-- Таблица -->
        <div class="admin-table-wrap">
            <table class="admin-table">
               <thead>
                    <tr>
                        <th>Фото</th>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Специализация</th>
                        <th>Рейтинг</th>
                        <th>Отзывов</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($masters as $m): ?>
                        <tr>
                            <td>
                                <?php if ($m['photo']): ?>
                                    <img src="<?php echo $basePath; ?>/assets/images/masters/<?php echo $m['photo']; ?>" 
                                         alt="" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                <?php else: ?>
                                    <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--bg-warm); display: flex; align-items: center; justify-content: center; color: var(--text-light); font-size: 12px;">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <circle cx="12" cy="8" r="4"/>
                                            <path d="M4 20c0-4 4-7 8-7s8 3 8 7" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>#<?php echo $m['id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($m['name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($m['specialization']); ?></td>
                            <td><span style="color: var(--gold);">★ <?php echo $m['rating']; ?></span></td>
                            <td><?php echo $m['reviews_count']; ?></td>
                            <td><?php echo $m['is_active'] ? 'Активен' : 'Неактивен'; ?></td>
                            <td>
                                <div class="admin-actions">
                                    <a href="?edit=<?php echo $m['id']; ?>" class="admin-edit-link">Редактировать</a>
                                    <a href="<?php echo $basePath; ?>/scripts/admin/delete-master.php?id=<?php echo $m['id']; ?>" class="admin-delete-link" onclick="return confirm('Удалить исследователя?')">Удалить</a>
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