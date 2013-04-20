
use LWP;
use LWP::UserAgent;
use HTTP::Request;
use JSON;
use DBI;

#Config variables - for now, can only compile on Kevin's local computer 
my $dsn = "localDSN"; 			  #Data Source Name - 'localDSN' is specific to Kevin's computer
my $host = 'Q6600\Q6600MSSQL';		#change to server name
my $database = 'trafficHistory';  #change to database name
my $user = 'Q6600\kev';				#database user name
my $auth = 'password';				#user password

#Use DBD::OBDC module to connect to SQL database 
#Currently uses a local DSN, this can be changed to connect to a different database
my $dbh = DBI->connect('DBI:ODBC:localDSN',	
			$user,
			$auth,  
			) || die "Database connection not made: $DBI::errstr";
					  
#Prepare the SQL insertion query- COLUMN NAMES LISTED MUST MATCH DATABASE COLUMN NAMES
my $SQLinsert = "INSERT INTO Weather (Zipcode, Weather, Date_Time)" .
				 "VALUES (?, ?, ?)";
my $query_handle; 	#Initialize query handle - define later when it is necessary


	# opens zip code input file and parses for locations
	# zip codes in input file missing the first 0s, but website accepts anyway
	my $zip;
	if (open(FILE, "allZip.txt")) {
		
		
		while (<FILE>) {
			
			  $zip="$_";
			  my $zero = "0";
			  $zip = $zero . $zip ;
			  print "ZIP CODE: 0$_\n";
			
			  insertZip();
			  print "\n";
		}
		print "\n";
		close (FILE);

	} else {
		print "Cannot open file!\n";
	#	exit 1;
	}
	
	
	sub insertZip() {

			my $zipcode = $zip;							

			
			#if the query handle is not yet defined, define it here (prevents the overhead of defining it in every loop)
			if(! defined $query_handle) {
				$query_handle = $dbh->prepare($SQLinsert)
					or die "Couldn't prepare statement: " . $dbh->errstr;
			}
			
			#execute the query handle
			#executes the SQL query defined by the handle and stores the given variables in the database using the DBI
			$query_handle->execute($zipcode);
			
	}


#Finished querying, close the connection
$query_handle->finish();
$dbh->disconnect();