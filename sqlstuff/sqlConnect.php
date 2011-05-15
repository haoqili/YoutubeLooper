<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$my_pw = file_get_contents("../mima.txt");
$sqlconnect = mysql_connect('sql.mit.edu', 'haoqili', trim($my_pw))
              or die('Could not connect to MySQL: ' . mysql_error() . '<br />');
mysql_select_db("haoqili+youtubelooper") or die ("Can't select a database");

?>
