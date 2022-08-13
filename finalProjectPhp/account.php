<?php
session_start();

// DEVELOPER                      DATE                        COMMENTS
// Kamaldeep Singh          2022-03-06                constant creationstarted validation with htmlspecial chars
// Kamaldeep Singh          2022-03-7                completed validation and started file read and append 
// Kamaldeep Singh          2022-03-8                completed file apend added css to  form 
// Kamaldeep Singh          2022-04-24                started working on account

// Kamaldeep Singh          2022-04-25                created dual password verification



header('Expires: Sat, 03 Dec 1994 16:00:00 GMT');
header('Cache-Control: no-cache');
header('Pragma: no-cache');
header('Content-type: text/html; charset=UTF-8');

// List of constants

define("CUSTOMER_FIRSTNAME_MAX_LENGTH", 20);

define("CUSTOMER_LASTNAME_MAX_LENGTH", 20);
define("CUSTOMER_CITY_MAX_LENGTH", 25);
define("USERNAME_MAX_LENGTH", 15);
define("PASSWORD_MAX_LENGTH", 255);
define("POSTALCODE_MAX_LENGTH", 7);

//include once used to avoid repetitive function occurance if possible 
include_once("CommonFunctions/commonFunctions.php");
//include_once("classes/customerclass.php");


Top("account");

//variables to store post form data
$C_firstName = $C_lastName = $City = $Address = $Postalcode = $Username = $Password = $Password1 = $Picture = $Province = "";

$Error_CfirstName = $Error_ClastName = $Error_City = $Error_Address = $Error_Postalcode = $Error_Username = $Error_Province = $Error_Password = $Error_Password1 = $Error_Picture = "";



function test_input($data) //to prevent java script injection and other glitches
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// set flag if  error Occured 
$errorflag = false;

