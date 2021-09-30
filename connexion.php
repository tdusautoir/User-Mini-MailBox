<?php 

session_start();

?>

<html>
    <head>
       <meta charset="utf-8">
        <link rel="stylesheet" href="style.css" type="text/css" />
        <title>Nhood mailbox</title>
    </head>
    <body>
        <div id="">
            <form method="POST" action="login.php" class="Connexion">
                <img src="images/LogoNHOOD.png" class="LogoNhood">
                <h1 class="FormTitle">Connexion</h1>  
                <label><b>Nom d'utilisateur</b></label>
                <input type="text" placeholder="Nom d'utilisateur" name="username" >

                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Mot de passe" name="password" >

                <input type="submit" name='submit' value='LOGIN'>
            </form>
        </div>
        <p>Creer un compte : <a href="/Projects/MessagerieUtilisateur/index.php">Enregistrement</a></p>
    </body>
</html>

<?php   

if(isset($_POST['submit']))
{
    $username = $_POST['username'];
    $pass = $_POST['password'];

    $db = new PDO('mysql:host=localhost;dbname=mailbox', 'root', 'root');

    $sql="SELECT * FROM user where username = '$username' ";
    $result = $db->prepare($sql);
    $result->execute();

    if($result->rowCount() <= 0)
    {
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (username, password) VALUES ('$username', '$pass')";
        $req = $db->prepare($sql);
        $req->execute();
        echo "<center><h2>Enregistrement <span class='ok'>effectué</span></h2></center>";
    }
    else
    {
        echo "<center><h2>Vous possédez deja un compte</h2></center>";
    }
}


?>