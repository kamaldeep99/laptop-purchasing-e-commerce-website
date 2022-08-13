<?php
session_start();

// DEVELOPER                      DATE                        COMMENTS
// Kamaldeep Singh          2022-03-06               Create ad style table

// Kamaldeep Singh          2022-03-8                change bg color and opacity
// Kamaldeep Singh          2022-04-23                started working and finished the order page
// Kamaldeep Singh          2022-04-25                started working on delete buttomn functionality
if (isset($_SESSION['login'])) {
    header('Expires: Sat, 03 Dec 1994 16:00:00 GMT');
    header('Cache-Control: no-cache');
    header('Pragma: no-cache');
    header('Content-type: text/html; charset=UTF-8');

    include("CommonFunctions/commonFunctions.php");

    Top("order");
    echo "<br>";



    include_once('classes/order.php');
    include_once('classes/product.php');
    include_once('classes/customer.php');
    //var_dump($_POST["deletebutton"]);

    if (isset($_POST["deletebutton"])) {

        //checkogmng if press the delete buttonwhich carry orderid as value 
        $servername = "127.0.0.1";

        //creating connection
        // $conn = new PDO("mysql:host=$servername;dbname=",);
        // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        // echo"connection succesful";
        $conn = new PDO("mysql:host=$servername;dbname=database_2111667", 'root', 'kamal');

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "CALL delete_order (:deleteid )";
        $PDOObject = $conn->prepare($sql);

        $PDOObject->bindParam(':deleteid', $_POST['deletebutton']);

        $PDOObject->execute();


        echo "<script>alert('order id" . $_POST["deletebutton"]    . " has been deleted succesfully');</script>";
    }


    if (isset($_POST["submit"])) {

        // submitting form and creating customer object to get parameters
        $currentcustomer = new customer();


        $username = $_SESSION['login'];
        $currentcustomer->setUsername($username);
        $currentcustomer->Load_Customer_data_by_username($username);





        $date = ($_POST["orderdate"]);
        echo $_POST["orderdate"];

        $servername = "127.0.0.1";

        //creating connection
        // $conn = new PDO("mysql:host=$servername;dbname=",);
        // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        // echo"connection succesful";
        $conn = new PDO("mysql:host=$servername;dbname=database_2111667", 'root', 'kamal');

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);








        $sql = "CALL selectorderby_date_username(:username,:dates)"; //getching data according to username of customer which was stored in session variable
        $PDOObject = $conn->prepare($sql);
        var_dump($_POST['orderdate']);
        $PDOObject->bindParam(':username', $username); //parameter binding to prevent sql injectiomn
        $PDOObject->bindParam(':dates', $_POST['orderdate']);
        $PDOObject->execute();
        // use exec() because no results are returned

        echo "Connected successfully";

        $count = $PDOObject->rowCount();
        var_dump($count);

        //$num=mysqli_fetch_array($query);
        if ($count > 0) {
?><p><a href="orders/cheatsheet.docx
">Cheatsheet link</a></p>
            <table class="ordertable">
                <tr>
                    <th>Delete</th>
                    <th>Product ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>City</th>
                    <th>Comments</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Taxes</th>
                    <th>Grand Total</th>
                </tr>
                <tr><?php
                    while ($row = $PDOObject->fetch(PDO::FETCH_ASSOC)) { ?>


                        <td>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"><input type="submit" name="deletebutton" value=<?php echo $row["orderid"]; ?>></form>
                        </td>

                        <td><?php echo $row["productid"]; ?></td>
                        <td><?php echo $row["firstname"]; ?></td>
                        <td><?php echo $row["lastname"]; ?></td>
                        <td><?php echo $row["city"]; ?></td>
                        <td><?php echo $row["comment"]; ?></td>
                        <td><?php echo $row["retailprice"]; ?></td>
                        <td><?php echo $row["quantity"]; ?></td>
                        <td><?php echo $row["subtotal"]; ?></td>
                        <td><?php echo $row["tax"]; ?></td>
                        <td><?php echo $row["grandtotal"]; ?></td>





                </tr>
        <?php }


                    echo "<script>alert('order present');</script>";
                } else {
                    echo "<script>alert('order not  present');</script>";



                    exit();
                }





        ?>






    <?php } ?>






    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"><input type="date" name="orderdate">
        <input type="submit" value="searchdate" name="submit">
    </form>
    <a href=" orders/cheatsheet.docx " class="navitem">Order</a>



<?php
    Bottom();
} else {
    header("location:userlogin.php");
}
?>