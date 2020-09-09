<?php
include('./classes/db.php');
include('./classes/Login.php');
    
if (Login::isLoggedIn()) {
        echo 'Logat';
        echo Login::isLoggedIn();
         if (isset($_POST['changepassword'])) {
                $oldpassword = $_POST['oldpassword'];
                $newpassword = $_POST['newpassword'];
                $newpasswordrepeat = $_POST['newpasswordrepeat'];
                $iduser = Login::isLoggedIn();
                if (password_verify($oldpassword, db::query('SELECT password FROM socialnetwork.users WHERE id=:iduser', array(':iduser'=>$iduser))[0]['password'])) {
                        if ($newpassword == $newpasswordrepeat) {
                                if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60) {
                                        db::query('UPDATE socialnetwork.users SET password=:newpassword WHERE id=:iduser', array(':newpassword'=>password_hash($newpassword, PASSWORD_BCRYPT), ':iduser'=>$iduser));
                                        echo 'Parola schimbata cu succes!';
                                }
                        } else {
                                echo 'Cele doua parole nu se potrivesc!';
                        }
                } else {
                        echo 'Parola veche gresita!';
                }
        }
} else {
        die( 'Nu e logat');
}
    
?>

<h1>Schimba-ti parola!</h1>
<form action="change_password.php" method="post">
        <input type="password" name="oldpassword" value="" placeholder="Parola curenta..."><p />
        <input type="password" name="newpassword" value="" placeholder="Parola noua ..."><p />
        <input type="password" name="newpasswordrepeat" value="" placeholder="Repeta parola noua ..."><p />
        <input type="submit" name="changepassword" value="Schimba parola">
</form>