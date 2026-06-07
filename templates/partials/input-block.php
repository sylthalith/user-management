<?php if (isset($name)): ?>
    <div class="input-block">
        <?php if (isset($label)): ?>
            <label for="<?= $name ?>"><?= $label ?></label>
        <?php endif ?>
        <input
            placeholder="<?= isset($placeholder) ? h($placeholder) : '' ?>"
            class="input-field <?= isset($errors[$name]) ? 'error' : ''?>"
            id="<?= h($name) ?>"
            type="<?= $type ?? 'text' ?>"
            name="<?= h($name) ?>"
            value="<?= isset($value) ? h($value) : '' ?>"
        >
        <?php if (isset($errors)): ?>
            <?php foreach(wrapArray($errors) as $error): ?>
                <div class="error-text"><?= h($error) ?></div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endif ?>