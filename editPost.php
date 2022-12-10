<?php
if (!isset($_GET['id'])) {
   header('location:/');
} else {
   include_once  'includes/db.php';

   $db = connectDB();
   $query = $db->prepare("SELECT * FROM posts WHERE post_id=?");
   $query->execute([$_GET['id']]);
   $post = $query->fetch();
   if (!$post) {
      echo "<h1 class='alert alert-warning'>Post Introuvable!</h1>";
   } else {


?>

      <title>Edit Post - <?php  ?></title>
      <?php include_once 'includes\head.php'; ?>

      <body class="">
         <?php include_once 'includes\nav.php'; ?>
         <section class="container">
            <h1 class="text-center my-4 text-success fw-bold">Modifier le post</h1>
            <hr>
            <form action="" method="post">
               <div class="mb-3">
                  <label for="title" class="form-label">Titre</label>
                  <input type="text" class="form-control" id="title" name="title" placeholder="Titre" value="<?= $post['post_title'] ?>" required>
               </div>
               <div class="mb-3">
                  <label for="body" class="form-label">Contenu</label>
                  <textarea class="form-control" id="body" name="body" rows="3" required><?= $post['post_body'] ?></textarea>
               </div>
               <div class="mb-3">
                  <label for="author" class="form-label">Auteur</label>
                  <input type="text" class="form-control" id="author" name="author" placeholder="Auteur" value="<?= $post['post_author'] ?>" readonly>
               </div>
               <p class="text-center mb-3">
                  <img src="server/uploads/<?= $post['post_filename'] ?>" alt="..." class="img-fluid rounded" width="150px">
               </p>
               <button type=" submit" name="submit" class="btn btn-info form-control">Actualiser!</button>
            </form>
         </section>
      </body>
      <?php include_once 'includes/foot.php' ?>
<?php
      if (isset($_POST['submit'])) {
         extract($_POST);
         $db = connectDB();
         $query = $db->prepare("UPDATE posts SET post_title=?, post_body=? WHERE post_id=?");
         $res = $query->execute([$title, $body, $_GET['id']]);
         if ($res) {
            header('location:post.php?id=' . $_GET['id']);
         } else {
            header('location:error.php');
         }
      }
   }
}
?>