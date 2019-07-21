<?php
    require('db.php');
    session_start();
    $uid = $_SESSION['id'];
    $email = trim($_POST["email"]);

    $sql = "SELECT * FROM Users WHERE email= '$email'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    $sid = $row['idUsers'];

    $sql = "SELECT * FROM History WHERE Student_id= '$sid' AND idBooks IN (SELECT idBooks FROM Distributor_has_Book WHERE idDistributor = '$uid')";
    $result = $db->query($sql);
    if($result->num_rows > 0) {
        $lines = $result->num_rows;
        $counter=1;
        while($lines > 0) {
            $row = $result->fetch_assoc();
            $bid = $row['idBooks'];

            //find book info -> will use with bs grid
            $sql2 = "SELECT * FROM Books WHERE idBooks=$bid";
            $result2 = $db->query($sql2);
            $row2 = $result2->fetch_assoc();

            $out = '<li class="list-group-item list-group-item-action flex-column align-items-start"><div class="row">
            <div class="col-sm-6"><div class="d-flex w-100 justify-content-between"> <h5 class="mb-1 text-primary">' . $counter . '. ' . $row2["Title"] . '</h5></div>
            <p class="mb-2">Συγγραφέας: ' . $row2["Author"] . '</p><p class="mb-2">Εκδόσεις: ' . $row2["Publication"] . '</p><p class="mb-2">ISBN:
            ' . $row2["ISBN"] . '</p></div></div>';

            //check if student has book
            $sql3 = "SELECT * FROM Student_has_Book WHERE Student_idStudent=$sid AND Book_idBook=$bid";
            $result3 = $db->query($sql3);
            if($result3->num_rows == 0) {
                $out .= '<div class="col-sm-6"><button class="btn btn-primary" style="min-width:150px;width:30%"> Παράδοση </button></div></div></li>';
            } else{
                $out .= '<div class="col-sm-6"><p style="font-style:italic"> *Ο φοιτητής έχει ήδη πραλάβει αυτό το σύγγραμμα* </p></div>';
            }

            echo $out;
            $lines -= 1;
            $counter += 1;
        }
    }
?>
