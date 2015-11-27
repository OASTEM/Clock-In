<?php
require_once "./common.php";

switch($_GET['action']){
    case 0:
        session_start();
        session_unset();
        session_destroy();
        echo "P200";
        break;
    default:
        if($_POST){
            $tables = array("LOGOUT",$chairs['members'],$chairs['admin'],$chairs['admin']);
            $table = $tables[$_GET['action']];
            $db = get_db();

            $email = $db->escape_string($_POST['email']);
            $pin = $db->escape_string(sha1($_POST['pin']));

            $query = "SELECT * FROM $table WHERE email='$email' AND pin='$pin'";
            $result = $db->query($query);

            if($result->num_rows == 1){ 
                $data = $result->fetch_assoc();
                unset($data['pin']);

                session_unset();
                session_start();

                $_SESSION['start_time'] = time();
                $_SESSION['auth_level'] = $_GET['action'];
                $_SESSION['user'] = $data;
                
                $db->close();
                echo "P200";
            }else{
                echo "P403";
            }
        }else{
            echo "P401";
        }
        break;
}

/**switch($_GET['action']){
    case "logincontroladmin":
        if($_POST){
            $table = $chairs['admin'];
            $db = get_db();

            $email = $db->escape_string($_POST['email']);
            $pin = $db->escape_string(sha1($_POST['pin']));

            $query = "SELECT * FROM $table WHERE email='$email' AND pin='$pin'";
            $result = $db->query($query);

            if($result->num_rows == 1){ 
                $data = $result->fetch_assoc();
                unset($data['pin']);

                session_unset();
                session_start();

                $_SESSION['start_time'] = time();
                $_SESSION['auth_level'] = $ADMIN;
                $_SESSION['user'] = $data;

                echo "P200";
            }else{
                echo "P403";
            }
        }else{
            echo "P401";
        }
        break;
    
    case "logincontroluser":
        if($_POST){
            $table = $chairs['members'];
            $db = get_db();

            $email = $db->escape_string($_POST['email']);
            $sid = $db->escape_string($_POST['sid']);

            $query = "SELECT * FROM $table WHERE email='$email' AND sid='$sid'";
            $result = $db->query($query);

            if($result->num_rows == 1){
                $data = $result->fetch_assoc();

                session_unset();
                session_start();

                $_SESSION['auth_level'] = $USER;
                $_SESSION['user'] = $data;
                echo "P200";
            }else{
                echo "P403";
            }
        }else{
            echo "P401";
        }
        break;
    
    case "loginpanel":
        if($_POST){
            $table = $chairs['admin'];
            $db = get_db();

            $email = $db->escape_string($_POST['email']);
            $pin = $db->escape_string(sha1($_POST['pin']));

            $query = "SELECT * FROM $table WHERE email='$email' AND pin='$pin'";
            $result = $db->query($query);

            if($result->num_rows == 1){
                $data = $result->fetch_assoc();

                session_unset();
                session_start();

                $_SESSION['auth_level'] = $PANEL;
                $_SESSION['user'] = $data;
                echo "P200";
                echo var_dump($_SESSION);
            }else{
                echo "P403";
            }
        }else{
            echo "P401";
        }
        break;
        
    case "logout":
        session_unset();
        session_destroy();
        break;
    default:
        echo "P400";    
}*/
?>