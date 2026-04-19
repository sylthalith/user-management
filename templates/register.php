<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="<?= style('register'); ?>">
</head>
<body>
<form action="/register" method="POST">
    <div class="input-block">
        <label for="name">Имя</label>
        <input id="name" type="text" name="name">
        <?php if (isset($data['errors']['name'])): ?>
            <?php foreach($data['errors']['name'] as $error): ?>
                <div class="error"><?= $error ?></div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="input-block">
        <label for="phone">Телефон</label>
        <input id="phone" type="text" name="phone">
        <?php if (isset($data['errors']['phone'])): ?>
            <?php foreach($data['errors']['phone'] as $error): ?>
                <div class="error"><?= $error ?></div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="input-block">
        <label for="email">Почта</label>
        <input id="email" type="email" name="email">
        <?php if (isset($data['errors']['email'])): ?>
            <?php foreach($data['errors']['email'] as $error): ?>
                <div class="error"><?= $error ?></div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="input-block">
        <label for="password">Пароль</label>
        <input id="password" type="password" name="password">
        <?php if (isset($data['errors']['password'])): ?>
            <?php foreach($data['errors']['password'] as $error): ?>
                <div class="error"><?= $error ?></div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="input-block">
        <label for="password_confirmation">Подтверждение пароля</label>
        <input id="password_confirmation" type="password" name="password_confirmation">
        <?php if (isset($data['errors']['password_confirmation'])): ?>
            <?php foreach($data['errors']['password_confirmation'] as $error): ?>
                <div class="error"><?= $error ?></div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <button type="submit">Отправить</button>
</form>
</body>
</html>