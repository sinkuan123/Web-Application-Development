<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Malaysian IC Information</title>
</head>

<body>
    <div class="container">
        <h2>Enter Malaysian IC</h2>
        <form method="POST" action="">
            <div class="form-group my-2">
                <input class="form-control" type="text" name="ic" placeholder="Eg: xxxxxx-xx-xxxx" pattern="[0-9]{6}-[0-9]{2}-[0-9]{4}" required>
                <button class="btn btn-primary my-2" type="submit" name="submit">Submit</button>
            </div>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            $ic = $_POST['ic'];
            $month = array('JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'OGO', 'SEP', 'OCT', 'NOV', 'DEC');
            $icyear = substr($ic, 0, 2);
            $icmonth = substr($ic, 2, 2);
            $icdate = substr($ic, 4, 2);
            $icplace = substr($ic, 7, 2);
            $icpattern = "/^[0-9]{6}-[0-9]{2}-[0-9]{4}$/";
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $Czodiac = array("Monkey", "Rooster", "Dog", "Pig", "Rat", "Ox", "Tiger", "Rabbit", "Dragon", "Snake", "Horse", "Goat");
            if (preg_match($icpattern, $ic)) {
                if ($icyear > (date('Y') - 2000)) {
                    $year = $icyear + 1900;
                } else {
                    $year = $icyear + 2000;
                }
                if (checkdate($icmonth, $icdate, $year)) {
                    $date = $icdate;
                    $imonth = $icmonth - 1;


                    $i = $year % 12;
                    if ($imonth == 0) {
                        if ($date <= 18) {
                            $zodiac = "Sagittarius";
                            $zodiac_img = "img/sagittarius.png";
                        } else {
                            $zodiac = "Capricornus";
                            $zodiac_img = "img/capricornus.png";
                        }
                    } else if ($imonth == 1) {
                        if ($date <= 15) {
                            $zodiac = "Capricornus";
                            $zodiac_img = "img/capricornus.png";
                        } else {
                            $zodiac = "Aquarius";
                            $zodiac_img = "img/aquarius.png";
                        }
                    } else if ($imonth == 2) {
                        if ($date <= 11) {
                            $zodiac = "Aquarius";
                            $zodiac_img = "img/aquarius.png";
                        } else {
                            $zodiac = "Pisces";
                            $zodiac_img = "img/pisces.png";
                        }
                    } else if ($imonth == 3) {
                        if ($date <= 18) {
                            $zodiac = "Pisces";
                            $zodiac_img = "img/pisces.png";
                        } else {
                            $zodiac = "Aries";
                            $zodiac_img = "img/aries.png";
                        }
                    } else if ($imonth == 4) {
                        if ($date <= 13) {
                            $zodiac = "Aries";
                            $zodiac_img = "img/aries.png";
                        } else {
                            $zodiac = "Taurus";
                            $zodiac_img = "img/taurus.png";
                        }
                    } else if ($imonth == 5) {
                        if ($date <= 19) {
                            $zodiac = "Taurus";
                            $zodiac_img = "img/taurus.png";
                        } else {
                            $zodiac = "Gemini";
                            $zodiac_img = "img/gemini.png";
                        }
                    } else if ($imonth == 6) {
                        if ($date <= 20) {
                            $zodiac = "Gemini";
                            $zodiac_img = "img/gemini.png";
                        } else {
                            $zodiac = "Cancer";
                            $zodiac_img = "img/cancer.png";
                        }
                    } else if ($imonth == 7) {
                        if ($date <= 9) {
                            $zodiac = "Cancer";
                            $zodiac_img = "img/cancer.png";
                        } else {
                            $zodiac = "Leo";
                            $zodiac_img = "img/leo.png";
                        }
                    } else if ($imonth == 8) {
                        if ($date <= 15) {
                            $zodiac = "Leo";
                            $zodiac_img = "img/leo.png";
                        } else {
                            $zodiac = "Virgo";
                            $zodiac_img = "img/virgo.png";
                        }
                    } else if ($imonth == 9) {
                        if ($date <= 30) {
                            $zodiac = "Virgo";
                            $zodiac_img = "img/virgo.png";
                        } else {
                            $zodiac = "Libra";
                            $zodiac_img = "img/libra.png";
                        }
                    } else if ($imonth == 10) {
                        if ($date <= 22) {
                            $zodiac = "Libra";
                            $zodiac_img = "img/libra.png";
                        } else if ($date <= 29) {
                            $zodiac = "Scorpius";
                            $zodiac_img = "img/scorpius.png";
                        } else {
                            $zodiac = "Ophiuchus";
                            $zodiac_img = "img/ophiuchus.png";
                        }
                    } else if ($imonth == 11) {
                        if ($date <= 17) {
                            $zodiac = "Ophiuchus";
                            $zodiac_img = "img/ophiuchus.png";
                        } else {
                            $zodiac = "Sagittarius";
                            $zodiac_img = "img/sagittarius.png";
                        }
                    }
                    if ($icplace == 1 || $icplace == 21 || $icplace == 22 || $icplace == 23 || $icplace == 24) {
                        $place = "Johor";
                        $place_img = "img/johor.jpg";
                    } else if ($icplace == 2 || $icplace == 25 || $icplace == 26 || $icplace == 27) {
                        $place = "Kedah";
                        $place_img = "img/kedah.jpg";
                    } else if ($icplace == 3 || $icplace == 28 || $icplace == 29) {
                        $place = "Kelantan";
                        $place_img = "img/kelantan.jpg";
                    } else if ($icplace == 4 || $icplace == 30) {
                        $place = "MAlacca";
                        $place_img = "img/malacca.jpg";
                    } else if ($icplace == 5 || $icplace == 31 || $icplace == 59) {
                        $place = "Negeri Sembilan";
                        $place_img = "img/sembilan.jpg";
                    } else if ($icplace == 6 || $icplace == 32 || $icplace == 33) {
                        $place = "Pahang";
                        $place_img = "img/pahang.jpg";
                    } else if ($icplace == 7 || $icplace == 34 || $icplace == 35) {
                        $place = "Penang";
                        $place_img = "img/penang.jpg";
                    } else if ($icplace == 8 || $icplace == 36 || $icplace == 37 || $icplace == 38 || $icplace == 39) {
                        $place = "Perak";
                        $place_img = "img/perak.jpg";
                    } else if ($icplace == 9 || $icplace == 40) {
                        $place = "Perlis";
                        $place_img = "img/perlis.jpg";
                    } else if ($icplace == 10 || $icplace == 41 || $icplace == 42 || $icplace == 43 || $icplace == 44) {
                        $place = "Selangor";
                        $place_img = "img/selangor.jpg";
                    } else if ($icplace == 11 || $icplace == 45 || $icplace == 46) {
                        $place = "Terengganu";
                        $place_img = "img/terengganu.jpg";
                    } else if ($icplace == 12 || $icplace == 47 || $icplace == 48 || $icplace == 49) {
                        $place = "Sabah";
                        $place_img = "img/sabah.jpg";
                    } else if ($icplace == 13 || $icplace == 50 || $icplace == 51 || $icplace == 52 || $icplace == 53) {
                        $place = "Sarawak";
                        $place_img = "img/sarawak.jpg";
                    } else if ($icplace == 14 || $icplace == 54 || $icplace == 55 || $icplace == 56 || $icplace == 57) {
                        $place = "Federal Territory of Kuala Lumpur";
                        $place_img = "img/kl.jpg";
                    } else if ($icplace == 15 || $icplace == 58) {
                        $place = "Federal Territory of Labuan";
                        $place_img = "img/labuan.jpg";
                    } else if ($icplace == 16) {
                        $place = "Federal Territory of Putrajaya";
                        $place_img = "img/putrajaya.jpg";
                    } else {
                        $place = "Not Found";
                    }

                    if ($Czodiac[$i] == "Monkey") {
                        $Czodiac_img = "img/monkey.png";
                    } else if ($Czodiac[$i] == "Rooster") {
                        $Czodiac_img = "img/rooster.png";
                    } else if ($Czodiac[$i] == "Dog") {
                        $Czodiac_img = "img/dog.png";
                    } else if ($Czodiac[$i] == "Pig") {
                        $Czodiac_img = "img/pig.png";
                    } else if ($Czodiac[$i] == "Rat") {
                        $Czodiac_img = "img/rat.png";
                    } else if ($Czodiac[$i] == "Ox") {
                        $Czodiac_img = "img/ox.png";
                    } else if ($Czodiac[$i] == "Tiger") {
                        $Czodiac_img = "img/tiger.png";
                    } else if ($Czodiac[$i] == "Rabbit") {
                        $Czodiac_img = "img/rabbit.png";
                    } else if ($Czodiac[$i] == "Dragon") {
                        $Czodiac_img = "img/dragon.png";
                    } else if ($Czodiac[$i] == "Snake") {
                        $Czodiac_img = "img/snake.png";
                    } else if ($Czodiac[$i] == "Horse") {
                        $Czodiac_img = "img/horse.png";
                    } else if ($Czodiac[$i] == "Goat") {
                        $Czodiac_img = "img/goat.png";
                    }
                    echo "<div class='alert alert-info role=alert'> Birth Date: " . $month[$imonth] . " " . $date . ", " . $year . "<br>";
                    echo "Chinese Zodiac: " . $Czodiac[$i] . ' <img width="50px" src="' . $Czodiac_img . '">' . "<br>";
                    echo "Star Zodiac: " . $zodiac . ' <img width="50px" src="' . $zodiac_img . '">'  . "<br>";
                    echo "Place of Birth: " . $place . ' <img width="50px" src="' . $place_img . '">'  . "</div>";
                } else {
                    echo "<div class = 'alert alert-danger role=alert'> Invalid IC Number!</div>";
                }
            }
        }
        ?>
    </div>
</body>

</html>