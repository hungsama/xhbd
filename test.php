<?php
$ddate = "2012-10-18";
$date = new DateTime($ddate);
$week = $date->format("F");
echo "Weeknummer: $week";