<?php
//Date Parse
function parseDate($date)
 {
    $data = explode('-', $date);
    $month = $data[1];
    $year = $data[0];
    $day = $data[2];
    switch ($month) {
      case 1:
        $month = "January";
        break;
      case 2:
        $month = "Feburary";
        break;
      case 3:
        $month = "March";
        break;
      case 4:
        $month = "April";
        break;
      case 5:
        $month = "May";
        break;
      case 6:
        $month = "June";
        break;
      case 7:
        $month = "July";
        break;
      case 8:
        $month = "August";
        break;
      case 9:
        $month = "September";
        break;
      case 10:
        $month = "October";
        break;
      case 11:
        $month = "November";
        break;
      case 12:
        $month = "December";
        break;
      default:
        $month = "May'";
        break;
    }

    
    switch ($day) {
      case 1:
        $day = '1st';
        break;
      case 2:
        $day = '2nd';
        break;
      case 3:
        $day = '3rd';
        break;
      default:
        $day = $day.'th';
        break;
    }
    return $day;
 }
?>