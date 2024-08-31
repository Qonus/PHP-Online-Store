<div class="categoriespage">
    <div class="categoriespage-wrapper">
        <?php

        function generate_tree_of_categories($categories, int $parent)
        {
            echo "<ul class='categories'>";
            foreach ($categories as $category) {
                $category = (array) $category;
                if ($category["parent_category_id"] == $parent || ($category["parent_category_id"] == null && $parent == -1)) {
                    echo "<li class='card'><a style='color: black;' href='/category/{$category['category_id']}/'>";
                    echo "<h3>{$category["category_name"]}</h3>";
                    generate_tree_of_categories($categories, $category["category_id"]);
                    echo "</a></li>";
                }
            }
            echo "</ul>";
        }

        $parent = -1;
        generate_tree_of_categories($categories, $parent);

        ?>
    </div>
</div>