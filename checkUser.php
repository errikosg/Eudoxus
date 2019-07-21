<?php
    session_start();
    require('db.php');
    $email = trim($_POST['email']);
    $psw = md5(trim($_POST['psw']));
    $sql = "SELECT * FROM Users WHERE email= '$email'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['password'] == $psw)
            echo "ok";
        else
            echo "O κωδικός που πληκτρολογήσατε δεν είναι σωστός!";
    }else
        echo "Το email που πληκτρολογήσατε δεν είναι σωστό!";
    $db->close();
?>
