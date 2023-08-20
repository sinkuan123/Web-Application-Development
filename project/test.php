<?php
// include database connection
include 'config/database.php';
try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');


    $image_query = "SELECT image FROM products WHERE id=?";
    $image_stmt = $con->prepare($image_query);
    $image_stmt->bindParam(1, $id);
    $image_stmt->execute();
    $images = $image_stmt->fetch(PDO::FETCH_ASSOC);
    $image = $images['image'];
    // delete query

    if (unlink("uploads/" . $image)) {
        echo "sohai";
    } else {
        echo "why";
    }
    // redirect to read records page and
    // // tell the user record was deleted
    // header("Location: product_read.php?action=deleted");
}

// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
