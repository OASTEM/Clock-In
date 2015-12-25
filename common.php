<?php

//Authentication levels; Only one at a time may be used
$LOGOUT = 0; //no authentication
$USER = 1; //member logged in to stats/control page
$ADMIN = 2; //admin logged in to stats/control page
$PANEL = 3; //panel unlocked for clockin

$rt = "/home/bnguyen/Git/Clock-in/";

require_once $rt . "config.php";

?>