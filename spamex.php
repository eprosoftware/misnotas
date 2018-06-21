<?php
// Antispam example using a random string
session_start();

require_once getcwd()."/jpgraph/src/jpgraph_antispam.php";


// Create new anti-spam challenge creator
// Note: Neither '0' (digit) or 'O' (letter) can be used to avoid confusion
$spam = new AntiSpam();

// Create a random 5 char challenge and return the string generated
$chars = $spam->Rand(4);
$_SESSION['rand_code'] = $chars;

// Stroke random cahllenge
if( $spam->Stroke() === false ) {
    die('Illegal or no data to plot');
}

?>