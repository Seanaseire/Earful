<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Sign Up | Earful</title>
		<meta name="viewport" content="width=divice-width,initial-scale=1"/>
     	<link href="style.css" rel="stylesheet" type="text/css">
     	<link rel="icon" type="images/png" href="Images/Icons/Earful.png">
	</head>
	<body>
		<div id="SignUp">
			<div id="SignupOptions">
					<img src="Images/Media/Logo2.png" alt="Earful" title="Sign Up Today">
			</div>
			<?php
				if (isset($_SESSION['user'])){
					echo("<div id='loginSuc'>
						<img src='Images/Icons/Earful.gif' alt='Earful'>
						<h3>Login Sucessful</h3>
						</div> ");
					header("refresh:2; url=index.php");
				}
				else{
					echo("<h2>Login or <a href='signup.php'>Sign Up</a> Today</h2>
					<form action='Includes/login.inc.php' method='POST'>
					<div id='Title'>
					<ul>
						<li id='User'>
							<input type='text' name='user' placeholder='Username' value='".(isset($_GET['user'])? $_GET['user'] : null)."'>
						</li>
						<li id='Password'>
							<input type='password' name='password' placeholder='Password'>
						</li>
					</ul>
				</div>");
					if(isset($_GET['error'])){
					if($_GET['error'] == "wrongpassword"){
							echo ("<style>#Password input{
								border: 3px solid #ec1313;
							}</style>
							<div class='errormessage'>
								<img src='Images/Icons/error.png'>
								<p>Wrong Password</p>
							<div>
							");
					}
					if($_GET['error'] == "emptyfields"){
							echo ("<style>#Password input{
								border: 3px solid #ec1313;
							}
							#User input{
								border: 3px solid #ec1313;
							}</style>
							<div class='errormessage'>
								<img src='Images/Icons/error.png'>
								<p>Please Enter Details</p>
							<div>
							");
					}
					if($_GET['error'] == "nouser"){
							echo ("<style>
							#User input{
								border: 3px solid #ec1313;
							}</style>
							<div class='errormessage'>
								<img src='Images/Icons/error.png'>
								<p>User Does Not Exist</p>
							<div>
							");
					}
				}
				echo("<div id='SaveButton'>
					<button type='submit' name='login-sub'><a title='Save'>Login</a></button>
				</div>
			</form>
			</div>
			");
				}
			?>
		</div>
		<div id="SignInfo">
			<img src="Images/Media/Logo-flat.png">
			<div id="Info">
				<h2>What is Earful?</h2>
				<p>Earful is a social media site designed to cater for fans of podcasts.</p>
				<h2>Listen to all your favourite podcasts</h2>
				<img src="Images/Media/pod.png">
			</div>
		</div>
		<div id="SignBottom">
				<p> &copy;Earful2019 </p>
			</div>
	</body>
</html>