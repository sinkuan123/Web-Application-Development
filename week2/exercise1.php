<!DOCTYPE html>
<html lang="en">

<head>
    <title>Exercise 1</title>
    <style>
        .num1 {
            color: green;
            font-style: italic;
        }

        .num2 {
            color: blue;
            font-style: italic;
        }

        .sum {
            color: red;
            font-weight: bold;
        }

        .multiple {
            font-style: italic;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php
    $num1 = rand(100, 200);
    $num2 = rand(100, 200);
    $sum = $num1 + $num2;
    $multiple = $num1 * $num2;
    echo "<p class=num1>The first random number is " . "$num1." . "</p><br>";
    echo "<p class=num2>The second random number is " . "$num2." . "</p><br>";
    echo "<p class=sum>The sum of two numbers is " . "$sum." . "</p><br>";
    echo "<p class=multiple>The multiple of two numbers is " . "$multiple." . "</p><br>";
    ?>
</body>

</html>