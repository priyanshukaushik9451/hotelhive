<?php
require(__DIR__ . '/admin/db_confg.php'); // ✅ Correct path

date_default_timezone_set("Asia/Kolkata");

$today = date("Y-m-d");

$query = "UPDATE bookings SET status = 0 WHERE DATE(checkout) = ?";
update($query, [$today], 's');

echo "Script ran successfully at " . date("Y-m-d H:i:s") . "\n";
?>
