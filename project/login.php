<?php
session_start();
if (isset($_SESSION['customer_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        body {
            background-image: url(img/login_bg.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
        }

        @media (max-width:550px) {
            .col {
                width: 100% !important;
            }
        }
    </style>
</head>

<body>
    <!-- container -->
    <div class="container pb-5">
        <?php

        $action = isset($_GET['action']) ? $_GET['action'] : "";
        if ($action == "warning") {
            $error = "Please login to your account first";
        }

        if ($_POST) {
            // include database connection
            include 'config/database.php';

            $user_input = $_POST['user_input'];
            $password_input = $_POST['password_input'];

            if (empty($user_input)) {
                $user_input_err = "Please enter the Username/Email field.";
            }
            if (empty($password_input)) {
                $password_input_err = "Please enter the Password field";
            } else {
                try {
                    $query = "SELECT * FROM customers WHERE user_name=:user_input OR email=:user_input";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':user_input', $user_input);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($row) {
                        if (password_verify($password_input, $row['user_password'])) {
                            if ($row['account_status'] == 'Active') {
                                $_SESSION['customer_id'] = $row['customer_id'];
                                header("Location: index.php");
                                exit();
                            } else {
                                $error = "Inactive account.";
                            }
                        } else {
                            $error = "Incorrect password.";
                        }
                    } else {
                        $error = "Username/Email Not Found.";
                    }
                } catch (PDOException $exception) {
                    $error = $exception->getMessage();
                }
            }
        }
        ?>
        <div class="position-absolute top-50 start-50 translate-middle row justify-content-center align-items-center w-75">
            <div class="col">
                <h1 class="text-primary"><strong>SK Stationery</strong></h1>
                <h7 class="fs-5">SK Stationery E-Commerce Website</h7>
            </div>
            <div class="col w-100 border border-3 bg-opacity-0 p-4 shadow">
                <form action="" method="post">
                    <div class="my-3">
                        <label for="user_input">Username/Email</label>
                        <input type="text" name="user_input" id="user_input" class="form-control" value="<?php echo isset($_POST['user_input']) ? ($_POST['user_input']) : ''; ?>">
                        <span class="text-danger"> <?php echo isset($user_input_err) ? $user_input_err : '';  ?></span>
                    </div>
                    <div class="my-3">
                        <label for="password_input">Password</label>
                        <input type="password" name="password_input" id="password_input" class="form-control">
                        <span class="text-danger"><?php echo isset($password_input_err) ? $password_input_err : ''; ?></span>
                    </div>
                    <div class="text-center">
                        <button class='btn btn-primary m-r-1em fs-5 px-5' name="submit" type="submit">Login</button>
                    </div>
                    <div class="text-center"><span class="text-danger"><?php echo isset($error) ? $error : ''; ?></span></div>
                </form>
            </div>
        </div>

    </div> <!-- end .container -->

    <!-- confirm delete record will be here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>