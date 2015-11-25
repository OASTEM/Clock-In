<?php
$level = 0;
if(session_id()){
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
}else{
?>
<div id="control-login-container">
    <form id="control-login-form">
    <!--Peter for UX-->
    </form>
</div>
<?php
}
?>