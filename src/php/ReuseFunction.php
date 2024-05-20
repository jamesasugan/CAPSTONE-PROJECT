<?php
function calculateDates($selectedDays, $startingDate, $endingDate) {
    $dates = [];

    if ($startingDate === $endingDate) {
        $dates[] = $startingDate;
        return $dates;
    }


    $currentDate = strtotime($startingDate);
    $endDate = strtotime($endingDate);

    while ($currentDate <= $endDate) {
        $dayOfWeek = date('N', $currentDate);
        if (in_array($dayOfWeek, $selectedDays)) {
            $dates[] = date('Y-m-d', $currentDate);
        }
        $currentDate = strtotime('+1 day', $currentDate);
    }

    return $dates;
}

function isValidDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
