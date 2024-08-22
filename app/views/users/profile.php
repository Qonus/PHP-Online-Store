<div class="card">
    <h3><?= $first_name?> <?= $last_name?></h3>
    <div class="info">
        <p>Email address: <?=$email?></p>
        <?php if (isset($phone)): ?>
            <p>Phone: <?=$phone?></p>
        <?php else: ?>
            <p>Phone: <span style="color: red;">absent</span></p>
        <?php endif; ?>
    </div>
</div>