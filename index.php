<?php
$auth = false;
if(session_id()){
    session_start();
    if($_SESSION['auth_level'] == $PANEL){
        $auth = true;
        ?>
        <!--Main Clock-in Panel-->
        <?php
    }else{
        session_unset();
        session_destroy();
    }
}else{
?>
<div id="panel-login-container">
    <form id="panel-login-form">
    <!--Peter for UX-->
    </form>
</div>
<?php
}
?>