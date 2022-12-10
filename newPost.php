<title>Nouveau Post</title>
<?php
include_once 'includes\head.php';
include_once 'includes\post.php';
include_once 'includes\db.php';
?>

<body class="">
   <?php include_once 'includes\nav.php'; ?>
   <section class="container">
      <h1 class="text-center my-4 text-success fw-bold">Poster Nouvelle Image</h1>
      <hr>
      <form action="" method="post" enctype="multipart/form-data">
         <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Titre" required>
         </div>
         <div class="mb-3">
            <label for="body" class="form-label">Contenu</label>
            <textarea class="form-control" id="body" name="body" rows="3" required></textarea>
         </div>
         <div class="mb-3">
            <label for="author" class="form-label">Auteur</label>
            <input type="text" class="form-control" id="author" name="author" placeholder="Auteur" required>
         </div>
         <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input class="form-control" type="file" id="image" name="image" accept=".png, .jpg, .jpeg">
         </div>
         <button type="submit" name="submit" class="btn btn-info form-control">Publier!</button>
      </form>
   </section>
</body>

<?php
if (isset($_POST['submit'])) {
   extract($_POST);
   $target_file = 'server/uploads/' . basename($_FILES["image"]["name"]);
   move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
   $db = connectDB();
   $post = new Post("", basename($_FILES["image"]["name"]), $title, $body, $author, "", "");
   $res = $post->createNew($db);
   if ($res) {
      header('location:/');
   } else {
      header('location:error.php');
   }
}
?>

<?php include_once 'includes\foot.php' ?>