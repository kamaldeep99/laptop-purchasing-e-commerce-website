<?php

session_start();

// Kamaldeep Singh          2022-03-06               created shuffled array and imported php files 
// Kamaldeep Singh          2022-03-08               added css for differenct image size 

if (isset($_SESSION["valid" == true])) echo "<script>alert('valid login details');</script>";

// icommon php function file
include("CommonFunctions/commonFunctions.php");

Top("Home");

// Creating and Shuffling Image array
$pics  = array("laptop1.jpg", "laptop2.jpg", "laptop3.jpg", "laptop4.jpg", "laptop5.jpg");
shuffle($pics);



?>
<?php if (isset($_SESSION['login'])) { ?>
  <div class="main">

    <p>Divine laptops</p>
    <p>Cheap and great value for money laptops available </p>




  </div>


  <!-- updating css for logo using php if image is desired one then different css used for bigger image -->

  <a href="https://www.bestbuy.ca/en-ca/category/laptops/36711" target="_blank"> <img src="pictures/<?php echo $pics[0]; ?>" class="<?php if ($pics[0] == "laptop1.jpg") {
                                                                                                                                      echo "bigpic";
                                                                                                                                    } else {
                                                                                                                                      echo "normalpic";
                                                                                                                                    } ?>" alt="pictures/$pics[0]" srcset=""> </a>
<?php  } else {
  header("location:userlogin.php");
  exit();
}


echo "<br>";



?>