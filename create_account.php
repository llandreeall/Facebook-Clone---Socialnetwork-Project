<?php
include('classes/db.php');
$err = "";

if(isset($_POST['createaccount'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $err = "";
    
    if(!db::query('SELECT username FROM socialnetwork.users WHERE username = :username', array(':username'=>$username))) {
        if(strlen($username) >= 4 && strlen($username) <= 30) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if (!db::query('SELECT email FROM socialnetwork.users WHERE email=:email', array(':email'=>$email))) {
                    if (strlen($password) >= 6 && strlen($password) <= 60) {
                        db::query('INSERT INTO socialnetwork.users VALUES (\'\', :username, :password, :email, \'\' )', array(':username'=>$username, ':password'=>password_hash($password, PASSWORD_BCRYPT), ':email'=>$email));
                    } else {
                        $err = 'Parola invalida!';
                    }
                } else {
                    $err = 'Email-ul este deja folosit!';
                }
            } else {
                $err = 'Email invalid!';
            }
        } else {
            $err = 'User invalid!';
        }
        
    } else {
        $err = 'Utilizatorul deja exista!';
    }
    
    
}

if(isset($_POST['redirect'])) {
        header('location: login.php');
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>socialnetwork</title>
     <link rel = "stylesheet" type="text/css" href = "css/css_files/create_account.css">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body style="background-color: rgba(59,89,152,1);">
 <div id="div1">
    <center>
     <font color="#f7f7f7">
     <h1>Bun venit la TheBodybook!</h1>
        <p>Intra in cont si incepe sa socializezi cu prietenii tai!
        </p>
     </font>
    </center>	                        	
    </div>  
     <br>
<div id="div2">
<center>
    <h2 class="sr-only">Inregistreaza-te</h2>
    <form action = "create_account.php" method = "post">
        <div class="illustration"><img src="images/logo.png"></div>
        <input type = "text" name = "username" value ="" placeholder = "Username..."><p />
        <input type = "password" name = "password" value ="" placeholder = "Parola..."><p />
        <input type = "email" name = "email" value = "" placeholder = "mugurmugurel@yahoo.com"><p />
        <div class="form-group">
        <?php echo $err; ?>
        </div>
        <button class="button" type="submit" name="createaccount">Sign in</button>
        <!--<input type = "submit" name = "createaccount" value = "Create Account">-->
    </form>
    <br>
    <form action = "create_account.php" method="post">
        <button class="button" type="submit" name="redirect">Am cont</button>
    </form>
</center>
</div>
    
</body>
</html>

