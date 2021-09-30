<?php

session_start();

if(isset($_POST["valider"])){
    if(isset($_POST["user"]) && $_POST["user"]!='' && isset($_POST["text"]) && $_POST["text"] != ''){
        $db = new PDO('mysql:host=localhost;dbname=mailbox;charset=utf8', 'root', 'root');
        $result = $db->prepare('INSERT INTO mailcontent (message, Username, sender) VALUES (:message, :user, :sender)');
        $result->execute(array('message' => $_POST["text"], 'user' =>$_POST["user"], 'sender' => $_SESSION["username"]));
        header('location:index.php?send=1');
    }
    else
    {
        header('location:index.php?send=0');
    }
}

?>