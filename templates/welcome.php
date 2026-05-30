<?php
partial('header', ['styles' => styles(['main', 'welcome'])]);
partial('navbar');
?>

<div class="container">
    <div class="introduce">
        <h1 class="title">Система управления пользователями</h1>
        <p class="description">Регистрация, авторизация, личный кабинет и панель администратора</p>
        <div class="links">
            <a class="btn white-btn" href="/register">Начать</a>
            <a class="btn dark-btn" href="/login">Вход</a>
        </div>
    </div>
    <div class="features">
        <div class="window feature">
            <h2 class="feature-title">Регистрация</h2>
            <p class="feature-description">Создание аккаунта через имя, телефон, email и пароль.</p>
        </div>
        <div class="window feature">
            <h2 class="feature-title">Личный кабинет</h2>
            <p class="feature-description">Управление профилем, аватаром и настройками безопасности.</p>
        </div>
        <div class="window feature">
            <h2 class="feature-title">Администрирование</h2>
            <p class="feature-description">Управление пользователями, ролями и статусами аккаунтов. </p>
        </div>
    </div>
</div>

<?php
partial('footer', ['scripts' => scripts('main')]);