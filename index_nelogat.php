<?php
include('./classes/db.php');
include('./classes/Login.php');
include('./classes/Post.php');
include('./classes/Comment.php');

//date despre imgur
//client ID = 67a72e24c1bfd8b
//client secret = 66b4a93df3638f221c68304896fa27eee599abe6
//https://imgur.com/#access_token=6eaff40f89c368a4c2105f70bb9f1268c73e4cee&expires_in=315360000&token_type=bearer&refresh_token=ccda280ffdb8d3b406a46816cdf9a33148cc7f25&account_username=andreeakage&account_id=121124747
//access token = 6eaff40f89c368a4c2105f70bb9f1268c73e4cee
//refresh token = ccda280ffdb8d3b406a46816cdf9a33148cc7f25


$showTimeline = False;
$iduser = "";
$username = "";
$err = "";
    
if (Login::isLoggedIn()) {
        $iduser = Login::isLoggedIn();
        $username = db::query('SELECT username FROM socialnetwork.users WHERE id=:iduser', array(':iduser'=>$iduser))[0]['username'];
        $showTimeline = True;
} else {
        $err = 'Nu e logat';
}

if (isset($_GET['postid'])) {
        Post::likePost($_GET['postid'], $iduser);
}

if (isset($_POST['comment'])) {
        Comment::createComment($_POST['commentbody'], $_GET['postid'], $iduser);
}

if (isset($_POST['searchbox'])) {
        //facem asta la inceput pentru a putea cauta utilizatori fara scrie tot cuvantul
        $tosearch = explode(" ", $_POST['searchbox']);
        if (count($tosearch) == 1) {
                $tosearch = str_split($tosearch[0], 2);
        }
        $whereclause = "";
        $paramsarray = array(':username'=>'%'.$_POST['searchbox'].'%');
        for ($i = 0; $i < count($tosearch); $i++) {
                $whereclause .= " OR username LIKE :u$i ";
                $paramsarray[":u$i"] = $tosearch[$i];
        }
        $users = db::query('SELECT users.username FROM socialnetwork.users WHERE users.username LIKE :username '.$whereclause.'', $paramsarray);
        print_r($users);
       
        echo '</pre>';
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>socialnetwork</title>
     <link rel = "stylesheet" type="text/css" href = "css/css_files/index.css">
    <style type = "text/css">
        #div2 {
          width: 900px;
          height: 150px;
          
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
    <font color="#333">
     <h1>Bun venit la TheBodybook!</h1>
        <p>Intra in cont si incepe sa socializezi cu prietenii tai!
        </p>
     </font>
    
    </div>
    </center>

</body>
</html>