<?php 
    $pageTitle = "Протоколы | Лаборатория красоты";
    include 'header.php'; 
?>

<!-- Заголовок -->
<section class="page-header">
    <div class="container">
        <span class="section-eyebrow">Направления работы</span>
        <h1 class="page-title">Протоколы красоты</h1>
        <p class="page-subtitle">Полный перечень процедур с актуальной стоимостью</p>
    </div>
</section>

<!-- Якорная навигация -->
<section class="section section-light category-nav-section">
    <div class="container">
        <nav class="category-nav">
            <a href="#coloring" class="category-nav-link">Окрашивание</a>
            <a href="#haircuts-women" class="category-nav-link">Женские стрижки</a>
            <a href="#haircuts-men" class="category-nav-link">Мужской зал</a>
            <a href="#styling" class="category-nav-link">Укладки</a>
            <a href="#care" class="category-nav-link">Уходы</a>
            <a href="#brows" class="category-nav-link">Эстетика бровей</a>
        </nav>
    </div>
</section>

<!-- ==================== ОКРАШИВАНИЕ ==================== -->
<section class="section" id="coloring">
    <div class="container">
        <div class="category-header">
            <img src="<?php echo $basePath; ?>/assets/images/icons/icon-coloring.svg" alt="" class="category-icon-svg" width="44" height="44">
            <div>
                <h2 class="category-title">Окрашивание</h2>
                <p class="category-desc">Авторские техники, классика, тонирование — персональная формула цвета</p>
            </div>
        </div>
        
        <div class="services-table">
            <div class="service-row service-row-header">
                <span class="service-col-name">Протокол</span>
                <span class="service-col-time">Продолжительность</span>
                <span class="service-col-price">Стоимость</span>
                <span class="service-col-action"></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Авторское окрашивание</strong>
                    <span class="service-subtitle">Тотальная перезагрузка цвета — смывка, анализ структуры, персональная формула</span>
                </div>
                <span class="service-col-time">5–6 ч</span>
                <span class="service-col-price">от 9 500 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Сложная техника окрашивания</strong>
                    <span class="service-subtitle">Airtouch, балаяж, шатуш — растяжка цвета с эффектом натуральности</span>
                </div>
                <span class="service-col-time">3–4 ч</span>
                <span class="service-col-price">от 7 500 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Окрашивание сложное (коррекция)</strong>
                    <span class="service-subtitle">Обновление балаяж / шатуш — работа с отросшей зоной</span>
                </div>
                <span class="service-col-time">2,5–3 ч</span>
                <span class="service-col-price">5 500 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Экстра блонд</strong>
                    <span class="service-subtitle">Осветление прикорневой зоны с тонированием — чистый блонд без компромиссов</span>
                </div>
                <span class="service-col-time">2,5–3 ч</span>
                <span class="service-col-price">от 4 500 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Окрашивание КЛАССИКА (полное)</strong>
                    <span class="service-subtitle">Равномерное окрашивание по всей длине в один тон</span>
                </div>
                <span class="service-col-time">2 ч</span>
                <span class="service-col-price">3 800 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Мелирование (классика)</strong>
                    <span class="service-subtitle">Осветление прядей — коррекция без тонирования</span>
                </div>
                <span class="service-col-time">2 ч</span>
                <span class="service-col-price">4 500 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Мелирование</strong>
                    <span class="service-subtitle">Частичное осветление прядей — акценты и блики</span>
                </div>
                <span class="service-col-time">1,5 ч</span>
                <span class="service-col-price">2 000 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Экспресс-тонирование PRIMA</strong>
                    <span class="service-subtitle">Краска-пена — чистота и глубина цвета за 40–60 минут</span>
                </div>
                <span class="service-col-time">40–60 мин</span>
                <span class="service-col-price">2 100 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Камуфляж седины ALPHA | PRIMA</strong>
                    <span class="service-subtitle">Тонирование седых волос — естественный результат</span>
                </div>
                <span class="service-col-time">1 ч</span>
                <span class="service-col-price">1 500 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
        </div>
    </div>
</section>

