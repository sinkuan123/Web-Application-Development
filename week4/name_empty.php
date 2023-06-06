<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Empty Function</title>
</head>

<body>
    <div class="container">
        <h1 class="my-3">Enter your name</h1>
        <form method="POST" action="">
            <div class="form-group my-2">
                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name">
            </div>
            <div class="form-group my-2">
                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name">
            </div>
            <button type="submit" class="btn btn-primary my-2" name="submit">Submit</button>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];

            if (empty($firstName) || empty($lastName)) {
                echo '<div class = "alert alert-danger role="alert">' . "Please enter your name." . '</div>';
            } else {
                // ucwords -> capital letter for first letter  strtolower ->lower case for other letters
                $formattedFirstName = ucwords(strtolower($firstName));
                $formattedLastName = ucwords(strtolower($lastName));
                echo '<div class = "alert alert-info role="alert">' . "Name: " . $formattedLastName . " " . $formattedFirstName . '</div>';
            }
        }
        ?>
    </div>
</body>

</html>