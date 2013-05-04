<?php include 'header.php'; ?>
    <div align="center">
        Create an account today! =D (currently under progress)
		
		<br><br>
		
		<br>
		
		<?php 
		
		$tryagain=1;
		
		//If someone has attempted to create an account, save their entries as variables
		$username = $_POST['newuser'];
		$p1 = $_POST['newpw1'];
		$p2 = $_POST['newpw2'];
		$create = $_GET['create'];
		
		
		if($create=='yes') {
			//check for matching passwords and that username/password are correct length
			?> <p style="color:red"> <?php
			if($p1!=$p2) { ?>
				Passwords did not match.  Please try again.<br> <?php
				$tryagain=1;
			}
			else if(strlen($username)<4 or strlen($username)>20) { ?>
				Username must be between 4 and 20 characters.<br> <?php
				$tryagain=1;
			}
			else if(strlen($p1)<3 or strlen($p1)>13) { ?>
				Password must be between 3 and 20 characters.<br> <?php
				$tryagain=1;
			}
			else {
				//Create database connection
				$con = mysqli_connect("localhost","traffich_admin","Admin2013","traffich_main");
				
				//Display error message if connection fails
				if (mysqli_connect_errno($con))
				{
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
			
				//SQL query which checks if the username is unique
				$unique = "SELECT COUNT(*)
						FROM Login 
						WHERE Username = '$username'";
						
				//SQL query which inserts new account into database
				$insert = "INSERT INTO Login (Username, Password)
						   VALUES ('$username', '$p1')";
						
				//Obtain the result of the query
				$result = $con->query($unique);
		
				//Get the first (and only) row of the result
				$row = $result->fetch_row();
			
				if($row[0] == 1){ ?>
					<p style="color:red"> Sorry, that username has already been taken. </p> <br> <?php		
				} 
				else {
					mysqli_query($con, $insert);
					mysqli_close($con); 
					$tryagain == 0;  ?>
					Account creation successful! <br>
					
					<form action="login.php" method="post">
						<input type="submit" value="Proceed to Login">
					</form> <?php
				}
			} 
		} ?> 
		
		<?php 
		if($tryagain == 1) { ?>
			<form name="input" action="create.php?create=yes" method="post">
				Enter your desired login information below: <br>
				Username:<input type="text" name="newuser"> <br>
				Password:<input type="password" name="newpw1"> <br>
				Confirm Password:<input type="password" name="newpw2"> <br>
				<input type="submit" value="Submit">
			</form> <?php
		} ?>
		
		
    </div>
<?php include 'footer.php'; ?>
