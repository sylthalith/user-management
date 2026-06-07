<?php if (isset($scripts)): ?>
    <?php foreach (wrapArray($scripts) as $script): ?>
        <script src="<?= $script ?>"></script>
    <?php endforeach ?>
<?php endif ?>
</body>
</html>