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
use Math::Trig;

#change databaseName to actual database name
my $dataSource = 'dbi:mysql:traffich_main';
my $dbUser     = 'traffich_admin';
my $dbPass     = 'Admin2013';

my $dbh = DBI->connect( $dataSource, $dbUser, $dbPass )
  or die "Counldn't connect to database: " . DBI->errstr;

#to prepare statements
#pull data out of traffic incident table(street,long,lat,zipcode)
#also should only pull out for the previous day or something depending on how the script is run
my $sth = $dbh->prepare(
"SELECT tm.Zipcode,tm.Date_Time,tm.Latitude,tm.Longitude,tm.Severity,tm.Address,w.Weather FROM Traffic_Mapquest as tm, Weather as w,Zip_Cdoes as zc WHERE DATE(Date_Time) = CURDATE() and w.Zipcode = zc.Zipcode and tm.County = zc.County and DATE(Timestamp) = CURDATE()"
) or die "Couldn't prepare statemenent: " . $dbh->errstr;
my $sth2 = $dbh->prepare(
"SELECT td.Zipcode,td.Date_Time,td.Latitude,td.Longitude,td.Severity,td.Address,w.Weather FROM Traffic_Display as td, Weather as w,Zip_Cdoes as zc WHERE DATE(Date_Time) = CURDATE() and w.Zipcode = zc.Zipcode and td.County = zc.County and DATE(Timestamp) = CURDATE()"
) or die "Couldn't prepare statemenent: " . $dbh->errstr;
$sth->execute() or die "Couldn't execute statement: " . $sth->errstr;
my $gatheredPoints = {};
my $displayPoints  = {};
while ( my $rowHash = $sth->fetchrow_hashref() ) {
	$rowHash->{"Date_Time"} =~ m/\d+-\d+-\d+ (\d+):.*/;
	my $hour = $1;
	if ( $hour == 12 || $hour == 1 || $hour == 2 ) {
		if (
			exists $gatheredPoints->{ $rowHash->{"Weather"} }->{'0'}
			->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			->{ $rowHash->{"Latitude"} } )
		{
			my $temp =
			  $gatheredPoints->{ $rowHash->{"Weather"} }->{'0'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} }[0];
			$temp = $temp + $rowHash->{"Severity"};
			$gatheredPoints->{ $rowHash->{"Weather"} }->{'0'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } = $temp;
		}
		else {
			$gatheredPoints->{ $rowHash->{"Weather"} }->{'0'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } =
			  [ $rowHash->{"Severity"}, $rowHash->{"Zipcode"} ];
		}
	}
	elsif ( $hour == 3 || $hour == 4 || $hour == 5 ) {
		if (
			exists $gatheredPoints->{ $rowHash->{"Weather"} }->{'1'}
			->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			->{ $rowHash->{"Latitude"} } )
		{
			my $temp =
			  $gatheredPoints->{ $rowHash->{"Weather"} }->{'1'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} }[0];
			$temp = $temp + $rowHash->{"Severity"};
			$gatheredPoints->{ $rowHash->{"Weather"} }->{'1'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } = $temp;
		}
		else {
			$gatheredPoints->{ $rowHash->{"Weather"} }->{'1'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } =
			  [ $rowHash->{"Severity"}, $rowHash->{"Zipcode"} ];
		}
	}
	elsif ( $hour == 6 || $hour == 7 || $hour == 8 ) {
		if (
			exists $gatheredPoints->{ $rowHash->{"Weather"} }->{'2'}
			->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			->{ $rowHash->{"Latitude"} } )
		{
			my $temp =
			  $gatheredPoints->{ $rowHash->{"Weather"} }->{'2'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} }[0];
			$temp = $temp + $rowHash->{"Severity"};
			$gatheredPoints->{ $rowHash->{"Weather"} }->{'2'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } = $temp;
		}
		else {
			$gatheredPoints->{ $rowHash->{"Weather"} }->{'2'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } =
			  [ $rowHash->{"Severity"}, $rowHash->{"Zipcode"} ];
		}
	}
	elsif ( $hour == 9 || $hour == 10 || $hour == 11 ) {
		if (
			exists $gatheredPoints->{ $rowHash->{"Weather"} }->{'3'}
			->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			->{ $rowHash->{"Latitude"} } )
		{
			my $temp =
			  $gatheredPoints->{ $rowHash->{"Weather"} }->{'3'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} }[0];
			$temp = $temp + $rowHash->{"Severity"};
			$gatheredPoints->{ $rowHash->{"Weather"} }->{'3'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } = $temp;
		}
		else {
			$gatheredPoints->{ $rowHash->{"Weather"} }->{'3'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } =
			  [ $rowHash->{"Severity"}, $rowHash->{"Zipcode"} ];
		}
	}
	elsif ( $hour == 12 || $hour == 13 || $hour == 14 ) {
		if (
			exists $gatheredPoints->{ $rowHash->{"Weather"} }->{'4'}
			->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			->{ $rowHash->{"Latitude"} } )
		{
			my $temp =
			  $gatheredPoints->{ $rowHash->{"Weather"} }->{'4'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} }[0];
			$temp = $temp + $rowHash->{"Severity"};
			$gatheredPoints->{ $rowHash->{"Weather"} }->{'4'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } = $temp;
		}
		else {
			$gatheredPoints->{ $rowHash->{"Weather"} }->{'4'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } =
			  [ $rowHash->{"Severity"}, $rowHash->{"Zipcode"} ];
		}
	}
	elsif ( $hour == 15 || $hour == 16 || $hour == 17 ) {
		if (
			exists $gatheredPoints->{ $rowHash->{"Weather"} }->{'5'}
			->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			->{ $rowHash->{"Latitude"} } )
		{
			my $temp =
			  $gatheredPoints->{ $rowHash->{"Weather"} }->{'5'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} }[0];
			$temp = $temp + $rowHash->{"Severity"};
			$gatheredPoints->{ $rowHash->{"Weather"} }->{'5'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } = $temp;
		}
		else {
			$gatheredPoints->{ $rowHash->{"Weather"} }->{'5'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } =
			  [ $rowHash->{"Severity"}, $rowHash->{"Zipcode"} ];
		}
	}
	elsif ( $hour == 18 || $hour == 19 || $hour == 20 ) {
		if (
			exists $gatheredPoints->{ $rowHash->{"Weather"} }->{'6'}
			->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			->{ $rowHash->{"Latitude"} } )
		{
			my $temp =
			  $gatheredPoints->{ $rowHash->{"Weather"} }->{'6'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} }[0];
			$temp = $temp + $rowHash->{"Severity"};
			$gatheredPoints->{ $rowHash->{"Weather"} }->{'6'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } = $temp;
		}
		else {
			$gatheredPoints->{ $rowHash->{"Weather"} }->{'6'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } =
			  [ $rowHash->{"Severity"}, $rowHash->{"Zipcode"} ];
		}
	}
	elsif ( $hour == 21 || $hour == 22 || $hour == 23 ) {
		if (
			exists $gatheredPoints->{ $rowHash->{"Weather"} }->{'7'}
			->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			->{ $rowHash->{"Latitude"} } )
		{
			my $temp =
			  $gatheredPoints->{ $rowHash->{"Weather"} }->{'7'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} }[0];
			$temp = $temp + $rowHash->{"Severity"};
			$gatheredPoints->{ $rowHash->{"Weather"} }->{'7'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } = $temp;
		}
		else {
			$gatheredPoints->{ $rowHash->{"Weather"} }->{'7'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } =
			  [ $rowHash->{"Severity"}, $rowHash->{"Zipcode"} ];
		}
	}
}

