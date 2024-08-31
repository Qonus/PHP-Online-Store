<div class="productspage">
    <div class="productspage-wrapper">
        <?php
        if ($products) {
            foreach ($products as $item) {
                $item = (array) $item;
                $product_link = "/product/{$item['product_id']}/";
                $product_name = $item['product_name'];
                $price = $item['price'];
                include "product-card.php";
            }
        } else {
            echo "<div class='card'><h3>Products in not found.</h3></div>";
        }

        if (isset($back_link)) {
            echo "<a href='$back_link' class='card'><h3>Back</h3></a>";
        }
        ?>
    </div>
</div>