<title>Galerie - Welcome</title>
<?php
include_once("includes/head.php");
?>
<!-- Body -->
<?php
include_once 'includes/db.php';
include_once 'includes/Post.php';
// DIDNT HAVE TIME TO REALY MAKE IT FULLY DYNAMIC, IT NEEDS A LOT MORE WORK BUT IT WORKS FOR NOW :)
// PAGINATION SETTINGS
$limit = 2;
$page = 1;
$db = connectDB();
$stmt = $db->prepare("SELECT * FROM posts");
$stmt->execute();
$rows = count($stmt->fetchAll());
$pages = ceil($rows / $limit);
if (isset($_GET['page'])) {
   $page = $_GET['page'];
}
$offset = ($page - 1) * $limit;

// ROWS SETTINGS
$search = "";
$sort = 'ASC';
$sortby = 'post_created_at';
$q = "";
// SEARCH SETTINGS
if (isset($_GET['q'])) {
   $q = $_GET['q'];
   $search = " WHERE post_title LIKE '%" . $_GET['q'] . "%'";
}
// SORT SETTINGS
if (isset($_GET['sortby'])) {
   if ($_GET['sortby'] == 'title') {
      $sortby = 'post_title';
   } else if ($_GET['sortby'] == 'author') {
      $sortby = 'post_author';
   } else if ($_GET['sortby'] == 'date') {
      $sortby = 'post_created_at';
   }
}
if (isset($_GET['sort'])) {
   $sort = $_GET['sort'];
}
// AVATARS FOR RANDOMIZING THE AVATAR BELLOW
$avatars = array('avatar_dog.jpg', 'avatar_female.jpg', 'avatar_male.jpg');
// ACTUAL POSTS DATA
$stmt = $db->prepare("SELECT * FROM posts" . $search . " ORDER BY $sortby $sort LIMIT $limit OFFSET $offset");
$stmt->execute();
$items = $stmt->fetchAll();
?>

<body class="">
   <!-- NAVBAR -->
   <?php include_once 'includes/nav.php' ?>
   <!-- CONTENT -->
   <div class="content container">
      <hr>
      <!-- SETTINGS -->
      <!-- SEARCH -->
      <form action="" method="get" class="d-flex gap-2">
         <input type="text" class="form-control" placeholder="Rechercher..." name="q" value="<?= $q ?>">
         <button type="submit" class="btn btn-primary rounded"><i class="fa-solid fa-magnifying-glass"></i></button>
      </form>
      <hr>
      <!-- FILTRES -->
      <div class="buttons d-flex justify-content-between my-4">
         <!-- FILTER BY -->
         <?php if ($items) { ?>
            <div class="filtrer d-flex align-items-center gap-4">
               <h4 class="m-0">
                  Filtrer par:
               </h4>
               <div class="dropdown me-2">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     Filtrer par
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                     <a href="?sortby=title&sort=ASC" class="dropdown-item border-bottom border-gray-500">
                        Titre A-Z &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <i class="fa-solid fa-arrow-down-a-z"></i>
                     </a>
                     <a href="?sortby=title&sort=DESC" class="dropdown-item border-bottom border-gray-500">
                        Titre Z-A &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-arrow-up-z-a"></i>
                     </a>
                     <a href="?sortby=author&sort=ASC" class="dropdown-item border-bottom border-gray-500">
                        Auteur A-Z &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <i class="fa-solid fa-arrow-down-a-z"></i>
                     </a>
                     <a href="?sortby=author&sort=DESC" class="dropdown-item border-bottom border-gray-500">
                        Auteur Z-A &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <i class="fa-solid fa-arrow-up-z-a"></i>
                     </a>
                     <a href="?sortby=date&sort=ASC" class="dropdown-item border-bottom border-gray-500">
                        Plus ancien &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     </a>
                     <a href="?sortby=date&sort=DESC" class="dropdown-item border-bottom border-gray-500">
                        Plus récent &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     </a>
                  </div>
               </div>
            </div>
         <?php } ?>
         <!-- ADD NEW POST -->
         <a href="newPost.php" class="btn btn-success fw-bold align-items-center"><i class="fa-sharp fa-solid fa-plus"></i>&nbsp;&nbsp; Ajouter Une Image</a>
      </div>
      <!-- CONTENT SECTION -->
      <section class="posts container">
         <div class="row text-center justify-content-center w-100 gap-1 p-0 m-0">
            <!-- PHP POSTS LOOP -->
            <?php
            foreach ($items as $item) {
               $post = new Post($item['post_id'], $item['post_filename'], $item['post_title'], $item['post_body'], $item['post_author'], $item['post_created_at'], $item['post_updated_at']);
               $avatar = array_rand($avatars);
            ?><div class="col-xs-12">
                  <div class="card p-0 p-">
                     <img class="card-img-top card-image" src="server/uploads/<?= $post->getImage() ?>" alt="Card image cap">
                     <div class="card-body">
                        <div class="avatar avatar-lg my-2">
                           <img src="assets/images/avatars/<?= $avatars[$avatar] ?>" alt="..." class="avatar-img rounded-circle" height="50">
                        </div>
                        <h5 class="text-gray-500">@<?= $post->getAuthor() ?></h5>
                        <p class="card-text small text-muted">
                           <i class="fa-regular fa-clock"></i> <time datetime="<?= $post->createdAt() ?>"><?= $post->createdAt() ?></time>
                        </p>
                        <h3 class="card-title text-primary"><a href="post.php?id=<?= $post->getId() ?>"><?= $post->getTitle() ?></a></h3>
                        <p class="card-text post__body"><?= $post->getBody() ?></p>
                        <div class="d-md-flex gap-2">
                           <a href="post.php?id=<?= $post->getId() ?>" class="btn btn-primary flex-grow-1">Aller à l'image</a>
                           <a href="server/uploads/<?= $post->getFilename() ?>" class="btn btn-success flex-grow-2" download>Télécharger <i class="fa-solid fa-cloud-arrow-down"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
            <?php } ?>
            <!-- /PHP POSTS LOOP -->
            <!-- PAGINATION -->
            <?php if ($items) { ?>
               <div class="d-flex justify-content-end">
                  <ul class="pagination justify-self-end">
                     <li class="page-item <?= ($page == 1) ?  "disabled" : "" ?>"><a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a></li>
                     <?php for ($i = 1; $i <= $pages; $i += 1) { ?>
                        <li class="page-item <?= ($i == $page) ?  "active" : "" ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                     <?php } ?>
                     <li class="page-item <?= ($page == $pages) ?  "disabled" : "" ?>"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
                  </ul>
               </div>
            <?php } ?>
            <!-- /PAGINATION -->
         </div>
      </section>
      <!-- /CONTENT SECTION -->
   </div>
</body>




<?php
include_once("includes/foot.php");
?>