<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Login | Earful</title>
		<meta name="viewport" content="width=divice-width,initial-scale=1"/>
     	<link href="style.css" rel="stylesheet" type="text/css">
     	<link rel="icon" type="images/png" href="Images/Icons/Earful.png">
	</head>
	<body>
		<div id="SignUp">
			<div id="SignupOptions">
					<img src="Images/Media/Logo2.png" alt="Earful" title="Sign Up Today">
			</div>

			<h2><a href="login.php">Login</a> or Sign Up Today</h2>
			<?php
				if(isset($_GET['error'])){
					if($_GET['error'] == "emptyfield"){
						if($_GET['fname']=="") {
							echo ("<style>#Fname input{
								border: 3px solid #ec1313;
							}</style>");
						}
						if($_GET['sname']=="") {
							echo ("<style>#Sname input{
								border: 3px solid #ec1313;
							}</style>");
						}
						if($_GET['user']=="") {
							echo ("<style>#User input{
								border: 3px solid #ec1313;
							}</style>");
						}
					}
				}
			?>
			<form action="Includes/signup.inc.php" method="POST">
				<div id="Title">
					<ul>
						<li id="Fname">
							<input type="text" name="fname" value="<?php if(isset($_GET['fname'])){
									echo($_GET['fname']);
									}
									else{
										echo(null);
									} ?>" placeholder="First Name">
						</li>
						<li id="Sname">
							<input type="text" name="sname"
							value="<?php if(isset($_GET['sname'])){
									echo($_GET['sname']);
									}
									else{
										echo(null);
									} ?>" placeholder="Surname">
						</li>
						<li id="User">
							<input type="text" name="user" 
							value="<?php if(isset($_GET['user'])){
									echo($_GET['user']);
									}
									else{
										echo(null);
									}
									?>" placeholder="Username">
						</li>
						<li id="Campus">
							<input type="password" name="password" placeholder="Password">
						</li>
						<li id="Course">
							<input type="password" name="re-password" placeholder="Confirm Password">
						</li>
					</ul>
				</div>
				<?php
				if(isset($_GET['error'])){
					if($_GET['error'] == "emptyfield"){
							echo ("
							<div class='errormessage'>
								<img src='Images/Icons/error.png'>
								<p>Please Fill All Fields</p>
							<div>
							");
					}
					if($_GET['error'] == "invalidusername"){
							echo ("<style>
							#User input{
								border: 3px solid #ec1313;
							}</style>
							<div class='errormessage'>
								<img src='Images/Icons/error.png'>
								<p>Username Must Only Consist of Letters And Numbers</p>
								<p>Spaces And Special Characters Are Not Permitted</p>
							<div>
							");
					}
					if($_GET['error'] == "passwordcheck"){
							echo ("<style>
							#Campus input{
								border: 3px solid #ec1313;
							}</style>
							<div class='errormessage'>
								<img src='Images/Icons/error.png'>
								<p>Passwords Do Not Match</p>
							<div>
							");
					}
					if($_GET['error'] == "duplicate"){
							echo ("<style>
							#User input{
								border: 3px solid #ec1313;
							}</style>
							<div class='errormessage'>
								<img src='Images/Icons/error.png'>
								<p>Username Already Taken</p>
							<div>
							");
					}
				}
				?>
				<div id="SaveButton">
					<button type="submit" name="signup-sub"><a title="Signup">Sign Up</a></button>
				</div>
			</form>
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
