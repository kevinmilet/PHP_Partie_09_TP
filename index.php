<?php

// vérifie si les parametres sont présents, sinon on leur donne une valeur par défaut -> mois et année en cours
$month = empty($_GET['month']) ? date('n') : $_GET['month'];
$year = empty($_GET['year']) ? date('Y') : $_GET['year'];
$today = date('j');

// liste des mois en français
$monthList = array(
    '1' => 'Janvier',
    '2' => 'Février',
    '3' => 'Mars',
    '4' => 'Avril',
    '5' => 'Mai',
    '6' => 'Juin',
    '7' => 'Juillet',
    '8' => 'Août',
    '9' => 'Septembre',
    '10' => 'Octobre',
    '11' => 'Novembre',
    '12' => 'Décembre',
);

// nombre de jours dans le mois choisi
$nbDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// 1er jour du mois choisi
setlocale(LC_ALL, 'fr_FR', 'french', 'fra');
$firstDay = intval(strftime('%u', strtotime($year . '-' . $month . '-01')));

// dernier jour du mois choisi
$lastDay = intval(strftime('%u', strtotime($year . '-' . $month . '-' . $nbDays)));

// remplissage du tableau calendrier
$calendar = array();

for ($a = 1; $a <= $firstDay - 1; $a++) {
    array_push($calendar, null);
}
for ($b = 1; $b <= $nbDays; $b++) {
    array_push($calendar, $b);
}
for ($c = $lastDay - 1; $c < 6; $c++) {
    array_push($calendar, null);
}

// fonction pour déterminer si le jour est férié
function holiday_day($timestamp)
{
    $hDay = date('j', $timestamp);
    $hMonth = date('n', $timestamp);
    $hYear = date('Y', $timestamp);
    $holiday = [];

    // dates fériées fixes

    // 1er janvier - Jour de l'an
    $holiday['1-1'] = 'Jour de l\'an';

    // 1er mai - Fête du travail
    $holiday['1-5'] = 'Fête du travail';

    // 8 mai - Fête de la Victoire
    $holiday['8-5'] = 'Fête de la Victoire';

    // 14 juillet - fête nationale
    $holiday['14-7'] = 'Fête Nationale';

    // 15 aout - Assomption
    $holiday['15-8'] = 'Assomption';

    // 1 novembre - Toussaint
    $holiday['1-11'] = 'Toussaint';

    // 11 novembre - Armistice
    $holiday['11-11'] = 'Armistice';

    // 25 décembre - Noël
    $holiday['25-12'] = '<i class="fas fa-tree-christmas"></i> Noël';

    // fetes religieuses mobiles
    $easter = easter_date($hYear);
    $easterDay = date('j', $easter);
    $easterMonth = date('n', $easter);

    // Pâques
    $holiday[$easterDay . '-' . $easterMonth] = '<i class="fas fa-egg"></i> Pâques';

    // Lundi de Pâques
    $easterMonday = mktime(date('H', $easter), date('i', $easter), date('s', $easter), date('n', $easter), date('j', $easter) + 1, date('Y', $easter));
    $easterDay = date('j', $easterMonday);
    $easterMonth = date('n', $easterMonday);

    $holiday[$easterDay . '-' . $easterMonth] = 'Lundi de Pâques';

    //ascension
    $ascension = mktime(date('H', $easter), date('i', $easter), date('s', $easter), date('n', $easter), date('j', $easter) + 39, date('Y', $easter));
    $easterDay = date('j', $ascension);
    $easterMonth = date('n', $ascension);

    $holiday[$easterDay . '-' . $easterMonth] = 'Ascension';

    // Pentecôte
    $pentecote = mktime(date('H', $easter), date('i', $easter), date('s', $easter), date('n', $easter), date('j', $easter) + 49, date('Y', $easter));
    $easterDay = date('j', $pentecote);
    $easterMonth = date('n', $pentecote);

    $holiday[$easterDay . '-' . $easterMonth] = 'Pentecôte';

    // lundi Pentecôte
    $pentecoteMonday = mktime(date('H', $ascension), date('i', $easter), date('s', $easter), date('n', $easter), date('j', $easter) + 50, date('Y', $easter));
    $easterDay = date('j', $pentecoteMonday);
    $easterMonth = date('n', $pentecoteMonday);

    $holiday[$easterDay . '-' . $easterMonth] = 'Lundi de Pentecôte';

    return $holiday;

}

