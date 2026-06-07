<?php
partial('header', ['styles' => styles(['input', 'profile/edit', 'profile/show'])]);
partial('navbar');
?>

<div class="window input">
    <h1 class="input-header">Редактирование профиля</h1>
    <div class="avatar profile-avatar">
        <img class="avatar-image" src="" alt="">
        <button class="btn dark-btn">Загрузить аватар</button>
    </div>
    <form class="form" action="/profile/edit" method="POST">
        <?= csrfToken() ?>
        <?php
        partial('input-block', ['name' => 'name', 'label' => 'Имя', 'value' => h($user['name'] ?? $old['name'] ?? ''), 'errors' => $errors['name'] ?? []]);
        partial('input-block', ['name' => 'phone', 'label' => 'Телефон', 'value' => h($user['phone'] ?? $old['phone'] ?? ''), 'errors' => $errors['phone'] ?? []]);
        partial('input-block', ['name' => 'email', 'label' => 'Почта', 'value' => h($user['email'] ?? $old['email'] ?? ''), 'errors' => $errors['email'] ?? []]);
        ?>
        <button class="btn white-btn" type="submit">Сохранить</button>
    </form>
</div>

<?php partial('footer') ?>