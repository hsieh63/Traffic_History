# This is the complete Traffic 511 script 

# This file will read XML files (RSS feeds) from 511nj.org 
# Accident information are stored in a database 


use strict;
use warnings;
use Data::Dumper;
use XML::Simple;
use LWP::Simple;
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


# Will gather data at a specific time interval
=begin
while(true){
	getNjTraffic();
	sleep(60); #sleep for 60 seconds
}	
=cut

sub getNjTraffic(){

	$Data::Dumper::Terse = 1; # important so dump does not print var name

	my $parser = new XML::Simple;
	my $data = $parser->XMLin( get( "http://rss.511nj.org/rss/RSSAllNJActiveEvents" ));
	# stores the xml file into an array


	open OUTPUT, ">read511NJOutput.txt"; # creates a new file for the output to be saved to 


	my $length = Dumper(length($data->{channel}->{item}));
	print "511NJ.org Incident number: $length\n\n"; # prints the number of incidents

	for(my $i=0;$i<$length;$i++){  
	
	#DATABASE IMPLEMENTATION - the data we need is to be stored in our database
	#Obtain required values from API
	
		#API contains a coordinate value, with both longitude and latitude
		my $coordinate = Dumper($data->{channel}->{item}->[$i]->{'georss:point'});
		my $description = Dumper($data->{channel}->{item}->[$i]->{description});
		my $time = Dumper($data->{channel}->{item}->[$i]->{pubDate});
	
		#Since we need the longitude and latitude separately, use subscripts to obtain
		#them from coordinate 
		my $long = getLongitude($coordinate);
		my $lat = getLatitude($coordinate);
	
		#Converts integer from 0-7 (see subscript convertTraffic511Time)
		my $converted_time = convertTraffic511Time($time);

		#if the query handle is not yet defined, define it here (prevents the overhead of defining it in every loop)
		if(! defined $query_handle) {
			$query_handle = $dbh->prepare($SQLinsert)
		or die "Couldn't prepare statement: " . $dbh->errstr;
		}
	
		#execute the query handle
		#uses the DBI to execute the SQL query defined by the handle and store the given variables in the database
		$query_handle->execute($long, $lat, $description, $converted_time);
	}
	
	close OUTPUT;
}

#get longitude from nj511 coordinate
sub getLongitude{	
	my $coordinate = $_[0];
	if($coordinate =~ /(\S+)\s(\S+)/) {
		print "poop";
		my $longitude = $1;
		return $longitude;
	}
}

#get latitude from nj511 coordinate
sub getLatitude{	
	my $coordinate = $_[0];
	if($coordinate =~ /(\S+)\s(\S+)/) {
		my $latitude = $2;
		return $latitude;
	}
}

#Converts the string obtained from the API into an integer from 0-7
#The string is in the format "14:35:00"
#12:00:00-2:59:59 = 1, 3:00:00-5:59:59 = 2, ... , 9:00:00-23:59:59 = 7
sub convertTraffic511Time{	
	my $obs_time = $_[0];
	if($obs_time =~ /(\d\d):\d\d:\d\d/) {	#obtain hour from given format
		my $hour = $1;
		
		#based on hour, return the appropriate value
		if ($hour == 0 or $hour == 1 or $hour == 2){
			return 1;
		}
		if ($hour == 3 or $hour == 4 or $hour == 5){
			return 2;
		}
		if ($hour == 6 or $hour == 7 or $hour == 8){
			return 3;
		}
		if ($hour == 9 or $hour == 10 or $hour == 11){
			return 4;
		}			
		if ($hour == 12 or $hour == 13 or $hour == 14){
			return 4;
		}
		if ($hour == 15 or $hour == 16 or $hour == 17){
			return 5;
		}
		if ($hour == 18 or $hour == 19 or $hour == 20){
			return 6;
		}
		if ($hour == 21 or $hour == 22 or $hour == 23){
			return 7;
		}			
	}
	else{
		print "Error";
	}
}

# main function
getNjTraffic();

#Finished querying, close the connection
$query_handle->finish();
$dbh->disconnect();