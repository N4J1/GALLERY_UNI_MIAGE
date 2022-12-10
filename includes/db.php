<?php
// CONNECTION
function connectDB()
{
   // CONSTANTS
   $host =  '127.0.0.1';
   $user = 'root';
   $password = '';
   $dbname = 'galerie';

   // DSN
   $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
   try {
      $db = new PDO($dsn, $user, $password);
      $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
   } catch (PDOException $e) {
      echo "Error!: " . $e->getMessage();
   }
   return $db;
}
