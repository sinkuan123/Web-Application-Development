<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    include 'config/database.php';
    $product_exist_query = "SELECT id FROM products WHERE EXISTS (SELECT product_id FROM order_detail WHERE order_detail.product_id = products.id)";
    $product_exist_stmt = $con->prepare($product_exist_query);
    $product_exist_stmt->execute();
    $products = $product_exist_stmt->fetchAll(PDO::FETCH_ASSOC);
    var_dump($products);

    for ($i = 0; $i < count($products); $i++) {
        echo $products[$i]['id'];
    }


    ?>
</body>

</html>