$sth2->execute() or die "Couldn't execute statement: " . $sth->errstr;
while ( my $rowHash = $sth2->fetchrow_hashref() ) {
	$rowHash->{"Date_Time"} =~ m/\d+-\d+-\d+ (\d+):.*/;
	my $hour = $1;
	if ( $hour == 12 || $hour == 1 || $hour == 2 ) {
		if (
			exists $displayPoints->{ $rowHash->{"Weather"} }->{'0'}
			->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			->{ $rowHash->{"Latitude"} } )
		{
			my $temp =
			  $displayPoints->{ $rowHash->{"Weather"} }->{'0'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} }[0];
			$temp = $temp + $rowHash->{"Severity"};
			$displayPoints->{ $rowHash->{"Weather"} }->{'0'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } = $temp;
		}
		else {
			$displayPoints->{ $rowHash->{"Weather"} }->{'0'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } =
			  [ $rowHash->{"Severity"}, $rowHash->{"Zipcode"} ];
		}
	}
	elsif ( $hour == 3 || $hour == 4 || $hour == 5 ) {
		if (
			exists $displayPoints->{ $rowHash->{"Weather"} }->{'1'}
			->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			->{ $rowHash->{"Latitude"} } )
		{
			my $temp =
			  $displayPoints->{ $rowHash->{"Weather"} }->{'1'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} }[0];
			$temp = $temp + $rowHash->{"Severity"};
			$displayPoints->{ $rowHash->{"Weather"} }->{'1'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } = $temp;
		}
		else {
			$displayPoints->{ $rowHash->{"Weather"} }->{'1'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } =
			  [ $rowHash->{"Severity"}, $rowHash->{"Zipcode"} ];
		}
	}
	elsif ( $hour == 6 || $hour == 7 || $hour == 8 ) {
		if (
			exists $displayPoints->{ $rowHash->{"Weather"} }->{'2'}
			->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			->{ $rowHash->{"Latitude"} } )
		{
			my $temp =
			  $displayPoints->{ $rowHash->{"Weather"} }->{'2'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} }[0];
			$temp = $temp + $rowHash->{"Severity"};
			$displayPoints->{ $rowHash->{"Weather"} }->{'2'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } = $temp;
		}
		else {
			$displayPoints->{ $rowHash->{"Weather"} }->{'2'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } =
			  [ $rowHash->{"Severity"}, $rowHash->{"Zipcode"} ];
		}
	}
	elsif ( $hour == 9 || $hour == 10 || $hour == 11 ) {
		if (
			exists $displayPoints->{ $rowHash->{"Weather"} }->{'3'}
			->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			->{ $rowHash->{"Latitude"} } )
		{
			my $temp =
			  $displayPoints->{ $rowHash->{"Weather"} }->{'3'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} }[0];
			$temp = $temp + $rowHash->{"Severity"};
			$displayPoints->{ $rowHash->{"Weather"} }->{'3'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } = $temp;
		}
		else {
			$displayPoints->{ $rowHash->{"Weather"} }->{'3'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } =
			  [ $rowHash->{"Severity"}, $rowHash->{"Zipcode"} ];
		}
	}
	elsif ( $hour == 12 || $hour == 13 || $hour == 14 ) {
		if (
			exists $displayPoints->{ $rowHash->{"Weather"} }->{'4'}
			->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			->{ $rowHash->{"Latitude"} } )
		{
			my $temp =
			  $displayPoints->{ $rowHash->{"Weather"} }->{'4'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} }[0];
			$temp = $temp + $rowHash->{"Severity"};
			$displayPoints->{ $rowHash->{"Weather"} }->{'4'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } = $temp;
		}
		else {
			$displayPoints->{ $rowHash->{"Weather"} }->{'4'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } =
			  [ $rowHash->{"Severity"}, $rowHash->{"Zipcode"} ];
		}
	}
	elsif ( $hour == 15 || $hour == 16 || $hour == 17 ) {
		if (
			exists $displayPoints->{ $rowHash->{"Weather"} }->{'5'}
			->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			->{ $rowHash->{"Latitude"} } )
		{
			my $temp =
			  $displayPoints->{ $rowHash->{"Weather"} }->{'5'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} }[0];
			$temp = $temp + $rowHash->{"Severity"};
			$displayPoints->{ $rowHash->{"Weather"} }->{'5'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } = $temp;
		}
		else {
			$displayPoints->{ $rowHash->{"Weather"} }->{'5'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } =
			  [ $rowHash->{"Severity"}, $rowHash->{"Zipcode"} ];
		}
	}
	elsif ( $hour == 18 || $hour == 19 || $hour == 20 ) {
		if (
			exists $displayPoints->{ $rowHash->{"Weather"} }->{'6'}
			->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			->{ $rowHash->{"Latitude"} } )
		{
			my $temp =
			  $displayPoints->{ $rowHash->{"Weather"} }->{'6'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} }[0];
			$temp = $temp + $rowHash->{"Severity"};
			$displayPoints->{ $rowHash->{"Weather"} }->{'6'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } = $temp;
		}
		else {
			$displayPoints->{ $rowHash->{"Weather"} }->{'6'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } =
			  [ $rowHash->{"Severity"}, $rowHash->{"Zipcode"} ];
		}
	}
	elsif ( $hour == 21 || $hour == 22 || $hour == 23 ) {
		if (
			exists $displayPoints->{ $rowHash->{"Weather"} }->{'7'}
			->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			->{ $rowHash->{"Latitude"} } )
		{
			my $temp =
			  $displayPoints->{ $rowHash->{"Weather"} }->{'7'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} }[0];
			$temp = $temp + $rowHash->{"Severity"};
			$displayPoints->{ $rowHash->{"Weather"} }->{'7'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } = $temp;
		}
		else {
			$displayPoints->{ $rowHash->{"Weather"} }->{'7'}
			  ->{ $rowHash->{"Address"} }->{ $rowHash->{"Longitude"} }
			  ->{ $rowHash->{"Latitude"} } =
			  [ $rowHash->{"Severity"}, $rowHash->{"Zipcode"} ];
		}
	}
}

