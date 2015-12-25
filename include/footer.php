<?php
if(session_id()){
    echo "logged in as" . $_SESSION['user']['sid'];
    
    if($_SESSION['auth_level'] == $ADMIN){
        $elapsed = time() - $_SESSION['time_start'];
        $rem = 600 - $elapsed;
        
        echo "Elapsed: " . $elapsed;
        echo "Remaining: " . $rem;
    }
    
}else{
    echo "not logged in";
}
?>

</boby>
</html>