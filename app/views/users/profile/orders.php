<?php if (isset($orders)):
    foreach ($orders as $item):
        $item = (array) $item;
        $order_date = $item['order_date'];
        $total_amount = $item['total_amount'];
        $status = $item['status']; ?>
        <div class="card">
            <h4>Status:
                <?= $status ?>
            </h4>
            <h4>Date:
                <?= $order_date ?>
            </h4>
            <h3>Total:
                <?= $total_amount ?>$
            </h3>
        </div>
    <?php endforeach;
else: ?>
    <h2>You don't have any orders yet</h2>
<?php endif; ?>