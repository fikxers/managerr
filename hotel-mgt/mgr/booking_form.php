<?php
// Database conection
require('../db.php');

// Fetch bookings from database
$sql = "SELECT id, start_date, end_date, booking_title FROM bookings";
$result = $con->query($sql);

// Create calendar
$month = isset($_GET['month']) ? $_GET['month'] : date('n');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

$timestamp = mktime(0, 0, 0, $month, 1, $year);
$days_in_month = date('t', $timestamp);
$first_day = date('N', $timestamp);
$month_name = date('F', $timestamp);

echo "<h2>$month_name $year</h2>";

echo "<table border='1'>";
echo "<tr>";
echo "<th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th><th>Sun</th>";
echo "</tr>";

echo "<tr>";
$day_of_week=1;
for ($i = 1 - $first_day+1; $i <= $days_in_month; $i++) {
    if ($i > 0) {
        $date = "$year-$month-" . sprintf("%02d", $i);
        $day_of_week = date('N', strtotime($date));
        $cell_class = $day_of_week >= 6 ? 'weekend' : 'weekday';
        echo "<td class='$cell_class'>$i<br>";

        // Check if date is booked
        $is_booked = false;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($date >= $row['start_date'] && $date <= $row['end_date']) {
                    echo "<span class='booking'>$row[booking_title]</span><br>";
                    $is_booked = true;
                }
            }
        }

        // Display booking form
        if (!$is_booked) {
            echo "<a href='booking_form.php?date=$date'>Book</a>";
        }

        echo "</td>";
    } else {
        echo "<td></td>";
    }
    //Undefined variable $day_of_week
    if ($day_of_week == 7) {
    //if ($i == 7) {
        echo "</tr><tr>";
    }
}

echo "</tr>";
echo "</table>";

$con->close();
?>