// if condition to validate if server method is post and submit button pressed to clear input fields 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {



    // product code validation using mb_strlen for utf8




    //validating firstname
    if (mb_strlen($_POST["C_firstName"]) == 0) {
        $errorflag = true;
        $Error_CfirstName = "The First Name can't be empty";
    } else if (mb_strlen($_POST["C_firstName"]) > CUSTOMER_FIRSTNAME_MAX_LENGTH) {
        $errorflag = true;
        $Error_CfirstName = "The First Name should not  be longer than " . CUSTOMER_FIRSTNAME_MAX_LENGTH  . " digits";
    } else $C_firstName = test_input($_POST["C_firstName"]);

    //validating lastname
    if (mb_strlen($_POST["C_lastName"]) == 0) {
        $errorflag = true;
        $Error_ClastName  = "The Last Name can't be empty";
    } else if (mb_strlen($_POST["C_lastName"]) > CUSTOMER_LASTNAME_MAX_LENGTH) {
        $errorflag = true;
        $Error_ClastName  = "The Last Name should not longer than " . CUSTOMER_LASTNAME_MAX_LENGTH . " digits";
    } else $C_lastName = test_input($_POST["C_lastName"]);

    //validating city
    if (mb_strlen($_POST["City"]) == 0) {
        $errorflag = true;
        $Error_City = "The City Name can't be empty";
    } else if (mb_strlen($_POST["City"]) > CUSTOMER_CITY_MAX_LENGTH) {
        $errorflag = true;
        $Error_City = "The City Name should not be longer than " . CUSTOMER_CITY_MAX_LENGTH . " digits";
    } else $City = test_input($_POST["City"]);

    if (mb_strlen($_POST["Address"]) == 0) {
        $errorflag = true;
        $Error_Address = "The address  can't be empty";
    } else $Address = test_input($_POST["Address"]);

    if (mb_strlen($_POST["Username"]) == 0) {
        $errorflag = true;
        $Error_Username = "The username Name can't be empty";
    } else if (mb_strlen($_POST["Username"]) > USERNAME_MAX_LENGTH) {
        $errorflag = true;
        $Error_Username = "The username  should not be longer than " . USERNAME_MAX_LENGTH . " digits";
    } else $Username = test_input($_POST["Username"]);
    if (mb_strlen($_POST["Password"]) == 0) {
        $errorflag = true;
        $Error_City = "The Password Name can't be empty";
    } else if (mb_strlen($_POST["Password"]) > PASSWORD_MAX_LENGTH) {
        $errorflag = true;
        $Error_Password = "The Password  should not be longer than " . PASSWORD_MAX_LENGTH . " digits";
    } else $Password = test_input($_POST["Password"]);
    if (isset(($_POST["Password"]))) {
        if (mb_strlen($_POST["Password1"]) == 0) {
            $errorflag = true;
            $Error_Password1 = "The Password Name can't be empty";
        } else if (mb_strlen($_POST["Password1"]) > PASSWORD_MAX_LENGTH) {
            $errorflag = true;
            $Error_Password1 = "The Password  should not be longer than " . PASSWORD_MAX_LENGTH . " digits";
        } else $Password1 = test_input($_POST["Password1"]);
        if ($Password != $Password1) {
            echo "<script>alert('password match exiting sessin and saving data');</script>";
            $Error_Password1 = "paswwordmismatch";
            $Error_Password = "paswwordmismatch";
            $errorflag = true;
        } else {
            echo "<script>alert('password mismatch ');</script>";
        }
    }


    if (mb_strlen($_POST["postalcode"]) == 0) {
        $errorflag = true;
        $Error_PostalCode = "The Postalcode  can't be empty";
    } else if (mb_strlen($_POST["postalcode"]) > POSTALCODE_MAX_LENGTH) {
        $errorflag = true;
        $Error_Postalcode = "The Postalcode Name should not be longer than " . POSTALCODE_MAX_LENGTH . " digits";
    } else $Postalcode = test_input($_POST["postalcode"]);
    if (mb_strlen($_POST["province"]) == 0) {
        $errorflag = true;
        $Error_Province = "The Province can't be empty";
    } else if (mb_strlen($_POST["province"]) > PROVINCE_MAX_LENGTH) {
        $errorflag = true;
        $Error_Province = "The Province Name should not be longer than " . PROVINCE_MAX_LENGTH . " digits";
    } else $Province = test_input($_POST["province"]);







    //if all error are false means no error 

    if ($errorflag == false) {

        //$customerobject = new customer ($Customerid ,$_POST['C_firstName'] ,$_POST['C_lastName'] , $_POST['Address'],$_POST['City'],$_POST['Postalcode'],$_POST['Username'],$_POST['Password'],$Pic);
        $servername = '127.0.0.1';
        $conn = new PDO("mysql:host=$servername;dbname=database_2111667", 'root', 'kamal');
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CALL update_account(:firstname, :lastname, :address, :city, :postal_code, :username, :password,:province,:picture) where username=:session";
        //$sql2 = "SELECT customerid from customers where


        $PDOObject = $conn->prepare($sql);
        $PDOObject->bindParam(':session', $_SESSION['login']);
        $PDOObject->bindParam(':firstname', $C_firstName);

        $PDOObject->bindParam(':lastname', $C_lastName);

        $PDOObject->bindParam(':address', $Address);

        $PDOObject->bindParam(':city', $City);

        $PDOObject->bindParam(':postal_code', $Postalcode);

        $PDOObject->bindParam(':username', $Username);

        $PDOObject->bindParam(':password', $Password);
        $PDOObject->bindParam(':province', $Province);
        $PDOObject->bindParam(':picture', $Picture);






        $PDOObject->execute();


        //$rowcount=$PDOObject->rowCount();

        //$PDOObject=$conn->prepare($sql2);

        //$PDOObject->execute();
        //$CID=$PDOObject->fetchColumn();

        //echo"$CID";

        if (isset($sql)) {
            echo "<script>alert('update Successfull');</script>";



            header("location:index.php");
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
        }
    }
}
?>
<?php if (isset($_SESSION['login'])) { ?>
    <div class="form">
        <p>Divine laptops </p>
        <p>Fill the form please </p>




        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div>
                <table>


                    <tr>
                        <td>First name:</td>
                        <td><input type="text" name="C_firstName" id="" value="<?php echo $C_firstName; ?>" placeholder="Customer C_firstname  enter please">
                            <span class="error">*<?php echo $Error_CfirstName; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Last name:</td>
                        <td><input type="text" name="C_lastName" id="" value="<?php echo $C_lastName; ?>" placeholder="Customer C_firstname  enter please">
                            <span class="error">*<?php echo $Error_ClastName; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>city:</td>
                        <td><input type="text" name="City" id="" value="<?php echo $City; ?>" placeholder="Enter City Name">
                            <span class="error">*<?php echo $Error_City; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td><input type="text" name="Address" id="" value="<?php echo $Address; ?>" placeholder="Enter streetname">
                            <span class="error"><?php echo $Error_Address; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Username:</td>
                        <td><input type="text" name="Username" id="" value="<?php echo $Username; ?>" placeholder="Enter streetname">
                            <span class="error"><?php echo $Error_Username; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input type="text" name="Password" id="" value="<?php echo $Password; ?>" placeholder="Enter streetname">
                            <span class="error"><?php echo $Error_Password; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <?php { ?>
                            <td>Password again:</td>
                            <td><input type="text" name="Password1" id="" value="<?php echo $Password1; ?>" placeholder="Enter streetname">
                                <span class="error"><?php echo $Error_Password1; ?></span>
                            </td>
                    </tr><?php } ?>
                <tr>
                    <td>Postal code:</td>
                    <td><input type="text" name="postalcode" id="" value="<?php echo $Postalcode; ?>" placeholder="Enter streetname">
                        <span class="error"><?php echo $Error_Postalcode; ?></span>
                    </td>
                </tr>
                <td>Provice:</td>
                <td><input type="text" name="province" id="" value="<?php echo $Province; ?>" placeholder="Enter province">
                    <span class="error"><?php echo $Error_Province; ?></span>
                </td>
                </tr>
                <tr>
                    <td>Picture:</td>
                    <td><input type="file" name="picture" accept="image/png, image/jpeg" id="" value=" <?php echo $Picture; ?>" placeholder="Enter photo">
                        <span class="error"><?php echo $Error_Picture; ?></span>
                    </td>
                </tr>


                </table>
                <div>
                    <input type="submit" name="submit" value="Submit" />
                    <input type="reset" value="Clear all fields" />

                </div>
        </form>
    <?php  } else {
    header("location:userlogin.php");
    exit();
}


echo "<br>";



    ?>