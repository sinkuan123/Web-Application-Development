<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Name Function</title>
</head>

<body>
    <div class="container">
        <h1>Enter Your Name</h1>
        <form method="POST" action="">
            <div class="form-group my-2">
                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name">
            </div>
            <div class="form-group my-2">
                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name">
            </div>
            <div class="form-group row row-col-3 my-2">
                <div class="col">
                    <label for="">Day</label>
                    <select class="form-select" name="day" id="day">
                        <?php
                        for ($i = 1; $i <= 31; $i++) {
                            echo "<option value=\"$i\">$i</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col">
                    <label for="">Month</label>
                    <select class="form-select col" name="month" id="month">
                        <?php
                        $month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                        for ($i = 0; $i < count($month); $i++) {
                            echo "<option value=\"" . ($i + 1) . "\">$month[$i]</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col">
                    <label for="">Year</label>
                    <select class="form-select col" id="year" name="year">
                        <?php
                        $currentYear = date("Y");
                        for ($i = 1990; $i <= $currentYear; $i++) {
                            echo "<option value=\"$i\">$i</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary my-2" name="submit">Submit</button>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $day = $_POST['day'];
            $months =  $_POST['month' - 1];
            $year = $_POST['year'];
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $currentYear = date('Y');
            $currentMonth = date('m');
            $currentDay = date('d');
            $age = $currentYear - $year;
            // haven't had birthday yet
            if ($month > $currentMonth || ($months == $currentMonth && $day > $currentDay)) {
                $age--;
            }
            if (empty($firstName) || empty($lastName)) {
                echo '<div class = "alert alert-danger role="alert">' . "Please enter your name." . '</div>';
            } else if (empty($day) || empty($months) || empty($year)) {
                echo '<div class = "alert alert-danger role="alert">' . "Please enter your date of birth." . '</div>';
            } else {
                // ucwords -> capital letter for first letter  strtolower ->lower case for other letters
                $formattedFirstName = ucwords(strtolower($firstName));
                $formattedLastName = ucwords(strtolower($lastName));

                echo '<div class = "alert alert-info role="alert">' . "Name: " . $formattedLastName . " " . $formattedFirstName . "<br>Birthday: " . $month[$months - 1] . " " .  $day . ", " . $year . "<br>Age: " . $age . '</div>';
            }
            $age = $currentYear - $year;
            // haven't had birthday yet
            if ($month > $currentMonth || ($months == $currentMonth && $day > $currentDay)) {
                $age--;
            }
            if ($age < 18) {
                echo '<div class = "alert alert-danger role="alert">' . "Please leave the website." . '</div>';
            } else {
                echo '<div class = "alert alert-info role=alert">' . "Welcome to the website." . '</div>';
            }
        }
        ?>
    </div>
</body>

</html>