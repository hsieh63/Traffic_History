Data Collection

We currently have three functioning data collection scripts.  Our Weather script gathers data automatically from the Wunderground API.  First, it reads an input file of zip codes.  Weather information is accessed from the API by changing the zip codes in the url through string manipulation - by looping through all the zip codes in the input file, weather information can be accessed for any zip code we desire.  In order to obtain the information for each zip code, we extract JSON object information and store it into a hash table.

The NJ511 script gathers data from the RSS feeds on 511NJ.org when it is run.  A list of updated traffic incidents are kept in an XML file.

The scripts for extracting data from the Bing Maps API and the Nokia Maps API are still works in progress.

Database Implementation

The APIs grant us access to various information.  However, we have to ensure that the data we are attempting to store in the database is consistent with the database columns.  For example, our database stores an integer called Date_Time, which is an integer from 0-7; 12-2:59AM = 1, 3-5:59AM = 2, ... , 9-11:59PM = 7.  When we obtain the time observed from our Weather API, the get a string saying something like "Last updated on 11:29 PM".  Therefore, we implemented several subscripts which convert the data we receive into data which our database requires.  In our nj511 script, we obtain a 'coordinate', which is a string containing both latitude and longitude.  Our database requires these values separately, so we have subscripts which convert the coordinate into separate latitude and longitude values.

After collecting the information we need, we have to store the information we need in our database.  To do this, our Perl script must be able to connect and interact with our database.  We do this by implementing the Perl Database Interface, or DBI module.  

The DBI module allows us to connect to a database, using the appropriate Database Driver (DBD).  Currently, we are using a local Microsoft SQL database, and thus we are using a driver called OBDC.

This allows us to create SQL queries in our Perl script and use the DBI to connect with our database and execute them.  When we connect using the DBI, the Perl script sends the query to the DBI, which uses the appropriate DBD to translate the query into the format requested by the database.  The database executes the query, and the DBI returns any result back to the Perl script.  

As of now, we have database implementations for our Weather script, and our NJ511 script.  We still have to include database implementation for our Mapquest and Bingmaps scripts; this should not be hard, as all DBI implementations are very similar.


