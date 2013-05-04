<?php include 'header.php'; ?>
    <div align="center">
	
        (still under progress - matt)
		<br>
		
		<?php 
		
		//determines whether user is logged in
		$loggedin = 0;
		
		//If someone has attempted to login, save their entries as variables
		$username = $_POST['username'];
		$password = $_POST['password'];
		$attempt = $_GET['attempt'];
		
		if($attempt=='yes') {
			
			//Create database connection
			$con = mysqli_connect("localhost","traffich_admin","Admin2013","traffich_main");
			
			//Display error message if connection fails
			if (mysqli_connect_errno($con))
			{
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
			
			//Create SQL query.  Counts number of rows with username and password entered
			//If a user with an account logs in, the count should be equal to 1
			$query = "SELECT COUNT(*)
					  FROM Login 
					  WHERE Username = '$username' and Password = '$password'";
		
			//Obtain the result of the query
			$result = $con->query($query);
		
			//Get the first (and only) row of the result
			$row = $result->fetch_row();
			
			if($row[0] != 1){ 
				?> Invalid login. <br>
				
				   <form action="login.php?attempt=no" method="post">
				   <input type="submit" value="Try again">
				   </form>
				
				<?php 
			}
			else { 	
			
			$loggedin = 1; ?>
		
			LOGIN SUCCESSFUL!
			<br><br>
		
			<form action="login.php?attempt=no" method="post">
				<input type="submit" value="Logout">
			</form> <?php 
			
			} 
		} 
		
		//If the user has not attempted to login yet
		if($attempt!='yes') {
		
			$loggedin = 0; ?>
		
			<br><br>
		
			<form action="login.php?attempt=yes" method="post">
			Username: <input type="text" name="username">
			<br>
			Password: <input type="password" name="password">
			<br>
			<input type="submit" value="Login">
			</form> <?php 
		} 
		
		//if the user is not logged in, create account option is available
		if($loggedin == 0) { ?>
		
			<br><br>
			Don't have an account?
			<br>
			
			<!--Create an account by clicking on this form-->
			<form action="create.php" method="post">
			<input type="submit" value="Create Account">
			</form> <?php
		} ?>		
    </div>
<?php include 'footer.php'; ?>
