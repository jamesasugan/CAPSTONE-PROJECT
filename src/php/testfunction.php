<?php
function getCurrentWeekDates() {
    // Get the current timestamp
    $currentTimestamp = time();

    // Get the day of the week for the current date (0 for Sunday through 6 for Saturday)
    $currentDayOfWeek = date('w', $currentTimestamp);

    // Calculate the timestamp of the first day of the current week (Sunday)
    $startOfWeekTimestamp = strtotime('last Sunday', $currentTimestamp);

    // Initialize an empty array to store the dates of the current week
    $weekDates = array();

    // Iterate over the days of the week and generate dates
    for ($i = 0; $i < 7; $i++) {
        // Calculate the timestamp for the current day
        $currentDayTimestamp = strtotime("+$i days", $startOfWeekTimestamp);


        $currentDayDate = date('Y-m-d', $currentDayTimestamp);

        // Add the date to the array
        $weekDates[] = $currentDayDate;
    }

    return $weekDates;
}


$currentWeekDates = getCurrentWeekDates();
print_r($currentWeekDates);