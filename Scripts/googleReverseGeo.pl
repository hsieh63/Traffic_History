#Kevin Hsieh
#Google reverse geocode script
#has a better accuracy and updated street database
#called once a day to update any missing addresses with street addresses
#
#
##########################################################################################################################################################

#traffh_admin : Admin2013
#traffic_user : User2013
use LWP;
use LWP::UserAgent;
use HTTP::Request;
use JSON;
use DBI;
use DateTime;

#change databaseName to actual database name
my $dataSource = 'dbi:mysql:traffich_main';
my $dbUser     = 'traffich_admin';
my $dbPass     = 'Admin2013';

my $dbh = DBI->connect( $dataSource, $dbUser, $dbPass )
  or die "Counldn't connect to database: " . DBI->errstr;

#to prepare statements
#pull data out of traffic incident table(street,long,lat,zipcode)
#also should only pull out for the previous day or something depending on how the script is run
# AND DATE(Date_Time) = CURDATE()")
my $sth =
  $dbh->prepare("SELECT * FROM `Traffic_Mapquest` WHERE Address LIKE ''") 
  or die "Couldn't prepare statemenent: " . $dbh->errstr;
my $sth2 = $dbh->prepare("UPDATE `Traffic_Mapquest` SET Address = ? WHERE `Index` = ?")
  or die "Couldn't prepare statemenent: " . $dbh->errstr;

$sth->execute() or die "Couldn't execute statement: " . $sth->errstr;
while ( my $rowHash = $sth->fetchrow_hashref() ) {
	my $lat  = $rowHash->{"Latitude"};
	my $long = $rowHash->{"Longitude"};
	my $index = $rowHash->{"Index"};
	
	my $ua = LWP::UserAgent->new;    #creates user agent to get http
	my $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false";
	#print FILE "url : $url\n";
	sleep(10);

	my $req = HTTP::Request->new( GET => $url );    #requesting url
	my $jsonResponse = JSON->new;                    #initilize json object
	my $response     = $ua->request($req);           #get response to url?
	$jsonResponse = $response->content;
	my $hashRef = decode_json $jsonResponse or die print $url; #decode json using module and gets a hash reference number
	my %hash = %$hashRef;        #deference hash number to a hash
	if ( $response->is_success ) {
		my @arrayResult = @{ $hash{"results"} };
		my $street;
		my $breakFlag = 0;
		if (@arrayResult) {
			foreach (@arrayResult) {
				my $resultHashRef = $_;
				#print $resultHashRef;
				foreach (@{$resultHashRef->{"address_components"}}) {
					my $nestedHashRef = $_;
					#print $nestedHashRef;
					if($nestedHashRef->{"types"}[0] eq "route") {
						$street = $nestedHashRef->{"short_name"};
						$breakFlag= 1;
						last;
					}
				}
				if ($breakFlag == 1) {
					last;
				}
			}
			if ($breakFlag == 1) {
				$sth2->execute($street,$index) or die "Couldn't execute statement: " . $sth2->errstr;
			}
		}
	}
}
