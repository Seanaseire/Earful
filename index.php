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
        <button id="openComment" class="w3-button w3-#32C9E7 w3-xlarge w3-color-white" onclick="otherOpen()" style="position: fixed;">&#10097;</button>
            <ul id="navbarlinks">
               <li id="link"><a href="profile.php"><i class="fas fa-user-circle "></i>  Profile</a></li>
               <li id="link"><a href="contact.php"><i class="fas fa-file-contract "></i>  Contact</a></li>
               <li id="link"><a href="about.php"><i class="fas fa-info-circle "></i>  About</a></li>
            </ul>
            <div id='posting'>
               <form action='Includes/post.inc.php' method='POST' enctype='multipart/form-data'>
                  <div id="PostBox" class="w3-animate-top">
                     <div id='PostSubBox'>
                        <textarea name='content' placeholder='Make a post!'></textarea>
                        <button type='submit' name='postsub' title='Post' ><img src="Images/Icons/send.png"></a></button>
                        <a href="#" onclick="toggle_visibility();"style="float: left;border-radius: 100px 100px 100px 100px;">Upload A File <i class="fas fa-file-upload"></i></a>
                        <div id="Podcast">                     
                           <input type='file' name='cover' id='cover'/>
                           <label for='cover' /><img src='Images/Icons/imgdefault.png'></label>
                           <input type='file' name='pod' id='pod'/>
                           <label for='pod' /><img src='Images/Icons/mic.png'></label>
                        </div>
                     </div>
                  </div>
               </form>
                  <button id="closeCommnet" class="w3-bar-item w3-button w3-large w3-animate-top" onclick="otherClose()" style="text-align: center;float: left;">&#10097;</button>
            </div>
         </div>
      <div id="main">
         <div id="Right">
            <li id="homebtn" ><a href="index.php"><img src="Images/Media/Logo-flat.png" style="width:150px;margin-left:20px; float:left; display: block; position: fixed; top:0;z-index: 5;margin-top: -10px;margin-left:20px;"></a></li>
            <div id='posts'>
               <h1 id='headline'>All Post's</h1>
               <?php 
                  $sql = 'SELECT * FROM posts;';
                  $result = mysqli_query($conn, $sql);
                  $resultCheck = mysqli_num_rows($result);        
                  
                  if(isset($_POST['listen'])){
                     $listenersql= "INSERT INTO listeners (userid, listenerid, date) VALUES ('".$_POST['postlistenerid']."', '".$id."',CURRENT_TIMESTAMP());";
                     $listenerresult = mysqli_query($conn, $listenersql);
                  }
                  if(isset($_POST['ignore'])){
                     $ignoreuserid = $_POST['postlistenerid'];
                     $ignoresql= "DELETE FROM `listeners` WHERE `listeners`.`userid`=".$ignoreuserid." AND `listeners`.`listenerid`=".$id.";";
                     $ignoreresult = mysqli_query($conn, $ignoresql);
                  }
                  if(isset($_POST['like'])){
                     $likesql= "INSERT INTO comments (postid, `like`, userid , date) VALUES ('".$_POST['postlikeid']."', 1 , '".$id."',CURRENT_TIMESTAMP());";
                     $likeresult = mysqli_query($conn, $likesql);
                  }
                  if(isset($_POST['liked'])){
                     $lid = $_POST['postcommentid'];
                     $likedpostid = $_POST['postlikeid'];
                     $likedsql= "DELETE FROM `comments` WHERE `comments`.`postid`=".$likedpostid." AND `comments`.`userid`=".$id." AND `comments`.`like`=1;";
                     $likedresult = mysqli_query($conn, $likedsql);
                     header("Location: index.php");
                  }
                  if(isset($_POST['comment']) && ($_POST['commentxt'] != '')) {
                     $cid = $_POST['postcommentid'];
                     $ctxt = $_POST['commentxt'];
                     $commentssql= "INSERT INTO `comments` (postid, comment , userid , date) VALUES (".$cid.", '".$ctxt."', ".$id.",CURRENT_TIMESTAMP());";
                     $commentsresult = mysqli_query($conn, $commentssql);
                     header('Location: index.php');
                     exit;
                  }
                  if(isset($_POST['deleteuser'])){
                     $deluserid = $_POST['deluserid'];
                     $delusersql= "DELETE `comments`,`listeners`,`posts`,`users` FROM `comments` LEFT JOIN `listeners` ON (`listeners`.`listenerid` = `comments`.`userid`) LEFT JOIN `posts` ON (`comments`.`userid` = `posts`.`userid`) LEFT JOIN `users` ON (`posts`.`userid` = `users`.`id`) WHERE `comments`.`userid` = $deluserid;";
                     $deluserresult = mysqli_query($conn, $delusersql);
                  }
                  if(isset($_POST['deletepost'])){
                     $delpostid = $_POST['delpostid'];
                     $delpostsql= "DELETE FROM `posts` WHERE `posts`.`id`=$delpostid;";
                     $delpostresult = mysqli_query($conn, $delpostsql);
                  }

                  $listensql = "SELECT `userid` FROM `listeners` WHERE `listeners`.`listenerid` = $id;";
                  $listenresult = mysqli_query($conn, $listensql);
                  $listenresultCheck = mysqli_num_rows($listenresult);
                  $listenout = array();
                  while($listenrow = mysqli_fetch_assoc($listenresult)){
                     $listenout[] = $listenrow['userid'];
                  }

                  
                  if ($resultCheck > 0){
                  while ($row = mysqli_fetch_assoc($result)){
                     $rows[] = $row;
                  }
                  $rows = array_reverse($rows);
                  
                  foreach ($rows as $row){
                     $postid = $row['id'];
                     $userid = $row['userid'];
                     $usersql = "SELECT * FROM `users` WHERE `users`.`id` = $userid;";
                     $userresult = mysqli_query($conn, $usersql);
                     $userrow = mysqli_fetch_assoc($userresult);

                        /* Gets amount of likes */
                        $sqllikes = "SELECT COUNT(`like`) as total from `comments` where `postid`= $postid;";
                        $rlike = mysqli_query($conn, $sqllikes);
                        $data = mysqli_fetch_assoc($rlike);
                        $totallikes=$data['total'];
                        /* ==================================== */
                  
                     echo("<div id='postt' class='post'>
                           <div class='user'>
                                    <div class='userinfo'>
                                    <img src='Images/Profiles/".$userrow['profile'].".png'>
                                    <h3>".$userrow['username']."</h3>
                              </div>
                           <div class='addfriend'>
                        ");
                  
                  
                        $likesql = "SELECT * FROM `comments` WHERE `comments`.`postid` = $postid AND `comments`.`userid` = $id AND `comments`.`comment` IS NULL;";
                        $likeresult = mysqli_query($conn, $likesql);
                        $likeresultCheck = mysqli_num_rows($likeresult);
                        $likerow = mysqli_fetch_assoc($likeresult);

                        $commentsql = "SELECT * FROM `comments` WHERE `comments`.`postid` = $postid AND `comments`.`like` IS NULL;";
                        $commentresult = mysqli_query($conn, $commentsql);
                        $commentresultCheck = mysqli_num_rows($commentresult);
                  
                                       if($id == $userid){
                  
                                       }
                                       else if($id == $admin){
                                          echo("<form method='POST'>
                                             <div class='adminUi'>
                                          <input type='number' name='deluserid' value='".$userid."'/>
                                          <input type='number' name='delpostid' value='".$postid."'/>
                                          <ul>
                                          <li> 
                                          <button type='submit' name='deleteuser' title='Delete User'><img src='Images/Icons/deleteuser.png'></button>
                                          </li>
                                          <li>
                                          <button type='submit' name='deletepost' title='Delete Post'><img src='Images/Icons/delete.png'></button>
                                          </li>
                                          </ul>
                                             </div>
                                          </form>");
                                       }
                                       else if($listenresultCheck > 0){
                                           if(in_array($userid, $listenout)){
                                          echo("<form method='POST'>
                                             <div class='remove'>
                                          <input type='number' name='postlistenerid' value='".$userid."'/> 
                                          <button type='submit' name='ignore' title='ignore'></button>
                                             </div>
                                          </form>");
                                          }
                                          else if(!in_array($userid, $listenout)){
                                          echo("<form method='POST'>
                                             <div class='add'>
                                          <input type='number' name='postlistenerid' value='".$userid."'/> 
                                          <button type='submit' name='listen' title='listen' ></button>
                                             </div>
                                          </form>");
                                          }
                                       }
                                       else{
                                          echo("<form method='POST'>
                                             <div class='add'>
                                          <input type='number' name='postlistenerid' value='".$userid."'/> 
                                          <button type='submit' name='listen' title='listen' ></button>
                                             </div>
                                          </form>");
                                       }
                  
                                    echo("</div>
                                 </div>");
                        if($row['podcast']!='default'){
                           echo("<div class='podcastpostmain'>
                                    <img src='Images/Covers/".$row['cover'].".png'>
                                    <audio controls> 
                                       <source src='Podcasts/".$row['podcast'].".mp3' type='audio/mpeg'>
                                    </audio>
                                    <h4>Description: </h4>
                                    <p>".$row['content']."</p>
                              </div>");
                        }
                        else if($row['cover']!='default'){
                           echo("<div class='imagepostmain'>
                                    <div class='imagebox'>
                                       <img src='Images/Covers/".$row['cover'].".png'>
                                    </div>
                                    <p>".$row['content']."</p>
                                 </div>");
                        }
                        else if(($row['cover']=='default')&&($row['podcast']=='default')){
                           echo("<div class='imagepostmain'>
                                    <p>".$row['content']."</p>
                                 </div>");
                        }
                  
                        $commentpostid = $likerow['commentid'];
                  
                        if($likeresultCheck > 0){
                           if($likerow['like'] == Null){
                              echo("<div class='like'>
                                    <form method='POST'>
                                       <input type='number' name='postlikeid' value='".$postid."'/>
                                       <input type='number' name='commentpostid' value='".$commentpostid."'/>
                                       <p id='Likes'>$totallikes <i class='fas fa-heart'></i></p>
                                       <button type='submit' name='like' title='like'><img src='Images/Icons/like.png'></button>
                                    </form>
                                 </div>");
                           }
                           else{
                              echo("<div class='like'>
                                    <form method='POST'>
                                       <input type='number' name='postlikeid' value='".$postid."'/>
                                       <input type='number' name='commentpostid' value='".$commentpostid."'/>
                                        <p id='Likes'>$totallikes <i class='fas fa-heart'></i></p>
                                       <button type='submit' name='liked' title='liked'><img src='Images/Icons/liked.png'></button>
                                    </form>
                                 </div>");
                           }
                        }
                        else{
                           echo("<div class='like'>
                                    <form method='POST'>
                                       <input type='number' name='postlikeid' value='".$postid."'/>
                                       <input type='number' name='commentpostid' value='".$commentpostid."'/>
                                        <p id='Likes'>$totallikes <i class='fas fa-heart'></i></p>
                                       <button type='submit' name='like' title='like'><img src='Images/Icons/like.png'></button>
                                    </form>
                                 </div>");
                        }
                        echo ("<div class='comments'>
                              <div class='commentinput'>
                                 <div class='commentinputbox'>
                                    <form method='POST'>
                                       <div class='commentsendid'>
                                          <input type='number' name='postcommentid' value='".$postid."'/>
                                       </div>
                                       <input type='text' name='commentxt' placeholder='Add your comment'/>
                                       <button type='submit' name='comment' title='comment'><img src='Images/Icons/send.png'></button>
                                    </form>
                                 </div>");
                  
                           echo("</div>");
                  
                        if($commentresultCheck > 0){
                           while ($commentrow = mysqli_fetch_assoc($commentresult)){
                              $commentrows[] = $commentrow;
                           }
                           $commentrows = array_reverse($commentrows);
                  
                           foreach ($commentrows as $commentrow){
                              if($commentrow['postid'] == $postid){
                                 $commentuserid = $commentrow['userid'];
                                 $commentusersql = "SELECT * FROM `users` WHERE `users`.`id` = $commentuserid;";
                                 $commentuserresult = mysqli_query($conn, $commentusersql);
                                 $commentuserrow = mysqli_fetch_assoc($commentuserresult);
                  
                                 echo ("<div class='comment'>
                                       <div class='commentuserinfo'>
                                          <img src='Images/Profiles/".$commentuserrow['profile'].".png'>
                                          <h4>".$commentuserrow['username']."</h4>
                                       </div>
                                       <div class='commentcontent'>
                                          <p>".$commentrow['comment']."</p>
                                          <h5>".$commentrow['date']."</h5>
                                       </div>
                                    </div>");
                              }
                              else{
                  
                              }
                           }
                        }
                        else{
                        }
                        echo("</div>");
                        echo("</div>");
                  }
                  }
                  ?>
            </div>
            <div id="indexbot">
               <img src="Images/Icons/icon.png">
            </div>
         </div>
      </div>
      <script>
         function w3_open() {
           document.getElementById("main").style.marginLeft = "10%";
           document.getElementById("PostBox").style.marginLeft = "-15%";
           document.getElementById("PostBox").style.width = "40%";
           document.getElementById("Left").style.display = "block";
           document.getElementById("openNav").style.display = 'none';
            document.getElementById("homebtn").style.display = 'none';

         }
         function otherOpen(){
         document.getElementById("PostBox").style.display = "block";
         document.getElementById("openComment").style.display = 'none';
         document.getElementById("closeCommnet").style.display = "block";
         }
         function otherClose(){
         document.getElementById("PostBox").style.display = "none";
         document.getElementById("openComment").style.display = "inline-block";
         document.getElementById("closeCommnet").style.display = "none";
         }
         function w3_close() {
           document.getElementById("main").style.marginLeft = "0%";
           document.getElementById("PostBox").style.marginLeft = "-25%";
           document.getElementById("PostBox").style.width = "50%";
           document.getElementById("Left").style.display = "none";
           document.getElementById("openNav").style.display = "inline-block";
           document.getElementById("homebtn").style.display = 'block';
         }
             function toggle_visibility() {
                var e = document.getElementById("Podcast");
                var x =document.getElementById("PostBox");
                 var y =document.getElementById("closeCommnet");

                if(e.style.display == 'block'){
                   e.style.display = 'none';
                    x.style.height="155px";
                    y.style.marginTop = "153px";
                    y.style.marginLeft = "50%";
                  }
  
                else{
                   e.style.display = 'block';
                         x.style.height="250px";
                         y.style.marginTop = "248px";
                           y.style.marginLeft = "50%";

                }
             }
                            if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
         //-->
      </script>
   </body>
</html>