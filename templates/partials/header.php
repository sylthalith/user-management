<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? 'Document' ?></title>
    <meta name="csrf-token" content="<?= csrfToken() ?>">
    <link rel="stylesheet" href="<?= styles('main')[0] ?>">
    <?php if (isset($styles)): ?>
        <?php foreach (wrapArray($styles) as $style): ?>
            <link rel="stylesheet" href="<?= $style ?>">
        <?php endforeach ?>
    <?php endif ?>
</head>
<body>