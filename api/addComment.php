<?php
if (isset($_GET['id'])) {
   include '../includes/db.php';
   include '../includes/Comment.php';
   extract($_POST);
   $db = connectDB();
   $comment = new Comment("", $_GET['id'], $comment_body, $comment_author, "");
   $res = $comment->createNew($db);
   if ($res) {
      header('location:../post.php?id=' . $_GET['id']);
   } else {
      header('location:../error.php');
   }
} else {
   header('location:../');
}
