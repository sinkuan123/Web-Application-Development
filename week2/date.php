<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Date</title>
</head>

<body>

    <form>
        <div class="row">
            <div class="col text-info">
                <label for="day">Day</label>
                <select class="form-select text-info" id="day" name="day">
                    <?php
                    for ($i = 1; $i <= 31; $i++) {
                        echo "<option value=\"$i\">$i</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col text-warning">
                <label for="month">Month</label>
                <select class="form-select text-warning" id="month" name="month">
                    <?php
                    for ($i = 1; $i <= 12; $i++) {
                        $monthName = date("F", mktime(0, 0, 0, $i, 1));
                        echo "<option value=\"$i\">$i</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col text-danger">
                <label for="year">Year</label>
                <select class="form-select text-danger" id="year" name="year">
                    <?php
                    $currentYear = date("Y");
                    for ($i = 1900; $i <= $currentYear; $i++) {
                        echo "<option value=\"$i\">$i</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
    </form>
</body>

</html>