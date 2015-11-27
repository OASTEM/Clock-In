<?php
include "./common.php";
include "./include/header.php";

session_start();

if(isset($_SESSION['auth_level']) && ($_SESSION['auth_level'] == $PANEL || $_SESSION['auth_level'] == $ADMIN)){
    $auth = $_SESSION['auth_level'] == $ADMIN;
    
    $db = get_db();
    
    $table = $chairs['meetings'];
    
    $query = "SELECT * FROM $table WHERE end IS NULL AND ended_by IS NULL";
    
    $result = $db->query($query)->fetch_assoc();
    
    foreach($result as $mtg){
    ?>
    <div class="container">
            <div class="meeting grid-2">
                <div class="meeting-header" style="background-color: #ed5025;">
                    <h1>FRC Meeting</h1>
                    <h2>Hosts: Byron Aguilar, Peter Yang</h2>
                </div>
                <div class="meeting-body">
                    <h1>Clock in</h1><form><img src='../img/id.svg'><input type='text'></form>
                    <div class="elapsed">
                        <span class="black-text meeting-elapsed" data-start=<?php echo $mtg['start'] ?>></span><span class="light-text">elapsed</span>
                    </div>
                </div>
            </div>
    </div>
<?php
    }
    
}else{
?>
<script src="js/auth.js"></script>
<div class="no-login-overlay">
        <div id="login-box">
            <div class="row">
                <div class="col-12"><h1>Please login to continue</h1></div>
            </div>
            <div class="row">
                <div class="col-6" style="background: #7670b3; color:#fff">
                    <h2>Administrator</h2>
                    <form id="admin-panel-login" method="post" action="auth.ajax.php?action=<?php echo $PANEL; ?>">
                        <div class="row">
                            <img src="../img/emailwhite.svg"><input type="text" name="email">
                        </div>
                        <div class="row">
                            <img src="../img/lockwhite.svg"><input id="pin" type="password" maxlength="6" name="pin">
                        </div>
                        <input type="submit" value="Login">
                    </form>
                </div>
                <div class="col-6" style="background: #fff;">
                    <h2>Student</h2>
                    <form id="user-control-login" method="post" action="auth.ajax.php?action=<?php echo $USER; ?>">
                        <div class="row">
                            <img src="../img/email.svg"><input type="text" name="email">
                        </div>
                        <div class="row">
                            <img src="../img/id.svg"><input type="text" name="pin">
                        </div>
                    <input type="submit" value="Login">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}

include "include/footer.php"; 
?>