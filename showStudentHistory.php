<?php
    require('db.php');
    session_start();
    $email = trim($_POST["email"]);

    $sql = "SELECT * FROM Users WHERE email= '$email'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    $sid = $row['idUsers'];

    $sql = "SELECT * FROM History WHERE Student_id= '$sid'";
    $result = $db->query($sql);
    if($result->num_rows > 0) {
        $lines = $result->num_rows;
        $counter=1;
        while($lines > 0) {
            $row = $result->fetch_assoc();
?>
