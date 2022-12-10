<?php
if (!isset($_GET['id'])) {
   header('location:/');
} else {
   include_once 'includes/db.php';
   include_once 'includes/Post.php';
   $avatars = array('avatar_dog.jpg', 'avatar_female.jpg', 'avatar_male.jpg');
   $db = connectDB();
   $id = $_GET['id'];
   $query = $db->prepare("SELECT * FROM posts WHERE post_id=?");
   $query->execute([$id]);
   $item = $query->fetch();
   if (!$item) {
      echo "Post Introuvable";
   } else {
      $post = new Post($item['post_id'], $item['post_filename'], $item['post_title'], $item['post_body'], $item['post_author'], $item['post_created_at'], $item['post_updated_at']);
   }

?>
   <title><?= $post->getAuthor() ?> | <?= $post->getTitle() ?></title>
   <?php include_once "includes/head.php"; ?>

   <body>
      <?php include_once 'includes/nav.php'; ?>
      <section class="container-fluid">
         <hr>
         <?php include_once "includes/head.php"; ?>
         <div class="container">
            <div class="card">
               <div class="card-body">

                  <!-- Header -->
                  <div class="mb-3">
                     <div class="row align-items-center">
                        <div class="col-auto">

                           <!-- Avatar -->
                           <a href="#!" class="avatar">
                              <img src="assets/images/avatars/avatar_dog.jpg" alt="..." class="avatar-img rounded-circle">
                           </a>

                        </div>
                        <div class="col ms-n2">

                           <!-- Author -->
                           <h4 class="mb-1">
                              <?= $post->getAuthor() ?>
                           </h4>

                           <!-- Time -->
                           <p class="card-text small text-muted">
                              <i class="fa-regular fa-clock"></i> <time datetime="<?= $post->createdAt() ?>"><?= $post->createdAt() ?></time>
                           </p>

                        </div>
                        <div class="col-auto">

                           <!-- Edit Buttons -->
                           <div class="buttons">
                              <a href="api/deletePost.php?id=<?= $post->getId() ?>" class="btn btn-sm btn-outline-danger">Supprimer</a>
                              <a href="editPost.php?id=<?= $post->getId() ?>" class="btn btn-sm btn-outline-primary">Editer</a>
                           </div>

                        </div>
                     </div> <!-- / .row -->
                  </div>
                  <!-- Title -->
                  <h3 class="mb-3 text-primary fw-bold">
                     <?= $post->getTitle()  ?>
                  </h3>
                  <!-- Body -->
                  <p class="mb-3">
                     <?= $post->getBody()  ?>
                  </p>



                  <!-- Image -->
                  <p class="text-center mb-3">
                     <img src="server/uploads/<?= $post->getFilename() ?>" alt="..." class="img-fluid rounded" width="500px">
                  </p>

                  <div class="d-flex justify-content-between text-muted my-3">
                     <small>Dernière actualisation : <?= $post->updatedAt() ?></small><a href="server/uploads/<?= $post->getFilename() ?>" class="btn btn-sm btn-outline-success flex-grow-2" download>Télécharger <i class="fa-solid fa-cloud-arrow-down"></i></a>
                  </div>
                  <!-- Divider -->
                  <h2 class="text-warning fw-bold">Commentaires:</h2>

                  <!-- Comments -->
                  <?php
                  include_once 'includes/Comment.php';
                  $items = $post->getComments($db);
                  foreach ($items as $item) {
                     $comment = new Comment($item['comment_id'], $item['post_id'], $item['comment_body'], $item['comment_author'], $item['comment_created_at']);
                     $avatar = $avatars[array_rand($avatars)];
                  ?>
                     <hr>
                     <div class="comment mb-1">
                        <div class="row align-items-center">
                           <div class="col-auto">

                              <!-- Avatar -->
                              <a class="avatar" href="#">
                                 <img src="assets/images/avatars/<?= $avatar ?>" alt="..." class="avatar-img rounded-circle">
                              </a>

                           </div>
                           <div class="col ms-n2">

                              <!-- Body -->
                              <div class="comment-body bg-light">

                                 <div class="row">
                                    <div class="col">

                                       <!-- Author -->
                                       <h5 class="comment-title">
                                          <?= $comment->getAuthor() ?>
                                       </h5>

                                    </div>
                                    <div class="col-auto">

                                       <!-- Time -->
                                       <time class="comment-time">
                                          <?= $comment->getCreatedAt() ?>
                                       </time>

                                    </div>
                                 </div> <!-- / .row -->

                                 <!-- Text -->
                                 <p class="comment-text">
                                    <?= $comment->getBody() ?>
                                 </p>

                              </div>

                           </div>
                        </div> <!-- / .row -->
                     </div>
                  <?php } ?>
               </div>



               <!-- Form -->
               <div class="row m-3 align-items-center">
                  <hr>
                  <div class="col-auto">

                     <!-- Avatar -->
                     <div class="avatar avatar-sm">
                        <img src="assets/images/avatars/avatar_dog.jpg" alt="..." class="avatar-img rounded-circle">
                     </div>

                  </div>
                  <div class="col ms-n2">

                     <!-- Input -->
                     <form method="post" action="api/addComment.php?id=<?= $post->getId() ?>" class="mt-1 row">
                        <label class="visually-hidden">Laissez un commentaire...</label>
                        <textarea class="form-control form-control-flush" name="comment_body" data-bs-toggle="autosize" rows="1" placeholder="Laissez un commentaire..." required></textarea>
                        <input type="text" class="form-control" name="comment_author" placeholder="Auteur" required>
                  </div>
                  <div class="col-auto align-self-center">

                     <!-- Icons -->
                     <button type="submit" class="btn btn-rounded btn-primary">
                        Envoyer <i class="fa-solid fa-paper-plane"></i>
                     </button>

                  </div>
                  </form>
               </div> <!-- / .row -->

            </div>
         </div>
         </div>
      </section>
   </body>

<?php }
include_once 'includes/foot.php'; ?>