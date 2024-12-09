<?php
    session_start();
    include("connection_database.php");
    if(isset($_GET['computer_id'])){
        $id = $_GET['computer_id'];
        $sql = "DELETE FROM `users_computers` where computer_id=$id";
        $conn->query($sql);
    }
    header("Location: main.php");
    exit;
 
?>