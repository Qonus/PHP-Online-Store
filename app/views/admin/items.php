<form method="post">
    <input type="text" name="brand_id" placeholder="Brand" />
    <input type="text" name="category_id" placeholder="Category" />
    <input type="date" name="release_date" placeholder="Release Date" />
    <input type="text" name="product_name" placeholder="Name" />
    <input type="text" name="description" placeholder="Description" />
    <input type="text" name="age_range" placeholder="Age Range" />
    <input type="text" name="player_number" placeholder="Player Number" />
    <input type="text" name="dimensions" placeholder="Dimensions" />
    <input type="number" name="weight" placeholder="Weight" />
    <input type="number" name="price" placeholder="Price" />
    <input type="number" name="stock_quantity" placeholder="Stock Quantity" />
    <input type="submit" name="add_product" value="Add Product" />
</form>

<table>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Stock Quantity</th>
        <th>Actions</th>
    </tr>

    <?php
    foreach ($items as $item):
        $item = (array) $item; ?>
        <tr>
            <td>
                <?= $item["product_name"] ?>
            </td>
            <td>
                <?= $item["description"] ?>
            </td>
            <td>
                <?= $item["price"] ?>
            </td>
            <td>
                <?= $item["stock_quantity"] ?>
            </td>
            <td><a href="/admin/items/<?= $item["product_id"] ?>">Details</a></td>
        </tr>
    <?php endforeach; ?>
</table>