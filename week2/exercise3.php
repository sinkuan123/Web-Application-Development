<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Exercise 3</title>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col fs-4">
                <?php

                $sum = 0;

                for ($num = 1; $num <= 100; $num++) {
                    if ($num % 2 == 1) {
                        echo $num . "<br>";
                    } else {
                        echo "<b>" . $num . "</b><br>";
                    }

                    $sum += $num;
                }
                echo "<p class=\"fw-bold fs-2\">" . "The total sum of the numbers = " . $sum;
                ?></div>
        </div>
    </div>
</body>

</html>