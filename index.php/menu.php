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
						<li><a href="#" class="parent"><span>Map</span></a>
							<div><ul>  
							
								<li><a href="/map.php?zipcode=<?php echo "$recentMap[0]";?>?time=<?php echo "$recentMap[1]";?>?weather=<?php echo "$recentMap[2]";?>">
									<span> <?php echo "Zip Code: $recentMap[0] Time Period: $recentMap[1] Weather: $recentMap[2]"; ?></span></a></li> <?php
								
								if(isset($recentMap[4])) { ?>
									<li><a href="/map.php?zipcode=<?php echo "$recentMap[3]";?>?time=<?php echo "$recentMap[4]";?>?weather=<?php echo "$recentMap[5]";?>">
									<span> <?php echo "Zip Code: $recentMap[3] Time Period: $recentMap[4] Weather: $recentMap[5]"; ?></span></a></li> <?php
								}
								if(isset($recentMap[7])) { ?>
									<li><a href="/map.php?zipcode=<?php echo "$recentMap[6]";?>?time=<?php echo "$recentMap[7]";?>?weather=<?php echo "$recentMap[8]";?>">
									<span> <?php echo "Zip Code: $recentMap[6] Time Period: $recentMap[7] Weather: $recentMap[8]"; ?></span></a></li> <?php
								}
								if(isset($recentMap[10])) { ?>
									<li><a href="/map.php?zipcode=<?php echo "$recentMap[9]";?>?time=<?php echo "$recentMap[10]";?>?weather=<?php echo "$recentMap[11]";?>">
									<span> <?php echo "Zip Code: $recentMap[9] Time Period: $recentMap[10] Weather: $recentMap[11]"; ?></span></a></li> <?php
								}
								if(isset($recentMap[13])) { ?>
									<li><a href="/map.php?zipcode=<?php echo "$recentMap[12]";?>?time=<?php echo "$recentMap[13]";?>?weather=<?php echo "$recentMap[14]";?>">
									<span> <?php echo "Zip Code: $recentMap[12] Time Period: $recentMap[13] Weather: $recentMap[14]"; ?></span></a></li> <?php
								} ?>
								

							</ul></div>
						</li>
						<li><a href="#" class="parent"><span>Directions</span></a>
							<div><ul>  
							
								<li><a href="/directions.php?sLocation=<?php echo "$recentDirections[0]";?>?destination=<?php echo "$recentDirections[1]";?>">
									<span> <?php echo "Origin: $recentDirections[0] Destination: $recentDirections[1]"; ?></span></a></li> <?php
									
								if(isset($recentDirections[3])) { ?>
									<li><a href="/directions.php?sLocation=<?php echo "$recentDirections[2]";?>?destination=<?php echo "$recentDirections[3]";?>">
									<span> <?php echo "Origin: $recentDirections[2] Destination: $recentDirections[3]"; ?></span></a></li> <?php
								}
								if(isset($recentDirections[5])) { ?>
									<li><a href="/directions.php?sLocation=<?php echo "$recentDirections[4]";?>?destination=<?php echo "$recentDirections[5]";?>">
									<span> <?php echo "Origin: $recentDirections[4] Destination: $recentDirections[5]"; ?></span></a></li> <?php
								}
								if(isset($recentDirections[7])) { ?>
									<li><a href="/directions.php?sLocation=<?php echo "$recentDirections[6]";?>?destination=<?php echo "$recentDirections[7]";?>">
									<span> <?php echo "Origin: $recentDirections[6] Destination: $recentDirections[7]"; ?></span></a></li> <?php
								}
								if(isset($recentDirections[9])) { ?>
									<li><a href="/directions.php?sLocation=<?php echo "$recentDirections[8]";?>?destination=<?php echo "$recentDirections[9]";?>">
									<span> <?php echo "Origin: $recentDirections[8] Destination: $recentDirections[9]"; ?></span></a></li> <?php
								} ?>
								

							</ul></div>
						</li>
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