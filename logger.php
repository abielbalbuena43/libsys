<?php
function logger($db, $user_id, $user_type, $message){
    $sql = "INSERT INTO logs (user_id, user_type, message, created_at) VALUES ('".$user_id."', '".$user_type."', '".$message."', NOW())";

    mysqli_query($db, $sql);
}

?>