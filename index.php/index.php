<?php include 'header.php'; ?>
    <div align="center">
        Welcome to Traffic Monitoring History. <br><br>
		
		<?php 
		session_start();
		
		if ($_SESSION['loggedin'] == TRUE) { ?>
			You are currently logged in - Username: <?php echo $_SESSION['username']; 
		} ?>
		
    </div>
<?php include 'footer.php'; ?>
