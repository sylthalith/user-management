<?php
partial('header', ['styles' => styles('input')]);
partial('navbar');
?>
<div class="window input">
    <h1 class="input-header">Вход</h1>
    <form class="form" action="/login" method="POST">
        <?= csrfToken() ?>
        <?php
        partial('input-block', ['name' => 'email', 'label' => 'Почта', 'value' => h($email ?? ''), 'type' => 'email', 'errors' => $errors['email'] ?? []]);
        partial('input-block', ['name' => 'password', 'label' => 'Пароль', 'type' => 'password', 'errors' => $errors['password'] ?? []]);
        ?>
        <div>
            <input type="checkbox" name="remember_me">
            Запомнить меня
        </div>
        <button class="btn submit-btn white-btn" type="submit">Отправить</button>
    </form>
</div>
<?php partial('footer') ?>