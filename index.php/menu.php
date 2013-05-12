﻿<?php
//written by: Kevin Hsieh and Matt Araneta
//tested by: Kevin Hsieh and Matt Araneta
//debugged by: Kevin Hsieh and Matt Araneta
?>
<div id="menu" align="center">
    <ul class="menu">
        <li><a href="index.php" class="parent"><span>Home</span></a></li>
        <li><a href="#" class="parent"><span>Services</span></a>
            <div><ul>
                <li><a href="/map.php" class="parent"><span>Map</span></a></li>
                <li><a href="/directions.php" class="parent"><span>Directions</span></a></li>
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
				
			$query = "SELECT recentMap, recentDirections
						FROM Login 
						WHERE Username = '$username'";
				  
			//Obtain the result of the query
			$result = $con->query($query);

			//Get the first (and only) row of the result		
			$row = $result->fetch_row();

			if($row[0] != NULL or $row[1] != NULL) {		
			
			$recentMapString = $row[0];
			$recentDirectionsString = $row[1];
			
			//Turn the string into an array, with delimeter ','
			$recentMap = explode(',', $recentMapString);
			$recentDirections = explode(':', $recentDirectionsString);
			
			?>
		
				<li><a href="/map.php" class="parent"><span>Recent Searches</span></a>
					<div><ul>
					
						<?php
						
						if($row[0] != NULL) { ?>
					
						<li><a href="#" class="parent"><span>Map</span></a>
							<div><ul>  
							
								<li><a href="/map.php?zipcode=<?php echo "$recentMap[0]";?>&time=<?php echo "$recentMap[1]";?>&weather=<?php echo "$recentMap[2]";?>&amount=3">
									<span> <?php echo "Zip Code: $recentMap[0] Time Period: $recentMap[1] Weather: $recentMap[2]"; ?></span></a></li> <?php
								
								if(isset($recentMap[4])) { ?>
									<li><a href="/map.php?zipcode=<?php echo "$recentMap[3]";?>&time=<?php echo "$recentMap[4]";?>&weather=<?php echo "$recentMap[5]";?>&amount=3">
									<span> <?php echo "Zip Code: $recentMap[3] Time Period: $recentMap[4] Weather: $recentMap[5]"; ?></span></a></li> <?php
								}
								if(isset($recentMap[7])) { ?>
									<li><a href="/map.php?zipcode=<?php echo "$recentMap[6]";?>&time=<?php echo "$recentMap[7]";?>&weather=<?php echo "$recentMap[8]";?>&amount=3">
									<span> <?php echo "Zip Code: $recentMap[6] Time Period: $recentMap[7] Weather: $recentMap[8]"; ?></span></a></li> <?php
								}
								if(isset($recentMap[10])) { ?>
									<li><a href="/map.php?zipcode=<?php echo "$recentMap[9]";?>&time=<?php echo "$recentMap[10]";?>&weather=<?php echo "$recentMap[11]";?>&amount=3">
									<span> <?php echo "Zip Code: $recentMap[9] Time Period: $recentMap[10] Weather: $recentMap[11]"; ?></span></a></li> <?php
								}
								if(isset($recentMap[13])) { ?>
									<li><a href="/map.php?zipcode=<?php echo "$recentMap[12]";?>&time=<?php echo "$recentMap[13]";?>&weather=<?php echo "$recentMap[14]";?>&amount=3">
									<span> <?php echo "Zip Code: $recentMap[12] Time Period: $recentMap[13] Weather: $recentMap[14]"; ?></span></a></li> <?php
								} 	?>
								
							</ul></div>
						</li>
												
						<?php
						}
						
						if($row[1] != NULL) { ?>
						
						<li><a href="#" class="parent"><span>Directions</span></a>
							<div><ul>  
							
								<li><a href="/directions.php?sLocation=<?php echo "$recentDirections[0]";?>&destination=<?php echo "$recentDirections[1]";?>&time=<?php echo "$recentDirections[2]";?>&amount=3">
									<span> <?php echo "Origin: $recentDirections[0] <br> Destination: $recentDirections[1] <br> Time Period: $recentDirections[2]"; ?></span></a></li> <?php
									
								if(isset($recentDirections[4])) { ?>
									<li><a href="/directions.php?sLocation=<?php echo "$recentDirections[3]";?>&destination=<?php echo "$recentDirections[4]";?>&time=<?php echo "$recentDirections[5]";?>&amount=3">
									<span> <?php echo "Origin: $recentDirections[3] <br> Destination: $recentDirections[4] <br> Time Period: $recentDirections[5]"; ?></span></a></li> <?php
								}
								if(isset($recentDirections[7])) { ?>
									<li><a href="/directions.php?sLocation=<?php echo "$recentDirections[6]";?>&destination=<?php echo "$recentDirections[7]";?>&time=<?php echo "$recentDirections[8]";?>&amount=3">
									<span> <?php echo "Origin: $recentDirections[6] <br> Destination: $recentDirections[7] <br> Time Period: $recentDirections[8]"; ?></span></a></li> <?php
								}
								if(isset($recentDirections[10])) { ?>
									<li><a href="/directions.php?sLocation=<?php echo "$recentDirections[9]";?>&destination=<?php echo "$recentDirections[10]";?>&time=<?php echo "$recentDirections[11]";?>&amount=3">
									<span> <?php echo "Origin: $recentDirections[9] <br> Destination: $recentDirections[10] <br> Time Period: $recentDirections[11]"; ?></span></a></li> <?php
								}
								if(isset($recentDirections[13])) { ?>
									<li><a href="/directions.php?sLocation=<?php echo "$recentDirections[12]";?>&destination=<?php echo "$recentDirections[13]";?>&time=<?php echo "$recentDirections[14]";?>&amount=3">
									<span> <?php echo "Origin: $recentDirections[12] <br> Destination: $recentDirections[13] <br> Time Period: $recentDirections[14]"; ?></span></a></li> <?php
								} 	?>
								

							</ul></div>
						</li> <?php
						} ?>
						
						
					</ul></div>
				</li>
		
			<?php 
			
			} 
			
			?>  <li><a href="/login.php" class="parent"><span>Logout</span></a></li> <?php
		}
		else {
			?>  <li><a href="/login.php" class="parent"><span>Login</span></a></li> <?php	
		}
		?>
		
    </ul>
</div>