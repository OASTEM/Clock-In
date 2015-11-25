<?php

//Authentication levels; Only one at a time may be used
$USER = 1; //member logged in to stats/control page
$ADMIN = 2; //admin logged in to stats/control page
$PANEL = 3; //panel unlocked for clockin

require_once "./config.php";
include "./include/header.php";


?>

<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script> 