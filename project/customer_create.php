<?php include "validatelogin.php"; ?>
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
        <?php
        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                $user_name = $_POST['user_name'];
                $user_password = $_POST['user_password'];
                $confirm_password = $_POST['confirm_password'];
                $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $gender = $_POST['gender'];
                $date_of_birth = $_POST['date_of_birth'];
                $email = $_POST['email'];
                $account_status = $_POST['account_status'];
                $image = !empty($_FILES["image"]["name"])
                    ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                    : "";
                $image = htmlspecialchars(strip_tags($image));
                $usernamePattern = "/^[A-Za-z][A-Za-z0-9_-]{5,}$/";
                $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/";

                $target_directory = "uploads/";
                $target_file = $target_directory . $image;
                $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

                $errorMessage = array();

                if ($image) {
                    //Check whether the size of image isn't square
                    $image_check = getimagesize($_FILES['image']['tmp_name']);
                    $image_width = $image_check[0];
                    $image_height = $image_check[1];
                    if ($image_width != $image_height) {
                        $errorMessage[] = "Only square size image allowed.";
                    }
                    // make sure submitted file is not too large, can't be larger than 1 MB
                    if ($_FILES['image']['size'] > (524288)) {
                        $errorMessage[] = "<div>Image must be less than 512 KB in size.</div>";
                    }
                    // make sure that file is a real image
                    if ($image_check == false) {
                        $errorMessage[] = "<div>Submitted file is not an image.</div>";
                    }
                    // make sure certain file types are allowed
                    $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                    if (!in_array($file_type, $allowed_file_types)) {
                        $errorMessage[] = "<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                    }
                }
                if (empty($user_name)) {
                    $errorMessage[] = "User Name field is empty.";
                } else if (!preg_match($usernamePattern, $user_name)) {
                    $errorMessage[] = "Username must be at least 6 characters long, start with a letter, and can only contain letters, digits, '_', or '-'.";
                }
                if (empty($user_password)) {
                    $errorMessage[] = "Password field is empty.";
                } else if (!preg_match($passwordPattern, $user_password)) {
                    $errorMessage[] = "Password must be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, and one number. No special symbols allowed.";
                }

                if (empty($confirm_password)) {
                    $errorMessage[] = "Confirm Password field is empty.";
                } else if ($user_password !== $confirm_password) {
                    $errorMessage[] = "Confirm Password must be same as Password";
                }
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
                if (empty($email)) {
                    $errorMessage[] = "Email field is empty.";
                } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errorMessage[] = "Invalid Email format.";
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
                    // insert query
                    $query = "INSERT INTO customers SET user_name=:user_name, user_password=:user_password, first_name=:first_name, last_name=:last_name, gender=:gender, date_of_birth=:date_of_birth,email=:email,  registration_date_time=:registration_date_time, account_status=:account_status, image=:image";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // Bind the parameters
                    $stmt->bindParam(':user_name', $user_name);
                    $stmt->bindParam(':user_password', $hashed_password);
                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':date_of_birth', $date_of_birth);
                    $stmt->bindParam(":email", $email);
                    date_default_timezone_set('Asia/Kuala_Lumpur');
                    $registration_date_time = date('Y-m-d H:i:s');
                    $stmt->bindParam(':registration_date_time', $registration_date_time);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':account_status', $account_status);
                    $stmt->bindParam(':image', $target_file);


                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success m-3'>Record was saved.</div>";
                        if ($image) {
                            // make sure the 'uploads' folder exists
                            // if not, create it
                            if (!is_dir($target_directory)) {
                                mkdir($target_directory, 0777, true);
                            }
                            // if $file_upload_error_messages is still empty
                            if (empty($file_upload_error_messages)) {
                                // it means there are no errors, so try to upload the file
                                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                    // it means photo was uploaded
                                } else {
                                    echo "<div class='alert alert-danger'>";
                                    echo "<div>Unable to upload photo.</div>";
                                    echo "<div>Update the record to upload photo.</div>";
                                    echo "</div>";
                                }
                            }

                            // if $file_upload_error_messages is NOT empty
                            else {
                                // it means there are some errors, so show them to user
                                echo "<div class='alert alert-danger'>";
                                echo "<div>{$file_upload_error_messages}</div>";
                                echo "<div>Update the record to upload photo.</div>";
                                echo "</div>";
                            }
                        }
                        $_POST = array();
                    } else {
                        echo "<div class='alert alert-danger m-3'>Unable to save the record.</div>";
                    }
                }
            }
            // show error
            catch (PDOException $exception) {
                if ($exception->getCode() == 23000) {
                    echo '<div class="alert alert-danger role=alert">' . 'Username has been taken.' . '</div>';
                } else {
                    echo '<div class="alert alert-danger role=alert">' . $exception->getMessage() . '</div>';
                }
            }
        }
        ?>


        <div class="p-3">
            <!-- html form here where the product information will be entered -->
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>User Name</td>
                        <td><input type='text' name='user_name' id='user_name' class='form-control' pattern="[A-Za-z][A-Za-z0-9_-]{5,}" value="<?php echo isset($_POST['user_name']) ? $_POST['user_name'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input type="password" name='user_password' id='user_password' class='form-control' value="<?php echo isset($_POST['user_password']) ? $_POST['user_password'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Confirm Password</td>
                        <td><input type="password" name='confirm_password' id='confirm_password' class='form-control' value="<?php echo isset($_POST['user_password']) ? $_POST['user_password'] : ''; ?>" /></td>
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
                        <td>Email</td>
                        <td><input type='email' name='email' class='form-control' value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" /></td>
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
                        <td>Image</td>
                        <td><input type='file' name='image' class='form-control' accept="image/*" /></td>
                    </tr>
                    <tr>
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