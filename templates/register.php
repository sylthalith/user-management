<?php partial('header', ['style' => style('register')]) ?>
<form action="/register" method="POST">
    <div class="input-block">
        <label for="name">Имя</label>
        <input id="name" type="text" name="name">
        <?php partial('errors', ['errors' => $errors ?? [], 'field' => 'name']) ?>
    </div>
    <div class="input-block">
        <label for="phone">Телефон</label>
        <input id="phone" type="text" name="phone">
        <?php partial('errors', ['errors' => $errors ?? [], 'field' => 'phone']) ?>
    </div>
    <div class="input-block">
        <label for="email">Почта</label>
        <input id="email" type="email" name="email">
        <?php partial('errors', ['errors' => $errors ?? [], 'field' => 'email']) ?>
    </div>
    <div class="input-block">
        <label for="password">Пароль</label>
        <input id="password" type="password" name="password">
        <?php partial('errors', ['errors' => $errors ?? [], 'field' => 'password']) ?>
    </div>
    <div class="input-block">
        <label for="password_confirmation">Подтверждение пароля</label>
        <input id="password_confirmation" type="password" name="password_confirmation">
        <?php partial('errors', ['errors' => $errors ?? [], 'field' => 'password_confirmation']) ?>
    </div>
    <button type="submit">Отправить</button>
</form>?>
<?php partial('footer') ?>