<?php
class Image
{
   private $filename;
   private $title;

   public function __construct($filename, $title)
   {
      $this->filename = $filename;
      $this->title = $title;
   }

   public function getImage()
   {
      return strval($this->filename);
   }

   public function getTitle()
   {
      return strval($this->title);
   }
   public function getFilename()
   {
      return strval($this->filename);
   }
}
