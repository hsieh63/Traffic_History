#old idea
#Need to create a script to cache all possible zip codes in tristate
#After caching this script will make a call to database to retrieve all zip codes

#to add
#should add error checkers for in case map service fails or has exceeded limits
#Things to do: cache zip codes, dynamic url call, insert into database required
#our key for developer.mapquest.com: Fmjtd%7Cluub2168nu%2Cax%3Do5-96zg9u

#new idea
#create bounding box to cover area
#have it cover all of tristate

use LWP;
use LWP::UserAgent;
use HTTP::Request;
use JSON;
use DBI;

#my @highwayArray = ("Route","RT","CR","I-","US","Turnpike","NJTP","Parkway","Pkwy");
my %boundingBox = (
	1  => { 45.106424 => -76.335860, },
	2  => { 43.543749 => -73.238476, },
	3  => { 43.725474 => -79.752497, },
	4  => { 41.746456 => -73.431732, },
	5  => { 42.192222 => -80.507425, },
	6  => { 39.706508 => -79.658603, },
	7  => { 42.171833 => -79.706045, },
	8  => { 40.567500 => -73.539199, },
	9  => { 40.848351 => -79.745373, },
	10 => { 39.717166 => -75.792135, },
	11 => { 40.717688 => -75.791919, },
	12 => { 39.405508 => -74.051794, },
	13 => { 39.539716 => -75.753014, },
	14 => { 38.739870 => -74.392522, },
	15 => { 41.188399 => -73.531727, },
	16 => { 40.450196 => -72.034044, },
);
my ( $firstBBLat, $firstBBLong, $secondBBLat, $secondBBLong );
foreach my $number ( sort keys %boundingBox ) {
	my %nestedBB = %{ $boundingBox{$number} };
	foreach my $BBLat ( sort keys %nestedBB ) {
		if ( ( $number % 2 ) == 1 ) {
			$firstBBLat  = $BBLat;
			$firstBBLong = $nestedBB{$BBLat};
		}
		else {
			$secondBBLat  = $BBLat;
			$secondBBLong = $nestedBB{$BBLat};
		}
	}
	if ( ( $number % 2 ) == 0 ) {
		my $ua = LWP::UserAgent->new;    #creates user agent to get http

		my $url = "http://www.mapquestapi.com/traffic/v1/incidents?key=Fmjtd%7Cluub2168nu%2Cax%3Do5-96zg9u&boundingBox=".$firstBBLat.",".$firstBBLong.",".$secondBBLat.",".$secondBBLong."&filters=construction,incidents&inFormat=kvp&outFormat=json";
		#sets up url, this needs to be dynamic

		my $req = HTTP::Request->new( POST => $url );    #requesting url
		my $jsonResponse = JSON->new;                    #initilize json object
		my $response     = $ua->request($req);           #get response to url?
		$jsonResponse = $response->content;
		my $hashRef =
		  decode_json $jsonResponse; #decode json using module and gets a hash reference number
		my %hash = %$hashRef;        #deference hash number to a hash

		if ( $response->is_success ) {

		 #Database Implementation - Connect to database using DBI
		 #Config variables - for now, can only compile on Kevin's local computer
			my $dataSource = 'DBI:mysql:traffich_main';
			my $dbUser     = 'traffich_admin';
			my $dbPass     = 'Admin2013';

			my $dbh = DBI->connect( $dataSource, $dbUser, $dbPass )
			  or die "Counldn't connect to database: " . DBI->errstr;
			my $sth = $dbh->prepare(
"INSERT INTO Traffic_Mapquest (Zipcode,Latitude,Longitude,Severity,Short_descrip,Address,County,State) VALUES (?,?,?,?,?,?,?,?)"
			) or die "Couldn't prepare statemenent: " . $dbh->errstr;

	  #user prepare statement and use the execute later when insertion is needed

			#print $response->content;
			#loops through the return to get the long lat
			my $i = 0;
			my ( $long, $lat ) = 0;
			my ( $zipcode, $severity, $street, $county, $state, $shortDes );

			my @arrayIncidents = @{ $hash{incidents} };
			if (@arrayIncidents) {
				foreach (@arrayIncidents) {
					my %hashNest  = %{$_};
					my $stateFlag = 0;
					$lat      = $hashNest{lat};
					$long     = $hashNest{lng};
					$severity = $hashNest{severity};
					$shortDes = $hashNest{shortDesc};

					my $geoUrl =
"http://www.mapquestapi.com/geocoding/v1/reverse?key=Fmjtd|luub2168nu%2Cax%3Do5-96zg9u&json={location:{latLng:{lat:$lat,lng:$long}}}";

					my $reqGeo =
					  HTTP::Request->new( POST => $geoUrl );    #requesting url
					my $jsonResponseGeo = JSON->new;    #initilize json object
					my $responseGeo =
					  $ua->request($reqGeo);            #get response to url?
					$jsonResponseGeo = $responseGeo->content;
					my $hashRefGeo =
					  decode_json $jsonResponseGeo; #decode json using module and gets a hash reference number
					my %hashGeo = %$hashRefGeo; #deference hash number to a hash

					if ( $responseGeo->is_success ) {

					   #print $response->content;
					   #should add if geocode fail add to database with unknown?
						if ( $hashGeo{results}[0]{locations}[0]{street} =~
							m/^(\d+) (\w+) (\w+)/i )
						{
							$street = $2 . $3;
						}
						else {
							$street =
							  $hashGeo{results}[0]{locations}[0]{street};
						}
						$street = $hashGeo{results}[0]{locations}[0]{street};
						$county =
						  $hashGeo{results}[0]{locations}[0]{adminArea4};
						$state = $hashGeo{results}[0]{locations}[0]{adminArea5};
						if (   $state ne "NJ"
							|| $state ne "NY"
							|| $state ne "PA" )
						{
							$stateFlag = 1;
						}
						$zipcode =
						  $hashGeo{results}[0]{locations}[0]{postalCode};

#next part is just a simple loop through hash to see whats inside
#foreach my $keyGeo( keys %hashGeo) {
#	#print "keyGeo: $keyGeo, value: " . $hashGeo{$keyGeo} . "\n";
#	if($keyGeo eq "results") {
#		my @arrayGeo = @{$hashGeo{$keyGeo}};
#		foreach(@arrayGeo){
#			my %hashNestGeo = %{$_};
#			foreach my $key3(keys %hashNestGeo) {
#				#print "key3: $key3, value: " . $hashNestGeo{$key3} . "\n";
#				if($key3 eq 'locations') {
#					my @arrayLoc = @{$hashNestGeo{$key3}};
#					foreach(@arrayLoc){
#						#print "Key: " . $_ . "\n";
#						my %hashNestLoc = %{$_};
#						#foreach my $hashLoc( keys %hashNestLoc) {
#							#keys: street,postalCode,adminArea5?(city),adminArea4?(county),adminArea3(state),sideOfStreet?
#							#print "keyLoc: $hashLoc, value: " . $hashNestLoc{$hashLoc} . "\n";
#						#}
#						#$hashNestLoc{"postalCode"} eq zipcode of area looking at
#						#set flag so that this does not get inserted into
#					}
#				}
#				#elsif($key3 eq 'providedLocation') {
#				#	my %hashProvLoc = %{$hashNestGeo{$key3}};
#				#	foreach my $provLoc( keys %hashProvLoc) {
#				#		#print "keyGeo: $provLoc, value: " . $hashProvLoc{$provLoc} . "\n";
#				#		my %hashNestProvLoc = %{$hashProvLoc{$provLoc}};
#				#		foreach my $key4( keys %hashNestProvLoc) {
#				#			#print "keyGeo: $key4, value: " . $hashNestProvLoc{$key4} . "\n";
#				#		}
#				#	}
#				#}
#			}
#		}
#	}
#}
						#print "Geo Success\n";
					}
					else {
						print $response->status_line . " Fail\n";
					}

					#need to add error checking so not inserting bad data
					#here we should've put all necessary values into variables
					#put insert into database here

					if ( $stateFlag == 0 ) {
						$sth->execute( $zipcode, $lat, $long, $severity,
							$shortDes, $street, $county, $state )
						  or die "Couldn't execute statement: " . $sth->errstr;
					}

					#for debug purpose to view only 1 incident
					#last;
				}

				#print "Success\n";
				$dbh->disconnect;
			}
		}
		else {
			print $response->status_line . " Fail\n";
		}
	}
}
