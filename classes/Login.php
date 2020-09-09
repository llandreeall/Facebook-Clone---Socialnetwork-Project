<?php
class Login {
    public static function isLoggedIn(){
    if (isset($_COOKIE['SNID'])) {
                if (db::query('SELECT id_user FROM socialnetwork.login_cookies WHERE cookies=:cookies', array(':cookies'=>sha1($_COOKIE['SNID'])))) {
                        $iduser = db::query('SELECT id_user FROM socialnetwork.login_cookies WHERE cookies=:cookies', array(':cookies'=>sha1($_COOKIE['SNID'])))[0]['id_user'];
                        if (isset($_COOKIE['SNID_'])) {
                                return $iduser;
                        } else {
                                $cstrong = True;
                                $cookie = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                                db::query('INSERT INTO socialnetwork.login_cookies VALUES (\'\', :cookies, :id_user)', array(':cookies'=>sha1($cookie), ':id_user'=>$iduser));
                                db::query('DELETE FROM socialnetwork.login_cookies WHERE cookies=:cookies', array(':cookies'=>sha1($_COOKIE['SNID'])));
                                setcookie("SNID", $cookie, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                                setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
                                return $iduser;
                        }
                    }
                }
    return false;
}
}
?>