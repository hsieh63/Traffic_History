use strict;
use warnings;

use DBI;
use DBD::ODBC;

#Config variables
my $dsn = "DBI:ODBC:Driver={SQL Server}"; #might have to change
my $host = '10.0.0.1,1433';		#change to server name
my $database = 'databasename';  #change to database name
my $user = 'Kevin';				#database user name
my $auth = 'kevinblah';

#Use DBD::OBDC module to connect to SQL database 

my $dbh = DBI->connect('$dsn;Server=$host;Database=$database',
						$user,
						$auth,  #might have different parameters
					  ) || die "Database connection not made: $DBI::errstr";
					  
#Prepare the SQL insertion - just test that it works
my $SQLinsert = "INSERT INTO table_name (zipcode, weather)" .
				 "VALUES (08873, Sunny)";
my $query_handle = $dbh->prepare($SQLinsert);
				 
#Will actually be parsing a text file and inserting many rows
				 
#Execute query
$query_handle->execute();

#Finished querying, close the connection
$query_handle->finish();
$dbh->disconnect();