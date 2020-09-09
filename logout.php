<?php
include('./classes/db.php');
include('./classes/Login.php');

if (!Login::isLoggedIn()) {
        die("Not logged in.");
}

if (isset($_POST['confirm'])) {
        if (isset($_POST['alldevices'])) {
                db::query('DELETE FROM socialnetwork.login_cookies WHERE id_user=:iduser', array(':iduser'=>Login::isLoggedIn()));
                header('location: index.php');
        } else {
                if (isset($_COOKIE['SNID'])) {
                        db::query('DELETE FROM socialnetwork.login_cookies WHERE cookies=:cookies', array(':cookies'=>sha1($_COOKIE['SNID'])));
                }
                setcookie('SNID', '1', time()-3600);
                setcookie('SNID_', '1', time()-3600);
                header('location: index.php');
        }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>socialnetwork</title>
     <link rel = "stylesheet" type="text/css" href = "css/css_files/logout.css">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body style="background-color: rgba(59,89,152,1);">
 <div id="div1">
    <center>
     <font color="#f7f7f7">
     <h1>Vrei sa iesi din cont?</h1>
     </font>
    </center>	                        	
    </div>  
     <br>
<div id="div2">
<center>
<p>Esti sigur ca vrei sa te deloghezi?</p>
<form action="logout.php" method="post">
        <input type="checkbox" name="alldevices" value="alldevices"> Logout de pe toate dispozitivele?<br />
        <input type="submit" class = "button" name="confirm" value="Confirm">
</form><br>
<form action = "index.php" method="post">
        <button class="button" type="submit" name="redirect2">Inapoi</button>
</form>
</center>
</div>
</body>
</html>