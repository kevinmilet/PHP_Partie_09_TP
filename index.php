<?php

    // vérifie si les parametres sont présents, sinon on leur donne une valeur par défaut -> mois et année en cours
    if (empty($_GET['month']) && empty($_GET['year'])) {
        $month = date('n');
        $year = date('Y');
    } else {
        $month = $_GET['month'];
        $year = $_GET['year'];
    }

    // liste des mois en français
    $monthList = array(
        '1'=>'Janvier',
        '2'=>'Février',
        '3'=>'Mars',
        '4'=>'Avril',
        '5'=>'Mai',
        '6'=>'Juin',
        '7'=>'Juillet',
        '8'=>'Août',
        '9'=>'Septembre',
        '10'=>'Octobre',
        '11'=>'Novembre',
        '12'=>'Décembre'
    );

    // nombre de jours dans le mois choisi
    $nbDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    // 1er jour du mois choisi
    setlocale(LC_ALL, 'fr_FR', 'french', 'fra');
    $firstDay = intval(strftime('%u', strtotime($year.'-'.$month.'-01')));

    // dernier jour du mois choisi
    $lastDay = intval(strftime('%u', strtotime($year.'-'.$month.'-'.$nbDays)));

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

    $caseClass = '';

    // fonction pour déterminer si le jour est férié
    function holiday_day($timestamp) {
        $hDay = date("d", $timestamp);
        $hMonth = date("m", $timestamp);
        $hYear = date("Y", $timestamp);
        $isHoliday = array (false, '');
        $holiday = '';

        // dates fériées fixes

        // 1er janvier - Jour de l'an
        if ($hDay == 1 && $hMonth == 1) {
            $isHoliday = array (true, 'Jour de l\'an'); 
        }

        // 1er mai - Fête du travail
        if ($hDay == 1 && $hMonth == 5) {
            $isHoliday = array (true, 'Fête du travail'); 
        }

        // 8 mai - Fête de la Victoire
        if ($hDay == 8 && $hMonth == 5) {
            $isHoliday = array (true, 'Fête de la Victoire'); 
        }

        // 14 juillet - fête nationale
        if ($hDay == 14 && $hMonth == 7) {
            $isHoliday = array (true, 'Fête Nationale'); 
        }

        // 15 aout - Assomption
        if ($hDay == 15 && $hMonth == 8) {
            $isHoliday = array (true, 'Assomption'); 
        }

        // 1 novembre - Toussaint
        if ($hDay == 1 && $hMonth == 11) {
            $isHoliday = array (true, 'Toussaint'); 
        }

        // 11 novembre - Armistice
        if ($hDay == 11 && $hMonth == 11){
            $isHoliday = array (true, 'Armistice'); 
        }

        // 25 décembre - Noël
        if ($hDay == 25 && $hMonth == 12){
            $isHoliday = array (true, 'Noël'); 
        } 

        // fetes religieuses mobiles
        $easter = easter_date($hYear);
        $easterDay = date("d", $easter);
        $easterMonth = date("m", $easter);

        // Pâques
        if ($easterDay == $hDay && $easterMonth == $hMonth){
            $isHoliday = array (true, 'Pâques');
        }

        // Lundi de Pâques
        $easterMonday = mktime(date("H", $easter), date("i", $easter), date("s", $easter), date("m", $easter), date("d", $easter) +1, date("Y", $easter) );
        $easterDay = date("d", $easterMonday);
        $easterMonth = date("m", $easterMonday);

        if ($easterDay == $hDay && $easterMonth == $hMonth){
            $isHoliday = array (true, 'Lundi de Pâques');
        }
        
        //ascension
        $ascension = mktime(date("H", $easter), date("i", $easter), date("s", $easter), date("m", $easter), date("d", $easter) + 39, date("Y", $easter) );
        $easterDay = date("d", $ascension);
        $easterMonth = date("m", $ascension);

        if ($easterDay == $hDay && $easterMonth == $hMonth){
            $isHoliday = array (true, 'Ascension');
        }

        // Pentecôte
        $pentecote = mktime(date("H", $easter), date("i", $easter), date("s", $easter), date("m", $easter), date("d", $easter) + 49, date("Y", $easter) );
        $easterDay = date("d", $pentecote);
        $easterMonth = date("m", $pentecote);

        if ($easterDay == $hDay && $easterMonth == $hMonth) {
            $isHoliday = array (true, 'Pentecôte');
        }

        // lundi Pentecôte
        $pentecoteMonday = mktime(date("H", $ascension), date("i", $easter), date("s", $easter), date("m", $easter), date("d", $easter) + 50, date("Y", $easter) );
        $easterDay = date("d", $pentecoteMonday);
        $easterMonth = date("m", $pentecoteMonday);

        if ($easterDay == $hDay && $easterMonth == $hMonth) {
            $isHoliday = array (true, 'Lundi de Pentecôte');
        }

        return $isHoliday;
        
}
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
                                echo '<option value="'.$key.'">'.$value.'</option>';
                            }
                        ?>
                    </select>
                </div>

                <div class="form-group ml-2">
                    <label for="year">Année</label>
                    <select name="year" id="year" class="form-control ml-2">
                        <?php
                            for ($i = (date('Y') - 5); $i <= (date('Y') + 10); $i++) {
                                echo '<option value="'.$i.'">'.$i.'</option>';
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
                <h4 class="month-year"><?=$monthList[$month];?> <?=$year;?> <a href=""><i class="fas fa-chevron-left"></i></a> <a href=""><i class="fas fa-chevron-right"></i></a></h4>
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
                
                foreach($chunkCalendar as $week => $days) {
                    // ouverture de la ligne
                    echo '<div class="row">';

                    foreach($chunkCalendar[$week] as $day){

                        // on récupère les valeurs du tableau des jours fériés
                        $holiday = holiday_day(strtotime($day.'-'.$month.'-'.$year));
                        
                        if ($day == null) {
                            $caseClass = ' empty';
                        } elseif ($day.'-'.$month.'-'.$year == date('j-m-Y')){
                            $caseClass = ' current';
                        } elseif ($holiday[0] === true) {
                            $caseClass = ' holiday';
                        } else {
                            $caseClass = '';
                        }
                        echo '<div class="col day-case'.$caseClass.'">'.$day.' '.$holiday[1].'</div>';
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