<!-- ==================== ЖЕНСКИЕ СТРИЖКИ ==================== -->
<section class="section section-light" id="haircuts-women">
    <div class="container">
        <div class="category-header">
            <img src="<?php echo $basePath; ?>/assets/images/icons/icon-haircut-w.svg" alt="" class="category-icon-svg" width="44" height="44">
            <div>
                <h2 class="category-title">Женские стрижки</h2>
                <p class="category-desc">Точная форма с учётом структуры волос и овала лица</p>
            </div>
        </div>
        
        <div class="services-table">
            <div class="service-row service-row-header">
                <span class="service-col-name">Протокол</span>
                <span class="service-col-time">Продолжительность</span>
                <span class="service-col-price">Стоимость</span>
                <span class="service-col-action"></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Стрижка женская + мытьё + сушка</strong>
                    <span class="service-subtitle">Стрижка с финишной укладкой по форме — подготовка, мытьё, кондиционирование, стрижка, сушка феном</span>
                </div>
                <span class="service-col-time">1 ч</span>
                <span class="service-col-price">1 200 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Экспресс-стрижка</strong>
                    <span class="service-subtitle">Подравнивание кончиков на сухих волосах — один срез</span>
                </div>
                <span class="service-col-time">30 мин</span>
                <span class="service-col-price">800 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Плетение косичек</strong>
                    <span class="service-subtitle">Различные виды плетения — от повседневного до вечернего</span>
                </div>
                <span class="service-col-time">30–60 мин</span>
                <span class="service-col-price">1 000 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
        </div>
    </div>
</section>

<!-- ==================== МУЖСКОЙ ЗАЛ ==================== -->
<section class="section" id="haircuts-men">
    <div class="container">
        <div class="category-header">
            <img src="<?php echo $basePath; ?>/assets/images/icons/icon-haircut-m.svg" alt="" class="category-icon-svg" width="44" height="44">
            <div>
                <h2 class="category-title">Мужской зал</h2>
                <p class="category-desc">Стрижки, оформление бороды, комплексный сервис</p>
            </div>
        </div>
        
        <div class="services-table">
            <div class="service-row service-row-header">
                <span class="service-col-name">Протокол</span>
                <span class="service-col-time">Продолжительность</span>
                <span class="service-col-price">Стоимость</span>
                <span class="service-col-action"></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Стрижка мужская комплекс</strong>
                    <span class="service-subtitle">Классическая мужская стрижка машинкой и ножницами</span>
                </div>
                <span class="service-col-time">45 мин</span>
                <span class="service-col-price">700 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Стрижка мужская КОМПЛЕКС+</strong>
                    <span class="service-subtitle">Расширенный комплекс — стрижка, мытьё, укладка</span>
                </div>
                <span class="service-col-time">1 ч</span>
                <span class="service-col-price">900 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Стрижка + правка бороды</strong>
                    <span class="service-subtitle">Комплексное оформление — стрижка головы и моделирование бороды</span>
                </div>
                <span class="service-col-time">1 ч 15 мин</span>
                <span class="service-col-price">1 200 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Стрижка налысо</strong>
                    <span class="service-subtitle">Чистое бритьё головы</span>
                </div>
                <span class="service-col-time">20 мин</span>
                <span class="service-col-price">260 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Удаление волос на лице</strong>
                    <span class="service-subtitle">Коррекция линии роста волос</span>
                </div>
                <span class="service-col-time">15 мин</span>
                <span class="service-col-price">200 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Сервис для мужчин</strong>
                    <span class="service-subtitle">Мытьё-пилинг, свето-массаж головы, восстанавливающая ампула</span>
                </div>
                <span class="service-col-time">45 мин</span>
                <span class="service-col-price">1 300 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
        </div>
    </div>
</section>

