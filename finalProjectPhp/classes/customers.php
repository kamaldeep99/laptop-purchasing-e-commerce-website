<?php


require_once('connection.php');
require_once('customer.php');
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


        $sql = "select * from customers";

        $PDOObject = $conn->prepare($sql);

        $PDOObject->execute();

        while ($row = $PDOObject->fetch(PDO::FETCH_ASSOC)) 
        {
            $customer= new customer($row["customerid"],$row["firstname"],$row["lastname"],$row["address"],$row["city"],$row["postalcode"],$row["province"],$row["username"],$row["password"],$row["picture"]);
            $this->add($row["productid"], $customer);
            // $items[$row["productid"]] = $product;
 
        }
    }

}
?>
 

