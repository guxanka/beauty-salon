<?php
    $pageTitle = "Запись | Лаборатория красоты";
    include 'header.php';
    
    require_once __DIR__ . '/../config/db.php';
    
    // Получаем услуги
    $services = $pdo->query("SELECT * FROM services WHERE is_active = 1 ORDER BY category, name")->fetchAll();
    
    // Получаем мастеров
    $masters = $pdo->query("SELECT * FROM masters WHERE is_active = 1 ORDER BY name")->fetchAll();
    
    // Группируем услуги по категориям
    $categories = [];
    foreach ($services as $s) {
        $categories[$s['category']][] = $s;
    }
    
    $categoryNames = [
        'coloring' => 'Окрашивание',
        'haircuts_women' => 'Женские стрижки',
        'haircuts_men' => 'Мужской зал',
        'styling' => 'Укладки',
        'care' => 'Уходы',
        'brows' => 'Эстетика бровей'
    ];
    
    $isLoggedIn = isset($_SESSION['client_id']);
    $clientName = $_SESSION['client_name'] ?? '';
    $clientPhone = '';
    $clientEmail = '';
    
    if ($isLoggedIn) {
        $stmt = $pdo->prepare("SELECT phone, email FROM clients WHERE id = ?");
        $stmt->execute([$_SESSION['client_id']]);
        $client = $stmt->fetch();
        $clientPhone = $client['phone'];
        $clientEmail = $client['email'];
    }
?>

<style>
.booking-section { padding: 60px 0 80px; background: var(--bg); min-height: calc(100vh - 200px); }
.booking-container { max-width: 700px; margin: 0 auto; }

