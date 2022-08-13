<?php
// Kamaldeep Singh          2022-03-25                completed login form with java script implemetation
//starting session for session variable storage
session_start();
session_unset();//unsetting to clear previous session variables for new login so that it doesnot get save and redirect becomew impossible
include_once("CommonFunctions/commonFunctions.php");
Top("login");
if(isset($_POST['login']))
{try {
    $servername = "127.0.0.1";
$connection = new PDO("mysql:host=$servername;dbname=database_2111667", 'root', 'kamal');//connection creation
// set the PDO error mode to exception
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "CALL login(:username,:password)";
$PDOObject=$connection->prepare($sql);
$PDOObject->bindParam(':username',$_POST['username'] );//binding param to avoid sql injection
$PDOObject->bindParam(':password', $_POST['password']);
$PDOObject->execute(
);
$count =   $PDOObject->rowCount();
if($count>0)//fetching rowcount to check if output is there or not 
{
$_SESSION['login']=$_POST['username'];
$_SESSION['valid']=true;
var_dump($_SESSION['login']);
echo "<script>alert('valid user login details');</script>";
header("location:index.php");//redirecting to index page page
}
else
{   
echo "<script>alert('Invalid  user login details.please enter again');</script>";
   // session_destroy();
   
header("location:userlogin.php");//redirecting to login page again
exit();

}
    }
   catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }


}
?>
<div style="text-align: center;" >Please Login first</div>

<form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
   
<div style="text-align: center;">

<span>Username:<input type="text" placeholder="username" name="username" required /></span>
<span>Passwword:<input type="password" placeholder="password" name="password" required /></span>
<span><button type="submit" name="login">login</button></span>
<p class="message">Need a user account <a href="register.php">Create account(MOVE TO REGISTER PAGE)</a></p>
<p>help(username: kd 
    password: singh )</p>
</div>
</form>
</div>
</div>
<?php
bottom();
?>