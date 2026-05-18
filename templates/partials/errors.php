<?php if (isset($errors)): ?>
    <?php foreach(wrap_array($errors) as $error): ?>
        <div class="error"><?= h($error) ?></div>
    <?php endforeach; ?>
<?php endif; ?>