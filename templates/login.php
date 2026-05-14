<?php template('partials/header', ['styles' => [style('auth')]]) ?>
    <form action="/login" method="POST">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        <div class="input-block">
            <label for="email">Почта</label>
            <input id="email" type="email" name="email" value="<?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') ?>">
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
        <button type="submit">Отправить</button>
    </form>
<?php template('partials/footer') ?>