<?php
partial('header', ['styles' => styles('profile/show')]);
partial('navbar');
?>

<div class="window profile">
    <div class="avatar profile-avatar">
        <img class="avatar-image" src="<?= avatarSrc(user()['avatar']) ?>" alt="">
    </div>
    <div class="info">
        <h1 class="info-title">Профиль</h1>
        <div class="info-group">
            <p class="name">Имя</p>
            <p class="value"><?= $old['name'] ?></p>
        </div>
        <div class="info-group">
            <p class="name">Почта</p>
            <p class="value"><?= $old['email'] ?></p>
        </div>
        <div class="info-group">
            <p class="name">Телефон</p>
            <p class="value"><?= $old['phone'] ?></p>
        </div>
        <div class="info-group">
            <p class="name">Дата регистрации</p>
            <p class="value"><?= $old['created_at'] ?></p>
        </div>
        <div class="links">
            <a class="btn white-btn" href="/profile/edit">Редактировать</a>
            <a class="btn dark-btn" href="/password/change">Сменить пароль</a>
        </div>
    </div>
</div>

<?php partial('footer') ?>