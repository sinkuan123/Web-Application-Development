<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div class="container">
        <?php include 'menu.php' ?>
        <div class="page-header">
            <h1>Update Customer</h1>
        </div>
        <?php
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        include 'config/database.php';

        try {
            $query = "SELECT customer_id, user_name, user_password, first_name, last_name, gender, date_of_birth, email, account_status FROM customers WHERE customer_id = ? LIMIT 0,1";
            $stmt = $con->prepare($query);

            $stmt->bindParam(1, $id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $user_name = $row['user_name'];
            $password = $row['user_password'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $gender = $row['gender'];
            $date_of_birth = $row['date_of_birth'];
            $email = $row['email'];
            $account_status = $row['account_status'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        if ($_POST) {
            try {
                $query = "UPDATE customers
                SET user_name=:user_name, user_password=:user_password, first_name=:first_name, last_name=:last_name, gender=:gender, date_of_birth=:date_of_birth, email=:email,
                account_status=:account_status WHERE customer_id = :id";
                // prepare query for excecution
                $stmt = $con->prepare($query);
                // posted values
                $user_name = htmlspecialchars(strip_tags($_POST['user_name']));
                $old_password = $_POST['old_password'];
                $new_password = $_POST['new_password'];
                $confirm_password = $_POST['confirm_password'];
                $first_name = htmlspecialchars(strip_tags($_POST['first_name']));
                $last_name = htmlspecialchars(strip_tags($_POST['last_name']));
                $gender = htmlspecialchars(strip_tags($_POST['gender']));
                $date_of_birth = htmlspecialchars(strip_tags($_POST['date_of_birth']));
                $email = htmlspecialchars(strip_tags($_POST['email']));
                $account_status = htmlspecialchars(strip_tags($_POST['account_status']));

                $error = array();
                if (!empty($_POST['old_password'])) {
                    if (password_verify($old_password, $row['user_password'])) {
                        if ($new_password == $old_password) {
                            $error[] = "New Password can not same with Old Password.";
                        } else if ($new_password == $confirm_password) {
                            $formatted_password = password_hash($new_password, PASSWORD_DEFAULT);
                        } else {
                            $error[] = "New Password does not match with confirm password.";
                        }
                    } else {
                        $error[] = "You Entered the wrong password for old password";
                    }
                } else {
                    $formatted_password = $password;
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error[] = "Invalid Email format.";
                }

                if (!empty($error)) {
                    echo "<div class='alert alert-danger m-3'>";
                    foreach ($error as $errorMessage) {
                        echo $errorMessage . "<br>";
                    }
                    echo "</div>";
                } else {
                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(':user_name', $user_name);
                    $stmt->bindParam(':user_password', $formatted_password);
                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':date_of_birth', $date_of_birth);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':account_status', $account_status);
                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was updated.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                    }
                }
            }
            // show errors
            catch (PDOException $exception) {
                echo "<div class='alert alert-danger'>ERROR: " . $exception->getMessage() . "</div>";
            }
        } ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>User Name</td>
                    <td><input type='text' name='user_name' value="<?php echo htmlspecialchars($user_name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>
                        <input type="password" name="old_password" class="form-control" placeholder="Old Password" value="<?php isset($_POST['old_password']) ? $_POST['old_password'] : '' ?>">
                        <input type="password" name="new_password" class="form-control" placeholder="New Password" value="<?php isset($_POST['new_password']) ? $_POST['new_password'] : '' ?>">
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" value="<?php isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '' ?>">
                    </td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='first_name' value="<?php echo htmlspecialchars($first_name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='last_name' value="<?php echo htmlspecialchars($last_name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>

                    <td><input type="radio" id="male" name="gender" value="Male" <?php if ($row['gender'] == "Male") {
                                                                                        echo 'checked';
                                                                                    } ?>>

                        <label for="male">Male</label><br>
                        <input type="radio" id="female" name="gender" value="Female" <?php if ($row['gender'] == "Female") {
                                                                                            echo 'checked';
                                                                                        } ?>>
                        <label for="female">Female</label><br>
                        <input type="radio" id="others" name="gender" value="Others" <?php $checked = $gender == "Others" ? "checked" : "" ?> $checked>
                        <label for="others">Others</label>
                    </td>
                </tr>
                <tr>
                    <td>Date Of Birth</td>
                    <td><input type='date' name='date_of_birth' value="<?php echo htmlspecialchars($date_of_birth, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type='email' name='email' value="<?php echo htmlspecialchars($email, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Account Status</td>
                    <td><input type='text' name='account_status' value="<?php echo htmlspecialchars($account_status, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='customer_read.php' class='btn btn-danger'>Back to read customers</a>
                    </td>
                </tr>
            </table>
        </form>

    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>