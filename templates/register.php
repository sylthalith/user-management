<?php
partial('header', ['styles' => styles('input')]);
partial('navbar');
?>
<div class="window input">
    <h1 class="input-header">Регистрация</h1>
    <form class="form" action="/register" method="POST">
        <?= csrfToken() ?>
        <?php
            partial('input-block', ['name' => 'name', 'label' => 'Имя', 'value' => h($old['name'] ?? ''), 'errors' => $errors['name'] ?? []]);
            partial('input-block', ['name' => 'phone', 'label' => 'Телефон', 'value' => h($old['phone'] ?? ''), 'errors' => $errors['phone'] ?? []]);
            partial('input-block', ['name' => 'email', 'label' => 'Почта', 'value' => h($old['email'] ?? ''), 'type' => 'email', 'errors' => $errors['email'] ?? []]);
            partial('input-block', ['name' => 'password', 'label' => 'Пароль', 'type' => 'password', 'errors' => $errors['password'] ?? []]);
            partial('input-block', ['name' => 'password_confirmation', 'label' => 'Подтверждение пароля', 'type' => 'password', 'errors' => $errors['password_confirmation'] ?? []]);
        ?>
        <button class="btn submit-btn white-btn" type="submit">Отправить</button>
    </form>
</div>
<?php partial('footer') ?>
