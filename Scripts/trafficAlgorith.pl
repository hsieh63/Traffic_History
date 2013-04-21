#Kevin Hsieh
#Creates and updates traffic points in the database
#First pull all gathered traffic points for previous day from database
#Then apply regexp to break it down into every 3 areas and construct a hash for gathered traffic and display traffic (difference is what is used to display on the map)
#Using foreach loops go through the gathered traffic and compare each point against the entire display hash and increasing the severity value when the points are within .5 miles 
# of each other. otherwise it will create a new point in the display hash
#Then insert/update the database with the new display hash 
#
#
##########################################################################################################################################################


#traffh_admin : Admin2013
#traffic_user : User2013
use DBI;
use strict;
use Math::trig;

#change databaseName to actual database name
my $dataSource = 'dbi:DriverName:databaseName';
my $dbUser = 'traffic_user';
my $dbPass = 'User2013';

my $dbh = DBI->connect($dataSource,$dbUser,$dbPass) or die "Counldn't connect to database: " . DBI->errstr;

#to prepare statements
#pull data out of traffic incident table(street,long,lat,zipcode)
#also should only pull out for the previous day or something depending on how the script is run
my $sth = $dbh->prepare("") or die "Couldn't prepare statemenent: " . $dbh->errstr;
my $sth2 = $dbh->prepare("") or die "Couldn't prepare statemenent: " . $dbh->errstr;
$sth->execute() or die "Couldn't execute statement: " . $sth->errstr;
my $gatheredPoints = {};
my $displayPoints = {};
while(my $rowHash = $sth->retchrow_arrayref()) {
	$rowHash->("time") =~ m/(\d+):.*/;
	my $hour = $1;
	if($hour == 12 || $hour == 1 || $hour == 2) {
		if(exists $gatheredPoints->{'0'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")}){
			my $temp = $gatheredPoints->{'0'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")};
			$temp = $temp + $rowHash->("severity");
			$gatheredPoints->{'0'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $temp;
		}
		else {
			$gatheredPoints->{'0'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $rowHash->{"severity"};
		}
	}
	elsif($hour == 3 || $hour == 4 || $hour == 5) {
		if(exists $gatheredPoints->{'1'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")}){
			my $temp = $gatheredPoints->{'1'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")};
			$temp = $temp + $rowHash->("severity");
			$gatheredPoints->{'1'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $temp;
		}
		else {
			$gatheredPoints->{'1'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $rowHash->{"severity"};
		}
	}
	elsif($hour == 6 || $hour == 7 || $hour == 8) {
		if(exists $gatheredPoints->{'2'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")}){
			my $temp = $gatheredPoints->{'2'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")};
			$temp = $temp + $rowHash->("severity");
			$gatheredPoints->{'2'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $temp;
		}
		else {
			$gatheredPoints->{'2'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $rowHash->{"severity"};
		}
	}
	elsif($hour == 9 || $hour == 10 || $hour == 11) {
		if(exists $gatheredPoints->{'3'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")}){
			my $temp = $gatheredPoints->{'3'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")};
			$temp = $temp + $rowHash->("severity");
			$gatheredPoints->{'3'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $temp;
		}
		else {
			$gatheredPoints->{'3'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $rowHash->{"severity"};
		}
	}
	elsif($hour == 12 || $hour == 13 || $hour == 14) {
		if(exists $gatheredPoints->{'4'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")}){
			my $temp = $gatheredPoints->{'4'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")};
			$temp = $temp + $rowHash->("severity");
			$gatheredPoints->{'4'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $temp;
		}
		else {
			$gatheredPoints->{'4'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $rowHash->{"severity"};
		}
	}
	elsif($hour == 15 || $hour == 16 || $hour == 17) {
		if(exists $gatheredPoints->{'5'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")}){
			my $temp = $gatheredPoints->{'5'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")};
			$temp = $temp + $rowHash->("severity");
			$gatheredPoints->{'5'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $temp;
		}
		else {
			$gatheredPoints->{'5'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $rowHash->{"severity"};
		}
	}
	elsif($hour == 18 || $hour == 19 || $hour == 20) {
		if(exists $gatheredPoints->{'6'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")}){
			my $temp = $gatheredPoints->{'6'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")};
			$temp = $temp + $rowHash->("severity");
			$gatheredPoints->{'6'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $temp;
		}
		else {
			$gatheredPoints->{'6'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $rowHash->{"severity"};
		}
	}
	elsif($hour == 21 || $hour == 22 || $hour == 23) {
		if(exists $gatheredPoints->{'7'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")}){
			my $temp = $gatheredPoints->{'7'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")};
			$temp = $temp + $rowHash->("severity");
			$gatheredPoints->{'7'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $temp;
		}
		else {
			$gatheredPoints->{'7'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $rowHash->{"severity"};
		}
	}
}

$sth2->execute() or die "Couldn't execute statement: " . $sth2->errstr;
while(my $rowHash = $sth2->retchrow_arrayref()) {
	$rowHash->("time") =~ m/(\d+):.*/;
	my $hour = $1;
	if($hour == 12 || $hour == 1 || $hour == 2) {
		if(exists $displayPoints->{'0'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")}){
			my $temp = $displayPoints->{'0'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")};
			$temp = $temp + $rowHash->("severity");
			$displayPoints->{'0'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $temp;
		}
		else {
			$displayPoints->{'0'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $rowHash->{"severity"};
		}
	}
	elsif($hour == 3 || $hour == 4 || $hour == 5) {
		if(exists $displayPoints->{'1'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")}){
			my $temp = $displayPoints->{'1'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")};
			$temp = $temp + $rowHash->("severity");
			$displayPoints->{'1'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $temp;
		}
		else {
			$displayPoints->{'1'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $rowHash->{"severity"};
		}
	}
	elsif($hour == 6 || $hour == 7 || $hour == 8) {
		if(exists $displayPoints->{'2'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")}){
			my $temp = $displayPoints->{'2'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")};
			$temp = $temp + $rowHash->("severity");
			$displayPoints->{'2'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $temp;
		}
		else {
			$displayPoints->{'2'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $rowHash->{"severity"};
		}
	}
	elsif($hour == 9 || $hour == 10 || $hour == 11) {
		if(exists $displayPoints->{'3'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")}){
			my $temp = $displayPoints->{'3'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")};
			$temp = $temp + $rowHash->("severity");
			$displayPoints->{'3'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $temp;
		}
		else {
			$displayPoints->{'3'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $rowHash->{"severity"};
		}
	}
	elsif($hour == 12 || $hour == 13 || $hour == 14) {
		if(exists $displayPoints->{'4'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")}){
			my $temp = $displayPoints->{'4'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")};
			$temp = $temp + $rowHash->("severity");
			$displayPoints->{'4'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $temp;
		}
		else {
			$displayPoints->{'4'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $rowHash->{"severity"};
		}
	}
	elsif($hour == 15 || $hour == 16 || $hour == 17) {
		if(exists $displayPoints->{'5'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")}){
			my $temp = $displayPoints->{'5'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")};
			$temp = $temp + $rowHash->("severity");
			$displayPoints->{'5'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $temp;
		}
		else {
			$displayPoints->{'5'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $rowHash->{"severity"};
		}
	}
	elsif($hour == 18 || $hour == 19 || $hour == 20) {
		if(exists $displayPoints->{'6'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")}){
			my $temp = $displayPoints->{'6'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")};
			$temp = $temp + $rowHash->("severity");
			$displayPoints->{'6'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $temp;
		}
		else {
			$displayPoints->{'6'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $rowHash->{"severity"};
		}
	}
	elsif($hour == 21 || $hour == 22 || $hour == 23) {
		if(exists $displayPoints->{'7'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")}){
			my $temp = $displayPoints->{'7'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")};
			$temp = $temp + $rowHash->("severity");
			$displayPoints->{'7'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $temp;
		}
		else {
			$displayPoints->{'7'}->{$rowHash->("address")}->{$rowHash->("long")}->{$rowHash->("lat")} = $rowHash->{"severity"};
		}
	}
}

my %gatheredPointsHash = %$gatheredPoints;
my %displayPointsHash = %$displayPoints;

foreach my $time (sort keys %gatheredPointsHash) {
	foreach my $address (sort keys %{$gatheredPointsHash{$time}}) {
		my $displayRef;
		my $displayFlag = 0;
		if(exists $displayPointsHash{$time}{$address}) {
			$displayRef = $displayPointsHash{$time}{$address};
		}
		else {
			$displayFlag = 1;
		}
		foreach my $long (sort keys %{$gatheredPointsHash{$time}{$address}}) {
			foreach my $lat (sort keys %{$gatheredPointsHash{$time}{$address}{$long}}) {
				if($displayFlag == 1) {
					$displayPointsHash{$time}{$address}{$long}{$lat} = $gatheredPointsHash{$time}{$address}{$long}{$lat};
					$displayFlag = 0;
					$displayRef = $displayPointsHash{$time}{$address};
					last;
				}
				else {
					my ($compareDistance, $inputLat, $inputLong);
					my $distanceFlag = 0;
					my $nearbyFlag = 0;
					foreach my $displayLong (sort keys %{$displayRef}) {
						foreach my $displayLat (sort keys %{$displayRef->{$displayLong}}) {
							#$lat1 and $lon1 are the coordinates of the first point in radians
							#$lat2 and $lon2 are the coordinates of the second point in radians
							#angle_radians=(pi/180)*angle_degrees
							#my $lat1 = $lat*(PI/2);
							#my $lon1 = $long*(PI/2);
							#my $lat2 = $displayLat*(PI/2);
							#my $lon2 = $displayLong*(PI/2);
							my $lat1 = deg2rad($lat);
							my $lon1 = deg2rad($long);
							my $lat2 = deg2rad($displayLat);
							my $lon2 = deg2rad($displayLong);
							my $a = sin(($lat2 - $lat1)/2.0);
							my $b = sin(($lon2 - $lon1)/2.0);
							my $h = ($a*$a) + cos($lat1) * cos($lat2) * ($b*$b);
							my $theta = 2 * asin(sqrt($h)); # distance in radians
							#in order to find the distance, multiply $theta by the radius of the earth, e.g.
							#$theta * 6,372.7976 = distance in kilometres (value from http://en.wikipedia.org/wiki/Earth_radius)
							my $distanceKm = $theta * 6372.7976;
							#from km  to miles
							my $distanceMi = $distanceKm / 1.60934;
							if($distanceMi < .5){
								if($distanceMi < $compareDistance || $distanceFlag == 0) {
									$distanceFlag = 1;
									$nearbyFlag = 1;
									$inputLat = $displayLat;
									$inputLong = $displayLong;
									$compareDistance = $distanceMi;
								}
							}
						}
					}
					if($nearbyFlag == 0) {
						$displayRef->{$long}->{$lat} = $gatheredPointsHash{$time}{$address}{$long}{$lat};
					}
					else{
						$displayRef->{$inputLong}->{$inputLat} = $displayRef->{$inputLong}->{$inputLat} + $gatheredPointsHash{$time}{$address}{$long}{$lat};
					}
				}
			}
		}
	}
}

#change hash to hash to hash... to hash to hash to array
#after getting data in hashes of hashes
#perform distance check
#then either add to point in display hash or create new point in display hash
#then push display hash back into database
$sth = $dbh->prepare("") or die "Couldn't prepare statemenent: " . $dbh->errstr;
foreach my $time (sort keys %displayPointsHash) {
	foreach my $address (sort keys %{$_}) {
		foreach my $long (sort keys %{$_}) {
			foreach my $lat (sort keys %{$_}) {
				$sth->execute() or die "Couldn't execute statement: " . $sth->errstr;				
			}
		}
	}
}

$dbh->disconnect();