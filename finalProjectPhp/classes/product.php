<?php



require_once('connection.php');


class product 
{





    private $productid = "";
    private $productcode = "";
    private $description = "";
    private $retailprice = "";


    public function getProductID()
    {
        return $this->productid;
    }
    public function setProductID($newProductID)
    {
  
            $this->productid = $newProductID;
        
    }
    public function getProductCode()
    {
        return $this->productcode;
    }
    public function setProductCode($newProductCode)
    {

                $this->productcode = $newProductCode;
        
    }

    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($newDescription)
    {
    
            $this->description = $newDescription;
    
    }

    public function getRetailPrice()
    {
        return $this->retailprice;
    }
    
    public function setRetailPrice($newRetailPrice)
    {
      
                    $this->retailprice = $newRetailPrice;

    }

  
   


  

    public function __construct($productcode="", $description="", $retailprice="",$productid="")
    {
        $this->setProductCode($productcode);
        $this->setDescription($description);
        $this->setRetailPrice($retailprice);
        $this->setProductID($productid);
            
            
            
        
        
    }


    public function load($productid)
    {
       
        


        try {
            
        
            $servername='127.0.0.1';
 $conn = new PDO("mysql:host=$servername;dbname=database_2111667", 'root', 'kamal');
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
  $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);//sql injection protection

            
            $sql = "CALL select_product(:productid)";
            $PDOObject = $conn->prepare($sql);
    
            $PDOObject->bindParam(':productid',$productid);
            $PDOObject->execute();
            if ($row = $PDOObject->fetch(PDO::FETCH_ASSOC)) {
                $this->productcode = $row["productcode"];
                $this->description = $row["description"];
                $this->retailprice = $row["retailprice"];
                $this->productid = $row["productid"];
                
                
    
                return ;
                }
        
            }
           catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
          }

        
    }




    public function save()
    {
        global $connection;
        if($this->productid == "")
        {
            
           

            try {
            
        
                $sql = "CALL save_product(:productcode, :description, :retailprice )";
                $PDOObject = $connection->prepare($sql);
    
                $PDOObject->bindParam(':productcode', $this->productcode);
                $PDOObject->bindParam(':description', $this->description);
                $PDOObject->bindParam(':retailprice', $this->retailprice);
               
                $PDOObject->execute();
    
                return true;
            
                }
               catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
              }
        }
        else
        {

           try {
               
            $sql = "CALL update_product(:productcode, :description, :retailprice, :productid)";
             $PDOObject = $connection->prepare($sql);
             $PDOObject->bindParam(':productid', $this->productid);
             $PDOObject->bindParam(':productcode', $this->productcode);
             $PDOObject->bindParam(':description', $this->description);
             $PDOObject->bindParam(':retailprice', $this->retailprice);
        $PDOObject->execute();
       
            
            echo $PDOObject->rowCount() . " records UPDATED successfully";
            
            echo "New record created successfully";
            return ;
          } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
          }




      

            
        }
    }

   
    public function delete()
    {
        global $connection;

        if($this->productid != "")
        {
            
            
         

            

            try {
                // $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
       
                // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           
                 $sql = "CALL delete_product(:productid)";
                 $PDOObject = $connection->prepare($sql);
                 
                 $PDOObject->bindParam(':productid', $this->productid);
                 $PDOObject->execute();
                 
     
                
                 echo "Record deleted successfully";
                 return ;
               } catch(PDOException $e) {
                 echo $sql . "<br>" . $e->getMessage();
               }
        }
    }

}

?>