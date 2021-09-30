<?php

session_start();

$messageid = $_GET['messageid'];

$db = new PDO('mysql:host=localhost;dbname=mailbox', 'root', 'root');

    $sql = "UPDATE mailcontent SET Favorites = 1, AsRead = 1 WHERE id='$messageid'";
    $result = $db->prepare($sql);
    $result->execute();

    header("location:index.php");
?>


