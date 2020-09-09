<?php
class Comment {
        public static function createComment($commentBody, $postId, $iduser) {
                if (strlen($commentBody) > 200 || strlen($commentBody) < 1) {
                        die('Dimensiuni gresite!');
                }
                if (!db::query('SELECT id FROM socialnetwork.posts WHERE id=:postid', array(':postid'=>$postId))) {
                        echo 'ID invalid';
                } else {
                        db::query('INSERT INTO socialnetwork.comments VALUES (\'\', :comment, :iduser, NOW(), :postid)', array(':comment'=>$commentBody, ':iduser'=>$iduser, ':postid'=>$postId));
                }
        }
    
        public static function displayComments($postId) {
                $comments = db::query('SELECT comments.comment, users.username FROM socialnetwork.comments, socialnetwork.users WHERE post_id = :postid AND comments.id_user = users.id', array(':postid'=>$postId));
                foreach($comments as $comment) {
                        echo $comment['comment']." @".$comment['username']."<hr />";
                }
        }
}
?>