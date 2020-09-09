<?php
include('./classes/db.php');
include('./classes/Login.php');
include('./classes/Image.php');

if (Login::isLoggedIn()) {
        $iduser = Login::isLoggedIn();
        $username = db::query('SELECT username FROM socialnetwork.users WHERE id=:iduser', array(':iduser'=>$iduser))[0]['username'];
        $ok = "";
} else {
        die('Not logged in!');
}

if (isset($_POST['uploadprofileimg'])) {

         Image::uploadImage('profileimg', "UPDATE socialnetwork.users SET profileimg = :profileimg WHERE id=:iduser", array(':iduser'=>$iduser));
         $ok = "Imagine schimbata !";

}
?>

<!DOCTYPE html>
<html>

<head>
    <title>socialnetwork</title>
     <link rel = "stylesheet" type="text/css" href = "css/css_files/index.css">
    <style type = "text/css">
        #divedit {
            border-radius: 5px;
            width: 400px;
            background-color: rgba(25, 25, 25, 0);
            height: 425px;
            margin-left: 50px;
            font-family: Tahoma, Geneva, sans-serif;
        }
        #div2 {
          width: 500px;
          height: 350px;
          
		  border-radius: 5px;
		  background-color: rgba(139, 157, 195, 0.5);
		  padding: 20px;
		  
		}
    </style>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
    <div class = "bar">
        <div id="wrapper">
            <div class = "logo">
                <img src="images/logo_lung.png">
            </div>
            <div class = "search_box">
                <form action="index.php" method="post">
                        <input type="text" name="searchbox" value="">
                        <input class = "button" type="submit" name="search" value="Cauta">
                </form>
            </div>
            <div id = "meniu">
                <b>
                <?php
                    if($iduser) {
                        
                        echo "<a href = "."index.php"." > Acasa </a>";
                        echo "<a href = "."profile.php?username=".$username." > Profilul meu </a>";
                        echo "<a href = "."logout.php"." > Log Out </a>"; 
                        
                } else {
                    echo "<a href = "."create_account.php"." > Sign In </a>
                    <a href = "."login.php"." > Log In </a>"; 
                }
                
                ?>
                </b>
            </div>
        </div>
</div>
<br>
<br>
<br>
    <center>
  <div id = "div2">
    <h1>Contul meu</h1> <br><br>
    <form action="my_account.php" method="post" enctype="multipart/form-data">
        <h3><b>Incarca o poza de profil:</b></h3>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="file" name="profileimg"><br><br>
            <input type="submit" class = "comm" name="uploadprofileimg" value="Incarca"><br><br>
            <?php
            echo $ok;
            ?>
    </form>
    </div>
    </center>
    </body>
</html>