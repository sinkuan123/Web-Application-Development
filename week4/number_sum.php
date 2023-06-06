<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Numeric Function</title>
</head>

<body>
    <div class="container">
        <h1 class="my-3">Number Sum Calculator</h1>
        <form method="POST" action="">
            <div class="form-group my-2">
                <input type="text" class="form-control" id="firstNumber" name="firstNumber" placeholder="First Number">
            </div>
            <div class="form-group my-2">
                <input type="text" class="form-control" id="secondNumber" name="secondNumber" placeholder="Second Number">
            </div>
            <button type="submit" class="btn btn-primary my-2" name="submit">Submit</button>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $firstNumber = $_POST['firstNumber'];
            $secondNumber = $_POST['secondNumber'];

            if (empty($firstNumber) || empty($secondNumber)) {
                echo '<div class = "alert alert-danger role="alert">' . "Please fill in a number." . '</div>';
            } else if (!is_numeric($firstNumber) || !is_numeric($secondNumber)) {
                echo '<div class = "alert alert-danger">' . "Please fill in a number." . '</div>';
            } else {
                echo '<div class = "alert alert-info role="alert">' . "The sum of two numbers is: " . $firstNumber + $secondNumber . '</div>';
            }
        }
        ?>
    </div>
</body>

</html>