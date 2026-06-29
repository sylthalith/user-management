<?php
partial('header', ['styles' => styles(['admin/main', 'admin/users'])]);
partial('navbar');
?>
<div class="container">
    <form method="GET" action="/admin/users" class="filters">
        <input name="name" type="text">
        <select name="role">
            <option value="all">Все роли</option>
            <option value="user">Пользователь</option>
            <option value="admin">Администратор</option>
        </select>
        <select name="status">
            <option value="all">Все статусы</option>
            <option value="blocked">Заблокированные</option>
        </select>
        <button type="submit" class="btn white-btn">Поиск</button>
    </form>
    <div class="table-wrapper window">
        <table class="users-table">
            <thead>
            <tr>
                <th>Пользователь</th>
                <th>Телефон</th>
                <th>Почта</th>
                <th>Роль</th>
                <th>Дата регистрации</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($paginator->getItems() as $user): ?>
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
                            <?= $user['phone'] ?>
                        </td>
                        <td>
                            <?= $user['email'] ?>
                        </td>
                        <td>
                            <?= $user['is_admin'] ? 'Администратор' : 'Пользователь' ?>
                        </td>
                        <td>
                            <?= $user['created_at'] ?>
                        </td>
                        <td class="actions">
                            <a class="btn dark-btn" href="">Заблокировать</a>
                            <a class="btn dark-btn" href="">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <div class="pagination-wrapper">
        <?php partial('pagination', ['paginator' => $paginator]) ?>
    </div>
</div>
<?php partial('footer') ?>