<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo style('register'); ?>">
</head>
<body>
<form action="/register" method="POST">
    <div class="input-block">
        <label for="name">Имя</label>
        <input id="name" type="text" name="name">
    </div>
    <div class="input-block">
        <label for="phone">Телефон</label>
        <input id="phone" type="text" name="phone">
    </div>
    <div class="input-block">
        <label for="email">Почта</label>
        <input id="email" type="email" name="email">
    </div>
    <div class="input-block">
        <label for="password">Пароль</label>
        <input id="password" type="password" name="password">
    </div>
    <div class="input-block">
        <label for="password_confirmation">Подтверждение пароля</label>
        <input id="password_confirmation" type="password" name="password2">
    </div>
    <button type="submit">Отправить</button>
</form>
</body>
</html>