
<?php 

session_start();

?>

<html>
    <head>
       <meta charset="utf-8">
        <link rel="stylesheet" href="style.css" type="text/css" />
        <script src="https://kit.fontawesome.com/49dbd7732f.js" crossorigin="anonymous"></script>
        <title>Nhood mailbox</title>
    </head>

<?php 

if (isset($_SESSION['username']))
{
    echo "<section class='header'><h2><i class='fas fa-user'></i>   ". $_SESSION['username']." <a class='disconnectButton' href='index.php?deconnexion=true'>Déconnexion</a></h2></section>";


    $username = $_SESSION['username'];

    $db = new PDO('mysql:host=localhost;dbname=mailbox', 'root', 'root');

    $message = $db->query("SELECT * FROM mailcontent WHERE Username = '$username'");
    $favoris = $db->query("SELECT * FROM mailcontent WHERE Username = '$username' AND Favorites = 1");
    $usernamedb = $db->query("SELECT username FROM user");

    if ($message->rowCount() > 0) 
    {
        ?>
        <h2 class="title-content">Favoris</h2>
        <?php
        if($favoris->rowCount() > 0)
        {
        while ($donnees = $favoris->fetch())
        //foreach ($reponse as $donnees) 
        :
        ?>
        <div class="favoris">
        <p>
        <?php echo '<strong>Message : </strong>'.$donnees['message'].'<strong> de la part de : </strong>'.$donnees['sender']; ?> <a class="UnFavButton" href="FavUnset.php?messageid=<?= $donnees['id']; ?>"><i class="fas fa-star"></i></a>
        </p>
        </div>
        <?php
        endwhile;
        }
        else
        {
            echo '<p>Vous n\'avez aucun message en favoris<p>';
        }
        ?>

        <h2 class="title-content">Messages</h2>
        <?php
        while ($donnees = $message->fetch())

        :
        if($donnees['favorites'] == 0) {  //si le message est pas dans 'favoris', le mettre dans 'vos messages';
        ?>
        <div class="message" style="background-color: <?php if($donnees['AsRead'] == 1){ ?>white<?php }else{ ?>rgb(235,235,235)<?php } ?>">
        
        <p><strong>Message : </strong><?= $donnees['message']?><strong> de la part de : </strong><?= $donnees['sender'];?><span class="Buttons"><?php if($donnees['AsRead'] == 0) /* Si le message n'est pas lu , mettre 'marquer comme lu' */ { ?><a class="AsReadButton" href="AsReadOn.php?messageid=<?= $donnees['id'];?>"><i class="fas fa-eye"></i></a><?php } ?><a class="DltButton" href="deleteMsg.php?messageid=<?= $donnees['id'];?>"><i class="fas fa-trash-alt"></i></a> <a class="FavButton" href="FavOn.php?messageid=<?= $donnees['id']; ?>"><i class="far fa-star"></i></a></p></span>
    
        </div>
        <?php
        }
        endwhile;
    }
    else
    {
        echo "<h1 class='EmptyBox'>Votre boite mail est vide</h1>";
    }
?>

<h2 class="title-content">Envoyer des messages</h2> 

<form action="SendMess.php" method="post" class="SendMess">
    <textarea name="text" placeholder="<?php if(isset($_GET['send'])){ if($_GET['send'] == 1){ echo 'Votre message à bien été envoyé'; }else{ echo 'Veuillez indiquer un message'; }}
?>
" required></textarea>
                                             
    <div class="select-style">          
    Destinataire :                              
    <select name="user">

        <?php
            
            while ($donnees = $usernamedb->fetch()) 
            :
            if($username != $donnees['username']) {
            ?>
            
                <option value="<?=$donnees['username']; ?>"><?=$donnees['username']; ?></option>

            <?php
            }
            endwhile;
            ?>

    </select>
    </div>
    <input class="SendButton" type="submit" name="valider" value="ENVOYER">
</form>

<?php
}
else
{
?>

    <body>
        <div id="">
            <form method="POST" action="connexion.php" class="Connexion">
                <img src="images/LogoNHOOD.png" class="LogoNhood">
                <h1 class="formTitle">Enregistrement</h1>
                <label><b>Nom d'utilisateur</b></label>
                <input type="text" placeholder="Nom d'utilisateur" name="username" required >

                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Mot de passe" name="password" required >

                <input type="submit" name='submit' value='SIGN IN'>
            </form>
        </div>
        <p>Deja enregistré ? <a href="/Projects/MessagerieUtilisateur/connexion.php">Connexion</a></p>
    </body>
</html>

<?php
}

if(isset($_GET['deconnexion']))
{ 
   if($_GET['deconnexion']==true)
   {  
      session_unset();
      header("location:connexion.php");
   }
}
?>
