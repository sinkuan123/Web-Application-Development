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
    $order_query = "SELECT order_id, product_id
    FROM order_detail;
    ";
    $order_stmt = $con->prepare($order_query);
    $order_stmt->execute();
    $orders = $order_stmt->fetch(PDO::FETCH_ASSOC);
    extract($orders);
    while ($nunm > 0) {
        echo $order_id;
        echo $product_id;
        var_dump($orders);
    }
    ?>
</body>

</html>