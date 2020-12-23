<?php
session_start();
include 'functions.php';

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Partie 9 - TP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/style.css" class="css">
</head>

<body>

    <div class="container">

        <!-- Formulaire permettant de choisir un mois et une année -->
        <div class="main">

            <!-- <p>Choisissez un mois et une année: </p> -->

            <form action="index.php" method="get" class="form-inline mt-3">

                <div class="form-group ml-2">
                    <!-- <label for="month">Mois</label> -->
                    <select name="month" id="month" class="form-control">

                        <?php
                        
foreach ($monthList as $key => $value) {
    ?>
    <option value="<?=$key?>" <?=($month==$key) ? 'selected' : ''?>><?=$value?></option>;

<?php
}
?>

                    </select>
                </div>

                <div class="form-group ml-2">
                    <!-- <label for="year">Année</label> -->
                    <select name="year" id="year" class="form-control ml-2">

                        <?php
for ($i = $currentYear - $interval; $i <= $currentYear + $interval; $i++) {
    ?>
   <option value="<?=$i?>" <?= ($year==$i) ? 'selected' : '';?>><?=$i?></option>;

<?php
}
?>

                    </select>
                </div>

                <div class="form-group ml-3">
                    <button type="submit" class="btn btn-primary">Afficher</button>
                </div>

            </form>

        </div>

        <!-- Calendrier -->
        <div class="container my-4">
            <div class="row month-title">
                <!-- <form action="" method="get">
                    <h4 class="month-year"><?=$monthList[$month];?> <?=$year;?> <a href="index.php?newMonth=-1" type="submit" name="dec"><i class="fas fa-chevron-left"></i></a> <a href="index.php?newMonth=+1" type="submit" name="inc"><i class="fas fa-chevron-right"></i></a></h4>
                </form> -->
                <h1 class="month-year"><?=$monthList[$month];?> <?=$year;?></h4>
            </div>

            <div class="row days">
                <div class="col pt-1">
                    <h5 class="text-center">Lundi</h5>
                </div>
                <div class="col pt-1">
                    <h5 class="text-center">Mardi</h5>
                </div>
                <div class="col pt-1">
                    <h5 class="text-center">Mercredi</h5>
                </div>
                <div class="col pt-1">
                    <h5 class="text-center">Jeudi</h5>
                </div>
                <div class="col pt-1">
                    <h5 class="text-center">Vendredi</h5>
                </div>
                <div class="col pt-1">
                    <h5 class="text-center">Samedi</h5>
                </div>
                <div class="col pt-1">
                    <h5 class="text-center">Dimanche</h5>
                </div>
            </div>

            <!-- Rendu du calendrier -->
            <?php
            include 'calendar.php';
            ?>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
    </script>
</body>

</html>