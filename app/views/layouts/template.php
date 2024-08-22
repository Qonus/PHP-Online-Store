<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
    <link rel="stylesheet" href="/css/global.css">
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
