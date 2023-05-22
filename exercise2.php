<!DOCTYPE html>
<html>

<head>
    <title>Exercise 2</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <style>
        .bigger {
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row row-cols-2">
            <?php
            $num1 = rand(1, 100);
            $num2 = rand(1, 100);

            if ($num1 > $num2) {
                echo '<p class="fs-1 fw-bold";>' . "The first number is " . " $num1" . '</p>';
                echo '<p>' . "The second number is " . $num2 . '</p>';
            } else if ($num2 > $num1) {
                echo '<p>' . "The first number is "  . $num1 . '</p>';
                echo '<p class="fs-1 fw-bold";>' . "The second number is " . "$num2" . '</p>';
            } else {
                echo "<p>" . "$num1" . "</p><br>";
                echo "<p>" . $num2 . "</p><br>";
                echo "Both numbers are the same.";
            }
            ?>
        </div>
    </div>
    </div>
</body>

</html>