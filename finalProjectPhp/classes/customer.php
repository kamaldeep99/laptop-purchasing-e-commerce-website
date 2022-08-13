

<?php


require_once('connection.php');




class Customer
{


    private $FirstName = "";
    private $LastName = "";
    private $Province  = "";
    private $Address = "";
    private $City   = "";
    private $CustomerID = "";
    private $Postal_code   = "";
    private $Pic   = "";
    private $Username   = "";
    private $Pass   = "";



    public function getCustomerID()
    {
        return $this->CustomerID;
    }
    public function setCustomerID($cid)
    {

        $this->CustomerID = $cid;
    }
    public function getFirstName()
    {
        return $this->FirstName;
    }
    public function setFirstName($fname)
    {

        $this->FirstName = $fname;
    }

    public function getLastName()
    {
        return $this->LastName;
    }
    public function setLastName($lname)
    {

        $this->LastName = $lname;
    }
    public function getAddress()
    {
        return $this->Address;
    }
    public function setAddress($add)
    {

        $this->Address = $add;
    }

    public function getCity()
    {
        return $this->City;
    }

    public function setCity($city)
    {

        $this->City = $city;
    }


    public function getPostalCode()
    {
        return $this->Postal_code;
    }

    public function setPostalCode($pc)
    {

        $this->Postal_code = $pc;
    }
    public function getProvince()
    {
        return $this->Province;
    }

    public function setProvince($p)
    {

        $this->Province = $p;
    }

    public function getUsername()
    {
        return $this->Username;
    }
    public function setUsername($newUsername)
    {

        $this->Username = $newUsername;
    }
    public function getPass()
    {
        return $this->Pass;
    }
    public function setPass($Pass)
    {

        $this->Pass = $Pass;
    }

    public function getPic()
    {
        return $this->Pic;
    }
    public function setPic($Pic)
    {
        $this->Pic = $Pic;
    }
























    public function __construct($CustomerID = "", $FirstName = "", $LastName = "", $Address = "", $City = "", $Postal_code = "", $Province = "", $Username = "", $Pass = "", $Pic = "")
    {
        if ($CustomerID != "") {
            $this->setCustomerID($CustomerID);
            $this->setFirstName($FirstName);
            $this->setLastName($LastName);
            $this->setAddress($Address);
            $this->setCity($City);
            $this->setPostalCode($Postal_code);
            $this->setProvince($Province);
            $this->setUsername($Username);
            $this->setPass($Pass);
            $this->setPic($Pic);
        }
    }


    public function load($CustomerID)
    {


        try {
            global $connection;

            $sql = "CALL select_customer(:CustomerID)";


            $PDOObject = $connection->prepare($sql);

            $PDOObject->bindParam(':CustomerID', $CustomerID);
            $PDOObject->execute();


            if ($row = $PDOObject->fetch(PDO::FETCH_ASSOC)) {

                $this->CustomerID = $row["customerid"];
                $this->FirstName = $row["firstname"];
                $this->LastName = $row["lastname"];
                $this->Address = $row["address"];
                $this->City = $row["city"];
                $this->Province = $row["province"];
                $this->Postal_code = $row["postalcode"];
                $this->Username = $row["username"];
                $this->Pass = $row["password"];
                $this->Pic = $row["picture"];




                return;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function Load_Customer_data_by_username($username)
    {


        try {
            global $connection;

            $sql = "select * from customers where username=:username";


            $PDOObject = $connection->prepare($sql);

            $PDOObject->bindParam(':username', $username);
            $PDOObject->execute();


            if ($row = $PDOObject->fetch(PDO::FETCH_ASSOC)) {

                $this->CustomerID = $row["customerid"];
                $this->FirstName = $row["firstname"];
                $this->LastName = $row["lastname"];
                $this->Address = $row["address"];
                $this->City = $row["city"];
                $this->Province = $row["province"];
                $this->Postal_code = $row["postalcode"];
                $this->Username = $row["username"];
                $this->Pass = $row["password"];
                $this->Pic = $row["picture"];


                return;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    public function saveCustomer()
    {
        global $connection;

        if ($this->CustomerID == "") {


            try {

                $sql = "CALL save_customer (:FirstName, :LastName, :Address, :City, :Postalcode,:Province, :Username, :Pass, :Pic)";
                $PDOObject = $connection->prepare($sql);
                $PDOObject->bindParam(':FirstName', $this->FirstName);
                $PDOObject->bindParam(':LastName', $this->LastName);
                $PDOObject->bindParam(':Address', $this->Address);
                $PDOObject->bindParam(':City', $this->City);
                $PDOObject->bindParam(':Province', $this->Province);
                $PDOObject->bindParam(':Postalcode', $this->Postal_code);
                $PDOObject->bindParam(':Username', $this->Username);
                $PDOObject->bindParam(':Pass', $this->Pass);
                $PDOObject->bindParam(':Pic', $this->Pic);
                $PDOObject->execute();

                $PDOObject = $connection->prepare($sql);
                echo "New record created successfully";
            } catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }







            return true;
        } else {

            try {


                $sql = "CALL update_customer(:FirstName, :LastName, :Address, :City, :Postal_code,:Province, :Username, :Pass, :Pic,:CustomerID)";
                $PDOObject = $connection->prepare($sql);
                $PDOObject->bindParam(':FirstName', $this->FirstName);
                $PDOObject->bindParam(':LastName', $this->LastName);
                $PDOObject->bindParam(':Address', $this->Address);
                $PDOObject->bindParam(':City', $this->City);
                $PDOObject->bindParam(':Province', $this->Province);
                $PDOObject->bindParam(':Postal_code', $this->Postal_code);
                $PDOObject->bindParam(':Username', $this->Username);
                $PDOObject->bindParam(':Pass', $this->Pass);
                $PDOObject->bindParam(':Pic', $this->Pic);
                $PDOObject->bindParam(':CustomerID', $this->CustomerID);
                $PDOObject->execute();




                echo "New record created successfully";
            } catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }




            return true;
        }
    }


    public function delete()
    {
        global $connection;

        if ($this->CustomerID != "") {





            try {






                $sql = "CALL delete_customer(:CustomerID)";
                $PDOObject = $connection->prepare($sql);
                $PDOObject->bindParam(':CustomerID', $this->CustomerID);


                $PDOObject->execute();
                echo "Record deleted successfully";
            } catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
        }
    }
}

?>