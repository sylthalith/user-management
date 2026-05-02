<?php partial('header', ['style' => style('auth')]) ?>
    <form action="/login" method="POST">
        <div class="input-block">
            <label for="email">Почта</label>
            <input id="email" type="email" name="email">
            <?php partial('errors', ['errors' => $errors['email'] ?? []]) ?>
        </div>
        <div class="input-block">
            <label for="password">Пароль</label>
            <input id="password" type="password" name="password">
            <?php partial('errors', ['errors' => $errors['password'] ?? []]) ?>
        </div>
        <button type="submit">Отправить</button>
    </form>
<?php partial('footer') ?>