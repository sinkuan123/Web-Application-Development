<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Date Format</title>

</head>

<body>
    <?php
    date_default_timezone_set('asia/Kuala_Lumpur');

    $month = date("M ");
    echo "<strong class='fs-1 text-uppercase' style='color:rgb(175,123,81)'> $month</strong>";
    $date = date("d, Y");
    echo "<strong class='fs-1'>$date</strong>";
    $day = date(" (D) ");
    echo "<span class='fs-1' style='color:rgb(7,55,99)'>$day</span><br>";
    $hour = date("H");
    echo "<span class='fs-1' style='color:rgb(91,15,0)'>$hour</span>";
    $min = date(":i");
    echo "<span class='fs-1' style='color:rgb(76,17,48)'>$min</span>";
    $sec = date(":s");
    echo "<span class='fs-1'>$sec</span>";
    ?>

</body>

</html>