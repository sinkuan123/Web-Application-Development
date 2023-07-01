<!DOCTYPE HTML>
<html>

<head>
    <title>Create Customer</title>
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
            <h1>Create Customer</h1>
        </div>



        <div class="p-3">
            <!-- html form here where the product information will be entered -->
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>User Name</td>
                        <td><input type='text' name='user_name' id='user_name' class='form-control' value="<?php echo isset($_POST['user_name']) ? $_POST['user_name'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input type="user_password" name='user_password' id='user_password' class='form-control' value="<?php echo isset($_POST['user_password']) ? $_POST['user_password'] : ''; ?>" /></textarea></td>
                    </tr>
                    <tr>
                        <td>First Name</td>
                        <td><input type='text' name='first_name' id='first_name' class='form-control' value="<?php echo isset($_POST['first_name']) ? $_POST['first_name'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Last Name</td>
                        <td><input type='text' name='last_name' id='last_name' class='form-control' value="<?php echo isset($_POST['last_name']) ? $_POST['last_name'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td><input type="radio" id="male" name="gender" value="Male" checked>
                            <label for="male">Male</label><br>
                            <input type="radio" id="female" name="gender" value="Female">
                            <label for="female">Female</label><br>
                            <input type="radio" id="others" name="gender" value="Others">
                            <label for="others">Others</label>
                        </td>
                    </tr>
                    <tr>
                        <td>Date of Birth</td>
                        <td><input type='date' name='date_of_birth' class='form-control' value="<?php echo isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Registration Date and Time</td>
                        <td><input type="datetime-local" name='registration_date_time' class='form-control' value="<?php echo isset($_POST['registration_date_time']) ? $_POST['registration_date_time'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Account Status</td>
                        <td><input type="radio" id="active" name="account_status" value="Active" checked>
                            <label for="active">Active</label><br>
                            <input type="radio" id="inactive" name="account_status" value="Inactive">
                            <label for="inactive">Inactive</label><br>
                        </td>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Save' class='btn btn-primary' />
                        </td>
                    </tr>
                </table>
            </form>
        </div><?php
                if ($_POST) {
                    // include database connection
                    include 'config/database.php';
                    try {
                        // insert query
                        $query = "INSERT INTO customers SET user_name=:user_name, user_password=:user_password, first_name=:first_name, last_name=:last_name, gender=:gender, date_of_birth=:date_of_birth, registration_date_time=:registration_date_time, account_status=:account_status";
                        // prepare query for execution
                        $stmt = $con->prepare($query);
                        $user_name = $_POST['user_name'];
                        $user_password = $_POST['user_password'];
                        $first_name = $_POST['first_name'];
                        $last_name = $_POST['last_name'];
                        $gender = $_POST['gender'];
                        $date_of_birth = $_POST['date_of_birth'];
                        $registration_date_time = $_POST['registration_date_time'];
                        $account_status = $_POST['account_status'];
                        //$usernamePattern = "/^[A-Za-z][A-Za-z0-9_-]{5,}$/";
                        //$passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/";

                        $errorMessage = array();

                        if (empty($user_name)) {
                            $errorMessage[] = "User Name field is empty.";
                        } /*else if (!preg_match($usernamePattern, $user_name)) {
                            $errorMessage[] = "Please follow the User Name format.";
                        }*/
                        if (empty($user_password)) {
                            $errorMessage[] = "Password field is empty.";
                        } /*else if (preg_match($passwordPattern, $user_password)) {
                            $errorMessage[] = "Please follow the Password format.";
                        }*/
                        if (empty($first_name)) {
                            $errorMessage[] = "First Name field is empty.";
                        }
                        if (empty($last_name)) {
                            $errorMessage[] = "Last Name field is empty.";
                        }
                        if (empty($gender)) {
                            $errorMessage[] = "Gender field is empty.";
                        }
                        if (empty($date_of_birth)) {
                            $errorMessage[] = "Date of Birth field is empty.";
                        }
                        if (empty($registration_date_time)) {
                            $errorMessage[] = "Registration Date Time field is empty.";
                        }
                        if (empty($account_status)) {
                            $errorMessage[] = "Account Status field is empty.";
                        }


                        if (!empty($errorMessage)) {
                            echo "<div class='alert alert-danger m-3'>";
                            foreach ($errorMessage as $displayErrorMessage) {
                                echo $displayErrorMessage . "<br>";
                            }
                            echo "</div>";
                        } else {
                            // Bind the parameters
                            $stmt->bindParam(':user_name', $user_name);
                            $stmt->bindParam(':user_password', $user_password);
                            $stmt->bindParam(':first_name', $first_name);
                            $stmt->bindParam(':last_name', $last_name);
                            $stmt->bindParam(':gender', $gender);
                            $stmt->bindParam(':date_of_birth', $date_of_birth);
                            $stmt->bindParam(':registration_date_time', $registration_date_time);
                            $stmt->bindParam(':account_status', $account_status);

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
    </div>
    <!-- end container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>