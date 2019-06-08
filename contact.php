<?php
   session_start();
   include_once 'Includes/dbh.inc.php';
   
   $id = $_SESSION['userid'];
   $sql = "SELECT * FROM `users` WHERE `users`.`id` = $id;";
   $result = mysqli_query($conn, $sql);
   $row = mysqli_fetch_assoc($result);
   
   $adminsql = "SELECT * FROM `users` WHERE `users`.`username` = 'EarfulAdmin';";
   $adminresult = mysqli_query($conn, $adminsql);
   $adminrow = mysqli_fetch_assoc($adminresult);
   $admin = $adminrow['id'];
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Home | Earful</title>
      <meta name="viewport" content="width=divice-width,initial-scale=1"/>
      <link href="style.css" rel="stylesheet" type="text/css">
      <link rel="icon" type="images/png" href="Images/Icons/icon.png">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
      <link href="https://fonts.googleapis.com/css?family=Quicksand:300,500" rel="stylesheet">
   </head>
   <body>
      <div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="Left">
         <button class="w3-bar-item w3-button w3-large"
            onclick="w3_close()"style="text-align: center;">Close &times;</button>
         <div id="LeftText">
            <div id="logo">
               <a href="index.php"><img src="Images/Media/Logo.png"></a>
            </div>
            <?php
               if(isset($_SESSION['user'])){
                  echo("<div id='LeftProfile'>
                     <a href='profile.php'><img src='Images/Profiles/".$row['profile'].".png'></a>
                     <h3>".$_SESSION['user']."</h3>
                     <a href='profile.php'><h3>View Profile</h3></a>
                     <div id='Logout'>
                           <a href='Includes/logout.inc.php' alt='Logout' title='Logout'><img src='Images/Icons/exit.png'></a>
                        </div>
                  </div>
                  ");
               }
               else{
                  header("Location: login.php");
               }
               ?>       
         </div>
      </div>
      <button id="openNav" class="w3-button w3-cyan w3-xlarge w3-color-white" onclick="w3_open()" style="position: fixed;margin-top: 20%;float:left;color:white;border-radius: 0px 100px 100px 0;">&#10097;</button>
      <div id="navbar">
            <ul id="navbarlinks">
               <li id="link"><a href="profile.php">Profile</a></li>
               <li id="link"><a href="contact.php">Contact</a></li>
               <li id="link"><a href="about.php">About</a></li>
            </ul>
         </div>
      <div id="main">
         <div id="Right">
            <li id="homebtn" ><a href="index.php"><img src="Images/Media/Logo-flat.png" style="width:150px;margin-left:20px; float:left; display: block; position: fixed; top:0;z-index: 5;margin-top: -10px;"></a></li>
            <img id="contactimg"src="Images/Media/contact.png"style="width:100%;">
            <div id="contact">
               <div id="cright">
               <h4 >Connect with us:</h4>
               <p >For support or any questions: <br> Email us at <span style="color:#32C9E7;">Earful@Gmail.com</span></p>
               <p>We gurantee a response within<b> 24 hours</b> of submission </p>
               <p><b>Dublin IE</b> <br> Griffith College Dublin, South Circular Road <br>Dublin 8 - D08 V04N</p>
               </div>
               <div id="cleft">
               <h4 >About Our Staff:</h4>
               <p>We at Earful value your opinion and hope to provide best experience possible. <br> So please let us know if anything disatisifes you or you have any issues. Our customer support staff are one of the finest we have been rated 4.5 out 5 on IGN and GamersNexus. Our staff will deal with your enquiry or issue proficiently and proffesionally.</p>
               <p> If you may expereience any issues with our staff dont hesitate to email our HR Management Team :<span style="color:#32C9E7;"> EarfulPR@Gmail.com. </span> <br><br> <i>This email address should only be used when you have experienced an issue with our staff. It should not be used to submit any issues you have with our website. Any such claims not related with staff issues will be dissmised and not evaluated.</i></p>
               </div>
            </div>
            <div id="indexbot">
               <img src="Images/Icons/icon.png">
            </div>
         </div>
      </div>
      <script>
         function w3_open() {
           document.getElementById("main").style.marginLeft = "10%";
           document.getElementById("Left").style.display = "block";
           document.getElementById("openNav").style.display = 'none';
            document.getElementById("homebtn").style.display = 'none';

         }

         function w3_close() {
           document.getElementById("main").style.marginLeft = "0%";
           document.getElementById("Left").style.display = "none";
           document.getElementById("openNav").style.display = "inline-block";
           document.getElementById("homebtn").style.display = 'block';
         }
                            if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
         //-->
      </script>
   </body>
</html>