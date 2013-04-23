#traffh_admin : Admin2013
#traffic_user : User2013
use DBI;
use strict;

#change databaseName to actual database name
my $dataSource = 'DBI:mysql:traffich_main';
my $dbUser = 'traffic_admin';
my $dbPass = 'Admin2013';

my $dbh = DBI->connect($dataSource,$dbUser,$dbPass) or die "Counldn't connect to database: " . DBI->errstr;

#to prepare statements
my $sth = $dbh->prepare("INSERT INTO Test_Table (Input) VALUES (?)") or die "Couldn't prepare statemenent: " . $dbh->errstr;
$sth->execute(2) or die "Couldn't execute statement: " . $sth->errstr;
$dbh->disconnect;