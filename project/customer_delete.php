<?php
// include database connection
include 'config/database.php';
try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');


    $customer_exist_query = "SELECT customer_id FROM customers WHERE EXISTS (SELECT customer_id FROM order_summary WHERE order_summary.customer_id = customers.customer_id)";
    $customer_exist_stmt = $con->prepare($customer_exist_query);
    $customer_exist_stmt->execute();
    $customers = $customer_exist_stmt->fetchAll(PDO::FETCH_ASSOC);

    $image_query = "SELECT image FROM customers WHERE customer_id=?";
    $image_stmt = $con->prepare($image_query);
    $image_stmt->bindParam(1, $id);
    $image_stmt->execute();
    $image = $image_stmt->fetch(PDO::FETCH_ASSOC);

    // delete query
    $query = "DELETE FROM customers WHERE customer_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);
    for ($i = 0; $i < count($customers); $i++) {
        if ($id == $customers[$i]['customer_id'])
            $error = 1;
    }
    if (isset($error)) {
        header("Location: customer_read.php?action=failed");
    } else if ($stmt->execute()) {
        unlink("uploads/" . $image['image']);
        // redirect to read records page and
        // tell the user record was deleted
        header("Location: customer_read.php?action=deleted");
    } else {
        die('Unable to delete record.');
    }
}
// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
