<?php

require_once "./common.php";

switch($_GET['action']){
    case "isLastHost":
        if(isset($_POST['mid']) && isset($_POST['stuid'])){
            $db = get_db();
            $mid = $db->real_escape_string($_POST['mid']);
            $sid = $db->real_escape_string($_POST['stuid']);
            
            $table = $chairs['shifts'];
            $query = "SELECT * FROM $table WHERE mid='$mid' AND host='1'";
            $result = $db->query($query);
            $data = $result->fetch_assoc();
            
            $isLastHost = $result->num_rows == 1 && $data['sid'] == $sid;
            
            if($isLastHost) echo "true";
            else echo "false";
        }
    case "isAdmin":
        if(isset($_POST['stuid'])){
            $db = get_db();
            $sid = $db->real_escape_string($_POST['stuid']);
            
            $table = $chairs['admin'];
            $query = "SELECT * FROM $table WHERE sid=$sid";
            $result = $db->query($query);
            
            if($result->num_rows == 1) echo "true";
            else echo "false";
        }
    case "isHost":
        if(isset($_POST['mid']) && isset($_POST['stuid'])){
            $db = get_db();
            $sid = $db->real_escape_string($_POST['stuid']);
            $mid = $db->real_escape_string($_POST['mid']);
            
            $table = $chairs['shifts'];
            $query = "SELECT * FROM $table WHERE sid=$sid AND host=1 AND time_out IS NULL AND duration IS NULL";
            $result = $db->query($query);
            
            if($result->num_rows == 1) echo "true";
            else echo "false";
        }else echo "P401";
        break;
    case "clock":
        if(isset($_POST['mid']) && isset($_POST['stuid'])){
            if($_SESSION['auth_level'] == 3) {
                $db = get_db();
                $mid = $db->real_escape_string($_POST['mid']);
                $sid = $db->real_escape_string($_POST['stuid']);

                $table = $chairs['shifts'];
                $query = "SELECT * FROM $table WHERE mid='$mid' AND sid='$sid' AND time_out IS NULL";

                $result = $db->query($query);
                if($result->num_rows > 0){ //already in
                    $data = $result->fetch_assoc();
                    $shift = $data['shift'];
                    $in = $data['time_in'];

                    $currtime = date("Y-m-d H:i:s");
                    $in = new DateTime($in);
                    $out = new DateTime($currtime);
                    $out_form = $out->format("Y-m-d H:i:s");
                    $dur = $out->getTimestamp() - $in->getTimestamp();
                    $query = "UPDATE $table SET time_out='$out_form', duration='$dur' WHERE shift='$shift'";

                    $db->query($query);

                    if($db->affected_rows > 0) echo "P200";
                    else echo "P500";

                    }else{ //not in
                        $query = "INSERT INTO $table (sid,mid,host) VALUES ($sid,$mid,$isAdmin)";
                        $db->query($query);

                        if($db->affected_rows > 0) echo "P200";
                        else echo "P500";
                    }
                }else echo "P403";
            }else echo "P401";   
}

?>