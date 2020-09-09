<?php
include('classes/db.php');
$err = "";
if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if (db::query('SELECT username FROM socialnetwork.users WHERE username=:username', array(':username'=>$username))) {
                if (password_verify($password, db::query('SELECT password FROM socialnetwork.users WHERE username=:username', array(':username'=>$username))[0]['password'])) {
                        $err = 'Logat!';
                        $cstrong = True;
                        $cookie = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                        $id_user = db::query('SELECT id FROM socialnetwork.users WHERE username=:username', array(':username'=>$username))[0]['id'];
                        db::query('INSERT INTO socialnetwork.login_cookies VALUES (\'\' , :cookie, :id_user)', array(':cookie'=>sha1($cookie), ':id_user'=>$id_user));
                    
                        //snid = socialnetworkid, valabil pt o saptamana
                        setcookie("SNID", $cookie, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                        setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
                        header('location: index.php');
                } else {
                        $err = 'Parola incorecta!';
                }
        } else {
                $err = 'Userul nu exista!';
        }
}

if(isset($_POST['redirect1'])) {
        header('location: create_account.php');
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>socialnetwork</title>
     <link rel = "stylesheet" type="text/css" href = "css/css_files/login.css">
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
        <form action="login.php" method="post">
        <h2 class="sr-only">Intra in contul tau</h2>
        <div class="illustration"><img src="images/logo.png"></div>
        <div class="form-group">
            <input type="text" name="username" class="form-control" value="" placeholder="Username ..."><p/>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" value="" placeholder="Parola ..."><p/>
        </div>
        <div class="form-group">
        <?php echo $err; ?>
        </div>
        <button class="button" type="submit" name="login">Log In</button>
        <!--<input type="submit" name="login" value="Login">-->
            
        </form>
        <br>
        <form action = "login.php" method="post">
        <button class="button" type="submit" name="redirect1">Nu am cont</button>
        </form>
        </center>
    </div>
    
</body>
</html>