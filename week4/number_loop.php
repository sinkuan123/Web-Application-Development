<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Looping Function</title>
</head>

<body>
    <div class="container">
        <h1 class="my-3">Number Loop</h1>
        <form method="POST" action="">
            <div class="form-group my-2">
                <input type="text" class="form-control" id="number" name="number" placeholder="Number">
            </div>
            <button type="submit" class="btn btn-primary my-2" name="submit">Submit</button>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $number = $_POST['number'];
            $sum = 0;

            if (empty($number) || !is_numeric($number)) {
                echo '<div class = "alert alert-danger role="alert">' . "Please fill in a number." . '</div>';
            } else if ($number <= 1) {
                echo '<div class = "alert alert-danger role="alert">' . "Please fill in a positive number that larger than 1." . '</div>';
            } else {
                for ($i = $number; $i >= 1; $i--) {
                    $sum += $i;
                }
                $result = implode(' + ', range(1, $number)) . ' = ' . $sum;
                echo '<div class = "alert alert-info role=alert">' . $result . '</div>';
            }
        }
        ?>
    </div>
</body>

</html>