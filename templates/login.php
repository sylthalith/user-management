<?php
partial('header', ['styles' => styles(['main', 'input'])]);
partial('navbar');
?>
<div class="input">
    <h1 class="input-header">Вход</h1>
    <form class="form" action="/login" method="POST">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        <?php
        partial('input-block', ['name' => 'email', 'label' => 'Почта', 'value' => h($email ?? ''), 'type' => 'email', 'errors' => $errors['name'] ?? []]);
        partial('input-block', ['name' => 'password', 'label' => 'Пароль', 'type' => 'password', 'errors' => $errors['password'] ?? []]);
        ?>
        <button class="submit-btn" type="submit">Отправить</button>
    </form>
</div>
<?php partial('footer') ?>