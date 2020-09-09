
<?php

class Post {
        public static function createPost($postbody, $loggedInUserId, $profileUserId) {
                if (strlen($postbody) > 200 || strlen($postbody) < 1) {
                        die('Dimensiuni gresite!');
                }
                if ($loggedInUserId == $profileUserId) {
                        db::query('INSERT INTO socialnetwork.posts VALUES (\'\', :postbody, NOW(), :iduser, 0, \'\')', array(':postbody'=>$postbody, ':iduser'=>$profileUserId));
                } else {
                        die('Incorrect user!');
                }
        }
    
        public static function createImgPost($postbody, $loggedInUserId, $profileUserId) {
                if (strlen($postbody) > 200) {
                        die('Dimensiune incorecta!');
                }
                if ($loggedInUserId == $profileUserId) {
                        db::query('INSERT INTO socialnetwork.posts VALUES (\'\', :postbody, NOW(), :iduser, 0, \'\')', array(':postbody'=>$postbody, ':iduser'=>$profileUserId));
                        $postid = db::query('SELECT id FROM socialnetwork.posts WHERE id_user=:iduser ORDER BY ID DESC LIMIT 1;', array(':iduser'=>$loggedInUserId))[0]['id'];
                        return $postid;
                } else {
                        die('User incorect!');
                }
        }
    
        public static function likePost($postId, $likerId) {
                //echo 'am intrat';
                if (!db::query('SELECT id_user FROM socialnetwork.post_likes WHERE post_id=:postid AND id_user=:iduser', array(':postid'=>$postId, ':iduser'=>$likerId))) {
                       // echo 'acum dau like';
                        db::query('UPDATE socialnetwork.posts SET likes=likes+1 WHERE id=:postid', array(':postid'=>$postId));
                        db::query('INSERT INTO socialnetwork.post_likes VALUES (\'\', :postid, :iduser)', array(':postid'=>$postId, ':iduser'=>$likerId));
                } else {
                        //echo 'deja am dat like';
                        db::query('UPDATE socialnetwork.posts SET likes=likes-1 WHERE id=:postid', array(':postid'=>$postId));
                        db::query('DELETE FROM socialnetwork.post_likes WHERE post_id=:postid AND id_user=:iduser', array(':postid'=>$postId, ':iduser'=>$likerId));
                }
        }
        public static function displayPosts($iduser, $username, $loggedInUserId) {
                $dbposts = db::query('SELECT * FROM socialnetwork.posts WHERE id_user=:iduser ORDER BY id DESC', array(':iduser'=>$iduser));
                $posts = "";
                foreach($dbposts as $p) {
                        if (!db::query('SELECT post_id FROM socialnetwork.post_likes WHERE post_id=:postid AND id_user=:iduser', array(':postid'=>$p['id'], ':iduser'=>$loggedInUserId))) {
                                $posts .= "<img id =  "."my_img_post"." src='".$p['postimg']."'><br>".htmlspecialchars($p['body'])."
                                <br><br>
                                <form action='profile.php?username=$username&postid=".$p['id']."' method='post'>
                                        <input type='submit' class = "."button_like"." name='like' value='Like'>
                                        <span><font color = #ff5ca1><b>".$p['likes']." likes</b></font></span>
                                ";
                                if ($iduser == $loggedInUserId) {
                                        $posts .= "<input type='submit' name='deletepost' class = "."comm"." value='Sterge' />";
                                }    
                            
                                $posts .= "
                                <hr /></br />
                                ";
                        } else {
                                $posts .= "<img id =  "."my_img_post"." src='".$p['postimg']."'><br>".htmlspecialchars($p['body'])."
                                <br><br>
                                <form action='profile.php?username=$username&postid=".$p['id']."' method='post'>
                                        <input type='submit' name='unlike' class = "."button_dislike"." value='Unlike'>
                                        <span><font color = #ff5ca1><b>".$p['likes']." likes</b></font></span>
                                ";
                                if ($iduser == $loggedInUserId) {
                                        $posts .= "<input type='submit' class = "."comm"." name='deletepost' value='Sterge' />";
                                }
                                $posts .= "
                                </form><hr /></br />
                                ";
                        }
                }
                return $posts;
        }
}
?>