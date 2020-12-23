<?php

// variables
$today = date('j');
$currentYear = date('Y');
$currentMonth = date('n');
$currentDate = date('j-n-Y');
$interval = 10;
$calendar = array();

// vérifie si les parametres sont présents, sinon on leur donne une valeur par défaut -> mois et année en cours
$month = empty($_GET['month']) ? $currentMonth : $_GET['month'];
$year = empty($_GET['year']) ? $currentYear : $_GET['year'];

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
// setlocale(LC_ALL, 'fr_FR', 'french', 'fra');
// $firstDay = intval(strftime('%u', strtotime($year . '-' . $month . '-01')));
$firstDay = date('N', strtotime($year . '-' . $month . '-01'));

// dernier jour du mois choisi
// $lastDay = intval(strftime('%u', strtotime($year . '-' . $month . '-' . $nbDays)));
$lastDay = date('N', strtotime($year . '-' . $month . '-' . $nbDays));

// ********** remplissage du tableau calendrier **********

    // génére le nombre de jours avant le premier jour du mois
    for ($i = 1; $i < $firstDay; $i++) {
        array_push($calendar, null);
    }

    // génére le nombre de jours du mois
    for ($i = 1; $i <= $nbDays; $i++) {
        array_push($calendar, $i);
    }

    // génére le nombre de jours après le dernier jour du mois
    for ($i = $lastDay; $i < 7; $i++) {
        array_push($calendar, null);
    }
// *******************************************************

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

// gestion des évenements dans l'année

// tableau des anniversaires
$birthday = array(
    '20-6' => '<i class="fas fa-birthday-cake"></i> Kevin',
    '21-8' => '<i class="fas fa-birthday-cake"></i> Florian M.',
    '24-4' => '<i class="fas fa-birthday-cake"></i> Timothy',
    '26-11' => '<i class="fas fa-birthday-cake"></i> Jérome',
    '29-4' => '<i class="fas fa-birthday-cake"></i> Lucas',
    '2-9' => '<i class="fas fa-birthday-cake"></i> Julien',
    '12-11' => '<i class="fas fa-birthday-cake"></i> Vincent',
    '4-7' => '<i class="fas fa-birthday-cake"></i> Florian L.',
    '12-3' => '<i class="fas fa-birthday-cake"></i> Laurent',
    '6-11' => '<i class="fas fa-birthday-cake"></i> Stéphane',
    '29-2' => 'Toto'
);

// $tasks = array(
//     '1-1' => '<i class="far fa-laugh-beam"></i> Bonne Année!!!'
// );

// tableau des fériés générés gràce à la fonction dédiée
$isHoliday = holiday_day(strtotime($today . '-' . $month . '-' . $year));

// fonction de remplissage du tableau des évenements
function createObjEventType($array, $color, $label)
{

    $events = [];

    foreach ($array as $key => $value) {
        $objEventsList = new stdClass;
        $objEventsList->date = $key;
        $objEventsList->description = $value;
        array_push($events, $objEventsList);
    }

    $objEventType = new stdClass();
    $objEventType->events = $events;
    $objEventType->color = $color;
    $objEventType->label = $label;

    return $objEventType;
}

$eventsCalendar = [];

array_push($eventsCalendar, createObjEventType($birthday, '#ffcc80', 'Anniversaires'));

array_push($eventsCalendar, createObjEventType($isHoliday, '#ef9a9a', 'Fériés'));

// array_push($eventsCalendar, createObjEventType($tasks, '#ef9a9a', 'Tâches'));