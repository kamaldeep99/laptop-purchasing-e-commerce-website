<?php


//session_start();
// DEVELOPER                      DATE                        COMMENTS
// Kamaldeep Singh          2022-03-06               created constants top and bottom html page 
             
// Kamaldeep Singh          2022-03-8                error handling , cache and order page congiguration like logo opacity and background color 


header('Expires: Sat, 03 Dec 1994 16:00:00 GMT');
header('Cache-Control: no-cache'); 
header('Pragma: no-cache'); 
header('Content-type: text/html; charset=UTF-8');

define("DEBUG_MODE", true);
define("FOLDER_PHP_COMMON_FUNCTION", "CommonFunctions/");
define("PHP_FUNCTION_FILE", FOLDER_PHP_COMMON_FUNCTION . "commonFunctions.php");
define("FILE_CSS",  "CSS/style.css");
define("ORDER_DOCUMENT",   "orders/orders.txt");

    
// function manageException($exception) {
//         if (DEBUG_MODE == true) {
//              echo "<br>An error " . $exception->getCode(). " (" . $exception->getMessage . ") Occured in the file " . $exception->getFile() . " at line " . $exception->getLine; 
//          }
        
// }
     
// function manageError($errorNumber, $errorString, $errorFile, $errorLine){

//     if (DEBUG_MODE == true) {

//         echo "<br>An error " . $errorNumber . " (" . $errorString . ") occured in the file " . $errorFile . " at line " . $errorLine;
//     }
//     exit();
// }

//php function for common html tag

function Top($title)
{
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo FILE_CSS; ?>">
    </head>
    
    <body class="<?php if($title == "order"){
        if(isset($_GET["command"]))
        {if($_GET["command"] == "print") {
               echo "print_order_css";
            }else{
                echo "order_css";
            }
        }else{
            echo "order_css";
        }
    }?>"><?php if(isset($_SESSION["login"])){?> <div style="text-align: center;"><img src="CommonFunctions/banff.jpeg" height="150px" width="150px" alt=""> </div> <?php }else echo"<div>login to see profile pic here</div>" ;?>



    <div>
       
        <img src="pictures/logo.png" class="<?php
        if($title == "order")
        {
        if(isset($_GET["command"]))
        {   
            if($_GET["command"] == "print") {
                echo "logo_opacity";
            }
            else{
                echo "logo_normal";
            }
            
        }
        else{echo "logo_normal";
            
        }//This else used to have something as a class for logo if user doesnot input into url
        
        
        }
        else{
                echo "logo_normal";//This else used to have something as a class for logo if user go to other page title rather than order
            }
        ?>" alt="pictures/logo.png" srcset="">

<!-- <iframe src="login2.php"></iframe> -->
        </div>


        

<!--        <div><iframe src="login.php" title="W3Schools Free Online Web Tutorials">
</iframe></div>-->
    <?php 
    // set_error_handler("manageError");

    // set_exception_handler("manageException");
    //error handling
   
    navbar();
}

function navbar()
{ ?>
         
         <div class="nav" style="display:flex;justify-content: centre;flex-direction: column" >
             <div  >
            <a  href=" index.php " class="navitem">Homepage</a>
            <a href=" buying.php " class="navitem">Buy</a>
            <a href=" order.php " class="navitem">Order</a>
            
            <a href="register.php" class="navitem"> register page </a>
     <a href="account.php"  class="navitem"> accountpage </a>
     
     <?php if (isset($_SESSION['login'])){echo '<a href="userlogin.php" style="text-align: right;;color: black;"target="_blank" > logout </a>';}?><!-- comment -->
 </div>
            </div>
        
        </div>
    <?php

}

function Bottom()
{
    ?>
        
        <p class="copyright">Copyright Kamaldeep Singh(2111667) <?php echo date('Y'); ?> </p>
    <?php
}

    ?>
    </body>

    </html>