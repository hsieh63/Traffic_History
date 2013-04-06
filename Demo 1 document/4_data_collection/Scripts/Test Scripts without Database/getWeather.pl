#Peter Lin
#132002835


# Zip codes taken from goverment websites, and compiled into input file
# Script will read zip codes and make calls to the weather API by changing the url
# Weather info for each area is stored in an output file

# Output will be reformatted and stored in a database

# our key for weather.com: e5d1818deab8c1a3

use LWP;
use LWP::UserAgent;
use HTTP::Request;
use JSON;
#use DBI;


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
			
			print OUTPUT "key: observation_time, value: " . $hashNest{"observation_time"} . "\n";
			print OUTPUT "key: icon, value: " . $hashNest{"icon"} . "\n";	
			print OUTPUT "key: precip_today_in, value: " . $hashNest{"precip_today_in"} . "\n";						
			print OUTPUT "key: temp_f, value: " . $hashNest{"temp_f"} . "\n";
			print OUTPUT "key: visibility_mi, value: " . $hashNest{"visibility_mi"} . "\n";
			print OUTPUT "key: wind_mph, value: " . $hashNest{"wind_mph"} . "\n";


			
			print OUTPUT "\n\n";
			
			# having OUTPUT after the print statement saves to the OUTPUT file
			

			#print $response->content;
			#next part is just a simple loop through hash to see whats inside
			foreach my $key( keys %hash) {
				print "key: $key, value: " . $hash{$key} . "\n";	
					
				my %hashNest = %{$hash{$key}};
		
				foreach my $keytwo (keys %hashNest) {
					print "key: $keytwo, value: " . $hashNest{$keytwo} . "\n";
				}
			}

			print "Success\n";
		}
		else {
			print $response->status_line. " Fail\n";
		}
		
	}
}



#main function
getWeather();
print "Check output file for results\n\n";

