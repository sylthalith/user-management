<?php
partial('header', ['styles' => styles('input')]);
partial('navbar');
?>
    <div class="window input">
        <h1 class="input-header">Смена пароля</h1>
        <form class="form" action="/password/change" method="POST">
            <?= csrfToken() ?>
            <?php
            partial('input-block', ['name' => 'current_password', 'label' => 'Текущий пароль', 'type' => 'password', 'errors' => $errors['password'] ?? []]);
            partial('input-block', ['name' => 'password', 'label' => 'Новый пароль', 'type' => 'password', 'errors' => $errors['password'] ?? []]);
            partial('input-block', ['name' => 'password_confirmation', 'label' => 'Подтверждение пароля', 'type' => 'password', 'errors' => $errors['password_confirmation'] ?? []]);
            ?>
            <button class="btn submit-btn white-btn" type="submit">Отправить</button>
        </form>
    </div>
<?php partial('footer') ?>