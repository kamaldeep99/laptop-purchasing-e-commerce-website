<?php


require_once('connection.php');


class order 
{
    



    private $orderid = "";
    private $customerid = "";
    private $productid = "";
    private $quantity = "";
    private $soldprice = "";
    private $comment = "";
    private $tax="";
    private $subtotal="";
    private $grandtotal="";
    


    public function getOrderID()
    {
        return $this->orderid;
    }
    public function setOrderID($newOrderID)
    {

            $this->orderid = $newOrderID;
    
    }
    public function getCustomerID()
    {
        return $this->customerid;
    }
    public function setCustomerID($newCustomerID)
    {

            $this->customerid = $newCustomerID;
        
    }
    public function getProductID()
    {
        return $this->productid;
    }
    public function setProductID($newProductID)
    {
 
            $this->productid = $newProductID;
        
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function setQuantity($newQuantity)
    {


                    $this->quantity = $newQuantity;

    
    }

    public function getSoldPrice()
    {
        return $this->soldprice;
    }
    public function setSoldPrice($newSoldPrice)
    {

                $this->soldprice = $newSoldPrice;
        
    }
    
    

    public function getsubtotal()
    {
        return $this->getQuantity()*$this->getSoldPrice();
    }
    public function setsubtotal()
    {
        $this->subtotal=$this->getQuantity()*$this->getSoldPrice();
    }
    public function gettax()
    {
        return $this->getsubtotal()*.1375;
    }
    public function settax()
    {
        $this->tax= $this->getsubtotal()*.1375;
    }
    
    public function getgrandtotal()
    {
        return $this->gettax()+$this->getsubtotal();
    }
    public function setgrandtotal($newgrandtotal)
    {
        $this-> grandtotal= $this->gettax()+$this->getsubtotal();
    }
    public function getComment()
    {
        return $this->comment;
    }
    public function setComment($newComment)
    {
        if(mb_strlen($newComment) > 200)
        {
            return "The comment must be less than 200 characters";
        }
        else
        {
            $this->comment = $newComment;
        }
    }

   

    public function __construct($quantity="", $soldprice="", $comment="",$orderid="", $customerid="", $productid="", $tax="",$subtotal="",$grandtotal="")
    {

        if($orderid != "")
        {   $this->setQuantity($quantity);
            $this->setSoldPrice($soldprice);
            $this->setComment($comment);
            $this->setOrderID($orderid);
            $this->setCustomerID($customerid);
            $this->setProductID($productid);
            $this->settax($tax);
            $this->setsubtotal($subtotal);
            $this->setgrandtotal($grandtotal);
        }
        
    }

    public function load($orderid)
    {
        global $connection;
        
        $sql = "CALL select_order (:orderid)";

        $PDOObject = $connection->prepare($sql);

        $PDOObject->bindParam(':orderid',$orderid);
        $PDOObject->execute();

        if ($row = $PDOObject->fetch(PDO::FETCH_ASSOC)) {
            $this->quantity = $row["quantity"];
            $this->soldprice = $row["soldprice"];
            $this->comment = $row["comment"];
            $this->orderid = $row["orderid"];
            $this->customerid = $row["customerid"];
            $this->tax = $row["tax"];
            $this->subtotal = $row["subtotal"];
            $this->grandtotal = $row["grandtotal"];
           
 
            return true;
        }
    }

   

    public function save()
    {
        global $connection;
        if($this->orderid == "")
        {

            $sql = "CALL save_order(:quantity, :soldprice,:comment,:customerid, :productid,:subtotal=0,:tax,:grandtotal)";
            $PDOObject = $connection->prepare($sql);
            $PDOObject->bindParam(':quantity', $this->quantity);
            $PDOObject->bindParam(':soldprice', $this->soldprice);
            $PDOObject->bindParam(':comment', $this->comment);
            $PDOObject->bindParam(':customerid', $this->customerid);
            $PDOObject->bindParam(':productid', $this->productid);

            $PDOObject->bindParam(':tax', $this->tax);
            $PDOObject->bindParam(':subtotal', $this->subtotal);
            $PDOObject->bindParam(':grandtotal', $this->grandtotal);


            $PDOObject->execute();

            return true;
        }
        else
        {
            
            
            $sql = "CALL update_order(:quantity, :soldprice, :comment,:orderid,:customerid, :productid )";
            $PDOObject = $connection->prepare($sql);
            $PDOObject->bindParam(':quantity', $this->quantity);
            $PDOObject->bindParam(':soldprice', $this->soldprice);
            $PDOObject->bindParam(':comment', $this->comment);
            $PDOObject->bindParam(':orderid', $this->orderid);
            $PDOObject->bindParam(':customerid', $this->customerid);
            $PDOObject->bindParam(':productid', $this->productid);
           
            $PDOObject->execute();

            return true;

            
        }
    }


    public function delete()
    {
        global $connection;

        if($this->orderid != "")
        {
           
           
            
            
            try {
                
                 $sql = "CALL order_delete(:orderid)";
                 $PDOObject = $connection->prepare($sql);
                 
                 $PDOObject->bindParam(':orderid', $this->orderid);
                 $PDOObject->execute();
            
                 return ;
               } catch(PDOException $e) {
                 echo $sql . "<br>" . $e->getMessage();
               }
        }
    }        


}
?>