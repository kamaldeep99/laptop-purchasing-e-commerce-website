<?php


require_once('connection.php');
require_once('product.php');
require_once('collection.php');


// $items = array();

class products extends collection
{
    function __construct()
    {
        global $connection;

        $servername='127.0.0.1';
 $conn = new PDO("mysql:host=$servername;dbname=database_2111667", 'root', 'kamal');

$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
  $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);


        $sql = "select * from products";

        $PDOObject = $conn->prepare($sql);

        $PDOObject->execute();

        while ($row = $PDOObject->fetch(PDO::FETCH_ASSOC)) 
        {
            $product = new product($row["productcode"],$row["description"],$row["retailprice"],$row["productid"]);
            $this->add($row["productid"], $product);
            // $items[$row["productid"]] = $product;
 
        }
    }

}
?>
 

