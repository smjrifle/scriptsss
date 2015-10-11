<?php 
require('ical.php');
$start = $_POST['start'];
$end = $_POST['end'];
$title = $_POST['title'];
$description = $_POST['description'];
$venue = $_POST['venue'];
$event = new ICS($start,$end,$title,$description,$venue);
$event->show();?>