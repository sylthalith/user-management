<?php if (isset($scripts)): ?>
    <?php foreach (wrap_array($scripts) as $script): ?>
        <script src="<?= $script ?>"></script>
    <?php endforeach ?>
<?php endif ?>
</body>
</html>