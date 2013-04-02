# This is the complete Weather script

# Zip codes taken from goverment websites, and compiled into input file
# Script will read zip codes and make calls to the weather API by changing the url
# Zip codes and weather information are stored in a database

# our key for weather.com: e5d1818deab8c1a3

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
my $auth = 'password';

#Use DBD::OBDC module to connect to SQL database 
my $dbh = DBI->connect('DBI:ODBC:localDSN',
			$user,
			$auth,  #might have different parameters
			) || die "Database connection not made: $DBI::errstr";
					  
#Prepare the SQL insertion - just test that it works
my $SQLinsert = "INSERT INTO Weather (Zipcode, Weather, Date_Time)" .
				 "VALUES (?, ?, ?)";
my $query_handle; 



# script will gather data at specific time intervals
=begin
while(true){
	getWeather();
	sleep(60); #sleep for 60 seconds
}	
=cut


sub getWeather(){
	# opens zip code input file and parses for locations
	# zip codes in input file missing the first 0s, but website accepts anyway
	my $zip;
	if (open(FILE, "zipCodeTestFile.txt")) {
		
		open OUTPUT, ">getWeatherOutput.txt";
		
		while (<FILE>) {
			
			  $zip="$_";
			  print "ZIP CODE: 0$_\n";
			  print OUTPUT "ZIP CODE: 0$_\n";
			  getInfo();
			  print "\n\n";

		}
		print "\n";
		close (FILE);
		close OUTPUT;
	} else {
		print "Cannot open file!\n";
	#	exit 1;
	}

	sub convertTime{
	my $obs_time = $_[0];
		if($obs_time =~ /((\d)+):\d\d\s((AM|PM))/) {
			my $hour = $1;
			my $period = $3;

			if($period eq "AM") {
				if ($hour == 12 or $hour == 1 or $hour == 2){
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
			}
			if($period eq "PM") {
				if ($hour == 12 or $hour == 1 or $hour == 2){
					return 4;
				}
				if ($hour == 3 or $hour == 4 or $hour == 5){
					return 5;
				}
				if ($hour == 6 or $hour == 7 or $hour == 8){
					return 6;
				}
				if ($hour == 9 or $hour == 10 or $hour == 11){
					return 7;
				}			
			}
		}
		else{
			print "Error";
		}
	}

		
	
	
	sub getInfo() {

		# converts the data in the JSON object into a hash table
		my $ua = LWP::UserAgent->new; #creates user agent to get http
		my $url = "http://api.wunderground.com/api/e5d1818deab8c1a3/conditions/q/${zip}.json"; #sets up url, this needs to be dynamic
		#my $url = 'http://api.wunderground.com/api/e5d1818deab8c1a3/conditions/q/CA/San_Francisco.json';

		my $req = HTTP::Request->new(POST => $url); #requesting url
		my $jsonResponse = JSON->new; #initilize json object
		my $response = $ua->request($req); #get response to url?
		$jsonResponse = $response->content; #set content which is a json into json object
		my $hashRef = decode_json $jsonResponse; #decode json using module and gets a hash reference number
		my %hash = %$hashRef; #deference hash number to a hash
		


		if ($response->is_success) {
			my %hashNest = %{$hash{"current_observation"}};			
			
			my $zipcode = $zip;
			my $description = $hashNest{"icon"};
			my $time = $hashNest{"observation_time"};
			my $converted_time = convertTime($time);
			
			print $zipcode;
			print $description;
			print $time;
			print $converted_time;
			
			if(! defined $query_handle) {
				$query_handle = $dbh->prepare($SQLinsert)
					or die "Couldn't prepare statement: " . $dbh->errstr;
			}
			
			$query_handle->execute($zipcode, $description, $converted_time);
			
		}
		else {
			print $response->status_line. " Fail\n";
		}
		
	}
}



#main function
getWeather();
