<?php foreach($orders as $item) {
    $item = (array)$item;
    $order_date = $item['order_date'];
    $total_amount = $item['total_amount'];
    $status = $item['status'];
    include "order-card.php";
}?>