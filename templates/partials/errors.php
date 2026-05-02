<?php if (isset($errors)): ?>
    <?php if (is_array($errors)): ?>
        <?php foreach($errors as $error): ?>
            <div class="error"><?= $error ?></div>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if (is_string($errors)): ?>
        <div class="error"><?= $errors ?></div>
    <?php endif; ?>
<?php endif; ?>