my %gatheredPointsHash = %$gatheredPoints;
my %displayPointsHash  = %$displayPoints;

#hash->weather->time->zipcode->street/Address->longitude->latitude = severity
foreach my $time ( sort keys %gatheredPointsHash ) {
	foreach my $weather ( sort keys %{ $gatheredPointsHash{$time} } ) {
		foreach
		  my $address ( sort keys %{ $gatheredPointsHash{$time}{$weather} } )
		{
			my $displayRef;
			my $displayFlag = 0;
			if ( exists $displayPointsHash{$time}{$weather}{$address} ) {
				$displayRef = $displayPointsHash{$time}{$weather}{$address};
			}
			else {
				$displayFlag = 1;
			}
			foreach my $long (
				sort
				keys %{ $gatheredPointsHash{$time}{$weather}{$address} }
			  )
			{
				foreach my $lat (
					sort keys
					%{ $gatheredPointsHash{$time}{$weather}{$address}{$long} } )
				{
					if ( $displayFlag == 1 ) {
						$displayPointsHash{$time}{$weather}{$address}{$long}
						  {$lat} =
						  $gatheredPointsHash{$time}{$weather}{$address}{$long}
						  {$lat};
						$displayFlag = 0;
						$displayRef =
						  $displayPointsHash{$time}{$weather}{$address};
						last;
					}
					else {
						my ( $inputLat, $inputLong );
						my $distanceFlag    = 0;
						my $nearbyFlag      = 0;
						my $compareDistance = 0;
						foreach my $displayLong ( sort keys %{$displayRef} ) {
							foreach my $displayLat (
								sort keys %{ $displayRef->{$displayLong} } )
							{

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
								my $a    = sin( ( $lat2 - $lat1 ) / 2.0 );
								my $b    = sin( ( $lon2 - $lon1 ) / 2.0 );
								my $h =
								  ( $a * $a ) +
								  cos($lat1) * cos($lat2) * ( $b * $b );
								my $theta =
								  2 * asin( sqrt($h) );    # distance in radians
								 #in order to find the distance, multiply $theta by the radius of the earth, e.g.
								 #$theta * 6,372.7976 = distance in kilometres (value from http://en.wikipedia.org/wiki/Earth_radius)
								my $distanceKm = $theta * 6372.7976;

								#from km  to miles
								my $distanceMi = $distanceKm * 0.62137;
								if ( $distanceMi < .5 ) {
									if (   $distanceMi < $compareDistance
										|| $distanceFlag == 0 )
									{
										$distanceFlag = 1;
										$nearbyFlag++;
										$inputLat     = $displayLat;
										$inputLong    = $displayLong;
										$compareDistance = $distanceMi;
									}
								}
							}
						}
						if ( $nearbyFlag == 1 ) {
							$displayRef->{$long}->{$lat} =
							  $gatheredPointsHash{$time}{$weather}{$address}
							  {$long}{$lat};
						}
						elsif ($nearbyFlag == 0) {
							warn "Problem nearby flag is zero, nothing is compared\n";
						}
						else {
							$displayRef->{$inputLong}->{$inputLat} =
							  $displayRef->{$inputLong}->{$inputLat} +
							  $gatheredPointsHash{$time}{$weather}{$address}
							  {$long}{$lat};
						}
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
$sth = $dbh->prepare(
"INSERT INTO Traffic_Display (Zipcode,Latitude,Longitude,Severity,Address,Weather,Time) VALUES (?,?,?,?,?,?,,?)"
) or die "Couldn't prepare statemenent: " . $dbh->errstr;
foreach my $time ( sort keys %displayPointsHash ) {
	foreach my $weather ( sort keys %{ $displayPointsHash{$time} } ) {
		foreach my $address (
			sort
			keys %{ $displayPointsHash{$time}{$weather} }
		  )
		{
			foreach my $long (
				sort keys %{ $displayPointsHash{$time}{$weather}{$address} } )
			{
				foreach my $lat (
					sort keys
					%{ $displayPointsHash{$time}{$weather}{$address}{$long} } )
				{
					my @array =
					  $displayPointsHash{$time}{$weather}{$address}{$long}
					  {$lat};
					$sth->execute( $array[1], $lat, $long, $array[0], $address,
						$weather, $time )
					  or die "Couldn't execute statement: " . $sth->errstr;
				}
			}
		}
	}
}

$dbh->disconnect();
