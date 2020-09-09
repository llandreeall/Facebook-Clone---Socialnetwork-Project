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
$users = "";
    
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
        //print_r($users);
       
        //echo '</pre>';
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>socialnetwork</title>
     <link rel = "stylesheet" type="text/css" href = "css/css_files/index.css">
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
                    header('location: index_nelogat.php');
                }
                
                ?>
                </b>
            </div>
        </div>
</div>
<br>
<br>
<br>

<h1 color = #333>&nbsp;&nbsp;&nbsp;&nbsp;Perete </h1>
<?php
echo $err;
    
$followingposts = db::query('SELECT posts.id, posts.body, posts.likes, users.`username`, posts.postimg FROM socialnetwork.users, socialnetwork.posts, socialnetwork.followers
WHERE posts.id_user = followers.id_user
AND users.id = posts.id_user
AND follower_id = :iduser
ORDER BY posts.likes DESC', array(':iduser'=>$iduser));
foreach ($followingposts as $post) {
    
    
    echo "<div id = "."div4"."><br>";
    echo "<img id =  "."my_img_post"." src='".$post['postimg']."'><br>".$post['body']." <b>@".$post['username']."</b>";
     echo "<form action='index.php?postid=".$post['id']."' method='post'>";
     if (!db::query('SELECT post_id FROM socialnetwork.post_likes WHERE post_id=:postid AND id_user=:iduser', array(':postid'=>$post['id'], ':iduser'=>$iduser))) {
        echo "<input class = "."button_like"." type='submit' name='like' value='Like'>";
     } else {
        echo "<input type='submit'" ."class = button_dislike"." name='unlike' value='Unlike'>";
        }
        echo "<span><font color = #ff5ca1><b>&nbsp;".$post['likes']." likes</b></font></span>
        </form>
        </form><br>
        <form action='index.php?postid=".$post['id']."' method='post'>
        <textarea name='commentbody' rows='3' cols='50'></textarea>
        &nbsp;
        <input class = "."comm"." type='submit' name='comment' value='Comenteaza'>
        </form>
        ";
        echo "<br><div id = "."divcom"."><h5><b>Comentarii:</b></h5>";
        Comment::displayComments($post['id']);
        echo "</div></div><div id = "."divbreak"."></div>  ";
        
    
}
    
?>
<div id = "cautare">
    <center>
    <?php
        if($users) {
            echo "<h5><b>Rezultatele cautarii:</b></h5><br>";
            foreach ($users as $user){
                echo "<a href = "."profile.php?username=".$user['username']." >@" . $user['username'] . "</a><br>";
            }
        }
    ?>
    </center>
</div>
</body>
</html>