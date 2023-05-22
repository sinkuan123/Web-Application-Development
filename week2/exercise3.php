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

                echo '<div class="container">';
                echo '<p>';
                for ($num = 1; $num <= 100; $num++) {
                    if ($num % 2 === 0) {
                        echo '<b>' . $num . '</b>';
                    } else {
                        echo $num;
                    }

                    if ($num !== 100) {
                        echo ' + ';
                    }

                    $sum += $num;
                }
                echo ' = ' . $sum;
                echo '</p>';
                echo '</div>';
                ?></div>
        </div>
    </div>
</body>

</html>