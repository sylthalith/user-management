<header class="header">
    <div class="logo">
        User management
    </div>
    <div class="nav">
        <ul class="nav-item nav-links">
            <?php if (isAuth()): ?>
                <li class="nav-links-item">
                    <a class="nav-link" href="#">Главная</a>
                </li>
                <li class="nav-links-item">
                    <a class="nav-link" href="#">Профиль</a>
                </li>
            <?php else: ?>
                <li class="nav-links-item">
                    <a class="nav-link" href="/login">Вход</a>
                </li>
                <li class="nav-links-item">
                    <a class="nav-link" href="/register">Регистрация</a>
                </li>
            <?php endif ?>
        </ul>
        <div class="nav-item user">
            <?php if (isAuth()): ?>
                <div class="role">
                    Пользователь
                </div>
    <!--                <a class="avatar" href="#">-->
    <!--                    <img src="image.png" alt="" class="avatar-image">-->
    <!--                </a>-->
            <?php endif ?>
        </div>
    </div>
</header>