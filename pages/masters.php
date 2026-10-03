<?php 
    $pageTitle = "Исследователи стиля | Лаборатория красоты";
    
    require_once __DIR__ . '/../config/db.php';
    
    $stmt = $pdo->query("SELECT * FROM masters WHERE is_active = 1 ORDER BY name ASC");
    $masters = $stmt->fetchAll();
    
    include 'header.php'; 
?>

<!-- Заголовок -->
<section class="page-header">
    <div class="container">
        <span class="section-eyebrow">Лабораторный состав</span>
        <h1 class="page-title">Исследователи стиля</h1>
        <p class="page-subtitle">Каждый специалист — компонент формулы вашего образа. Изучают, анализируют, создают</p>
    </div>
</section>

<!-- Сетка мастеров -->
<section class="section">
    <div class="container">
        <div class="masters-grid">
            <?php foreach ($masters as $master): ?>
                <div class="master-card">
                    
                    <!-- Фото -->
                    <div class="master-photo">
                        <?php if (!empty($master['photo'])): ?>
                            <img src="<?php echo $basePath; ?>/assets/images/masters/<?php echo $master['photo']; ?>" 
                                 alt="<?php echo htmlspecialchars($master['name']); ?>" 
                                 class="master-avatar-img">
                        <?php else: ?>
                            <img src="<?php echo $basePath; ?>/assets/images/icons/avatar-placeholder.svg" 
                                 alt="<?php echo htmlspecialchars($master['name']); ?>" 
                                 class="master-avatar-img" 
                                 width="80" height="80">
                        <?php endif; ?>
                    </div>
                    
                    <!-- Информация -->
                    <div class="master-info">
                        <h3 class="master-name"><?php echo htmlspecialchars($master['name']); ?></h3>
                        <p class="master-spec"><?php echo htmlspecialchars($master['specialization']); ?></p>
                        
                        <?php if (!empty($master['description'])): ?>
                            <p class="master-desc"><?php echo htmlspecialchars($master['description']); ?></p>
                        <?php endif; ?>
                        
                        <?php if ($master['reviews_count'] > 0): ?>
                            <div class="master-meta">
                                <div class="master-rating">
                                    <span class="master-stars">★</span>
                                    <span class="master-rating-value"><?php echo $master['rating']; ?></span>
                                    <span class="master-reviews">(<?php echo $master['reviews_count']; ?> отзывов)</span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Кнопка -->
                    <a href="<?php echo $basePath; ?>/pages/booking.php?master=<?php echo $master['id']; ?>" class="btn btn-gold btn-sm master-btn">Записаться</a>
                    
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>