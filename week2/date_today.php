<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Date today</title>
</head>

<body>
    <!-- HTML form -->
    <form>
        <div class="row">
            <div class="col">
                <label for="day">Day</label>
                <select class="form-select" id="day" name="day">
                    <?php
                    // Generate options for day
                    for ($i = 1; $i <= 31; $i++) {
                        $selected = ($i == date('d')) ? 'selected' : '';
                        echo "<option value=\"$i\" $selected>$i</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <label for="month">Month</label>
                <select class="form-select" id="month" name="month">
                    <?php
                    // Generate options for month
                    for ($i = 1; $i <= 12; $i++) {
                        $monthName = date("F", mktime(0, 0, 0, $i, 1));
                        $selected = ($i == date('m')) ? 'selected' : '';
                        echo "<option value=\"$i\" $selected>$monthName</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <label for="year">Year</label>
                <select class="form-select" id="year" name="year">
                    <?php
                    // Generate options for year
                    $currentYear = date("Y");
                    for ($i = 1900; $i <= $currentYear; $i++) {
                        $selected = ($i == date('Y')) ? 'selected' : '';
                        echo "<option value=\"$i\" $selected>$i</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
    </form>

</body>

</html>