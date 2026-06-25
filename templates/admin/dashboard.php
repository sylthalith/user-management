<?php
partial('header', ['styles' => styles(['admin/main', 'admin/dashboard'])]);
partial('navbar');
?>
<div class="container">
    <ul class="stats">
        <li class="stats-item window">
            <div class="stats-item-label">
                Всего пользователей
            </div>
            <div class="stats-item-value">
                <?= $totalUsersCount ?>
            </div>
        </li>
        <li class="stats-item window">
            <div class="stats-item-label">
                За неделю
            </div>
            <div class="stats-item-value">
                <?= $weeklyUsersCount ?>
            </div>
        </li>
        <li class="stats-item window">
            <div class="stats-item-label">
                Заблокировано
            </div>
            <div class="stats-item-value">
                <?= $blockedUsersCount ?>
            </div>
        </li>
    </ul>
    <div class="users window">
        <div class="users-header">
            <h1 class="users-header-title">Последние регистрации</h1>
            <a href="/admin/users" class="users-header-all">Все пользователи</a>
        </div>
        <div class="table-wrapper">
            <table class="users-table">
                <thead>
                <tr>
                    <th>Пользователь</th>
                    <th>Почта</th>
                    <th>Дата регистрации</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($recentUsers as $user): ?>
                    <tr>
                        <td>
                            <div class="user">
                                <div class="avatar user-avatar">
                                    <img src="<?= avatarSrc($user['avatar']) ?>" class="avatar-image">
                                </div>
                                <div class="user-name">
                                    <?= $user['name'] ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?= $user['email'] ?>
                        </td>
                        <td>
                            <?= $user['created_at'] ?>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php partial('footer') ?>
