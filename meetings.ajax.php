<?php

require_once "common.php";

switch($_GET['action']){
    case "get":
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
        $db->close();
        break;
    
    case "count":
        $db = get_db();
        $table = $chairs['meetings'];
        $query = "SELECT * FROM $table WHERE end IS NULL AND ended_by IS NULL";
        $result = $db->query($query);
        echo $result->num_rows;
}

?>