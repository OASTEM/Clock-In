<?php
$start = new DateTime($_GET['start']);
$elapsed = $start->diff(new DateTime());

$hr = $elapsed->h;
$min = $elapsed->i;
$sec = $elapsed->s;

echo "$hr:$min:$sec";
?>