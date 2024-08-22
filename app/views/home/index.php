<h1>Home Page</h1>
<hr>
<h2>Latest Products: </h2>
<?php foreach($products as $item) {
    $item = (array)$item;
    $product_link = "/product/{$item['product_id']}/";
    $product_name = $item['product_name'];
    $price = $item['price'];
    include "product-card.php";
}?>