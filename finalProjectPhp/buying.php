<?php if (isset($_POST["login"])) {
    session_start();

    // DEVELOPER                      DATE                        COMMENTS
    // Kamaldeep Singh          2022-03-06                constant creationstarted validation with htmlspecial chars
    // Kamaldeep Singh          2022-03-7                completed validation and started file read and append 
    // Kamaldeep Singh          2022-03-8                completed file apend added css to  form 



    header('Expires: Sat, 03 Dec 1994 16:00:00 GMT');
    header('Cache-Control: no-cache');
    header('Pragma: no-cache');
    header('Content-type: text/html; charset=UTF-8');

    // List of constants

    define("CUSTOMER_FIRSTNAME_MAX_LENGTH", 15);
    define("PRODUCT_CODE_MAX_LENGTH", 12);
    define("CUSTOMER_LASTNAME_MAX_LENGTH", 20);
    define("CUSTOMER_CITY_MAX_LENGTH", 8);
    define("COMMENTS_MAX_LENGTH", 200);
    define("MAX_PRICE", 10000.00);
    define("MAX_QUANTITY", 99);
    define("MIN_QUANTITY", 1);
    define("LOCALTAX", 0.1345);



    //include once used to avoid repetitive function occurance if possible 
    include_once("CommonFunctions/commonFunctions.php");

    include_once("./classes/product.php");
    include_once("./classes/order.php");
    include_once("./classes/products.php");
    include_once("./classes/customer.php");

    Top("buying");

    //variables to store post form data
    $Productid =  $Comments = "";
    $Price = 0;
    $Quantity = 0;
    $orders = 0;
    $tax = 0;
    $grandTotal = 0;
    $subTotal = 0;

    $Error_ProductCode = $Error_CfirstName = $Error_ClastName = $Error_City = $Error_Comment = $Error_Price = $Error_Quantity = $subTotal = "";



    function test_input($data) //to prevent java script injection and other glitches
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // set flag if  error Occured 
    $errorflag = false;

    // if condition to validate if server method is post and submit button pressed to clear input feilds 

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

        // $temp=$_POST["Product_Code"];

        // product code validation using mb_strlen for utf8

        $currentproduct = new Product();
        $currentorder = new Order();
        $currentcustomer = new Customer();





        //validating firstname
        if (!(is_numeric($_POST["Quantity"]))) {
            $errorflag = true;
            $Error_Quantity  = "The Quantity must be a Number";
        } else 
    if (mb_strpos($_POST["Quantity"], ".") || mb_strpos($_POST["Quantity"], ",")) {
            $errorflag = true;
            $Error_Quantity  = "The Quantity cannot be decimal";
        } else 
        if ($_POST["Quantity"] < MIN_QUANTITY || $_POST["Quantity"] > MAX_QUANTITY) {
            $errorflag = true;
            $Error_Quantity  = "Quantity not valid Quantity must be between " . MIN_QUANTITY . " and " . MAX_QUANTITY;
        } else {
            $Quantity = test_input($_POST["Quantity"]);
            $currentorder->setQuantity($Quantity);
        }



        //if all error are false means no error 

        if ($errorflag == false) {
            $username = $_SESSION['login'];
            var_dump($_POST["Productid"]);


            $currentcustomer->setUsername($username);
            $currentcustomer->Load_Customer_data_by_username($username);
            $cid = $currentcustomer->getCustomerID();
            var_dump($cid);

            $currentorder->setCustomerID($cid);
            $pid = $_POST["Productid"];

            $currentproduct->setProductID($_POST["Productid"]);
            var_dump($currentproduct->getProductID());
            $currentproduct->load($pid);
            var_dump($currentproduct->getDescription());
            $Price = $currentproduct->getRetailPrice();
            // var_dump($_POST["Productid"]);

            var_dump($Quantity);

            $currentorder->setProductID($currentproduct->getProductID());
            $currentorder->setSoldPrice($currentproduct->getRetailPrice());
            $currentorder->setQuantity($Quantity);
            $Price = $currentproduct->getRetailPrice();


            $p = intval($Price);
            $q = intval($Quantity);

            $subTotal = $p * $q;
            $tax = ($subTotal * LOCALTAX);    //LOCALTAX=.1345
            $grandTotal = $subTotal + $tax;
            //rounding up using round function upto 2 decimal places
            $grandTotal = round($grandTotal, 2);
            $currentorder->setQuantity($Quantity);
            $currentorder->settax($tax);
            $currentorder->setsubtotal($subTotal);
            $currentorder->setgrandtotal($grandTotal);

            $currentorder->save();


            echo "<script>alert('item bought');</script>";
        }
    }



?>

    <div class="form">
        <p>Divine laptops </p>
        <p>Fill the form please </p>




        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div>
                <table>

                    <tr>
                        <td>Product Code :</td>
                        <td><select name="Productid">
                                <?php

                                // $servername='127.0.0.1';

                                // $conn = new PDO("mysql:host=$servername;dbname=database_2111667", 'root', 'kamal');
                                // // set the PDO error mode to exception
                                // $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                                // // echo "Connected successfully";
                                // $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

                                $products = new products();

                                foreach ($products->items as $product) {

                                    echo "<option value=" . $product->getProductID() . ">" . $product->getProductCode() . "_ " . $product->getDescription() . "_ " . $product->getRetailPrice() . " </option>";
                                }
                                //
                                //            
                                ?>
                            </select>
                            <span class="error">* <?php echo $Error_ProductCode; ?></span>
                        </td>
                    </tr>

                    <tr>
                        <td>comments:</td>
                        <td><input type="text" name="Comments" id="" value="<?php echo $Comments; ?>" placeholder="Commentss....">
                            <span class="error"><?php echo $Error_Comment; ?></span>
                        </td>
                    </tr>

                    <tr>
                        <td>Quantity:</td>
                        <td><input type="text" name="Quantity" id="" value="<?php echo $Quantity; ?>" placeholder="Enter Quantity">
                            <span class="error">*<?php echo $Error_Quantity; ?></span>
                        </td>
                    </tr>



                </table>
                <div>
                    <input type="submit" name="submit" value="Submit" />
                    <input type="reset" value="Clear all fields" />

                </div>
        </form>
    <?php
    Bottom();
} else {
    header("location:userlogin.php");
}
    ?>