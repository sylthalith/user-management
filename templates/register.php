<?php template('partials/header', ['styles' => [style('auth')]]) ?>
<form action="/register" method="POST">
    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
    <div class="input-block">
        <label for="name">Имя</label>
        <input id="name" type="text" name="name" value="<?= $name ?? '' ?>">
        <?php if (isset($errors['name'])) : ?>
            <?php template('partials/errors', ['errors' => $errors['name']]) ?>
        <?php endif ?>
    </div>
    <div class="input-block">
        <label for="phone">Телефон</label>
        <input id="phone" type="text" name="phone" value="<?= $phone ?? '' ?>">
        <?php if (isset($errors['phone'])) : ?>
            <?php template('partials/errors', ['errors' => $errors['phone']]) ?>
        <?php endif ?>
    </div>
    <div class="input-block">
        <label for="email">Почта</label>
        <input id="email" type="email" name="email" value="<?= $email ?? '' ?>">
        <?php if (isset($errors['email'])) : ?>
            <?php template('partials/errors', ['errors' => $errors['email']]) ?>
        <?php endif ?>
    </div>
    <div class="input-block">
        <label for="password">Пароль</label>
        <input id="password" type="password" name="password">
        <?php if (isset($errors['password'])) : ?>
            <?php template('partials/errors', ['errors' => $errors['password']]) ?>
        <?php endif ?>
    </div>
    <div class="input-block">
        <label for="password_confirmation">Подтверждение пароля</label>
        <input id="password_confirmation" type="password" name="password_confirmation">
        <?php if (isset($errors['password_confirmation'])) : ?>
            <?php template('partials/errors', ['errors' => $errors['password_confirmation']]) ?>
        <?php endif ?>
    </div>
    <button type="submit">Отправить</button>
</form>
<?php template('partials/footer') ?>