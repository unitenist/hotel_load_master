<?php
include("config.inc.php"); //include config file
//sanitize post value
$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

//throw HTTP error if page number is not valid
if(!is_numeric($page_number)){
    header('HTTP/1.1 500 Invalid page number!');
    exit();
}

//get current starting point of records
$position = (($page_number-1) * $item_per_page);

//fetch records using page position and item per page. 
$results = $mysqli->prepare("SELECT DISTINCT hoteladi,kod FROM hotel ORDER BY kod DESC LIMIT ?, ?");

//bind parameters for markers, where (s = string, i = integer, d = double,  b = blob)
//for more info https://www.sanwebe.com/2013/03/basic-php-mysqli-usage
$results->bind_param("dd", $position, $item_per_page); 
$results->execute(); //Execute prepared Query
$results->bind_result($hoteladi, $kod); //bind variables to prepared statement

//output results from database
while($results->fetch()){ //fetch values
    echo '<li>'.$hoteladi.') <strong>'.$kod.'</strong></li>'; 
}