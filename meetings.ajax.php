<?php

require_once "./common.php";

session_start();

switch($_GET['action']){
    case "get":
        $db = get_db();
        $table = $chairs['meetings'];
        $query = "SELECT * FROM $table WHERE end IS NULL AND ended_by IS NULL";
        $result = $db->query($query);
            
        while($mtg = $result->fetch_assoc()){
            $mid = $mtg['mid'];
            $start = new DateTime($mtg['start']);
            $table = $chairs['shifts'];
            
        ?>
            <div data-mid="<?php echo $mid ?>" class="meeting grid-2">
                <div class="meeting-header" style="background-color: <?php echoColor($mid, $db); ?>;">
                    <h1><?php echoSD($mid,$db) ?> Meeting</h1>
                    <h2><?php echoHosts($mid,$db) ?></h2>
                </div>
                <div class="meeting-body">
                    <h1>Clock in</h1><form class="scannable" method="post" action="members.ajax.php?action=clock"><img src='../img/id.svg'><input name="stuid" type='text'></form>
                    <div class="elapsed">
                        <span class="black-text meeting-elapsed" data-start="<?php echo $start->getTimestamp(); ?>"></span> <span class="light-text">elapsed</span>
                    </div>
                </div>
            </div>
        <?php
        }
        $db->close();
        ?>
            <div class="meeting grid-2">
                <div class="meeting-header" style="background-color: #7670b3;">
                    <h1>Start New Session</h1>
                    <h2>Logged in as <?php echo $_SESSION['user']['first'] . " " . $_SESSION['user']['last']; ?></h2>
                </div>
                <div class="meeting-body">
                    <form id="meeeting-new">
                        <div class="row">
                            <img src="../img/email.svg"><input type="text">
                        </div>
                        <div class="row">
                            <img src="../img/lock.svg"><input type="password">
                        </div>
                        <section class="row tofrom">
                            <input type="time" name="start_time" value="15:00:00">
                            <span class="light-text" style="vertical-align: middle"> to </span>
                            <input type="time" name="end_time" value="16:15:00">
                        </section>
                    </form>
                </div>
            </div>
        <?php
        break;
    case "count":
        $db = get_db();
        $table = $chairs['meetings'];
        $query = "SELECT * FROM $table WHERE end IS NULL AND ended_by IS NULL";
        $result = $db->query($query);
        echo $result->num_rows;
        break;
    case "transfer":
        if($_POST){
            
        }else echo "P401";
        break;
    
}

function echoMembers($mid,$db){
    global $chairs;
    
    $table = $chairs['shifts'];
    $query = "SELECT * FROM $table WHERE time_out IS NULL AND host='0'";
    $members = $db->query($query)->fetch_assoc();
}

function echoHosts($mid,$db){
    global $chairs;
    
    $table = $chairs['shifts'];
    $query = "SELECT * FROM $table WHERE time_out IS NULL AND host='1' AND mid='$mid'";
    $results = $db->query($query);
    
    $str = "";
    
    $str .= "Hosts: ";
    
    while($host = $results->fetch_assoc()){
        $sid = $host['sid'];
        
        $table = $chairs['admin'];
        $query = "SELECT * FROM $table WHERE sid='$sid'";
        $h = $db->query($query)->fetch_assoc();
        
        $str .= $h['first'] . " " . $h['last'] . ", ";
    }
    
    echo rtrim($str,", ");
}

function echoSD($mid,$db){ //subdept
    global $chairs;
    
    $table = $chairs['meetings'];
    $query = "SELECT sid FROM $table WHERE mid='$mid'";
    $data = $db->query($query)->fetch_assoc();
    $sid = $data['sid'];
    
    $table = $chairs['subdepts'];
    $query = "SELECT name FROM $table WHERE sid='$sid'";
    $data = $db->query($query)->fetch_assoc();
    
    echo $data['name'];
}

function echoColor($mid,$db){
    global $chairs;
    
    $table = $chairs['meetings'];
    $query = "SELECT sid FROM $table WHERE mid='$mid'";
    $data = $db->query($query)->fetch_assoc();
    $sid = $data['sid'];
    
    $table = $chairs['subdepts'];
    $query = "SELECT did FROM $table WHERE sid='$sid'";
    $data = $db->query($query)->fetch_assoc();
    $did = $data['did'];
    
    $table = $chairs['dept'];
    $query = "SELECT color FROM $table WHERE did='$did'";
    $data = $db->query($query)->fetch_assoc();
    
    echo $data['color'];
}

function echoHostable($sid,$db){
    global $chairs;
    
    $table = $chairs['admin'];
    $query = "SELECT * FROM $table WHERE sid='$sid'";
    $data = $db->query($query)->fetch_assoc();
    $scope = $data['scope'];
    $section = $data['section'];
    
    $table = $chairs['subdepts'];
    switch($scope){
        case 1:
            $query = "SELECT * FROM $table";
            break;
        case 2:
            $query = "SELECT * FROM $table WHERE did='$section'";
            break;
        case 3:
            $query = "SELECT * FROM $table WHERE sid='$section'";
            break;
    }
    
    $result = $db->query($query);
    
    echo "<select name='sid'>"
    
    while($data = $results->fetch_assoc()){
        $sid = $data['sid'];
        $name = $data['name'];
        
        echo "<option value='$sid'>$name</option>";
    }
    
    echo "</select>";
}

function queryList(){
    
}

function isHostable($sid,$mid,$db){
    global $chairs;
    
    $table = $chairs['meetings'];
    $query = "SELECT sid FROM $table WHERE mid='$mid'";
    $data = $db->query($query)->fetch_assoc();
    $sdid = $data['sid'];
    
    $table = $chairs['subdepts'];
    $query = "SELECT did FROM $table WHERE sid='$sdid'";
    $data = $db->query($query)->fetch_assoc();
    $did = $data['did'];
    
    $table = $chairs['admin'];
    $query = "SELECT * FROM $table WHERE sid='$sid'";
    $data = $db->query($query)->fetch_assoc();
    $scope = $data['scope'];
    $section = $data['section'];
    
    return ($scope == 1) || ($scope == 2 && $section == $did) || ($scope == 3 && $section = $sdid); 
}

?>