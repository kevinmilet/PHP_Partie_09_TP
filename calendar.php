<?php
// on sépare le tableau contenant le mois en cours en plusieurs tableaux de 7 jours
$chunkCalendar = array_chunk($calendar, 7);

foreach ($chunkCalendar as $week => $days) {
    // ouverture de la ligne
    echo '<div class="row">';

    foreach ($chunkCalendar[$week] as $day) {

        $caseClass = '';
        $description = '';
        $color = '#fafafa';

        // on remplis le calendrier

        if ($day === null) {
            $caseClass = ' empty'; // cases vides
        } elseif ($day . '-' . $month . '-' . $year === date('j-n-Y')) { // mise en évidence jour actuel
            $caseClass = ' current';
        } else {
            $caseClass = ' normal';
        }

        foreach ($eventsCalendar as $eventType) {

            foreach ($eventType->events as $event) {
                $date = $event->date;

                if ($date === $day . '-' . $month) {
                    $description = $event->description;
                    $color = $eventType->color;
                }

            }
        }

        echo '<div class="col day-case' . $caseClass . '" style="background-color: ' . $color . '">' . $day . ' ' . $description . '</div>';

    }
    // fermeture de la ligne(row)
    echo '</div>';
}
