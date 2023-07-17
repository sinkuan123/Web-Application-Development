<!DOCTYPE HTML>
<html>

<head>
    <title>Contact Us</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div class="container p-0 bg-light">
        <?php
        include 'menu.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Contact Us</h1>
        </div>
        <?php
        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                // insert query
                $query = "INSERT INTO contact_us SET firstname=:firstname, lastname=:lastname, email=:email, phone_number=:phone_number, message=:message, expired_date=:expired_date, created=:created";
                // prepare query for execution
                $stmt = $con->prepare($query);
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $phone_number = $_POST['phone_number'];
                //$phone_pattern = "/^[0-9]{3}-[0-9]{7}$/";
                //$pattern_011 = "/^[0-9]{3}-[0-9]{8}$/";
                //$f3numbers = substr($phone_number, 0, 3);
                $message = $_POST['message'];

                $errorMessage = array();

                if (empty($firstname)) {
                    $errorMessage[] = "First Name field is empty.";
                }
                if (empty($lastname)) {
                    $errorMessage[] = "Last Name field is empty.";
                }
                if (empty($email)) {
                    $errorMessage[] = "Email field is empty.";
                } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errorMessage[] = "Please follow the Email format.";
                }
                if (empty($phone_number)) {
                    $errorMessage[] = "Phone Number field is empty.";
                } else if (!is_numeric($phone_number)) {
                    $errorMessage[] = "Phone Number must be numbers only.";
                }
                /*  if ($f3numbers == "011") {
                    if (!preg_match($pattern_011, $phone_number)) {
                        $errorMessage[] = "Please insert a valid Phone Numbers. E.g. 011-12345678";
                    }
                } else if (!preg_match($phone_pattern, $phone_number)) {
                    $errorMessage[] = "Please insert a valid Phone Numbers. E.g. 012-1234567";
                }*/

                if (empty($message)) {
                    $errorMessage[] = "message field is empty.";
                }

                if (!empty($errorMessage)) {
                    echo "<div class='alert alert-danger m-3'>";
                    foreach ($errorMessage as $displayErrorMessage) {
                        echo $displayErrorMessage . "<br>";
                    }
                    echo "</div>";
                } else {
                    // Bind the parameters
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':phone_number', $phone_number);
                    $stmt->bindParam(':message', $message);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success m-3'>Record was saved.</div>";
                        $_POST = array();
                    } else {
                        echo "<div class='alert alert-danger m-3'>Unable to save the record.</div>";
                    }
                }
            }
            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>
        <div class="p-3">
            <!-- html form here where the product information will be entered -->
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>First Name</td>
                        <td><input type='text' name='firstname' id='firstname' class='form-control' value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Last Name</td>
                        <td><input type="text" name='lastname' id='lastname' class='form-control' value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input type='email' name='email' id='email' class='form-control' value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td><input type="text" name='phone_number' id='phone_number' class='form-control' value="<?php echo isset($_POST['phone_number']) ? $_POST['phone_number'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Message</td>
                        <td><textarea name='message' class='form-control'><?php echo isset($_POST['message']) ? $_POST['message'] : ''; ?></textarea></td>
                    </tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                    </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <!-- end container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>