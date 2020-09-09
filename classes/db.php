<?php
class db {
    private static function connect() {
        try{
        $server = "localhost";
        $user= "root";
        $dbname = "socialnetwork";
        $parola = "";
        $pdo = new PDO("mysql:host=$server; dbname = $dbname; charset = utf8", $user, $parola);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    
    public static function query($query, $params = array()) {
        //se conecteaza la baza de date si pregateste interogarea
        $statement = self::connect()->prepare($query);
        //executa interogarea
        $statement->execute($params);
        
        if(explode(' ', $query)[0] == 'SELECT') {
        //ia datele returnate din interogare
            $data = $statement->fetchALL();
            return $data;
        }
    }
}
?>