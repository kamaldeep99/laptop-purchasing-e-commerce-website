




<?php


try {
  
  $servername='127.0.0.1';
  $dbName='database_2111667';
  $user='root';



  $connection = new PDO("mysql:host=$servername;dbname=$dbName", 'root', 'kamal');

  $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
  $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>