<!-- ==================== УКЛАДКИ ==================== -->
<section class="section section-light" id="styling">
    <div class="container">
        <div class="category-header">
            <img src="<?php echo $basePath; ?>/assets/images/icons/icon-styling.svg" alt="" class="category-icon-svg" width="44" height="44">
            <div>
                <h2 class="category-title">Укладки и причёски</h2>
                <p class="category-desc">От повседневной формы до вечернего образа</p>
            </div>
        </div>
        
        <div class="services-table">
            <div class="service-row service-row-header">
                <span class="service-col-name">Протокол</span>
                <span class="service-col-time">Продолжительность</span>
                <span class="service-col-price">Стоимость</span>
                <span class="service-col-action"></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Экспресс-сушка волос</strong>
                    <span class="service-subtitle">Быстрая сушка феном с расчёсыванием</span>
                </div>
                <span class="service-col-time">20 мин</span>
                <span class="service-col-price">650 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Укладка феном (вечерняя)</strong>
                    <span class="service-subtitle">Объёмная или гладкая укладка со стайлингом</span>
                </div>
                <span class="service-col-time">45 мин</span>
                <span class="service-col-price">1 000 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Причёска вечерняя</strong>
                    <span class="service-subtitle">Сложная вечерняя причёска для особого случая</span>
                </div>
                <span class="service-col-time">1–1,5 ч</span>
                <span class="service-col-price">2 000 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
        </div>
    </div>
</section>

<!-- ==================== УХОДЫ ==================== -->
<section class="section" id="care">
    <div class="container">
        <div class="category-header">
            <img src="<?php echo $basePath; ?>/assets/images/icons/icon-care.svg" alt="" class="category-icon-svg" width="44" height="44">
            <div>
                <h2 class="category-title">Уходы для волос и кожи головы</h2>
                <p class="category-desc">Восстановление, детокс, глубокое питание</p>
            </div>
        </div>
        
        <div class="services-table">
            <div class="service-row service-row-header">
                <span class="service-col-name">Протокол</span>
                <span class="service-col-time">Продолжительность</span>
                <span class="service-col-price">Стоимость</span>
                <span class="service-col-action"></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Детокс кожи головы + реконструкция</strong>
                    <span class="service-subtitle">Молекулярное очищение, пенное обёртывание с протеинами, гиалуроновое восстановление</span>
                </div>
                <span class="service-col-time">1 ч</span>
                <span class="service-col-price">1 600 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Уходы для волос и кожи головы</strong>
                    <span class="service-subtitle">Базовый восстанавливающий уход — питание и увлажнение</span>
                </div>
                <span class="service-col-time">30 мин</span>
                <span class="service-col-price">350 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
        </div>
    </div>
</section>

<!-- ==================== ЭСТЕТИКА БРОВЕЙ ==================== -->
<section class="section section-light" id="brows">
    <div class="container">
        <div class="category-header">
            <img src="<?php echo $basePath; ?>/assets/images/icons/icon-brows.svg" alt="" class="category-icon-svg" width="44" height="44">
            <div>
                <h2 class="category-title">Эстетика бровей</h2>
                <p class="category-desc">Коррекция, окрашивание, долговременная укладка</p>
            </div>
        </div>
        
        <div class="services-table">
            <div class="service-row service-row-header">
                <span class="service-col-name">Протокол</span>
                <span class="service-col-time">Продолжительность</span>
                <span class="service-col-price">Стоимость</span>
                <span class="service-col-action"></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Долговременная укладка бровей</strong>
                    <span class="service-subtitle">Ламинирование + коррекция + окрашивание — формула идеальной формы</span>
                </div>
                <span class="service-col-time">1 ч</span>
                <span class="service-col-price">1 100 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Коррекция + окрашивание бровей</strong>
                    <span class="service-subtitle">Точная форма + подобранный оттенок</span>
                </div>
                <span class="service-col-time">40 мин</span>
                <span class="service-col-price">680 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Коррекция бровей</strong>
                    <span class="service-subtitle">Пинцет / воск — чёткий контур без лишних волосков</span>
                </div>
                <span class="service-col-time">20 мин</span>
                <span class="service-col-price">300 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
            
            <div class="service-row">
                <div class="service-col-name">
                    <strong>Окрашивание бровей или ресниц</strong>
                    <span class="service-subtitle">Краска / хна — выразительный взгляд</span>
                </div>
                <span class="service-col-time">20 мин</span>
                <span class="service-col-price">300 ₽</span>
                <span class="service-col-action"><a href="<?php echo $basePath; ?>/pages/register.php" class="btn btn-gold btn-sm">Выбрать</a></span>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>