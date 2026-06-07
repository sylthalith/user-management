<?php
partial('header', ['styles' => styles('error')]);
partial('navbar');
?>

<div class="content">
    <h1 class="code"><?= $code ?></h1>
    <p class="message"><?= $message ?></p>
    <a class="btn white-btn" href="/">На главную</a>
</div>

<?php partial('footer'); ?>