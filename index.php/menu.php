﻿<div id="menu" align="center">
    <ul class="menu">
        <li><a href="index.php" class="parent"><span>Home</span></a></li>
        <li><a href="#" class="parent"><span>Services</span></a>
            <div><ul>
                <li><a href="/map.php" class="parent"><span>Map</span></a></li>
                <li><a href="/directions.php" class="parent"><span>Directions</span></a>
                    <div><ul>
                        <li><a href="#"><span>Sub Item 2.1</span></a></li>
                        <li><a href="#"><span>Sub Item 2.2</span></a></li>
                    </ul></div>
                </li>
            </ul></div>
        </li>
        <li><a href="/progress.php" class="parent"><span>Project Progress</span></a></li>
        <li class="last"><a href="/groupMember.php"><span>Group Members</span></a></li>
		
		<?php
		
		session_start();
		
		if ($_SESSION['loggedin'] == TRUE) { 
		

		
			$username = $_SESSION['username'];
		
			//Create database connection
			$con = mysqli_connect("localhost","traffich_admin","Admin2013","traffich_main");
				
			//Display error message if connection fails
			if (mysqli_connect_errno($con))	{
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
				
			$query = "SELECT recentMap
						FROM Login 
						WHERE Username = '$username'";
				  
			//Obtain the result of the query
			$result = $con->query($query);

			//Get the first (and only) row of the result		
			$row = $result->fetch_row();

			if($row[0] != NULL) {		
			
			$recentMap = $row[0];
			
			//Turn the string into an array, with delimeter ','
			$recentArray = explode(',', $recentMap);
			
			?>
		
				<li><a href="/map.php" class="parent"><span>Recent Searches</span></a>
					<div><ul>
						<li><a href="#" class="parent"><span>Map</span></a>
							<div><ul>  
							
								<li><a href="/map.php?zipcode=<?php echo "$recentArray[0]";?>?time=<?php echo "$recentArray[1]";?>?weather=<?php echo "$recentArray[2]";?>">
									<span> <?php echo "Zip Code: $recentArray[0] Time Period: $recentArray[1] Weather: $recentArray[2]"; ?></span></a></li>
								<li><a href="#"><span>Sub Item 1.2</span></a></li>
							</ul></div>
						</li>
					</ul></div>
				</li>
		
			<?php } 
			
			?>  <li><a href="/login.php" class="parent"><span>Logout</span></a></li> <?php
		}
		else {
			?>  <li><a href="/login.php" class="parent"><span>Login</span></a></li> <?php	
		}
		?>
		
    </ul>
</div>