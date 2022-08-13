<?php


require_once('connection.php');
require_once('order.php');
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


        $sql = "select * from orders";

        $PDOObject = $conn->prepare($sql);

        $PDOObject->execute();

        while ($row = $PDOObject->fetch(PDO::FETCH_ASSOC)) 
        {
            $order = new order($row["quantity"],$row["soldprice"],$row["comment"],$row["customerid"],$row["subtotal"],$row["tax"],$row["grandtotal"]);
            $this->add($row["productid"], $order);
            // $items[$row["productid"]] = $product;
 
        }
    }

}
?>
 

