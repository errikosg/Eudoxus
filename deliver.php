<?php
    require('db.php');
    session_start();
    $uid = $_SESSION['id'];
    $bid = trim($_POST["bid"]);
    $sid = trim($_POST["sid"]);
    echo "$bid, " . "$sid";

    //student gets book
    $sql = "INSERT INTO Student_has_Book (Student_idStudent, Book_idBook) VALUES ('$sid', '$bid')";
    $result = $db->query($sql);

    //book quantity reduced by 1
    $sql = "SELECT * FROM Distributor_has_Book WHERE idDistributor='$uid' AND idBooks='$bid'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    $quant = $row['Quantity'];
    $quant -= 1;

    $sql = "UPDATE Distributor_has_Book SET Quantity=$quant WHERE idDistributor='$uid' AND idBooks='$bid'";
    $result = $db->query($sql);

    $db->close();
?>
