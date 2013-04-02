#Need to create a script to cache all possible zip codes in tristate
#After caching this script will make a call to database to retrieve all zip codes
#Will make a call for each zip code and only input the desired weather condition into database
#Things to do: cache zip codes, dynamic url call, insert into database required
#our key for weather.com: e5d1818deab8c1a3

use LWP;
use LWP::UserAgent;
use HTTP::Request;
use JSON;

#Fmjtd%7Cluub2168nu%2Cax%3Do5-96zg9u
my $ua = LWP::UserAgent->new; #creates user agent to get http

my $url = 'http://www.mapquestapi.com/traffic/v1/incidents?key=Fmjtd%7Cluub2168nu%2Cax%3Do5-96zg9u&callback=handleIncidentsResponse&boundingBox=40.928272,-74.269274,40.511944,-73.719958&filters=construction,incidents&inFormat=kvp&outFormat=json'; #sets up url, this needs to be dynamic

my $req = HTTP::Request->new(POST => $url); #requesting url
my $jsonResponse = JSON->new; #initilize json object
my $response = $ua->request($req); #get response to url?
$jsonResponse = $response->content; #set content which is a json into json object
print $jsonResponse;
my $hashRef = decode_json $jsonResponse; #decode json using module and gets a hash reference number
my %hash = %$hashRef; #deference hash number to a hash

if ($response->is_success) {
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