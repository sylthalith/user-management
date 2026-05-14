<?php if (isset($errors)): ?>
    <?php foreach(wrap_array($errors) as $error): ?>
        <div class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endforeach; ?>
<?php endif; ?>