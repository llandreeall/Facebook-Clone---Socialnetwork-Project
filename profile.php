<?php
include('./classes/db.php');
include('./classes/Login.php');
include('./classes/Post.php');
include('./classes/Image.php');

$username = "";
$isFollowing = 0;
$profileimg = "";

if (isset($_GET['username'])) {
        if (db::query('SELECT username FROM socialnetwork.users WHERE username=:username', array(':username'=>$_GET['username']))) {
                $username = db::query('SELECT username FROM socialnetwork.users WHERE username=:username', array(':username'=>$_GET['username']))[0]['username'];
                $profileimg = db::query('SELECT profileimg FROM socialnetwork.users WHERE username=:username', array(':username'=>$_GET['username']))[0]['profileimg'];
                //echo $username;
                $iduser = db::query('SELECT id FROM socialnetwork.users WHERE username=:username', array(':username'=>$_GET['username']))[0]['id'];
                $followerid = Login::isLoggedIn();
                $followeruser = db::query('SELECT username FROM socialnetwork.users WHERE id=:followerid', array(':followerid'=>$followerid))[0]['username'];
                //echo $iduser;
            
                if (isset($_POST['follow'])) {
                    if ($iduser != $followerid) {
                        if (!db::query('SELECT follower_id FROM socialnetwork.followers WHERE id_user=:iduser AND follower_id=:followerid', array(':iduser'=>$iduser , ':followerid'=>$followerid))) {
                                db::query('INSERT INTO socialnetwork.followers VALUES (\'\', :iduser, :followerid)', array(':iduser'=>$iduser, ':followerid'=>$followerid));
                        } else {
                                echo 'Deja il urmaresti!';
                        }
                        $isFollowing = 1;
                    }
                } 
                
                if (isset($_POST['unfollow'])) {
                        if ($iduser != $followerid) {
                                if (db::query('SELECT follower_id FROM socialnetwork.followers WHERE id_user=:iduser AND follower_id=:followerid', array(':iduser'=>$iduser, ':followerid'=>$followerid))) {
                                        //echo '5';
                                        db::query('DELETE FROM socialnetwork.followers WHERE id_user=:iduser AND follower_id=:followerid', array(':iduser'=>$iduser, ':followerid'=>$followerid));
                                    //$isFollowing = False;
                                }
                                $isFollowing = 0;
                        }
                }
            
                if (db::query('SELECT follower_id FROM socialnetwork.followers WHERE id_user=:iduser AND follower_id=:followerid', array(':iduser'=>$iduser, ':followerid'=>$followerid))) {
                        //echo 'Already following!';
                        $isFollowing = 1;
                }
            
                if (isset($_POST['deletepost'])) {
                        if (db::query('SELECT id FROM socialnetwork.posts WHERE id=:postid AND id_user=:iduser', array(':postid'=>$_GET['postid'], ':iduser'=>$followerid))) {
                                db::query('DELETE FROM socialnetwork.posts WHERE id=:postid and id_user=:iduser', array(':postid'=>$_GET['postid'], ':iduser'=>$followerid));
                                db::query('DELETE FROM socialnetwork.post_likes WHERE post_id=:postid', array(':postid'=>$_GET['postid']));
                                db::query('DELETE FROM socialnetwork.comments WHERE post_id=:postid', array(':postid'=>$_GET['postid']));
                                echo 'Postare stearsa!';
                        }
                }
            
                //de aici postam
                if (isset($_POST['post'])) {
                    if ($_FILES['postimg']['size'] == 0) {
                        Post::createPost($_POST['postbody'], Login::isLoggedIn(), $iduser);
                    } else {
                                $postid = Post::createImgPost($_POST['postbody'], Login::isLoggedIn(), $iduser);
                                Image::uploadImage('postimg', "UPDATE socialnetwork.posts SET postimg=:postimg WHERE id=:postid", array(':postid'=>$postid));
                    }
                }
                if (isset($_GET['postid']) && !isset($_POST['deletepost'])) {
                    //verificam daca userul a dat like deja
                       Post::likePost($_GET['postid'], $followerid);
                }
                $posts = Post::displayPosts($iduser, $username, $followerid);

        } else {
                die('Utilizatorul nu a fost gasit!');
        }
}
    
?>

<!DOCTYPE html>
<html>

<head>
    <title>socialnetwork</title>
     <link rel = "stylesheet" type="text/css" href = "css/css_files/index.css">
    <style type = "text/css">
        #divprofil {
            border-radius: 5px;
            width: 800px;
            background-color: rgba(25, 25, 25, 0);
            height: 125px;
            margin-left: 50px;
            font-family: Tahoma, Geneva, sans-serif;
        }

        #rest{
            border-radius: 5px;
            width: 660px;
            background-color: rgba(220, 220, 20, 0);
            height: 125px;
            
            color: #333;
            float:right;
        }

        #imagineprofil{

            background-color: rgba(55, 255, 255, 0);
            float: left;
            width: 125px;
            height: 125px;
            border-radius: 5px;

        }

        #my_img { 
            width: 100%; 
            height: 100%; 
            object-fit: contain; 
            border-radius: 50%;
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
                        echo "<a href = "."profile.php?username=".$followeruser." > Profilul meu </a>";
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

<div id = "divprofil">
       <div id = "imagineprofil">
            <img id = "my_img" src = "<?php echo $profileimg;?>" alt="Avatar"> 
       </div>
    
    <div id = "rest">
    <h1 color = #333>Profilul lui @<?php echo $username; ?></h1>
    <br>
    <form action="profile.php?username=<?php echo $username; ?>" method="post">
        <?php
            if ($iduser != $followerid) {
                    if ($isFollowing) {
                            echo '<input type="submit" class = "unfollow" name="unfollow" value="Nu mai urmari">';
                    } else {
                            echo '<input type="submit" class = "comm" name="follow" value="Urmareste">';
                    }
            }
            ?>
    </form>
    <form action="my_account.php" method="post">
        <?php
           if ($iduser == $followerid) {
                echo '<input type="submit" class = "comm" name="edit" value="Edit">';
           } 
        ?>
    </form>
    </div>
</div>
<br><br>
<div id = "div4">
<h3 color = #333>Fa o postare </h3>

<form action="profile.php?username=<?php echo $username; ?>" method="post" enctype="multipart/form-data">
        <textarea name="postbody" placeholder = "Posteaza ceva..." rows="3" cols="80"></textarea>
         <br />Incarca o imagine:
        <input type="file" name="postimg" >
        <input type="submit" class = "comm" name="post" value="Post">
</form>
    <br>
    </div>
    <br>
<div id = "divbreak"></div>

<div id="div4">
    <h4><b>Postarile lui @<?php echo $username; ?></b></h4>
   <hr>
        <br>
        <?php echo $posts; ?>
</div>

    
    </body>
</html>