$birthday = array(
    '20-6' => 'Kevin',
    '21-8' => 'Florian M.',
    '24-4' => 'Timothy',
    '26-11' => 'Jérome',
    '29-4' => 'Lucas',
    '2-9' => 'Julien',
    '12-11' => 'Vincent',
    '4-7' => 'Florian L.',
    '12-3' => 'Laurent',
    '6-11' => 'Stéphane',
);

?>

<!-- partie html de la page -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Partie 9 - TP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/style.css" class="css">
</head>
<body>

    <div class="container">

        <!-- Formulaire permettant de choisir un mois et une année -->
        <div class="mt-2 formular">

            <p>Choisissez un mois et une année: </p>

            <form action="index.php" method="get" class="form-inline">

                <div class="form-group ml-2">
                    <label for="month">Mois</label>
                    <select name="month" id="month" class="form-control ml-2">

                        <?php
foreach ($monthList as $key => $value) {
    echo '<option value="' . $key . '">' . $value . '</option>';
}
?>

                    </select>
                </div>

                <div class="form-group ml-2">
                    <label for="year">Année</label>
                    <select name="year" id="year" class="form-control ml-2">

                        <?php
for ($i = (date('Y') - 1); $i <= (date('Y') + 9); $i++) {
    echo '<option value="' . $i . '">' . $i . '</option>';
}
?>

                    </select>
                </div>

                <div class="form-group ml-3">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>

            </form>

        </div>

        <!-- Calendrier -->
        <div class="container my-5">
            <div class="row month-title">
                <form action="" method="get">
                    <h4 class="month-year"><?=$monthList[$month];?> <?=$year;?> <a href="" type="submit" name="dec"><i class="fas fa-chevron-left"></i></a> <a href="" type="submit" name="inc"><i class="fas fa-chevron-right"></i></a></h4>
                </form>
                <!-- <h4 class="month-year"><?=$monthList[$month];?> <?=$year;?></h4> -->
            </div>

            <div class="row days">
                <div class="col">
                    <h5 class="text-center">Lundi</h5>
                </div>
                <div class="col">
                    <h5 class="text-center">Mardi</h5>
                </div>
                <div class="col">
                    <h5 class="text-center">Mercredi</h5>
                </div>
                <div class="col">
                    <h5 class="text-center">Jeudi</h5>
                </div>
                <div class="col">
                    <h5 class="text-center">Vendredi</h5>
                </div>
                <div class="col">
                    <h5 class="text-center">Samedi</h5>
                </div>
                <div class="col">
                    <h5 class="text-center">Dimanche</h5>
                </div>
            </div>

            <!-- Rendu du calendrier -->
            <?php
// on sépare le tableau contenant le mois en cours en plusieurs tableaux de 7 jours
$chunkCalendar = array_chunk($calendar, 7);

foreach ($chunkCalendar as $week => $days) {
    // ouverture de la ligne
    echo '<div class="row">';

    foreach ($chunkCalendar[$week] as $day) {

        $caseClass = '';

        // on récupère les valeurs du tableau des jours fériés
        $isHoliday = holiday_day(strtotime($today . '-' . $month . '-' . $year));

        // on rempli le calendrier
        if ($day == null) { // affichage des cases vides avant 1er jour et après dernier jour
            $caseClass = ' empty';
        } elseif ($day . '-' . $month . '-' . $year == date('j-n-Y')) { // mise en évidence jour actuel
            $caseClass = ' current';
        } elseif (isset($isHoliday[$day . '-' . $month])) { // affichage des jours fériés
            if (key($isHoliday) != $day . '-' . $month || key($isHoliday) == '1-1') {
                $caseClass = ' holiday';
            }
        } elseif (key($birthday) == $day . '-' . $month) { // affichage des anniversaires
            $caseClass = ' birthday';
        } else {
            $caseClass = ' normal';
        }
        if (isset($isHoliday[$day . '-' . $month])) {
            // affichage jour férié
            echo '<div class="col day-case' . $caseClass . '">' . $day . ' ' . $isHoliday[$day . '-' . $month] . '</div>';
        } elseif (isset($birthday[$day . '-' . $month])) {
            // affichage de l'anniversaire
            echo '<div class="col day-case' . $caseClass . '">' . $day . ' ' . '<i class="fas fa-birthday-cake"></i> ' . $birthday[$day . '-' . $month] . '</div>';
        } else {
            echo '<div class="col day-case' . $caseClass . '">' . $day . '</div>';
        }
    }
    // fermeture de la ligne
    echo '</div>';
}
?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>
</html>