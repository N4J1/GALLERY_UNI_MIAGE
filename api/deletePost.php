<?php
if (isset($_GET['id'])) {
   include '../includes/db.php';
   $db = connectDB();
   $query = $db->prepare("DELETE FROM posts WHERE post_id=?");
   $res = $query->execute([$_GET['id']]);
   if ($res) {
      header('location:../');
   } else {
      header('location:../error.php');
   }
} else {
   header('location:../');
}
