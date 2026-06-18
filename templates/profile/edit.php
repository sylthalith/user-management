<?php
partial('header', ['styles' => styles(['input', 'profile/edit', 'profile/show'])]);
partial('navbar');
?>

<div class="window input">
    <h1 class="input-header">Редактирование профиля</h1>
    <div class="avatar profile-avatar">
        <img class="avatar-image" src="<?= avatarSrc(user()['avatar']) ?>" alt="">
    </div>
    <form class="form" action="/profile/edit" method="POST" enctype="multipart/form-data">
        <?= csrfToken() ?>
        <label class="btn dark-btn">
            Загрузить аватар
            <input type="file" name="avatar" accept="image/*" id="avatar" style="display: none;">
        </label>
        <?php
        partial('input-block', ['name' => 'name', 'label' => 'Имя', 'value' => h($old['name'] ?? ''), 'errors' => $errors['name'] ?? []]);
        partial('input-block', ['name' => 'phone', 'label' => 'Телефон', 'value' => h($old['phone'] ?? ''), 'errors' => $errors['phone'] ?? []]);
        partial('input-block', ['name' => 'email', 'type' => 'email', 'label' => 'Почта', 'value' => h($old['email'] ?? ''), 'errors' => $errors['email'] ?? []]);
        ?>
        <button class="btn submit-btn white-btn" type="submit">Сохранить</button>
    </form>
</div>

<?php partial('footer') ?>