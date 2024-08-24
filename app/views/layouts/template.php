<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
    <?php
    $dir = './css';
    $files = scandir($dir);
    foreach ($files as $file) : ?>
        <link rel="stylesheet" href="/css/<?= $file ?>">
    <?php endforeach; ?>
</head>
<body>
    <?php include __DIR__ . '/../elements/header.php'; ?>
    <main>
        <?=$content?>
    </main>
    <?php include __DIR__ . '/../elements/footer.php'; ?>
    <script src="/js/app.js"></script>
</body>
</html>
