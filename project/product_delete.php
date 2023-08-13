<?php
// include database connection
include 'config/database.php';
try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');


    $product_exist_query = "SELECT id FROM products WHERE EXISTS (SELECT product_id FROM order_detail WHERE order_detail.product_id = products.id)";
    $product_exist_stmt = $con->prepare($product_exist_query);
    $product_exist_stmt->execute();
    $products = $product_exist_stmt->fetchAll(PDO::FETCH_ASSOC);

    // delete query
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);
    for ($i = 0; $i < count($products); $i++) {
        if ($id == $products[$i]['id'])
            $error = 1;
    }
    if (isset($error)) {
        header("Location: product_read.php?action=failed");
    } else if ($stmt->execute()) {
        // redirect to read records page and
        // tell the user record was deleted
        header("Location: product_read.php?action=deleted");
    } else {
        die('Unable to delete record.');
    }
}
// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
