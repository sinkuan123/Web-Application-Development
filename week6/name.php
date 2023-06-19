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
            $day = $_POST['day'];
            $months =  $_POST['month'];
            $year = $_POST['year'];
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $currentYear = date('Y');
            $currentMonth = date('m');
            $currentDay = date('d');
            $age = $currentYear - $year;
            $zodiac = "";

            $Czodiac = array("Monkey", "Rooster", "Dog", "Pig", "Rat", "Ox", "Tiger", "Rabbit", "Dragon", "Snake", "Horse", "Goat");
            $i = $year % 12;
            echo "<div class='alert alert-info role=alert'>" . "Your Chinese Zodiac is " . $Czodiac[$i] . ". </div>";

            if ($months == 1) {
                if ($day <= 18) {
                    $zodiac = "Sagittarius";
                } else {
                    $zodiac = "Capricornus";
                }
            } else if ($months == 2) {
                if ($day <= 15) {
                    $zodiac = "Capricornus";
                } else {
                    $zodiac = "Aquarius";
                }
            } else if ($months == 3) {
                if ($day <= 11) {
                    $zodiac = "Aquarius";
                } else {
                    $zodiac = "Pisces";
                }
            } else if ($months == 4) {
                if ($day <= 18) {
                    $zodiac = "Pisces";
                } else {
                    $zodiac = "Aries";
                }
            } else if ($months == 5) {
                if ($day <= 13) {
                    $zodiac = "Aries";
                } else {
                    $zodiac = "Taurus";
                }
            } else if ($months == 6) {
                if ($day <= 19) {
                    $zodiac = "Taurus";
                } else {
                    $zodiac = "Gemini";
                }
            } else if ($months == 7) {
                if ($day <= 20) {
                    $zodiac = "Gemini";
                } else {
                    $zodiac = "Cancer";
                }
            } else if ($months == 8) {
                if ($day <= 9) {
                    $zodiac = "Cancer";
                } else {
                    $zodiac = "Leo";
                }
            } else if ($months == 9) {
                if ($day <= 15) {
                    $zodiac = "Leo";
                } else {
                    $zodiac = "Virgo";
                }
            } else if ($months == 10) {
                if ($day <= 30) {
                    $zodiac = "Virgo";
                } else {
                    $zodiac = "Libra";
                }
            } else if ($months == 11) {
                if ($day <= 22) {
                    $zodiac = "Libra";
                } else if ($day <= 29) {
                    $zodiac = "Scorpius";
                } else {
                    $zodiac = "Ophiuchus";
                }
            } else if ($months == 12) {
                if ($day <= 17) {
                    $zodiac = "Ophiuchus";
                } else {
                    $zodiac = "Sagittarius";
                }
            }
        }
        ?>
    </div>
</body>

</html>