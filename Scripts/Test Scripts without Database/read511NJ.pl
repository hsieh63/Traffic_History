# Peter Lin
# 132002835

# This file will read XML files (RSS feeds) from 511nj.org 
# Accident information will be stored to an output file

# Output will be reformatted and stored in a database

use strict;
use warnings;
use Data::Dumper;
use XML::Simple;
use LWP::Simple;


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
	print "511NJ.org Incident number: $length\n\n\n"; # prints the number of incidents
	print OUTPUT "511NJ.org Incident number: $length\n\n\n";

	for(my $i=0;$i<$length;$i++){  
		print OUTPUT Dumper($data->{channel}->{item}->[$i]->{title});	# saves to output file - the road
		print OUTPUT Dumper($data->{channel}->{item}->[$i]->{'georss:point'}); # saves to output file - the coordinates
		print OUTPUT"\n";
		print OUTPUT Dumper($data->{channel}->{item}->[$i]->{description}); # saves to output file - description of the incident
		# the description will be parsed later for key words, to determine the severity of the incident
		print OUTPUT"\n\n\n\n";
	}
	close OUTPUT;
}


# main function
getNjTraffic();
print "Check output file for results\n\n";