/* Индикатор шагов */
.booking-steps { display: flex; justify-content: space-between; margin-bottom: 48px; position: relative; }
.booking-steps::before { content: ''; position: absolute; top: 18px; left: 0; right: 0; height: 1px; background: var(--border); z-index: 0; }
.booking-step { display: flex; flex-direction: column; align-items: center; gap: 10px; position: relative; z-index: 1; flex: 1; }
.booking-step-num { width: 36px; height: 36px; border-radius: 50%; background: var(--bg); border: 1.5px solid var(--border); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 600; color: var(--text-light); transition: all var(--transition); }
.booking-step.active .booking-step-num { background: var(--gold); border-color: var(--gold); color: #fff; }
.booking-step.done .booking-step-num { background: var(--dark); border-color: var(--dark); color: #fff; }
.booking-step-label { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: var(--text-light); font-weight: 500; text-align: center; }
.booking-step.active .booking-step-label { color: var(--gold); }
.booking-step.done .booking-step-label { color: var(--dark); }

/* Шаги */
.booking-step-content { display: none; }
.booking-step-content.active { display: block; }

/* Заголовок шага */
.booking-step-heading { font-family: var(--font-accent); font-size: 24px; color: var(--dark); margin-bottom: 8px; }
.booking-step-subtitle { font-size: 14px; color: var(--text-muted); margin-bottom: 32px; }

/* Выбор старта */
.booking-start-choice { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px; }
.booking-start-card { padding: 32px 24px; border: 1px solid var(--border); text-align: center; cursor: pointer; transition: all var(--transition); background: var(--white); }
.booking-start-card:hover { border-color: var(--gold); box-shadow: 0 8px 24px rgba(0,0,0,0.03); transform: translateY(-2px); }
.booking-start-card-icon { font-size: 32px; margin-bottom: 12px; }
.booking-start-card h3 { font-family: var(--font-accent); font-size: 18px; color: var(--dark); margin-bottom: 6px; }
.booking-start-card p { font-size: 13px; color: var(--text-muted); }

/* Фиксированная кнопка Далее */
.booking-sticky-next { position: sticky; bottom: 0; background: var(--bg); padding: 16px 0; border-top: 1px solid var(--border); margin-top: 32px; display: flex; justify-content: flex-end; z-index: 10; }

/* Выбор услуги */
.booking-category-block { margin-bottom: 32px; }
.booking-category-title { font-family: var(--font-accent); font-size: 20px; color: var(--dark); margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid var(--border-light); }
.booking-service-item { display: flex; justify-content: space-between; align-items: center; padding: 14px 0; border-bottom: 1px solid var(--border-light); cursor: pointer; transition: all var(--transition); }
.booking-service-item:hover { color: var(--gold); }
.booking-service-item.selected { color: var(--gold); font-weight: 500; }
.booking-service-item-name { flex: 1; font-size: 14px; }
.booking-service-item-price { font-family: var(--font-accent); font-size: 15px; font-weight: 600; color: var(--dark); margin-left: 16px; white-space: nowrap; }
.booking-service-item.selected .booking-service-item-price { color: var(--gold); }

/* Выбор мастера */
.booking-masters-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 20px; }
.booking-master-card { padding: 16px; border: 1px solid var(--border); cursor: pointer; transition: all var(--transition); text-align: center; }
.booking-master-card:hover { border-color: var(--gold); }
.booking-master-card.selected { border-color: var(--gold); background: var(--gold-pale); }
.booking-master-card-name { font-family: var(--font-accent); font-size: 16px; color: var(--dark); margin-bottom: 2px; }
.booking-master-card-spec { font-size: 11px; color: var(--text-muted); }
.booking-skip { text-align: center; margin-top: 16px; }
.booking-skip-link { font-size: 13px; color: var(--text-muted); cursor: pointer; transition: color var(--transition); }
.booking-skip-link:hover { color: var(--gold); }

/* Выбор времени */
.booking-date-field { position: relative; margin-bottom: 32px; }
.booking-date-field label { display: block; font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); margin-bottom: 8px; font-weight: 500; }
.booking-date-field input { width: 100%; padding: 12px 16px; border: 1px solid var(--border); font-family: var(--font-main); font-size: 14px; outline: none; background: var(--white); }
.booking-date-field input:focus { border-color: var(--gold); }
.booking-time-group { margin-bottom: 28px; }
.booking-time-group-title { font-size: 12px; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); margin-bottom: 12px; font-weight: 500; }
.booking-time-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
.booking-time-slot { padding: 12px 8px; text-align: center; border: 1px solid var(--border); font-size: 13px; cursor: pointer; transition: all var(--transition); background: var(--white); }
.booking-time-slot:hover { border-color: var(--gold); color: var(--gold); }
.booking-time-slot.selected { background: var(--gold); border-color: var(--gold); color: #fff; }
.booking-time-slot.disabled { opacity: 0.3; pointer-events: none; }

/* Кнопки */
.booking-buttons { display: flex; justify-content: space-between; margin-top: 32px; gap: 12px; }

/* Форма контактов */
.booking-form .field { position: relative; margin-bottom: 24px; }
.booking-form .field input, .booking-form .field textarea { width: 100%; padding: 16px 0 8px; font-family: var(--font-main); font-size: 15px; color: var(--dark); background: transparent; border: none; border-bottom: 1px solid var(--border); outline: none; resize: vertical; }
.booking-form .field input:focus, .booking-form .field textarea:focus { border-bottom-color: var(--gold); }
.booking-form .field label { position: absolute; top: 16px; left: 0; font-size: 14px; color: var(--text-light); pointer-events: none; transition: all 0.25s ease; }
.booking-form .field input:focus + label, .booking-form .field input:not(:placeholder-shown) + label,
.booking-form .field textarea:focus + label, .booking-form .field textarea:not(:placeholder-shown) + label { top: -6px; font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase; color: var(--gold); font-weight: 600; }
.booking-form .field input::placeholder, .booking-form .field textarea::placeholder { color: transparent; }

@media (max-width: 576px) {
    .booking-start-choice { grid-template-columns: 1fr; }
    .booking-masters-grid { grid-template-columns: 1fr; }
    .booking-time-grid { grid-template-columns: repeat(3, 1fr); }
    .booking-step-label { font-size: 9px; letter-spacing: 0.5px; }
}
</style>

<section class="booking-section">
    <div class="container booking-container">
        
        <div class="section-header">
            <span class="section-eyebrow">Онлайн-запись</span>
            <h2 class="section-heading">Зарезервировать время</h2>
        </div>
        
        <!-- Индикатор шагов -->
        <div class="booking-steps" id="bookingSteps">
            <div class="booking-step active" data-step="1">
                <span class="booking-step-num">1</span>
                <span class="booking-step-label">Протокол</span>
            </div>
            <div class="booking-step" data-step="2">
                <span class="booking-step-num">2</span>
                <span class="booking-step-label">Исследователь</span>
            </div>
            <div class="booking-step" data-step="3">
                <span class="booking-step-num">3</span>
                <span class="booking-step-label">Дата и время</span>
            </div>
            <div class="booking-step" data-step="4">
                <span class="booking-step-num">4</span>
                <span class="booking-step-label">Контакты</span>
            </div>
        </div>
        
        <form id="bookingForm" action="<?php echo $basePath; ?>/scripts/booking-process.php" method="POST">
            <input type="hidden" name="service_id" id="selectedServiceId">
            <input type="hidden" name="master_id" id="selectedMasterId">
            <input type="hidden" name="booking_date" id="selectedDate">
            <input type="hidden" name="booking_time" id="selectedTime">
            
            <!-- Шаг 0: Выбор старта -->
            <div class="booking-step-content active" data-step="0">
                <h3 class="booking-step-heading">С чего начнём?</h3>
                <p class="booking-step-subtitle">Вы можете выбрать протокол или сразу перейти к выбору исследователя</p>
                
                <div class="booking-start-choice">
                    <div class="booking-start-card" id="startService">
                        <div class="booking-start-card-icon">
                            <img src="<?php echo $basePath; ?>/assets/images/icons/icon-coloring.svg" alt="" width="40" height="40" style="opacity: 0.7;">
                        </div>
                        <h3>Выбрать протокол</h3>
                        <p>Подобрать услугу, а затем мастера</p>
                    </div>
                    <div class="booking-start-card" id="startMaster">
                        <div class="booking-start-card-icon">
                            <img src="<?php echo $basePath; ?>/assets/images/icons/icon-consultation.svg" alt="" width="40" height="40" style="opacity: 0.7;">
                        </div>
                        <h3>Выбрать исследователя</h3>
                        <p>Сначала найти мастера, затем услугу</p>
                    </div>
                </div>
            </div>
            
            <!-- Шаг 1: Выбор услуги -->
            <div class="booking-step-content" data-step="1">
                <h3 class="booking-step-heading">Выберите протокол</h3>
                <p class="booking-step-subtitle">Определитесь с категорией и услугой</p>
                
                <?php foreach ($categories as $catKey => $catServices): ?>
                    <div class="booking-category-block">
                        <h4 class="booking-category-title"><?php echo $categoryNames[$catKey] ?? $catKey; ?></h4>
                        <?php foreach ($catServices as $service): ?>
                            <div class="booking-service-item" data-service-id="<?php echo $service['id']; ?>" data-service-name="<?php echo htmlspecialchars($service['name']); ?>" data-service-price="<?php echo $service['price']; ?>" data-service-duration="<?php echo $service['duration_min']; ?>">
                                <span class="booking-service-item-name"><?php echo htmlspecialchars($service['name']); ?></span>
                                <span class="booking-service-item-price"><?php echo number_format($service['price'], 0, '', ' '); ?> ₽</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
                
                <!-- Фиксированная кнопка -->
                <div class="booking-sticky-next">
                    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                        <span id="selectedServiceInfo" style="font-size: 13px; color: var(--text-muted);"></span>
                        <button type="button" class="btn btn-gold" id="nextFromService" disabled>Далее</button>
                    </div>
                </div>
            </div>
            
            <!-- Шаг 2: Выбор мастера -->
            <div class="booking-step-content" data-step="2">
                <h3 class="booking-step-heading">Выберите исследователя</h3>
                <p class="booking-step-subtitle">Доверьтесь профессионалу или пропустите — назначим любого свободного</p>
                
                <div class="booking-masters-grid" id="mastersGrid">
                    <?php foreach ($masters as $master): ?>
                        <div class="booking-master-card" data-master-id="<?php echo $master['id']; ?>" data-master-name="<?php echo htmlspecialchars($master['name']); ?>">
                            <div class="booking-master-card-name"><?php echo htmlspecialchars($master['name']); ?></div>
                            <div class="booking-master-card-spec"><?php echo htmlspecialchars($master['specialization']); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="booking-skip">
                    <span class="booking-skip-link" id="skipMaster">Пропустить — назначить любого исследователя</span>
                </div>
                
                <div class="booking-buttons">
                    <button type="button" class="btn btn-ghost" id="backFromMaster">← Назад</button>
                    <button type="button" class="btn btn-gold" id="nextToStep3">Далее</button>
                </div>
            </div>
            
            <!-- Шаг 3: Выбор даты и времени -->
            <div class="booking-step-content" data-step="3">
                <h3 class="booking-step-heading">Выберите дату и время</h3>
                <p class="booking-step-subtitle">Свободные слоты сгруппированы по времени суток</p>
                
                <div class="booking-date-field">
                    <label for="bookingDate">Дата визита</label>
                    <input type="date" id="bookingDate" min="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <div id="timeSlots">
                    <p style="font-size: 14px; color: var(--text-muted); text-align: center; padding: 40px;">Выберите дату, чтобы увидеть доступное время</p>
                </div>
                
                <div class="booking-buttons">
                    <button type="button" class="btn btn-ghost" id="backFromTime">← Назад</button>
                    <button type="button" class="btn btn-gold" id="nextToStep4" disabled>Далее</button>
                </div>
            </div>
            
            <!-- Шаг 4: Контакты -->
            <div class="booking-step-content booking-form" data-step="4">
                <h3 class="booking-step-heading">Ваши контакты</h3>
                <p class="booking-step-subtitle">Укажите данные для подтверждения записи</p>
                
                <div class="field">
                    <input type="text" id="clientName" name="client_name" placeholder=" " value="<?php echo htmlspecialchars($clientName); ?>" required>
                    <label for="clientName">Ваше имя</label>
                </div>
                
                <div class="field">
                    <input type="tel" id="clientPhone" name="client_phone" placeholder=" " value="<?php echo htmlspecialchars($clientPhone); ?>" required>
                    <label for="clientPhone">Телефон</label>
                </div>
                
                <div class="field">
                    <input type="email" id="clientEmail" name="client_email" placeholder=" " value="<?php echo htmlspecialchars($clientEmail); ?>">
                    <label for="clientEmail">Email (необязательно)</label>
                </div>
                
                <div class="field">
                    <textarea id="comment" name="comment" placeholder=" " rows="2"></textarea>
                    <label for="comment">Комментарий (необязательно)</label>
                </div>
                
                <div class="booking-buttons">
                    <button type="button" class="btn btn-ghost" id="backFromContacts">← Назад</button>
                    <button type="submit" class="btn btn-gold">Зарезервировать</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 0;
    let bookingData = {
        serviceId: null,
        serviceName: '',
        servicePrice: 0,
        masterId: null,
        masterName: '',
        date: '',
        time: ''
    };
    
    // === ВЫБОР СТАРТА ===
    document.getElementById('startService').addEventListener('click', function() {
        goToStep(1);
    });
    
    document.getElementById('startMaster').addEventListener('click', function() {
        goToStep(2);
    });
    
    // === ШАГ 1: Выбор услуги ===
    document.querySelectorAll('.booking-service-item').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('.booking-service-item').forEach(i => i.classList.remove('selected'));
            this.classList.add('selected');
            bookingData.serviceId = this.dataset.serviceId;
            bookingData.serviceName = this.dataset.serviceName;
            bookingData.servicePrice = this.dataset.servicePrice;
            document.getElementById('selectedServiceId').value = this.dataset.serviceId;
            document.getElementById('selectedServiceInfo').textContent = 'Выбрано: ' + this.dataset.serviceName + ' — ' + parseInt(this.dataset.servicePrice).toLocaleString() + ' ₽';
            document.getElementById('nextFromService').disabled = false;
        });
    });
    
        document.getElementById('nextFromService').addEventListener('click', function() {
        if (!bookingData.serviceId) {
            alert('Пожалуйста, выберите протокол');
            return;
        }
        goToStep(2);
    });
    
    // === ШАГ 2: Выбор мастера ===
    document.querySelectorAll('.booking-master-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.booking-master-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            bookingData.masterId = this.dataset.masterId;
            bookingData.masterName = this.dataset.masterName;
            document.getElementById('selectedMasterId').value = this.dataset.masterId;
        });
    });
    
    document.getElementById('skipMaster').addEventListener('click', function() {
        document.querySelectorAll('.booking-master-card').forEach(c => c.classList.remove('selected'));
        bookingData.masterId = null;
        bookingData.masterName = 'Любой исследователь';
        document.getElementById('selectedMasterId').value = '';
        this.textContent = 'Пропущено — будет назначен любой исследователь';
    });
    
        document.getElementById('nextToStep3').addEventListener('click', function() {
        // Если услуга не выбрана — сначала на шаг 1
        if (!bookingData.serviceId) {
            goToStep(1);
        } else {
            goToStep(3);
        }
    });
        document.getElementById('nextToStep4').addEventListener('click', function() {
        if (!bookingData.serviceId) {
            alert('Пожалуйста, выберите протокол');
            goToStep(1);
            return;
        }
        if (!bookingData.date || !bookingData.time) {
            alert('Пожалуйста, выберите дату и время');
            return;
        }
        goToStep(4);
    });
        document.getElementById('backFromMaster').addEventListener('click', function() {
        // Если услуга не выбрана — возвращаем на выбор услуги, иначе на старт
        if (!bookingData.serviceId) {
            goToStep(1);
        } else {
            goToStep(0);
        }
    });
    
    // === ШАГ 3: Дата и время ===
    document.getElementById('bookingDate').addEventListener('change', function() {
        bookingData.date = this.value;
        document.getElementById('selectedDate').value = this.value;
        loadTimeSlots(this.value);
    });
    
    function loadTimeSlots(date) {
        const container = document.getElementById('timeSlots');
        container.innerHTML = '<p style="text-align:center; padding: 20px; color: var(--text-muted);">Загрузка доступного времени...</p>';
        
        fetch('<?php echo $basePath; ?>/scripts/get-time-slots.php?date=' + date + '&service_id=' + bookingData.serviceId + '&master_id=' + (bookingData.masterId || ''))
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    container.innerHTML = '<p style="text-align:center; padding: 20px; color: #C44;">' + data.error + '</p>';
                    return;
                }
                
                let html = '';
                
                if (data.morning && data.morning.length > 0) {
                    html += '<div class="booking-time-group"><div class="booking-time-group-title">Утро (10:00–12:00)</div><div class="booking-time-grid">';
                    data.morning.forEach(slot => { html += '<div class="booking-time-slot" data-time="' + slot + '">' + slot + '</div>'; });
                    html += '</div></div>';
                }
                
                if (data.day && data.day.length > 0) {
                    html += '<div class="booking-time-group"><div class="booking-time-group-title">День (12:00–17:00)</div><div class="booking-time-grid">';
                    data.day.forEach(slot => { html += '<div class="booking-time-slot" data-time="' + slot + '">' + slot + '</div>'; });
                    html += '</div></div>';
                }
                
                if (data.evening && data.evening.length > 0) {
                    html += '<div class="booking-time-group"><div class="booking-time-group-title">Вечер (17:00–20:00)</div><div class="booking-time-grid">';
                    data.evening.forEach(slot => { html += '<div class="booking-time-slot" data-time="' + slot + '">' + slot + '</div>'; });
                    html += '</div></div>';
                }
                
                if (!html) {
                    html = '<p style="text-align:center; padding: 20px; color: var(--text-muted);">На выбранную дату нет свободных слотов</p>';
                }
                
                container.innerHTML = html;
                
                container.querySelectorAll('.booking-time-slot').forEach(slot => {
                    slot.addEventListener('click', function() {
                        container.querySelectorAll('.booking-time-slot').forEach(s => s.classList.remove('selected'));
                        this.classList.add('selected');
                        bookingData.time = this.dataset.time;
                        document.getElementById('selectedTime').value = this.dataset.time;
                        document.getElementById('nextToStep4').disabled = false;
                    });
                });
            });
    }
    
    document.getElementById('nextToStep4').addEventListener('click', () => goToStep(4));
    document.getElementById('backFromTime').addEventListener('click', () => goToStep(2));
    document.getElementById('backFromContacts').addEventListener('click', () => goToStep(3));
    
    // === Навигация ===
        function goToStep(step) {
        // Если переходим на шаг 3 или 4, но услуга не выбрана — возвращаем на шаг 1
        if (step >= 3 && !bookingData.serviceId) {
            step = 1;
        }
        
        document.querySelector('.booking-step-content.active').classList.remove('active');
        document.querySelector('.booking-step-content[data-step="' + step + '"]').classList.add('active');
        
        document.querySelectorAll('.booking-step').forEach(s => {
            s.classList.remove('active', 'done');
            const sn = parseInt(s.dataset.step);
            if (sn < step) s.classList.add('done');
            if (sn === step) s.classList.add('active');
        });
        
        currentStep = step;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});
</script>

<?php include 'footer.php'; ?>