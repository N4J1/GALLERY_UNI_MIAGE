<?php
include_once 'includes\Image.php';
class Post extends Image
{
   private $body;
   private $author;
   private $comments;
   private $created_at;
   private $updated_at;
   private $id;

   public function __construct($id, $filename, $title, $body, $author, $created_at, $updated_at)
   {
      parent::__construct($filename, $title);
      $this->body = $body;
      $this->author = $author;
      $this->created_at = $created_at;
      $this->updated_at = $updated_at;
      $this->id = $id;
   }

   public function getBody()
   {
      return strval($this->body);
   }
   public function getAuthor()
   {
      return strval($this->author);
   }
   public function getComments($db)
   {
      $stmt = $db->prepare("SELECT * FROM comments WHERE post_id=? ORDER BY comment_created_at DESC");
      $stmt->execute([$this->id]);
      $this->comments = $stmt->fetchAll();
      return $this->comments;
   }
   public function createdAt()
   {
      $valid_date = date('d/m/y g:i A', strtotime($this->created_at));
      return strval($valid_date);
   }
   public function updatedAt()
   {
      $valid_date = date('d/m/y g:i A', strtotime($this->updated_at));
      return strval($valid_date);
   }
   public function getId()
   {
      return $this->id;
   }
   public function createNew($db)
   {
      $stmt = $db->prepare("INSERT INTO posts (post_filename, post_title, post_body, post_author) VALUES (?, ?, ?, ?)");
      $res = $stmt->execute([$this->getFilename(), $this->getTitle(), $this->getBody(), $this->getAuthor()]);
      return $res;
   }
}
