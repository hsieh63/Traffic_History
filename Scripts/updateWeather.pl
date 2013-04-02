use strict;
use warnings;

use DBI;
use DBD::ODBC;

#Config variables
my $dsn = "localDSN"; #might have to change
my $host = 'Q6600\Q6600MSSQL';		#change to server name
my $database = 'trafficHistory';  #change to database name
my $user = 'Q6600\kev';				#database user name
my $auth = '';

#Use DBD::OBDC module to connect to SQL database 

my $dbh = DBI->connect('DBI:ODBC:localDSN',
						$user,
						$auth,  #might have different parameters
					  ) || die "Database connection not made: $DBI::errstr";
					  
#Prepare the SQL insertion - just test that it works
my $SQLinsert = "INSERT INTO Weather (zipcode, weather)" .
				 "VALUES (08873, 'Sunny')";
my $query_handle = $dbh->prepare($SQLinsert);
				 
#Will actually be parsing a text file and inserting many rows
				 
#Execute query
$query_handle->execute();

#Finished querying, close the connection
$query_handle->finish();
$dbh->disconnect();