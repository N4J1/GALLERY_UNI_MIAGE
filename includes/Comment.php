<?php
class Comment
{
   private $id;
   private $post_id;
   private $body;
   private $author;
   private $created_at;
   public function getId()
   {
      return $this->id;
   }
   public function getPostId()
   {
      return $this->post_id;
   }
   public function getBody()
   {
      return $this->body;
   }
   public function getAuthor()
   {
      return $this->author;
   }
   public function getCreatedAt()
   {
      $valid_date = date('d/m/y g:i A', strtotime($this->created_at));
      return strval($valid_date);
   }
   public function __construct($id, $post_id, $body, $author, $created_at)
   {
      $this->id = $id;
      $this->post_id = $post_id;
      $this->body = $body;
      $this->author = $author;
      $this->created_at = $created_at;
   }
   public function createNew($db)
   {
      $stmt = $db->prepare("INSERT INTO comments (post_id, comment_body, comment_author) VALUES (?, ?, ?)");
      $res = $stmt->execute([$this->getPostId(), $this->getBody(), $this->getAuthor()]);
      return $res;
   }
}
