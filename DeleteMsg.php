<?php
session_start();

$messageid = $_GET['messageid'];

$db = new PDO('mysql:host=localhost;dbname=mailbox', 'root', 'root');

    $sql = "DELETE FROM mailcontent where id='$messageid'";
    $result = $db->prepare($sql);
    $result->execute();

    header("location:index.php");
?>

