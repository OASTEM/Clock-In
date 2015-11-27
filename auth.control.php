<?php
$level = $LOGOUT;
session_start();
if($_SESSION['auth_level'] == $PANEL){
    session_unset();
    session_destroy();
}else if(time() - $_SESSION['start_time'] > 10){
    session_unset();
    session_destroy();
}else{
    $level = $_SESSION['auth_level'];
}
?>