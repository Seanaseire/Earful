<?php
	session_start();
	include_once 'Includes/dbh.inc.php';
	$id = $_SESSION['userid'];
	$sql = "SELECT * FROM `users` WHERE `users`.`id` = $id;";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

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
	</head>
	<body>
		<li id="homebtn" ><a href="index.php"><img src="Images/Media/Logo-flat.png" style="width:150px; float:left; display: block; position: fixed; top:0;z-index: 5;margin-top: -10px;"></a></li>
		<div id="navbar">
           <ul id="navbarlinks">
               <li id="link"><a href="profile.php">Profile</a></li>
               <li id="link"><a href="contact.php">Contact</a></li>
               <li id="link"><a href="about.php">About</a></li>
            </ul>
         </div>
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
							<img src='Images/Profiles/".$row['profile'].".png'>
							<h3>".$_SESSION['user']."</h3>
							<a href='index.php'><h3>Home</h3></a>
							<div id='Logout'>
									<a href='Includes/logout.inc.php' alt='Logout' title='Logout'><img src='Images/Icons/exit.png'></a>
								</div>
							</div>
						");
					}
					else{
						echo("<div id='LeftProfile'>
							<a href='login.php'><h2>Login</h2></a>
							<h2>Or</h2>
							<a href='signup.php'><h2>Signup</h2></a>	
						</div>");
					}
				?>			
			</div>
		</div>
		  	<button id="openNav" class="w3-button w3-cyan w3-xlarge w3-color-white" onclick="w3_open()" style="position: fixed;margin-top: 20%;float:left;color:white;border-radius: 0px 100px 100px 0;">&#10097;</button>
  		<div id="main" style="margin-left: 0%;">
		<div id="Right">
			<?php
				if(isset($_SESSION['user'])){
					echo("<div id='RightProfile'>
							<div id='RightProImgCont'>
							<div id='RightProImg'>
							<img src='Images/Profiles/".$row['profile'].".png'>
						</div>
						</div>
						<div id='ProUpt'>
						<a id='batton' class='w3-animate-top' href='#' onclick='toggle_visibility();'style='float: left;'><h3 id='edith3'>Edit Profile</h3></a>
                        <div id='EditProf' class='w3-animate-top'>
                        <p>Change Your Profile Picture</p>                     
								<input type='file' name='file' id='file' />
								<label for='file' ></label>
								<button type='submit' name='profilesub'>Save</button>
								</form>
                        </div>
						</div>
						</div>
						<div id='ProPost'>
						<div id='posts'>");

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
                     header("Location: profile.php");
                  }
					if(isset($_POST['comment'])){
							$cid = $_POST['postcommentid'];
							$ctxt = $_POST['commentxt'];
							$commentssql= "INSERT INTO `comments` (postid, comment , userid , date) VALUES (".$cid.", '".$ctxt."', ".$id.",CURRENT_TIMESTAMP());";
							$commentsresult = mysqli_query($conn, $commentssql);
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
                        
                        $sqllikes = "SELECT COUNT(`like`) as total from `comments` where `postid`= $postid;";
                        $rlike = mysqli_query($conn, $sqllikes);
                        $data = mysqli_fetch_assoc($rlike);
                        $totallikes=$data['total'];

					if($listenresultCheck > 0){
						if(($id == $userid) || (in_array($userid, $listenout))){	
							echo("<div class='post'>
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
							}
						}
						else if($id == $userid){
							echo("<div class='post'>
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
													else if($listenresultCheck > 0){
													    if(in_array($userid, $listenrow)){
														echo("<form method='POST'>
															<div class='remove'>
														<input type='number' name='postlistenerid' value='".$userid."'/> 
														<button type='submit' name='ignore' title='ignore'></button>
															</div>
														</form>");
														}
														else if(!in_array($userid, $listenrow)){
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
													<button type='submit' name='like' title='like'><img src='Images/Icons/like.png'></button>
												</form>
											</div>");
									}
									else{
										echo("<div class='like'>
												<form method='POST'>
													<input type='number' name='postlikeid' value='".$postid."'/>
													<input type='number' name='commentpostid' value='".$commentpostid."'/>
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
						}
						else{
							echo("<div class='filler'>.</div>");
						}
							echo("</div>");
							echo("</div>");
					}
				}
			}
			else{
				header("Location: login.php");
			}
		?>
	</div>
		<div id="profilebot">
			<div id="profilebotimg">
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
  document.getElementById("RightProfile").style.marginTop = '48px';
}
function w3_close() {
  document.getElementById("main").style.marginLeft = "0%";
  document.getElementById("Left").style.display = "none";
  document.getElementById("openNav").style.display = "inline-block";
  document.getElementById("homebtn").style.display = 'block';
}
             function toggle_visibility() {
                var e = document.getElementById("EditProf");
                var x =document.getElementById("ProUpt");

                if(e.style.display == 'block'){
                   e.style.display = 'none';
                    x.style.height="60px";
                  }
  
                else{
                   e.style.display = 'block';
                         x.style.height="190px";

                }
             }
               if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
	</body>
</html>