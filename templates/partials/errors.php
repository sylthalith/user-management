<?php if (isset($errors[$field])): ?>
    <?php foreach($errors[$field] as $error): ?>
        <div class="error"><?= $error ?></div>
    <?php endforeach; ?>
<?php endif; ?>