Peter Lin


getWeather

README: The script gathers data automatically from the Wunderground API when run. The input file of zip codes must be in the same directory. The script will output the data in the terminal as well as store the data to an output file in the same directory.

read511NJ

README: The script gathers data automatically from the RSS feeds on 511NJ.org when run. The script will output the data in the terminal as well as store the data to an output file in the same directory.


Documentation


The getWeather script read an input file of zip codes. By using the wundergrounds weather api, we access weather information by changing the zip codes in the url through string manipulation. We extract the JSON object information and store it into a hash table. Examples of data include visibility and percipitation. 


The read511NJ script will gather data automatically from the RSS feeds on 511NJ.org when run. A list of updated traffic incidents are kept in an XML file. This script parsed that file and returns relevant info. 


All scripts output the data in the terminal as well as store the data to an output file in the same directory. There is a function that can be uncommented, that will allow the script to run at a specific time interval (i.e. every 3 hours). Additional code to store the data into a database can be found in other files. This script is only meant to test the data collection.

The scripts for extracting data from the Bing Maps API and the Nokia Maps API are a work in progress.
