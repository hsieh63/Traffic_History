#Need to create a script to cache all possible zip codes in tristate
#After caching this script will make a call to database to retrieve all zip codes
#Will make a call for each zip code and only input the desired traffic values into database
#Things to do: cache zip codes, dynamic url call, insert into database required
#our key for developer.mapquest.com: Fmjtd%7Cluub2168nu%2Cax%3Do5-96zg9u

use LWP;
use LWP::UserAgent;
use HTTP::Request;
use JSON;
use DBI;

my @highwayArray = ("Route","RT","CR","I-","US","Turnpike","NJTP","Parkway","Pkwy");
my $ua = LWP::UserAgent->new; #creates user agent to get http

# get zipcode and zipcode center coordinate then + or - .3 long/lat to 15 mile box
my $url = 'http://www.mapquestapi.com/traffic/v1/incidents?key=Fmjtd%7Cluub2168nu%2Cax%3Do5-96zg9u&boundingBox=40.928272,-74.269274,40.511944,-73.719958&filters=construction,incidents&inFormat=kvp&outFormat=json'; #sets up url, this needs to be dynamic
#my $url = 'http://www.mapquestapi.com/traffic/v1/incidents?key=Fmjtd%7Cluub2168nu%2Cax%3Do5-96zg9u&callback=handleIncidentsResponse&boundingBox=40.928272,-74.269274,40.511944,-73.719958&filters=construction,incidents&inFormat=kvp&outFormat=json'; #sets up url, this needs to be dynamic

my $req = HTTP::Request->new(POST => $url); #requesting url
my $jsonResponse = JSON->new; #initilize json object
my $response = $ua->request($req); #get response to url?
#my $textResponse = $response->content;
#$textResponse =~ m/^handleIncidentsResponse\((.*)\);$/g; #set content which is a json into json object
#$jsonResponse = $1;
#print $jsonResponse . "\n";
$jsonResponse = $response->content;
my $hashRef = decode_json $jsonResponse; #decode json using module and gets a hash reference number
my %hash = %$hashRef; #deference hash number to a hash

if ($response->is_success) {

	#Database Implementation - Connect to database using DBI
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
	my $SQLinsert = "INSERT INTO Weather (Longitude, Latitude, Traffic_Descrip, Date_Time)" .
					"VALUES (?, ?, ?, ?)";
	my $query_handle; 	#Initialize query handle - define later when it is necessary

	#print $response->content;
	#loops through the return to get the long lat
	my $i = 0;
	#print %{@{$hash{'incidents'}}[2]};
	foreach my $key( keys %hash) {
		#print "key: $key, value: " . $hash{$key} . "\n";
		if($key eq "incidents") {
			my @arrayIncidents = @{$hash{$key}};
			foreach(@arrayIncidents) {
				my ($long, $lat) = 0;
				my %hashNest = %{$_};
				foreach my $key2(keys %hashNest) {
					#print "key: $key2, value: " . $hashNest{$key2} . "\n";
					if($key2 eq "lng") {
						$long = $hashNest{$key2};
					}
					elsif($key2 eq "lat"){
						$lat = $hashNest{$key2};
					}
				}
				my $geoUrl = "http://www.mapquestapi.com/geocoding/v1/reverse?key=Fmjtd|luub2168nu%2Cax%3Do5-96zg9u&json={location:{latLng:{lat:$lat,lng:$long}}}";
				my $reqGeo = HTTP::Request->new(POST => $geoUrl); #requesting url
				my $jsonResponseGeo = JSON->new; #initilize json object
				my $responseGeo = $ua->request($reqGeo); #get response to url?
				$jsonResponseGeo = $responseGeo->content;
				my $hashRefGeo = decode_json $jsonResponseGeo; #decode json using module and gets a hash reference number
				my %hashGeo = %$hashRefGeo; #deference hash number to a hash
				
				if ($responseGeo->is_success) {
					#print $response->content;
					#next part is just a simple loop through hash to see whats inside
					foreach my $keyGeo( keys %hashGeo) {
						#print "keyGeo: $keyGeo, value: " . $hashGeo{$keyGeo} . "\n";
						if($keyGeo eq "results") {
							my @arrayGeo = @{$hashGeo{$keyGeo}};
							foreach(@arrayGeo){
								my %hashNestGeo = %{$_};
								foreach my $key3(keys %hashNestGeo) {
									#print "key3: $key3, value: " . $hashNestGeo{$key3} . "\n";
									if($key3 eq 'locations') {
										my @arrayLoc = @{$hashNestGeo{$key3}};
										foreach(@arrayLoc){
											#print "Key: " . $_ . "\n";
											my %hashNestLoc = %{$_};
											foreach my $hashLoc( keys %hashNestLoc) {
												#print "keyLoc: $hashLoc, value: " . $hashNestLoc{$hashLoc} . "\n";
											}
											#$hashNestLoc{"postalCode"} eq zipcode of area looking at
											#set flag so that this does not get inserted into 
										}
									}
									elsif($key3 eq 'providedLocation') {
										my %hashProvLoc = %{$hashNestGeo{$key3}};
										foreach my $provLoc( keys %hashProvLoc) {
											#print "keyGeo: $provLoc, value: " . $hashProvLoc{$provLoc} . "\n";
											my %hashNestProvLoc = %{$hashProvLoc{$provLoc}};
											foreach my $key4( keys %hashNestProvLoc) {
												#print "keyGeo: $key4, value: " . $hashNestProvLoc{$key4} . "\n";
											}
										}
									}
								}
							}
						}
					}
					print "Geo Success\n";
					
					#STILL TO BE IMPLEMENTED - Prepare the query and execute it, adding a new incident row to our database
					#if the query handle is not yet defined, define it here (prevents the overhead of defining it in every loop)
					#	if(! defined $query_handle) {
					#	$query_handle = $dbh->prepare($SQLinsert)
					#		or die "Couldn't prepare statement: " . $dbh->errstr;
					#	}
						#execute the query handle - STILL TO BE IMPLEMENTED
						#executes the SQL query defined by the handle and stores the given variables in the database using the DBI
						#$query_handle->execute($long, $lat, $description, $time);
				}
				else {
					print $response->status_line. " Fail\n";
				}
			last;
			}
		}
		$i++;
		#for debug purpose stops at one call
		last if ($i == 3);
	}
	print "Success\n";
}
else {
	print $response->status_line. " Fail\n";
}