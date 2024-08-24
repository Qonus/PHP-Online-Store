<h2><?= $first_name ?> <?= $last_name ?></h2>
<div>
    <p>Joined: <?= $created_at ?></p>
    <p>Last seen: <?= $updated_at ?></p>
    <p>Email address: <?= $email ?></p>
    <?php if ($phone != ""): ?>
        <p>Phone: <?= $phone ?></p>
    <?php else: ?>
        <p>Phone: <span style="color: red;">absent</span></p>
    <?php endif; ?>
</div>