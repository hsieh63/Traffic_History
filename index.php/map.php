<?php include 'header.php'; ?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=AIzaSyAdM76kzhZ0uwCyHxZLogbt5Sc9PrF1RpM" type="text/javascript"></script>
<script src="http://www.acme.com/javascript/OverlayMessage.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
    $('#mapImageData').validate({
        rules: {
            zipcode: {
                required: true,
                minlength: 5,
                maxlength: 5,
                digits: true
            },
            time : "required",
            weather : "required"
        },
        messages: {
            zipcode: {
                required: "Please input a zipcode",
                minlength: "Zipcode must be 5 digits",
                maxlength: "Zipcode must be 5 digits",
                digits: "Zipcode must be digits"
            },
            time : "Please select a time",
            weather : "Please select a weather condition."
        },
        submitHandler: function(form) {
            $.ajax({
                url: "mapImaging.php",
                type: "POST",
                data: $('#mapImageData').serialize(),
                success: function(response) {
                    //$('#zoomIn').show();
                    //$('#zoomOut').show();
                    $('#intensityColorTble').show();
                    $('#mapImageData').find('#formResult').html(response);
                    //alert('Success');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //alert('Error');
                }
            });
        },
        invalidHandler: function(event, validator) {
            return false;
        }
    });
    $('#zoomIn').hide();
    $('#zoomOut').hide();
    $('#zoomIn').click(function () {
        var imgSrc = $('#mapImg').attr('src');
        var zoomLvlSt = $('#zoomLvl').attr('value');
        var zoomLvl = parseInt(zoomLvlSt);
        zoomLvl = zoomLvl + 1;
        var newSrc = 'zoom=' + zoomLvl;
        imgSrc = imgSrc.replace(/zoom=\d+/g,newSrc);
        $('#mapImg').attr('src', imgSrc);
        $('#zoomLvl').attr('value',zoomLvl);
    });
    $('#zoomOut').click(function () {
        var imgSrc = $('#mapImg').attr('src');
        var zoomLvlSt = $('#zoomLvl').attr('value');
        var zoomLvl = parseInt(zoomLvlSt);
        zoomLvl = zoomLvl - 1;
        var newSrc = 'zoom=' + zoomLvl;
        imgSrc = imgSrc.replace(/zoom=\d+/g,newSrc);
        $('#mapImg').attr('src', imgSrc);
        $('#zoomLvl').attr('value',zoomLvl);
    });
});
</script>
<script>
$(document).ready(function() {
    function GetQueryStringParams(sParam)
    {
        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++) 
        {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam) 
            {
                return sParameterName[1];
            }
        }
    }
    if (GetQueryStringParams('amount') == 3) {
        $.ajax({
                url: "mapImaging.php",
                type: "POST",
                data: {zipcode : GetQueryStringParams('zipcode'), time : GetQueryStringParams('time'),weather : GetQueryStringParams('weather')},
                success: function(response) {
                    //$('#zoomIn').show();
                    //$('#zoomOut').show();
                    $('#intensityColorTble').show();
                    $('#mapImageData').find('#formResult').html(response);
                    //alert('Success');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //alert('Error');
                }
            });
    }

});
</script>
    <div align="center">
        <form id="mapImageData" action="" method="">
        <table>
            <tr>
                <td>
                    Zipcode: <input name="zipcode" id="zipcode">
                </td>
                <td>
                    <select name="time">
                        <option value="-1" selected="selected" disabled>Select a time period</option>
                        <option value="0">12am-3am</option>
                        <option value="1">3am-6am</option>
                        <option value="2">6am-9am</option>
                        <option value="3">9am-12pm</option>
                        <option value="4">12am-3pm</option>
                        <option value="5">3pm-6pm</option>
                        <option value="6">6pm-9pm</option>
                        <option value="7">9pm-12am</option>
                    </select>
                </td>
                <td>
                    <select name="weather">
                        <option value="-1" selected="selected" disabled>Select weather condition</option>
                        <option value="all">All</option>
                        <option value="sunny">Sunny</option>
                        <option value="clear">Clear</option>
                        <option value="rain">Rainy</option>
                        <option value="cloudy">Cloudy</option>
                        <option value="sleet">Sleet</option>
                        <option value="snow">Snow</option>
                        <option value="tstorms">Thunder Storms</option>
                        <option value="unknown">Unkown</option>
                    </select>
                </td>
                <td>
                    <input type="submit" value="Submit" id="submitInput">
                </td>
            </tr>
            <tr>
                <td>
                    <label class="error" for="zipcode" style="color:#FF0000;"></label>
                </td>
                <td>
                    <label class="error" for="time" style="color:#FF0000;"></label>
                </td>
                <td>
                    <label class="error" for="weather" style="color:#FF0000;"></label>
                </td>
                <td>
                </td>
            </tr>
        </table>
        <br>
        <button id="zoomIn" type="button" style="display: none;">Zoom In</button>
        <button id="zoomOut" type="button" style="display: none;">Zoom Out</button>
        <br>
        <table id="intensityColorTble" style="text-align:center;display: none;">
            <tr>
                <td colspan=5>
                    Severity color correspondence (low to high)
                </td>
            </tr>
            <tr>
                <td>
                    <label style="background-color:#00FF00;">Severity : 1 (lowest)</label>
                </td>
                <td>
                    <label style="background-color:#CCFF00;">Severity : 2 (lower)</label>
                </td>
                <td>
                    <label style="background-color:#FFFF00;">Severity : 3 (medium)</label>
                </td>
                <td>
                    <label style="background-color:#FF9900;">Severity : 4 (higher)</label>
                </td>
                <td>
                    <label style="background-color:#FF0000;">Severity : 5 (highest)</label>
                </td>
            </tr>
        </table>
        <br>
        <div id="formResult"> </div>
        </form>
    </div>
    
    
<br>

  <body onunload="GUnload()">
    <div id="map" style="width: 550px; height: 450px; margin: 0 auto;"></div>
 

    <noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
      However, it seems JavaScript is either disabled or not supported by your browser. 
      To view Google Maps, enable JavaScript by changing your browser options, and then 
      try again.
    </noscript>
 
    <script type="text/javascript">
    //<![CDATA[

    if (GBrowserIsCompatible()) {

      // display the loading message
      var om = new OverlayMessage(document.getElementById('map'));      
      om.Set('<b>Loading...<\/b>');
      

      var n=0;

      var icon = new GIcon();
      icon.image = "http://labs.google.com/ridefinder/images/mm_20_red.png";
      icon.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
      icon.iconSize = new GSize(12, 20);
      icon.shadowSize = new GSize(22, 20);
      icon.iconAnchor = new GPoint(6, 20);
      icon.infoWindowAnchor = new GPoint(5, 1);      

      iconblue = new GIcon(icon,"http://labs.google.com/ridefinder/images/mm_20_blue.png"); 
      icongreen = new GIcon(icon,"http://labs.google.com/ridefinder/images/mm_20_green.png"); 
      iconyellow = new GIcon(icon,"http://labs.google.com/ridefinder/images/mm_20_yellow.png"); 


      function createMarker(point,name,html,icon) {
        var marker = new GMarker(point, {icon:icon});
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
		  //change stuff here
        });
        return marker;
      }

      // new strategy - read the XML first, THEN create the map


      // read the markers from the XML
      GDownloadUrl("rwanda.xml", function (doc) {
        var gmarkersA = [];      
        var gmarkersB = [];      
        var gmarkersC = [];      
        var gmarkersD = [];      
        var gmarkersE = [];      
        var gmarkersF = [];  
		
          
        var xmlDoc = GXml.parse(doc);
        var markers = xmlDoc.documentElement.getElementsByTagName("marker");

		/*
        for (var i = 0; i < markers.length; i++) {
          // obtain the attribues of each marker
          var lat = parseFloat(markers[i].getAttribute("lat"));
          var lng = parseFloat(markers[i].getAttribute("lng"));
          var point = new GLatLng(lat,lng);
          var town = markers[i].getAttribute("town");
          var pop = markers[i].getAttribute("pop");
          // split the markers into four arrays, with different GIcons
          if (parseInt(pop) > 70000) {
             var marker = createMarker(point,town,town+"<br>Population: "+pop,icon);
             gmarkersA.push(marker);
          }
          else if (parseInt(pop) > 50000) {
             var marker = createMarker(point,town,town+"<br>Population: "+pop,iconyellow);
             gmarkersB.push(marker);
          }
          else if (parseInt(pop) > 40000) {
             var marker = createMarker(point,town,town+"<br>Population: "+pop,icongreen);
             gmarkersC.push(marker);
          }
          else {
             var marker = createMarker(point,town,town+"<br>Population: "+pop,iconblue);
             gmarkersD.push(marker);
          }
        }
		*/

		

		
//07001 40.582568 -74.278522
var zip = "07001";
var point = new GLatLng(40.582568,-74.278522);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07002 40.666399 -74.119169
var zip = "07002";
var point = new GLatLng(40.666399,-74.119169);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07003 40.803456 -74.189074
var zip = "07003";
var point = new GLatLng(40.803456,-74.189074);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07004 40.882178 -74.296027
var zip = "07004";
var point = new GLatLng(40.882178,-74.296027);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07005 40.911528 -74.414035
var zip = "07005";
var point = new GLatLng(40.911528,-74.414035);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07006 40.849059 -74.276771
var zip = "07006";
var point = new GLatLng(40.849059,-74.276771);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07007 40.840833 -74.302222
var zip = "07007";
var point = new GLatLng(40.840833,-74.302222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07008 40.582278 -74.231345
var zip = "07008";
var point = new GLatLng(40.582278,-74.231345);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07009 40.85344 -74.229672
var zip = "07009";
var point = new GLatLng(40.85344,-74.229672);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07010 40.822168 -73.987982
var zip = "07010";
var point = new GLatLng(40.822168,-73.987982);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07011 40.878876 -74.142459
var zip = "07011";
var point = new GLatLng(40.878876,-74.142459);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07012 40.848835 -74.161172
var zip = "07012";
var point = new GLatLng(40.848835,-74.161172);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07013 40.869334 -74.171144
var zip = "07013";
var point = new GLatLng(40.869334,-74.171144);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07014 40.834375 -74.137682
var zip = "07014";
var point = new GLatLng(40.834375,-74.137682);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07015 40.858333 -74.164167
var zip = "07015";
var point = new GLatLng(40.858333,-74.164167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07016 40.655357 -74.305685
var zip = "07016";
var point = new GLatLng(40.655357,-74.305685);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07017 40.769614 -74.207723
var zip = "07017";
var point = new GLatLng(40.769614,-74.207723);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07018 40.755799 -74.219822
var zip = "07018";
var point = new GLatLng(40.755799,-74.219822);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07019 40.767222 -74.205278
var zip = "07019";
var point = new GLatLng(40.767222,-74.205278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07020 40.831654 -73.973821
var zip = "07020";
var point = new GLatLng(40.831654,-73.973821);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07021 40.827924 -74.279705
var zip = "07021";
var point = new GLatLng(40.827924,-74.279705);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07022 40.816985 -73.999967
var zip = "07022";
var point = new GLatLng(40.816985,-73.999967);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07023 40.641856 -74.386762
var zip = "07023";
var point = new GLatLng(40.641856,-74.386762);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07024 40.850312 -73.974455
var zip = "07024";
var point = new GLatLng(40.850312,-73.974455);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07026 40.878886 -74.108141
var zip = "07026";
var point = new GLatLng(40.878886,-74.108141);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07027 40.65121 -74.323864
var zip = "07027";
var point = new GLatLng(40.65121,-74.323864);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07028 40.804015 -74.205477
var zip = "07028";
var point = new GLatLng(40.804015,-74.205477);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07029 40.74754 -74.155871
var zip = "07029";
var point = new GLatLng(40.74754,-74.155871);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07030 40.7445 -74.032863
var zip = "07030";
var point = new GLatLng(40.7445,-74.032863);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07031 40.78977 -74.134288
var zip = "07031";
var point = new GLatLng(40.78977,-74.134288);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07032 40.76466 -74.147108
var zip = "07032";
var point = new GLatLng(40.76466,-74.147108);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07033 40.675869 -74.294419
var zip = "07033";
var point = new GLatLng(40.675869,-74.294419);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07034 40.88252 -74.383013
var zip = "07034";
var point = new GLatLng(40.88252,-74.383013);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07035 40.920769 -74.299512
var zip = "07035";
var point = new GLatLng(40.920769,-74.299512);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07036 40.635366 -74.255567
var zip = "07036";
var point = new GLatLng(40.635366,-74.255567);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07039 40.789633 -74.3202
var zip = "07039";
var point = new GLatLng(40.789633,-74.3202);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07040 40.727906 -74.265573
var zip = "07040";
var point = new GLatLng(40.727906,-74.265573);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07041 40.722798 -74.301469
var zip = "07041";
var point = new GLatLng(40.722798,-74.301469);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07042 40.81307 -74.216467
var zip = "07042";
var point = new GLatLng(40.81307,-74.216467);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07043 40.843023 -74.201104
var zip = "07043";
var point = new GLatLng(40.843023,-74.201104);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07044 40.831928 -74.242847
var zip = "07044";
var point = new GLatLng(40.831928,-74.242847);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07045 40.904914 -74.36456
var zip = "07045";
var point = new GLatLng(40.904914,-74.36456);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07046 40.890447 -74.441487
var zip = "07046";
var point = new GLatLng(40.890447,-74.441487);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07047 40.793019 -74.017715
var zip = "07047";
var point = new GLatLng(40.793019,-74.017715);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07050 40.769223 -74.2355
var zip = "07050";
var point = new GLatLng(40.769223,-74.2355);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07051 40.770556 -74.233056
var zip = "07051";
var point = new GLatLng(40.770556,-74.233056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07052 40.785926 -74.256765
var zip = "07052";
var point = new GLatLng(40.785926,-74.256765);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07054 40.862106 -74.411663
var zip = "07054";
var point = new GLatLng(40.862106,-74.411663);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07055 40.860132 -74.128348
var zip = "07055";
var point = new GLatLng(40.860132,-74.128348);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07057 40.85356 -74.107937
var zip = "07057";
var point = new GLatLng(40.85356,-74.107937);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07058 40.874207 -74.350009
var zip = "07058";
var point = new GLatLng(40.874207,-74.350009);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07059 40.631787 -74.510456
var zip = "07059";
var point = new GLatLng(40.631787,-74.510456);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07060 40.61978 -74.425298
var zip = "07060";
var point = new GLatLng(40.61978,-74.425298);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07061 40.633611 -74.407778
var zip = "07061";
var point = new GLatLng(40.633611,-74.407778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07062 40.631992 -74.406042
var zip = "07062";
var point = new GLatLng(40.631992,-74.406042);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07063 40.604838 -74.445325
var zip = "07063";
var point = new GLatLng(40.604838,-74.445325);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07064 40.570935 -74.246643
var zip = "07064";
var point = new GLatLng(40.570935,-74.246643);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07065 40.608668 -74.281881
var zip = "07065";
var point = new GLatLng(40.608668,-74.281881);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07066 40.620256 -74.310581
var zip = "07066";
var point = new GLatLng(40.620256,-74.310581);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07067 40.593743 -74.316368
var zip = "07067";
var point = new GLatLng(40.593743,-74.316368);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07068 40.82034 -74.304688
var zip = "07068";
var point = new GLatLng(40.82034,-74.304688);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07069 40.637778 -74.451389
var zip = "07069";
var point = new GLatLng(40.637778,-74.451389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07070 40.829245 -74.112146
var zip = "07070";
var point = new GLatLng(40.829245,-74.112146);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07071 40.809433 -74.12453
var zip = "07071";
var point = new GLatLng(40.809433,-74.12453);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07072 40.840298 -74.092498
var zip = "07072";
var point = new GLatLng(40.840298,-74.092498);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07073 40.838527 -74.104069
var zip = "07073";
var point = new GLatLng(40.838527,-74.104069);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07074 40.839352 -74.056646
var zip = "07074";
var point = new GLatLng(40.839352,-74.056646);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07075 40.849348 -74.087845
var zip = "07075";
var point = new GLatLng(40.849348,-74.087845);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07076 40.642162 -74.381663
var zip = "07076";
var point = new GLatLng(40.642162,-74.381663);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07077 40.554181 -74.260736
var zip = "07077";
var point = new GLatLng(40.554181,-74.260736);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07078 40.73678 -74.327085
var zip = "07078";
var point = new GLatLng(40.73678,-74.327085);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07079 40.746453 -74.257532
var zip = "07079";
var point = new GLatLng(40.746453,-74.257532);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07080 40.583884 -74.414695
var zip = "07080";
var point = new GLatLng(40.583884,-74.414695);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07081 40.701461 -74.322705
var zip = "07081";
var point = new GLatLng(40.701461,-74.322705);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07082 40.927691 -74.342807
var zip = "07082";
var point = new GLatLng(40.927691,-74.342807);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07083 40.695184 -74.267653
var zip = "07083";
var point = new GLatLng(40.695184,-74.267653);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07086 40.769444 -74.020833
var zip = "07086";
var point = new GLatLng(40.769444,-74.020833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07087 40.768153 -74.030558
var zip = "07087";
var point = new GLatLng(40.768153,-74.030558);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07088 40.717927 -74.282874
var zip = "07088";
var point = new GLatLng(40.717927,-74.282874);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07090 40.647851 -74.345056
var zip = "07090";
var point = new GLatLng(40.647851,-74.345056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07091 40.658889 -74.347778
var zip = "07091";
var point = new GLatLng(40.658889,-74.347778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07092 40.678461 -74.358785
var zip = "07092";
var point = new GLatLng(40.678461,-74.358785);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07093 40.788192 -74.012859
var zip = "07093";
var point = new GLatLng(40.788192,-74.012859);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07094 40.79101 -74.063416
var zip = "07094";
var point = new GLatLng(40.79101,-74.063416);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07095 40.555973 -74.284542
var zip = "07095";
var point = new GLatLng(40.555973,-74.284542);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07096 40.789444 -74.056944
var zip = "07096";
var point = new GLatLng(40.789444,-74.056944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07097 40.7164 -74.038
var zip = "07097";
var point = new GLatLng(40.7164,-74.038);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07099 40.768333 -74.145833
var zip = "07099";
var point = new GLatLng(40.768333,-74.145833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07101 40.7308 -74.1744
var zip = "07101";
var point = new GLatLng(40.7308,-74.1744);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07102 40.73201 -74.176505
var zip = "07102";
var point = new GLatLng(40.73201,-74.176505);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07103 40.736975 -74.196364
var zip = "07103";
var point = new GLatLng(40.736975,-74.196364);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07104 40.766446 -74.1695
var zip = "07104";
var point = new GLatLng(40.766446,-74.1695);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07105 40.727086 -74.156346
var zip = "07105";
var point = new GLatLng(40.727086,-74.156346);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07106 40.741485 -74.233023
var zip = "07106";
var point = new GLatLng(40.741485,-74.233023);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07107 40.760656 -74.18816
var zip = "07107";
var point = new GLatLng(40.760656,-74.18816);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07108 40.723647 -74.201538
var zip = "07108";
var point = new GLatLng(40.723647,-74.201538);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07109 40.79458 -74.163119
var zip = "07109";
var point = new GLatLng(40.79458,-74.163119);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07110 40.818548 -74.158934
var zip = "07110";
var point = new GLatLng(40.818548,-74.158934);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07111 40.7261 -74.231271
var zip = "07111";
var point = new GLatLng(40.7261,-74.231271);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07112 40.71071 -74.213073
var zip = "07112";
var point = new GLatLng(40.71071,-74.213073);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07114 40.708246 -74.189105
var zip = "07114";
var point = new GLatLng(40.708246,-74.189105);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07175 40.7355 -74.1727
var zip = "07175";
var point = new GLatLng(40.7355,-74.1727);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07182 40.731 -74.174
var zip = "07182";
var point = new GLatLng(40.731,-74.174);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07184 40.7355 -74.1727
var zip = "07184";
var point = new GLatLng(40.7355,-74.1727);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07188 40.7355 -74.1727
var zip = "07188";
var point = new GLatLng(40.7355,-74.1727);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07189 40.7949 -74.1624
var zip = "07189";
var point = new GLatLng(40.7949,-74.1624);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07191 40.7355 -74.1727
var zip = "07191";
var point = new GLatLng(40.7355,-74.1727);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07192 40.7355 -74.1727
var zip = "07192";
var point = new GLatLng(40.7355,-74.1727);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07193 40.7355 -74.1727
var zip = "07193";
var point = new GLatLng(40.7355,-74.1727);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07194 40.7355 -74.1727
var zip = "07194";
var point = new GLatLng(40.7355,-74.1727);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07195 40.7355 -74.1727
var zip = "07195";
var point = new GLatLng(40.7355,-74.1727);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07198 40.7355 -74.1727
var zip = "07198";
var point = new GLatLng(40.7355,-74.1727);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07199 40.7355 -74.1727
var zip = "07199";
var point = new GLatLng(40.7355,-74.1727);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07201 40.67169 -74.204335
var zip = "07201";
var point = new GLatLng(40.67169,-74.204335);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07202 40.65652 -74.221544
var zip = "07202";
var point = new GLatLng(40.65652,-74.221544);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07203 40.652972 -74.261044
var zip = "07203";
var point = new GLatLng(40.652972,-74.261044);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07204 40.665134 -74.267003
var zip = "07204";
var point = new GLatLng(40.665134,-74.267003);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07205 40.696811 -74.228065
var zip = "07205";
var point = new GLatLng(40.696811,-74.228065);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07206 40.653207 -74.192487
var zip = "07206";
var point = new GLatLng(40.653207,-74.192487);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07207 40.663889 -74.211111
var zip = "07207";
var point = new GLatLng(40.663889,-74.211111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07208 40.674659 -74.22392
var zip = "07208";
var point = new GLatLng(40.674659,-74.22392);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07302 40.722126 -74.046878
var zip = "07302";
var point = new GLatLng(40.722126,-74.046878);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07303 40.7164 -74.038
var zip = "07303";
var point = new GLatLng(40.7164,-74.038);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07304 40.717973 -74.075358
var zip = "07304";
var point = new GLatLng(40.717973,-74.075358);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07305 40.702007 -74.088998
var zip = "07305";
var point = new GLatLng(40.702007,-74.088998);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07306 40.732125 -74.066038
var zip = "07306";
var point = new GLatLng(40.732125,-74.066038);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07307 40.748167 -74.049752
var zip = "07307";
var point = new GLatLng(40.748167,-74.049752);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07308 40.7164 -74.038
var zip = "07308";
var point = new GLatLng(40.7164,-74.038);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07309 40.7164 -74.038
var zip = "07309";
var point = new GLatLng(40.7164,-74.038);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07310 40.732354 -74.043149
var zip = "07310";
var point = new GLatLng(40.732354,-74.043149);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07311 40.728 -74.078
var zip = "07311";
var point = new GLatLng(40.728,-74.078);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07395 40.7282 -74.0776
var zip = "07395";
var point = new GLatLng(40.7282,-74.0776);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07399 40.728 -74.078
var zip = "07399";
var point = new GLatLng(40.728,-74.078);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07401 41.032654 -74.134185
var zip = "07401";
var point = new GLatLng(41.032654,-74.134185);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07403 41.012845 -74.333756
var zip = "07403";
var point = new GLatLng(41.012845,-74.333756);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07405 40.992118 -74.364065
var zip = "07405";
var point = new GLatLng(40.992118,-74.364065);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07407 40.906896 -74.120896
var zip = "07407";
var point = new GLatLng(40.906896,-74.120896);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07410 40.934297 -74.1166
var zip = "07410";
var point = new GLatLng(40.934297,-74.1166);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07416 41.116355 -74.58649
var zip = "07416";
var point = new GLatLng(41.116355,-74.58649);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07417 41.008095 -74.211347
var zip = "07417";
var point = new GLatLng(41.008095,-74.211347);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07418 41.235618 -74.488481
var zip = "07418";
var point = new GLatLng(41.235618,-74.488481);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07419 41.146714 -74.587379
var zip = "07419";
var point = new GLatLng(41.146714,-74.587379);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07420 41.030111 -74.296542
var zip = "07420";
var point = new GLatLng(41.030111,-74.296542);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07421 41.170867 -74.368566
var zip = "07421";
var point = new GLatLng(41.170867,-74.368566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07422 41.182622 -74.456442
var zip = "07422";
var point = new GLatLng(41.182622,-74.456442);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07423 41.000412 -74.102532
var zip = "07423";
var point = new GLatLng(41.000412,-74.102532);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07424 40.885353 -74.21145
var zip = "07424";
var point = new GLatLng(40.885353,-74.21145);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07428 41.201667 -74.550833
var zip = "07428";
var point = new GLatLng(41.201667,-74.550833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07430 41.074473 -74.155974
var zip = "07430";
var point = new GLatLng(41.074473,-74.155974);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07432 40.995668 -74.140904
var zip = "07432";
var point = new GLatLng(40.995668,-74.140904);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07435 41.064691 -74.435857
var zip = "07435";
var point = new GLatLng(41.064691,-74.435857);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07436 41.029436 -74.233754
var zip = "07436";
var point = new GLatLng(41.029436,-74.233754);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07438 41.028401 -74.508801
var zip = "07438";
var point = new GLatLng(41.028401,-74.508801);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07439 41.076707 -74.598188
var zip = "07439";
var point = new GLatLng(41.076707,-74.598188);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07440 40.947308 -74.29601
var zip = "07440";
var point = new GLatLng(40.947308,-74.29601);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07442 40.999284 -74.287566
var zip = "07442";
var point = new GLatLng(40.999284,-74.287566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07444 40.965515 -74.301602
var zip = "07444";
var point = new GLatLng(40.965515,-74.301602);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07446 41.057743 -74.144467
var zip = "07446";
var point = new GLatLng(41.057743,-74.144467);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07450 40.982023 -74.113134
var zip = "07450";
var point = new GLatLng(40.982023,-74.113134);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07451 40.979167 -74.116944
var zip = "07451";
var point = new GLatLng(40.979167,-74.116944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07452 40.960183 -74.125367
var zip = "07452";
var point = new GLatLng(40.960183,-74.125367);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07456 41.092816 -74.265872
var zip = "07456";
var point = new GLatLng(41.092816,-74.265872);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07457 40.993109 -74.308756
var zip = "07457";
var point = new GLatLng(40.993109,-74.308756);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07458 41.053083 -74.096775
var zip = "07458";
var point = new GLatLng(41.053083,-74.096775);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07460 41.099204 -74.528256
var zip = "07460";
var point = new GLatLng(41.099204,-74.528256);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07461 41.229211 -74.599156
var zip = "07461";
var point = new GLatLng(41.229211,-74.599156);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07462 41.184981 -74.533196
var zip = "07462";
var point = new GLatLng(41.184981,-74.533196);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07463 41.012968 -74.124259
var zip = "07463";
var point = new GLatLng(41.012968,-74.124259);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07465 41.054447 -74.278968
var zip = "07465";
var point = new GLatLng(41.054447,-74.278968);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07470 40.947112 -74.246565
var zip = "07470";
var point = new GLatLng(40.947112,-74.246565);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07474 40.9128 -74.2631
var zip = "07474";
var point = new GLatLng(40.9128,-74.2631);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07477 40.9252 -74.2769
var zip = "07477";
var point = new GLatLng(40.9252,-74.2769);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07480 41.091513 -74.374996
var zip = "07480";
var point = new GLatLng(41.091513,-74.374996);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07481 40.997834 -74.166009
var zip = "07481";
var point = new GLatLng(40.997834,-74.166009);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07495 41.088611 -74.144167
var zip = "07495";
var point = new GLatLng(41.088611,-74.144167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07501 40.914273 -74.167141
var zip = "07501";
var point = new GLatLng(40.914273,-74.167141);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07502 40.919926 -74.193238
var zip = "07502";
var point = new GLatLng(40.919926,-74.193238);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07503 40.897046 -74.157272
var zip = "07503";
var point = new GLatLng(40.897046,-74.157272);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07504 40.912179 -74.145247
var zip = "07504";
var point = new GLatLng(40.912179,-74.145247);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07505 40.915581 -74.171947
var zip = "07505";
var point = new GLatLng(40.915581,-74.171947);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07506 40.956355 -74.156897
var zip = "07506";
var point = new GLatLng(40.956355,-74.156897);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07507 40.949167 -74.154167
var zip = "07507";
var point = new GLatLng(40.949167,-74.154167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07508 40.945689 -74.182599
var zip = "07508";
var point = new GLatLng(40.945689,-74.182599);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07509 40.9146 -74.1682
var zip = "07509";
var point = new GLatLng(40.9146,-74.1682);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07510 40.9146 -74.1682
var zip = "07510";
var point = new GLatLng(40.9146,-74.1682);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07511 40.905 -74.210278
var zip = "07511";
var point = new GLatLng(40.905,-74.210278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07512 40.904811 -74.21675
var zip = "07512";
var point = new GLatLng(40.904811,-74.21675);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07513 40.906994 -74.152862
var zip = "07513";
var point = new GLatLng(40.906994,-74.152862);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07514 40.924764 -74.146717
var zip = "07514";
var point = new GLatLng(40.924764,-74.146717);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07522 40.925168 -74.178078
var zip = "07522";
var point = new GLatLng(40.925168,-74.178078);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07524 40.930916 -74.155457
var zip = "07524";
var point = new GLatLng(40.930916,-74.155457);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07533 40.8945 -74.1603
var zip = "07533";
var point = new GLatLng(40.8945,-74.1603);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07538 40.935556 -74.186667
var zip = "07538";
var point = new GLatLng(40.935556,-74.186667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07543 40.906 -74.1527
var zip = "07543";
var point = new GLatLng(40.906,-74.1527);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07544 40.9335 -74.1545
var zip = "07544";
var point = new GLatLng(40.9335,-74.1545);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07601 40.888191 -74.050301
var zip = "07601";
var point = new GLatLng(40.888191,-74.050301);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07602 40.885833 -74.043889
var zip = "07602";
var point = new GLatLng(40.885833,-74.043889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07603 40.874441 -74.028122
var zip = "07603";
var point = new GLatLng(40.874441,-74.028122);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07604 40.862241 -74.075971
var zip = "07604";
var point = new GLatLng(40.862241,-74.075971);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07605 40.862929 -73.987873
var zip = "07605";
var point = new GLatLng(40.862929,-73.987873);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07606 40.863391 -74.045601
var zip = "07606";
var point = new GLatLng(40.863391,-74.045601);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07607 40.902412 -74.062916
var zip = "07607";
var point = new GLatLng(40.902412,-74.062916);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07608 40.86175 -74.054204
var zip = "07608";
var point = new GLatLng(40.86175,-74.054204);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07620 40.951097 -73.930842
var zip = "07620";
var point = new GLatLng(40.951097,-73.930842);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07621 40.923837 -73.998918
var zip = "07621";
var point = new GLatLng(40.923837,-73.998918);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07624 40.972051 -73.958985
var zip = "07624";
var point = new GLatLng(40.972051,-73.958985);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07626 40.941847 -73.965206
var zip = "07626";
var point = new GLatLng(40.941847,-73.965206);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07627 40.954775 -73.960221
var zip = "07627";
var point = new GLatLng(40.954775,-73.960221);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07628 40.944692 -73.992139
var zip = "07628";
var point = new GLatLng(40.944692,-73.992139);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07630 40.975459 -74.028515
var zip = "07630";
var point = new GLatLng(40.975459,-74.028515);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07631 40.894251 -73.977182
var zip = "07631";
var point = new GLatLng(40.894251,-73.977182);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07632 40.882043 -73.954449
var zip = "07632";
var point = new GLatLng(40.882043,-73.954449);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07640 40.991791 -73.980017
var zip = "07640";
var point = new GLatLng(40.991791,-73.980017);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07641 40.960808 -73.987376
var zip = "07641";
var point = new GLatLng(40.960808,-73.987376);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07642 41.006945 -74.042625
var zip = "07642";
var point = new GLatLng(41.006945,-74.042625);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07643 40.849319 -74.040502
var zip = "07643";
var point = new GLatLng(40.849319,-74.040502);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07644 40.876363 -74.083827
var zip = "07644";
var point = new GLatLng(40.876363,-74.083827);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07645 41.049458 -74.038362
var zip = "07645";
var point = new GLatLng(41.049458,-74.038362);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07646 40.933115 -74.019517
var zip = "07646";
var point = new GLatLng(40.933115,-74.019517);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07647 41.011196 -73.952375
var zip = "07647";
var point = new GLatLng(41.011196,-73.952375);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07648 40.995231 -73.95817
var zip = "07648";
var point = new GLatLng(40.995231,-73.95817);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07649 40.953456 -74.033525
var zip = "07649";
var point = new GLatLng(40.953456,-74.033525);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07650 40.846238 -73.995436
var zip = "07650";
var point = new GLatLng(40.846238,-73.995436);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07652 40.947683 -74.06724
var zip = "07652";
var point = new GLatLng(40.947683,-74.06724);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07653 40.944444 -74.075833
var zip = "07653";
var point = new GLatLng(40.944444,-74.075833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07656 41.034349 -74.039574
var zip = "07656";
var point = new GLatLng(41.034349,-74.039574);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07657 40.832568 -74.001531
var zip = "07657";
var point = new GLatLng(40.832568,-74.001531);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07660 40.856218 -74.022962
var zip = "07660";
var point = new GLatLng(40.856218,-74.022962);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07661 40.926476 -74.03924
var zip = "07661";
var point = new GLatLng(40.926476,-74.03924);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07662 40.904928 -74.091296
var zip = "07662";
var point = new GLatLng(40.904928,-74.091296);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07663 40.898889 -74.093056
var zip = "07663";
var point = new GLatLng(40.898889,-74.093056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07666 40.89148 -74.011928
var zip = "07666";
var point = new GLatLng(40.89148,-74.011928);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07670 40.921596 -73.965906
var zip = "07670";
var point = new GLatLng(40.921596,-73.965906);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07675 41.001696 -74.032586
var zip = "07675";
var point = new GLatLng(41.001696,-74.032586);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07676 41.002778 -74.018889
var zip = "07676";
var point = new GLatLng(41.002778,-74.018889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07677 40.991111 -74.033056
var zip = "07677";
var point = new GLatLng(40.991111,-74.033056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07699 40.859722 -74.059722
var zip = "07699";
var point = new GLatLng(40.859722,-74.059722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07701 40.354083 -74.080003
var zip = "07701";
var point = new GLatLng(40.354083,-74.080003);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07702 40.328198 -74.058892
var zip = "07702";
var point = new GLatLng(40.328198,-74.058892);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07703 40.317667 -74.039001
var zip = "07703";
var point = new GLatLng(40.317667,-74.039001);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07704 40.359873 -74.038891
var zip = "07704";
var point = new GLatLng(40.359873,-74.038891);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07709 40.236111 -74.001111
var zip = "07709";
var point = new GLatLng(40.236111,-74.001111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07710 40.218056 -74.256667
var zip = "07710";
var point = new GLatLng(40.218056,-74.256667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07711 40.236675 -74.006706
var zip = "07711";
var point = new GLatLng(40.236675,-74.006706);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07712 40.235571 -74.029486
var zip = "07712";
var point = new GLatLng(40.235571,-74.029486);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07715 40.178333 -74.022222
var zip = "07715";
var point = new GLatLng(40.178333,-74.022222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07716 40.40772 -74.032411
var zip = "07716";
var point = new GLatLng(40.40772,-74.032411);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07717 40.191796 -74.016737
var zip = "07717";
var point = new GLatLng(40.191796,-74.016737);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07718 40.417281 -74.088887
var zip = "07718";
var point = new GLatLng(40.417281,-74.088887);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07719 40.17434 -74.047247
var zip = "07719";
var point = new GLatLng(40.17434,-74.047247);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07720 40.202308 -74.013166
var zip = "07720";
var point = new GLatLng(40.202308,-74.013166);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07721 40.435281 -74.235759
var zip = "07721";
var point = new GLatLng(40.435281,-74.235759);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07722 40.301225 -74.177988
var zip = "07722";
var point = new GLatLng(40.301225,-74.177988);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07723 40.250568 -74.001998
var zip = "07723";
var point = new GLatLng(40.250568,-74.001998);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07724 40.302815 -74.06978
var zip = "07724";
var point = new GLatLng(40.302815,-74.06978);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07726 40.306274 -74.330613
var zip = "07726";
var point = new GLatLng(40.306274,-74.330613);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07727 40.204312 -74.177864
var zip = "07727";
var point = new GLatLng(40.204312,-74.177864);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07728 40.245776 -74.276822
var zip = "07728";
var point = new GLatLng(40.245776,-74.276822);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07730 40.422554 -74.179896
var zip = "07730";
var point = new GLatLng(40.422554,-74.179896);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07731 40.148096 -74.213683
var zip = "07731";
var point = new GLatLng(40.148096,-74.213683);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07732 40.402377 -73.990912
var zip = "07732";
var point = new GLatLng(40.402377,-73.990912);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07733 40.385853 -74.173971
var zip = "07733";
var point = new GLatLng(40.385853,-74.173971);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07734 40.441363 -74.130633
var zip = "07734";
var point = new GLatLng(40.441363,-74.130633);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07735 40.439862 -74.199563
var zip = "07735";
var point = new GLatLng(40.439862,-74.199563);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07737 40.417704 -74.062265
var zip = "07737";
var point = new GLatLng(40.417704,-74.062265);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07738 40.33689 -74.120469
var zip = "07738";
var point = new GLatLng(40.33689,-74.120469);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07739 40.335393 -74.041319
var zip = "07739";
var point = new GLatLng(40.335393,-74.041319);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07740 40.299204 -73.991176
var zip = "07740";
var point = new GLatLng(40.299204,-73.991176);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07746 40.31825 -74.263871
var zip = "07746";
var point = new GLatLng(40.31825,-74.263871);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07747 40.410876 -74.237955
var zip = "07747";
var point = new GLatLng(40.410876,-74.237955);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07748 40.396018 -74.113908
var zip = "07748";
var point = new GLatLng(40.396018,-74.113908);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07750 40.333032 -73.98089
var zip = "07750";
var point = new GLatLng(40.333032,-73.98089);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07751 40.352917 -74.277863
var zip = "07751";
var point = new GLatLng(40.352917,-74.277863);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07752 40.399444 -74.035833
var zip = "07752";
var point = new GLatLng(40.399444,-74.035833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07753 40.211153 -74.054045
var zip = "07753";
var point = new GLatLng(40.211153,-74.054045);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07754 40.204722 -74.051944
var zip = "07754";
var point = new GLatLng(40.204722,-74.051944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07755 40.26479 -74.018413
var zip = "07755";
var point = new GLatLng(40.26479,-74.018413);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07756 40.211606 -74.009306
var zip = "07756";
var point = new GLatLng(40.211606,-74.009306);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07757 40.31573 -74.016372
var zip = "07757";
var point = new GLatLng(40.31573,-74.016372);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07758 40.428886 -74.108259
var zip = "07758";
var point = new GLatLng(40.428886,-74.108259);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07760 40.371829 -74.000618
var zip = "07760";
var point = new GLatLng(40.371829,-74.000618);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07762 40.154198 -74.037885
var zip = "07762";
var point = new GLatLng(40.154198,-74.037885);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07763 40.279444 -74.334722
var zip = "07763";
var point = new GLatLng(40.279444,-74.334722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07764 40.287811 -74.016221
var zip = "07764";
var point = new GLatLng(40.287811,-74.016221);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07765 40.35 -74.248333
var zip = "07765";
var point = new GLatLng(40.35,-74.248333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07777 40.345 -74.184444
var zip = "07777";
var point = new GLatLng(40.345,-74.184444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07799 40.296111 -74.051389
var zip = "07799";
var point = new GLatLng(40.296111,-74.051389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07801 40.887218 -74.559702
var zip = "07801";
var point = new GLatLng(40.887218,-74.559702);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07802 40.8848 -74.5588
var zip = "07802";
var point = new GLatLng(40.8848,-74.5588);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07803 40.8782 -74.5978
var zip = "07803";
var point = new GLatLng(40.8782,-74.5978);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07806 40.8866 -74.5809
var zip = "07806";
var point = new GLatLng(40.8866,-74.5809);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07820 40.921667 -74.810556
var zip = "07820";
var point = new GLatLng(40.921667,-74.810556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07821 40.961386 -74.752418
var zip = "07821";
var point = new GLatLng(40.961386,-74.752418);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07822 41.145086 -74.684753
var zip = "07822";
var point = new GLatLng(41.145086,-74.684753);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07823 40.830819 -75.050261
var zip = "07823";
var point = new GLatLng(40.830819,-75.050261);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07825 40.967386 -74.965097
var zip = "07825";
var point = new GLatLng(40.967386,-74.965097);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07826 41.170512 -74.750025
var zip = "07826";
var point = new GLatLng(41.170512,-74.750025);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07827 41.302259 -74.753956
var zip = "07827";
var point = new GLatLng(41.302259,-74.753956);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07828 40.873108 -74.742552
var zip = "07828";
var point = new GLatLng(40.873108,-74.742552);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07829 40.832222 -75.006667
var zip = "07829";
var point = new GLatLng(40.832222,-75.006667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07830 40.716209 -74.815218
var zip = "07830";
var point = new GLatLng(40.716209,-74.815218);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07831 40.738056 -74.944444
var zip = "07831";
var point = new GLatLng(40.738056,-74.944444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07832 40.938805 -75.054983
var zip = "07832";
var point = new GLatLng(40.938805,-75.054983);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07833 40.892778 -75.065
var zip = "07833";
var point = new GLatLng(40.892778,-75.065);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07834 40.889735 -74.484379
var zip = "07834";
var point = new GLatLng(40.889735,-74.484379);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07836 40.845316 -74.70188
var zip = "07836";
var point = new GLatLng(40.845316,-74.70188);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07837 40.986389 -74.633889
var zip = "07837";
var point = new GLatLng(40.986389,-74.633889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07838 40.85196 -74.941806
var zip = "07838";
var point = new GLatLng(40.85196,-74.941806);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07839 40.973889 -74.821389
var zip = "07839";
var point = new GLatLng(40.973889,-74.821389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07840 40.852891 -74.834315
var zip = "07840";
var point = new GLatLng(40.852891,-74.834315);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07842 40.943889 -74.493056
var zip = "07842";
var point = new GLatLng(40.943889,-74.493056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07843 40.938983 -74.66163
var zip = "07843";
var point = new GLatLng(40.938983,-74.66163);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07844 40.911111 -74.967778
var zip = "07844";
var point = new GLatLng(40.911111,-74.967778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07845 40.822778 -74.626111
var zip = "07845";
var point = new GLatLng(40.822778,-74.626111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07846 40.964444 -74.878889
var zip = "07846";
var point = new GLatLng(40.964444,-74.878889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07847 40.881901 -74.620984
var zip = "07847";
var point = new GLatLng(40.881901,-74.620984);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07848 41.076099 -74.691223
var zip = "07848";
var point = new GLatLng(41.076099,-74.691223);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07849 40.965882 -74.614438
var zip = "07849";
var point = new GLatLng(40.965882,-74.614438);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07850 40.908684 -74.655425
var zip = "07850";
var point = new GLatLng(40.908684,-74.655425);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07851 41.205913 -74.817219
var zip = "07851";
var point = new GLatLng(41.205913,-74.817219);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07852 40.878028 -74.655405
var zip = "07852";
var point = new GLatLng(40.878028,-74.655405);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07853 40.787817 -74.78698
var zip = "07853";
var point = new GLatLng(40.787817,-74.78698);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07855 41.055833 -74.863333
var zip = "07855";
var point = new GLatLng(41.055833,-74.863333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07856 40.928267 -74.636331
var zip = "07856";
var point = new GLatLng(40.928267,-74.636331);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07857 40.898497 -74.698454
var zip = "07857";
var point = new GLatLng(40.898497,-74.698454);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07860 41.058275 -74.780191
var zip = "07860";
var point = new GLatLng(41.058275,-74.780191);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07863 40.810537 -75.00194
var zip = "07863";
var point = new GLatLng(40.810537,-75.00194);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07865 40.790615 -74.91675
var zip = "07865";
var point = new GLatLng(40.790615,-74.91675);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07866 40.922916 -74.50937
var zip = "07866";
var point = new GLatLng(40.922916,-74.50937);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07869 40.845557 -74.572519
var zip = "07869";
var point = new GLatLng(40.845557,-74.572519);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07870 40.799167 -74.814167
var zip = "07870";
var point = new GLatLng(40.799167,-74.814167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07871 41.027697 -74.640701
var zip = "07871";
var point = new GLatLng(41.027697,-74.640701);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07874 40.921743 -74.70044
var zip = "07874";
var point = new GLatLng(40.921743,-74.70044);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07875 41.035833 -74.878611
var zip = "07875";
var point = new GLatLng(41.035833,-74.878611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07876 40.85385 -74.653601
var zip = "07876";
var point = new GLatLng(40.85385,-74.653601);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07877 41.086944 -74.8275
var zip = "07877";
var point = new GLatLng(41.086944,-74.8275);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07878 40.873611 -74.479167
var zip = "07878";
var point = new GLatLng(40.873611,-74.479167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07879 40.956111 -74.808889
var zip = "07879";
var point = new GLatLng(40.956111,-74.808889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07880 40.868611 -74.889444
var zip = "07880";
var point = new GLatLng(40.868611,-74.889444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07881 41.134332 -74.917595
var zip = "07881";
var point = new GLatLng(41.134332,-74.917595);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07882 40.75818 -74.991361
var zip = "07882";
var point = new GLatLng(40.75818,-74.991361);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07885 40.913883 -74.58634
var zip = "07885";
var point = new GLatLng(40.913883,-74.58634);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07890 41.146389 -74.752778
var zip = "07890";
var point = new GLatLng(41.146389,-74.752778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07901 40.71494 -74.364159
var zip = "07901";
var point = new GLatLng(40.71494,-74.364159);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07902 40.741389 -74.36
var zip = "07902";
var point = new GLatLng(40.741389,-74.36);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07920 40.678937 -74.560463
var zip = "07920";
var point = new GLatLng(40.678937,-74.560463);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07921 40.657109 -74.643236
var zip = "07921";
var point = new GLatLng(40.657109,-74.643236);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07922 40.67522 -74.434599
var zip = "07922";
var point = new GLatLng(40.67522,-74.434599);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07924 40.72251 -74.577812
var zip = "07924";
var point = new GLatLng(40.72251,-74.577812);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07926 40.794167 -74.568333
var zip = "07926";
var point = new GLatLng(40.794167,-74.568333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07927 40.822335 -74.456861
var zip = "07927";
var point = new GLatLng(40.822335,-74.456861);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07928 40.730526 -74.401701
var zip = "07928";
var point = new GLatLng(40.730526,-74.401701);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07930 40.789193 -74.677649
var zip = "07930";
var point = new GLatLng(40.789193,-74.677649);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07931 40.704035 -74.653959
var zip = "07931";
var point = new GLatLng(40.704035,-74.653959);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07932 40.775701 -74.392819
var zip = "07932";
var point = new GLatLng(40.775701,-74.392819);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07933 40.687678 -74.468134
var zip = "07933";
var point = new GLatLng(40.687678,-74.468134);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07934 40.721948 -74.670656
var zip = "07934";
var point = new GLatLng(40.721948,-74.670656);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07935 40.741618 -74.451685
var zip = "07935";
var point = new GLatLng(40.741618,-74.451685);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07936 40.819165 -74.36357
var zip = "07936";
var point = new GLatLng(40.819165,-74.36357);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07938 40.664722 -74.577778
var zip = "07938";
var point = new GLatLng(40.664722,-74.577778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07939 40.685278 -74.5475
var zip = "07939";
var point = new GLatLng(40.685278,-74.5475);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07940 40.759939 -74.417868
var zip = "07940";
var point = new GLatLng(40.759939,-74.417868);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07945 40.778919 -74.600035
var zip = "07945";
var point = new GLatLng(40.778919,-74.600035);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07946 40.672716 -74.518292
var zip = "07946";
var point = new GLatLng(40.672716,-74.518292);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07950 40.843982 -74.479645
var zip = "07950";
var point = new GLatLng(40.843982,-74.479645);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07960 40.795236 -74.487288
var zip = "07960";
var point = new GLatLng(40.795236,-74.487288);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07961 40.7966 -74.4819
var zip = "07961";
var point = new GLatLng(40.7966,-74.4819);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07962 40.8051 -74.4647
var zip = "07962";
var point = new GLatLng(40.8051,-74.4647);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07963 40.8051 -74.4647
var zip = "07963";
var point = new GLatLng(40.8051,-74.4647);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07970 40.826111 -74.570556
var zip = "07970";
var point = new GLatLng(40.826111,-74.570556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07974 40.700403 -74.402291
var zip = "07974";
var point = new GLatLng(40.700403,-74.402291);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//07976 40.734685 -74.484471
var zip = "07976";
var point = new GLatLng(40.734685,-74.484471);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07977 40.716667 -74.656944
var zip = "07977";
var point = new GLatLng(40.716667,-74.656944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07978 40.645556 -74.639444
var zip = "07978";
var point = new GLatLng(40.645556,-74.639444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//07979 40.661111 -74.821389
var zip = "07979";
var point = new GLatLng(40.661111,-74.821389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//07980 40.677366 -74.49683
var zip = "07980";
var point = new GLatLng(40.677366,-74.49683);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//07981 40.821862 -74.419971
var zip = "07981";
var point = new GLatLng(40.821862,-74.419971);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//07983 40.823 -74.4188
var zip = "07983";
var point = new GLatLng(40.823,-74.4188);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//07999 40.8252 -74.4369
var zip = "07999";
var point = new GLatLng(40.8252,-74.4369);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08001 39.560833 -75.362778
var zip = "08001";
var point = new GLatLng(39.560833,-75.362778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08002 39.930808 -75.017538
var zip = "08002";
var point = new GLatLng(39.930808,-75.017538);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08003 39.880453 -74.970568
var zip = "08003";
var point = new GLatLng(39.880453,-74.970568);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08004 39.770909 -74.879368
var zip = "08004";
var point = new GLatLng(39.770909,-74.879368);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08005 39.755248 -74.246988
var zip = "08005";
var point = new GLatLng(39.755248,-74.246988);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//08006 39.7575 -74.106667
var zip = "08006";
var point = new GLatLng(39.7575,-74.106667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08007 39.865062 -75.056361
var zip = "08007";
var point = new GLatLng(39.865062,-75.056361);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08008 39.636347 -74.189033
var zip = "08008";
var point = new GLatLng(39.636347,-74.189033);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08009 39.778839 -74.930808
var zip = "08009";
var point = new GLatLng(39.778839,-74.930808);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08010 40.056452 -74.911363
var zip = "08010";
var point = new GLatLng(40.056452,-74.911363);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//08011 39.975833 -74.710556
var zip = "08011";
var point = new GLatLng(39.975833,-74.710556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08012 39.774104 -75.058747
var zip = "08012";
var point = new GLatLng(39.774104,-75.058747);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08014 39.801616 -75.34782
var zip = "08014";
var point = new GLatLng(39.801616,-75.34782);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08015 39.95974 -74.565549
var zip = "08015";
var point = new GLatLng(39.95974,-74.565549);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08016 40.068015 -74.845353
var zip = "08016";
var point = new GLatLng(40.068015,-74.845353);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08018 39.715278 -74.901111
var zip = "08018";
var point = new GLatLng(39.715278,-74.901111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08019 39.801945 -74.525619
var zip = "08019";
var point = new GLatLng(39.801945,-74.525619);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08020 39.799228 -75.223655
var zip = "08020";
var point = new GLatLng(39.799228,-75.223655);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08021 39.80703 -75.003997
var zip = "08021";
var point = new GLatLng(39.80703,-75.003997);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08022 40.064238 -74.68988
var zip = "08022";
var point = new GLatLng(40.064238,-74.68988);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08023 39.683333 -75.490833
var zip = "08023";
var point = new GLatLng(39.683333,-75.490833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08025 39.698611 -75.186389
var zip = "08025";
var point = new GLatLng(39.698611,-75.186389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08026 39.836532 -74.970996
var zip = "08026";
var point = new GLatLng(39.836532,-74.970996);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08027 39.82314 -75.275128
var zip = "08027";
var point = new GLatLng(39.82314,-75.275128);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08028 39.706823 -75.117247
var zip = "08028";
var point = new GLatLng(39.706823,-75.117247);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08029 39.840376 -75.069744
var zip = "08029";
var point = new GLatLng(39.840376,-75.069744);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08030 39.891105 -75.116962
var zip = "08030";
var point = new GLatLng(39.891105,-75.116962);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08031 39.868878 -75.094368
var zip = "08031";
var point = new GLatLng(39.868878,-75.094368);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08032 39.425833 -75.225278
var zip = "08032";
var point = new GLatLng(39.425833,-75.225278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08033 39.895449 -75.041726
var zip = "08033";
var point = new GLatLng(39.895449,-75.041726);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08034 39.9074 -75.000762
var zip = "08034";
var point = new GLatLng(39.9074,-75.000762);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08035 39.878832 -75.06639
var zip = "08035";
var point = new GLatLng(39.878832,-75.06639);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//08036 39.983889 -74.8275
var zip = "08036";
var point = new GLatLng(39.983889,-74.8275);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08037 39.638878 -74.790735
var zip = "08037";
var point = new GLatLng(39.638878,-74.790735);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08038 39.505278 -75.462222
var zip = "08038";
var point = new GLatLng(39.505278,-75.462222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08039 39.685 -75.266389
var zip = "08039";
var point = new GLatLng(39.685,-75.266389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08041 40.038698 -74.687305
var zip = "08041";
var point = new GLatLng(40.038698,-74.687305);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08042 40.013333 -74.669167
var zip = "08042";
var point = new GLatLng(40.013333,-74.669167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//08043 39.850422 -74.964614
var zip = "08043";
var point = new GLatLng(39.850422,-74.964614);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08045 39.867601 -75.031681
var zip = "08045";
var point = new GLatLng(39.867601,-75.031681);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08046 40.028959 -74.883482
var zip = "08046";
var point = new GLatLng(40.028959,-74.883482);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08048 39.96512 -74.806736
var zip = "08048";
var point = new GLatLng(39.96512,-74.806736);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08049 39.853807 -75.039254
var zip = "08049";
var point = new GLatLng(39.853807,-75.039254);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08050 39.705017 -74.260391
var zip = "08050";
var point = new GLatLng(39.705017,-74.260391);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08051 39.786983 -75.178531
var zip = "08051";
var point = new GLatLng(39.786983,-75.178531);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08052 39.951085 -74.994644
var zip = "08052";
var point = new GLatLng(39.951085,-74.994644);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08053 39.884517 -74.90674
var zip = "08053";
var point = new GLatLng(39.884517,-74.90674);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08054 39.947808 -74.903588
var zip = "08054";
var point = new GLatLng(39.947808,-74.903588);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08055 39.868099 -74.823384
var zip = "08055";
var point = new GLatLng(39.868099,-74.823384);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08056 39.785653 -75.249777
var zip = "08056";
var point = new GLatLng(39.785653,-75.249777);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08057 39.9683 -74.953323
var zip = "08057";
var point = new GLatLng(39.9683,-74.953323);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08059 39.882749 -75.09289
var zip = "08059";
var point = new GLatLng(39.882749,-75.09289);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08060 39.993028 -74.795522
var zip = "08060";
var point = new GLatLng(39.993028,-74.795522);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08061 39.809741 -75.208153
var zip = "08061";
var point = new GLatLng(39.809741,-75.208153);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08062 39.725228 -75.20654
var zip = "08062";
var point = new GLatLng(39.725228,-75.20654);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08063 39.866412 -75.179397
var zip = "08063";
var point = new GLatLng(39.866412,-75.179397);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08064 39.958056 -74.628333
var zip = "08064";
var point = new GLatLng(39.958056,-74.628333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08065 40.003654 -75.025685
var zip = "08065";
var point = new GLatLng(40.003654,-75.025685);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//08066 39.831157 -75.224233
var zip = "08066";
var point = new GLatLng(39.831157,-75.224233);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08067 39.743451 -75.412046
var zip = "08067";
var point = new GLatLng(39.743451,-75.412046);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08068 39.971206 -74.667629
var zip = "08068";
var point = new GLatLng(39.971206,-74.667629);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08069 39.717938 -75.465623
var zip = "08069";
var point = new GLatLng(39.717938,-75.465623);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08070 39.649107 -75.51553
var zip = "08070";
var point = new GLatLng(39.649107,-75.51553);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08071 39.731162 -75.129679
var zip = "08071";
var point = new GLatLng(39.731162,-75.129679);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08072 39.545833 -75.412778
var zip = "08072";
var point = new GLatLng(39.545833,-75.412778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08073 40.010556 -74.867222
var zip = "08073";
var point = new GLatLng(40.010556,-74.867222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08074 39.7225 -75.165833
var zip = "08074";
var point = new GLatLng(39.7225,-75.165833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08075 40.024684 -74.956128
var zip = "08075";
var point = new GLatLng(40.024684,-74.956128);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08076 40.011389 -75.015278
var zip = "08076";
var point = new GLatLng(40.011389,-75.015278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08077 39.996393 -74.995141
var zip = "08077";
var point = new GLatLng(39.996393,-74.995141);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08078 39.850825 -75.074224
var zip = "08078";
var point = new GLatLng(39.850825,-75.074224);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08079 39.559124 -75.452096
var zip = "08079";
var point = new GLatLng(39.559124,-75.452096);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08080 39.747345 -75.089852
var zip = "08080";
var point = new GLatLng(39.747345,-75.089852);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08081 39.735385 -74.986385
var zip = "08081";
var point = new GLatLng(39.735385,-74.986385);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08083 39.839988 -75.030913
var zip = "08083";
var point = new GLatLng(39.839988,-75.030913);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08084 39.828798 -75.014707
var zip = "08084";
var point = new GLatLng(39.828798,-75.014707);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08085 39.752853 -75.336202
var zip = "08085";
var point = new GLatLng(39.752853,-75.336202);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08086 39.859178 -75.176698
var zip = "08086";
var point = new GLatLng(39.859178,-75.176698);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08087 39.588149 -74.364586
var zip = "08087";
var point = new GLatLng(39.588149,-74.364586);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08088 39.867631 -74.711025
var zip = "08088";
var point = new GLatLng(39.867631,-74.711025);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08089 39.721512 -74.860933
var zip = "08089";
var point = new GLatLng(39.721512,-74.860933);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08090 39.799283 -75.153644
var zip = "08090";
var point = new GLatLng(39.799283,-75.153644);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08091 39.81959 -74.941678
var zip = "08091";
var point = new GLatLng(39.81959,-74.941678);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08092 39.662665 -74.288508
var zip = "08092";
var point = new GLatLng(39.662665,-74.288508);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08093 39.860494 -75.132278
var zip = "08093";
var point = new GLatLng(39.860494,-75.132278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08094 39.665006 -74.971027
var zip = "08094";
var point = new GLatLng(39.665006,-74.971027);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08095 39.657222 -74.862778
var zip = "08095";
var point = new GLatLng(39.657222,-74.862778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08096 39.829477 -75.137966
var zip = "08096";
var point = new GLatLng(39.829477,-75.137966);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08097 39.814162 -75.152972
var zip = "08097";
var point = new GLatLng(39.814162,-75.152972);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08098 39.645663 -75.324806
var zip = "08098";
var point = new GLatLng(39.645663,-75.324806);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08099 39.8675 -75.095
var zip = "08099";
var point = new GLatLng(39.8675,-75.095);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08101 39.925833 -75.12
var zip = "08101";
var point = new GLatLng(39.925833,-75.12);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08102 39.951244 -75.118644
var zip = "08102";
var point = new GLatLng(39.951244,-75.118644);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08103 39.935099 -75.111708
var zip = "08103";
var point = new GLatLng(39.935099,-75.111708);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08104 39.918575 -75.107835
var zip = "08104";
var point = new GLatLng(39.918575,-75.107835);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08105 39.948417 -75.086382
var zip = "08105";
var point = new GLatLng(39.948417,-75.086382);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08106 39.891035 -75.072425
var zip = "08106";
var point = new GLatLng(39.891035,-75.072425);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08107 39.90799 -75.08489
var zip = "08107";
var point = new GLatLng(39.90799,-75.08489);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08108 39.915682 -75.063383
var zip = "08108";
var point = new GLatLng(39.915682,-75.063383);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08109 39.95193 -75.048204
var zip = "08109";
var point = new GLatLng(39.95193,-75.048204);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08110 39.962742 -75.063446
var zip = "08110";
var point = new GLatLng(39.962742,-75.063446);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08201 39.462368 -74.503106
var zip = "08201";
var point = new GLatLng(39.462368,-74.503106);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08202 39.095095 -74.726177
var zip = "08202";
var point = new GLatLng(39.095095,-74.726177);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08203 39.403709 -74.377644
var zip = "08203";
var point = new GLatLng(39.403709,-74.377644);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08204 38.969208 -74.92624
var zip = "08204";
var point = new GLatLng(38.969208,-74.92624);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08205 39.428333 -74.496111
var zip = "08205";
var point = new GLatLng(39.428333,-74.496111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08210 39.101434 -74.826846
var zip = "08210";
var point = new GLatLng(39.101434,-74.826846);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08212 38.937222 -74.969722
var zip = "08212";
var point = new GLatLng(38.937222,-74.969722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08213 39.504722 -74.613611
var zip = "08213";
var point = new GLatLng(39.504722,-74.613611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08214 39.193056 -74.825556
var zip = "08214";
var point = new GLatLng(39.193056,-74.825556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08215 39.533123 -74.617709
var zip = "08215";
var point = new GLatLng(39.533123,-74.617709);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08217 39.576389 -74.717222
var zip = "08217";
var point = new GLatLng(39.576389,-74.717222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08218 39.141389 -74.853333
var zip = "08218";
var point = new GLatLng(39.141389,-74.853333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08219 39.046111 -74.901667
var zip = "08219";
var point = new GLatLng(39.046111,-74.901667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08220 39.491944 -74.429444
var zip = "08220";
var point = new GLatLng(39.491944,-74.429444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08221 39.346883 -74.580744
var zip = "08221";
var point = new GLatLng(39.346883,-74.580744);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08223 39.258562 -74.659297
var zip = "08223";
var point = new GLatLng(39.258562,-74.659297);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08224 39.592222 -74.451389
var zip = "08224";
var point = new GLatLng(39.592222,-74.451389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08225 39.370256 -74.555237
var zip = "08225";
var point = new GLatLng(39.370256,-74.555237);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//08226 39.270894 -74.587514
var zip = "08226";
var point = new GLatLng(39.270894,-74.587514);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08230 39.215425 -74.707548
var zip = "08230";
var point = new GLatLng(39.215425,-74.707548);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08231 39.471111 -74.460833
var zip = "08231";
var point = new GLatLng(39.471111,-74.460833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08232 39.401518 -74.552365
var zip = "08232";
var point = new GLatLng(39.401518,-74.552365);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08234 39.413611 -74.588889
var zip = "08234";
var point = new GLatLng(39.413611,-74.588889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08240 39.478333 -74.575556
var zip = "08240";
var point = new GLatLng(39.478333,-74.575556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08241 39.527196 -74.490263
var zip = "08241";
var point = new GLatLng(39.527196,-74.490263);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08242 39.019583 -74.875642
var zip = "08242";
var point = new GLatLng(39.019583,-74.875642);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08243 39.144929 -74.701432
var zip = "08243";
var point = new GLatLng(39.144929,-74.701432);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//08244 39.322308 -74.600796
var zip = "08244";
var point = new GLatLng(39.322308,-74.600796);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08245 39.178333 -74.820278
var zip = "08245";
var point = new GLatLng(39.178333,-74.820278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08246 39.178889 -74.760278
var zip = "08246";
var point = new GLatLng(39.178889,-74.760278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08247 39.053338 -74.762049
var zip = "08247";
var point = new GLatLng(39.053338,-74.762049);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08248 39.199246 -74.655446
var zip = "08248";
var point = new GLatLng(39.199246,-74.655446);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08250 39.29 -74.754167
var zip = "08250";
var point = new GLatLng(39.29,-74.754167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08251 39.021943 -74.935396
var zip = "08251";
var point = new GLatLng(39.021943,-74.935396);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08252 39.038889 -74.857222
var zip = "08252";
var point = new GLatLng(39.038889,-74.857222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08260 38.989901 -74.819096
var zip = "08260";
var point = new GLatLng(38.989901,-74.819096);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08270 39.248915 -74.802628
var zip = "08270";
var point = new GLatLng(39.248915,-74.802628);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08302 39.445294 -75.226728
var zip = "08302";
var point = new GLatLng(39.445294,-75.226728);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08310 39.536988 -74.889495
var zip = "08310";
var point = new GLatLng(39.536988,-74.889495);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08311 39.337028 -75.199362
var zip = "08311";
var point = new GLatLng(39.337028,-75.199362);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//08312 39.658969 -75.094188
var zip = "08312";
var point = new GLatLng(39.658969,-75.094188);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08313 39.493056 -75.217222
var zip = "08313";
var point = new GLatLng(39.493056,-75.217222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08314 39.202258 -74.970505
var zip = "08314";
var point = new GLatLng(39.202258,-74.970505);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08315 39.270278 -75.101389
var zip = "08315";
var point = new GLatLng(39.270278,-75.101389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08316 39.272778 -74.977222
var zip = "08316";
var point = new GLatLng(39.272778,-74.977222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08317 39.40313 -74.831577
var zip = "08317";
var point = new GLatLng(39.40313,-74.831577);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08318 39.569146 -75.163023
var zip = "08318";
var point = new GLatLng(39.569146,-75.163023);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08319 39.37825 -74.816512
var zip = "08319";
var point = new GLatLng(39.37825,-74.816512);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08320 39.381667 -75.220278
var zip = "08320";
var point = new GLatLng(39.381667,-75.220278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08321 39.2375 -75.171944
var zip = "08321";
var point = new GLatLng(39.2375,-75.171944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08322 39.615557 -75.04088
var zip = "08322";
var point = new GLatLng(39.615557,-75.04088);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08323 39.389722 -75.338889
var zip = "08323";
var point = new GLatLng(39.389722,-75.338889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08324 39.245013 -74.993942
var zip = "08324";
var point = new GLatLng(39.245013,-74.993942);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//08326 39.523942 -74.937688
var zip = "08326";
var point = new GLatLng(39.523942,-74.937688);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08327 39.238724 -75.001211
var zip = "08327";
var point = new GLatLng(39.238724,-75.001211);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08328 39.575495 -75.058155
var zip = "08328";
var point = new GLatLng(39.575495,-75.058155);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08329 39.285833 -74.993611
var zip = "08329";
var point = new GLatLng(39.285833,-74.993611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08330 39.432011 -74.69619
var zip = "08330";
var point = new GLatLng(39.432011,-74.69619);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08332 39.367313 -75.029311
var zip = "08332";
var point = new GLatLng(39.367313,-75.029311);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08340 39.445078 -74.866671
var zip = "08340";
var point = new GLatLng(39.445078,-74.866671);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08341 39.515512 -74.946685
var zip = "08341";
var point = new GLatLng(39.515512,-74.946685);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08342 39.486667 -74.836111
var zip = "08342";
var point = new GLatLng(39.486667,-74.836111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08343 39.644224 -75.156848
var zip = "08343";
var point = new GLatLng(39.644224,-75.156848);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//08344 39.555257 -75.027558
var zip = "08344";
var point = new GLatLng(39.555257,-75.027558);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08345 39.283205 -75.171647
var zip = "08345";
var point = new GLatLng(39.283205,-75.171647);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08346 39.564477 -74.859049
var zip = "08346";
var point = new GLatLng(39.564477,-74.859049);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08347 39.496111 -75.088333
var zip = "08347";
var point = new GLatLng(39.496111,-75.088333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08348 39.313333 -74.981389
var zip = "08348";
var point = new GLatLng(39.313333,-74.981389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08349 39.256263 -75.050608
var zip = "08349";
var point = new GLatLng(39.256263,-75.050608);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08350 39.485048 -74.877615
var zip = "08350";
var point = new GLatLng(39.485048,-74.877615);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08352 39.478056 -75.131667
var zip = "08352";
var point = new GLatLng(39.478056,-75.131667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08353 39.458889 -75.299444
var zip = "08353";
var point = new GLatLng(39.458889,-75.299444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08360 39.48177 -75.009087
var zip = "08360";
var point = new GLatLng(39.48177,-75.009087);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08361 39.4606 -74.9748
var zip = "08361";
var point = new GLatLng(39.4606,-74.9748);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08362 39.4741 -74.9844
var zip = "08362";
var point = new GLatLng(39.4741,-74.9844);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//08401 39.366411 -74.431727
var zip = "08401";
var point = new GLatLng(39.366411,-74.431727);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08402 39.328621 -74.509038
var zip = "08402";
var point = new GLatLng(39.328621,-74.509038);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08403 39.309712 -74.542143
var zip = "08403";
var point = new GLatLng(39.309712,-74.542143);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08404 39.359 -74.4313
var zip = "08404";
var point = new GLatLng(39.359,-74.4313);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08405 39.3641 -74.4233
var zip = "08405";
var point = new GLatLng(39.3641,-74.4233);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08406 39.345992 -74.472343
var zip = "08406";
var point = new GLatLng(39.345992,-74.472343);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08501 40.158922 -74.59093
var zip = "08501";
var point = new GLatLng(40.158922,-74.59093);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08502 40.467732 -74.628993
var zip = "08502";
var point = new GLatLng(40.467732,-74.628993);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08504 40.4075 -74.703056
var zip = "08504";
var point = new GLatLng(40.4075,-74.703056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08505 40.143141 -74.703249
var zip = "08505";
var point = new GLatLng(40.143141,-74.703249);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08510 40.199751 -74.434387
var zip = "08510";
var point = new GLatLng(40.199751,-74.434387);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08511 40.048109 -74.559524
var zip = "08511";
var point = new GLatLng(40.048109,-74.559524);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08512 40.303868 -74.506531
var zip = "08512";
var point = new GLatLng(40.303868,-74.506531);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08514 40.127907 -74.499425
var zip = "08514";
var point = new GLatLng(40.127907,-74.499425);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08515 40.158353 -74.666838
var zip = "08515";
var point = new GLatLng(40.158353,-74.666838);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08518 40.118025 -74.805515
var zip = "08518";
var point = new GLatLng(40.118025,-74.805515);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08520 40.266885 -74.524993
var zip = "08520";
var point = new GLatLng(40.266885,-74.524993);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08525 40.390224 -74.770963
var zip = "08525";
var point = new GLatLng(40.390224,-74.770963);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08526 40.166215 -74.510939
var zip = "08526";
var point = new GLatLng(40.166215,-74.510939);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08527 40.120964 -74.301709
var zip = "08527";
var point = new GLatLng(40.120964,-74.301709);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08528 40.380465 -74.616071
var zip = "08528";
var point = new GLatLng(40.380465,-74.616071);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08530 40.373122 -74.926605
var zip = "08530";
var point = new GLatLng(40.373122,-74.926605);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08533 40.071343 -74.506721
var zip = "08533";
var point = new GLatLng(40.071343,-74.506721);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//08534 40.333858 -74.794352
var zip = "08534";
var point = new GLatLng(40.333858,-74.794352);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//08535 40.214971 -74.440381
var zip = "08535";
var point = new GLatLng(40.214971,-74.440381);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08536 40.332432 -74.568836
var zip = "08536";
var point = new GLatLng(40.332432,-74.568836);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//08540 40.366633 -74.640832
var zip = "08540";
var point = new GLatLng(40.366633,-74.640832);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08541 40.3486 -74.6594
var zip = "08541";
var point = new GLatLng(40.3486,-74.6594);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08542 40.353545 -74.659378
var zip = "08542";
var point = new GLatLng(40.353545,-74.659378);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08543 40.3486 -74.6594
var zip = "08543";
var point = new GLatLng(40.3486,-74.6594);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08544 40.346029 -74.65754
var zip = "08544";
var point = new GLatLng(40.346029,-74.65754);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08550 40.297684 -74.614596
var zip = "08550";
var point = new GLatLng(40.297684,-74.614596);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08551 40.44587 -74.828839
var zip = "08551";
var point = new GLatLng(40.44587,-74.828839);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08553 40.400985 -74.640042
var zip = "08553";
var point = new GLatLng(40.400985,-74.640042);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08554 40.115352 -74.777224
var zip = "08554";
var point = new GLatLng(40.115352,-74.777224);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08555 40.22 -74.473611
var zip = "08555";
var point = new GLatLng(40.22,-74.473611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08556 40.422005 -74.991928
var zip = "08556";
var point = new GLatLng(40.422005,-74.991928);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08557 40.445833 -74.943889
var zip = "08557";
var point = new GLatLng(40.445833,-74.943889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08558 40.417312 -74.693828
var zip = "08558";
var point = new GLatLng(40.417312,-74.693828);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08559 40.43974 -74.955419
var zip = "08559";
var point = new GLatLng(40.43974,-74.955419);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08560 40.307728 -74.865469
var zip = "08560";
var point = new GLatLng(40.307728,-74.865469);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08561 40.242222 -74.581667
var zip = "08561";
var point = new GLatLng(40.242222,-74.581667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08562 40.071953 -74.573098
var zip = "08562";
var point = new GLatLng(40.071953,-74.573098);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//08601 40.2169 -74.7433
var zip = "08601";
var point = new GLatLng(40.2169,-74.7433);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08602 40.2169 -74.7433
var zip = "08602";
var point = new GLatLng(40.2169,-74.7433);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08603 40.2169 -74.7433
var zip = "08603";
var point = new GLatLng(40.2169,-74.7433);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08604 40.2169 -74.7433
var zip = "08604";
var point = new GLatLng(40.2169,-74.7433);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//08605 40.2169 -74.7433
var zip = "08605";
var point = new GLatLng(40.2169,-74.7433);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08606 40.2169 -74.7433
var zip = "08606";
var point = new GLatLng(40.2169,-74.7433);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08607 40.2169 -74.7433
var zip = "08607";
var point = new GLatLng(40.2169,-74.7433);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08608 40.220437 -74.762237
var zip = "08608";
var point = new GLatLng(40.220437,-74.762237);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08609 40.223338 -74.742598
var zip = "08609";
var point = new GLatLng(40.223338,-74.742598);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08610 40.19894 -74.717205
var zip = "08610";
var point = new GLatLng(40.19894,-74.717205);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08611 40.207297 -74.751997
var zip = "08611";
var point = new GLatLng(40.207297,-74.751997);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08618 40.237687 -74.782062
var zip = "08618";
var point = new GLatLng(40.237687,-74.782062);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08619 40.241977 -74.690377
var zip = "08619";
var point = new GLatLng(40.241977,-74.690377);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08620 40.178477 -74.671699
var zip = "08620";
var point = new GLatLng(40.178477,-74.671699);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08625 40.2712 -74.8179
var zip = "08625";
var point = new GLatLng(40.2712,-74.8179);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08628 40.267232 -74.826186
var zip = "08628";
var point = new GLatLng(40.267232,-74.826186);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08629 40.219843 -74.732764
var zip = "08629";
var point = new GLatLng(40.219843,-74.732764);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08638 40.251006 -74.762699
var zip = "08638";
var point = new GLatLng(40.251006,-74.762699);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08640 40.009946 -74.618296
var zip = "08640";
var point = new GLatLng(40.009946,-74.618296);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08641 40.044026 -74.588195
var zip = "08641";
var point = new GLatLng(40.044026,-74.588195);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08645 40.2169 -74.7433
var zip = "08645";
var point = new GLatLng(40.2169,-74.7433);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08646 40.2169 -74.7433
var zip = "08646";
var point = new GLatLng(40.2169,-74.7433);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08647 40.2169 -74.7433
var zip = "08647";
var point = new GLatLng(40.2169,-74.7433);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08648 40.277646 -74.723956
var zip = "08648";
var point = new GLatLng(40.277646,-74.723956);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08650 40.2169 -74.7433
var zip = "08650";
var point = new GLatLng(40.2169,-74.7433);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08666 40.2169 -74.7433
var zip = "08666";
var point = new GLatLng(40.2169,-74.7433);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//08677 40.2169 -74.7433
var zip = "08677";
var point = new GLatLng(40.2169,-74.7433);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08690 40.223852 -74.659138
var zip = "08690";
var point = new GLatLng(40.223852,-74.659138);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08691 40.231785 -74.606262
var zip = "08691";
var point = new GLatLng(40.231785,-74.606262);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08695 40.2169 -74.7433
var zip = "08695";
var point = new GLatLng(40.2169,-74.7433);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08701 40.085043 -74.204199
var zip = "08701";
var point = new GLatLng(40.085043,-74.204199);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08720 40.141389 -74.100278
var zip = "08720";
var point = new GLatLng(40.141389,-74.100278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08721 39.914708 -74.190529
var zip = "08721";
var point = new GLatLng(39.914708,-74.190529);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08722 39.930246 -74.196145
var zip = "08722";
var point = new GLatLng(39.930246,-74.196145);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08723 40.040817 -74.12686
var zip = "08723";
var point = new GLatLng(40.040817,-74.12686);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08724 40.087432 -74.115237
var zip = "08724";
var point = new GLatLng(40.087432,-74.115237);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08730 40.107727 -74.063511
var zip = "08730";
var point = new GLatLng(40.107727,-74.063511);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08731 39.844425 -74.197301
var zip = "08731";
var point = new GLatLng(39.844425,-74.197301);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08732 39.943197 -74.146787
var zip = "08732";
var point = new GLatLng(39.943197,-74.146787);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08733 40.020054 -74.290901
var zip = "08733";
var point = new GLatLng(40.020054,-74.290901);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08734 39.861993 -74.166765
var zip = "08734";
var point = new GLatLng(39.861993,-74.166765);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08735 39.977486 -74.070424
var zip = "08735";
var point = new GLatLng(39.977486,-74.070424);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08736 40.121693 -74.061055
var zip = "08736";
var point = new GLatLng(40.121693,-74.061055);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08738 40.026125 -74.056188
var zip = "08738";
var point = new GLatLng(40.026125,-74.056188);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08739 40.0025 -74.060833
var zip = "08739";
var point = new GLatLng(40.0025,-74.060833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08740 39.925975 -74.135128
var zip = "08740";
var point = new GLatLng(39.925975,-74.135128);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08741 39.934746 -74.167992
var zip = "08741";
var point = new GLatLng(39.934746,-74.167992);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08742 40.080226 -74.065719
var zip = "08742";
var point = new GLatLng(40.080226,-74.065719);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08750 40.134522 -74.043604
var zip = "08750";
var point = new GLatLng(40.134522,-74.043604);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08751 39.946639 -74.076479
var zip = "08751";
var point = new GLatLng(39.946639,-74.076479);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08752 39.922175 -74.079521
var zip = "08752";
var point = new GLatLng(39.922175,-74.079521);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08753 39.977083 -74.156508
var zip = "08753";
var point = new GLatLng(39.977083,-74.156508);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08754 39.953 -74.2031
var zip = "08754";
var point = new GLatLng(39.953,-74.2031);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08755 39.999946 -74.222819
var zip = "08755";
var point = new GLatLng(39.999946,-74.222819);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08756 39.953 -74.2031
var zip = "08756";
var point = new GLatLng(39.953,-74.2031);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08757 39.971471 -74.251168
var zip = "08757";
var point = new GLatLng(39.971471,-74.251168);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08758 39.789646 -74.195376
var zip = "08758";
var point = new GLatLng(39.789646,-74.195376);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08759 39.950983 -74.360713
var zip = "08759";
var point = new GLatLng(39.950983,-74.360713);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08801 40.628731 -74.885512
var zip = "08801";
var point = new GLatLng(40.628731,-74.885512);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08802 40.650175 -75.01585
var zip = "08802";
var point = new GLatLng(40.650175,-75.01585);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08803 40.521667 -75.006389
var zip = "08803";
var point = new GLatLng(40.521667,-75.006389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08804 40.64366 -75.09664
var zip = "08804";
var point = new GLatLng(40.64366,-75.09664);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08805 40.568115 -74.539735
var zip = "08805";
var point = new GLatLng(40.568115,-74.539735);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08807 40.590388 -74.626741
var zip = "08807";
var point = new GLatLng(40.590388,-74.626741);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08808 40.731944 -75.051944
var zip = "08808";
var point = new GLatLng(40.731944,-75.051944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08809 40.641194 -74.908846
var zip = "08809";
var point = new GLatLng(40.641194,-74.908846);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08810 40.38249 -74.511102
var zip = "08810";
var point = new GLatLng(40.38249,-74.511102);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08812 40.594237 -74.47187
var zip = "08812";
var point = new GLatLng(40.594237,-74.47187);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08816 40.428395 -74.406381
var zip = "08816";
var point = new GLatLng(40.428395,-74.406381);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08817 40.517079 -74.397286
var zip = "08817";
var point = new GLatLng(40.517079,-74.397286);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08818 40.5261 -74.387
var zip = "08818";
var point = new GLatLng(40.5261,-74.387);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08820 40.57804 -74.358863
var zip = "08820";
var point = new GLatLng(40.57804,-74.358863);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08821 40.516944 -74.684722
var zip = "08821";
var point = new GLatLng(40.516944,-74.684722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08822 40.517976 -74.845316
var zip = "08822";
var point = new GLatLng(40.517976,-74.845316);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08823 40.442097 -74.536908
var zip = "08823";
var point = new GLatLng(40.442097,-74.536908);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08824 40.4208 -74.552921
var zip = "08824";
var point = new GLatLng(40.4208,-74.552921);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08825 40.520795 -75.032468
var zip = "08825";
var point = new GLatLng(40.520795,-75.032468);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08826 40.713437 -74.916207
var zip = "08826";
var point = new GLatLng(40.713437,-74.916207);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08827 40.677351 -74.962221
var zip = "08827";
var point = new GLatLng(40.677351,-74.962221);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08828 40.377742 -74.420393
var zip = "08828";
var point = new GLatLng(40.377742,-74.420393);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08829 40.668438 -74.893667
var zip = "08829";
var point = new GLatLng(40.668438,-74.893667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08830 40.571593 -74.316677
var zip = "08830";
var point = new GLatLng(40.571593,-74.316677);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//08831 40.342475 -74.433568
var zip = "08831";
var point = new GLatLng(40.342475,-74.433568);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08832 40.519171 -74.302119
var zip = "08832";
var point = new GLatLng(40.519171,-74.302119);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08833 40.646623 -74.829035
var zip = "08833";
var point = new GLatLng(40.646623,-74.829035);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08834 40.611111 -75.076389
var zip = "08834";
var point = new GLatLng(40.611111,-75.076389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08835 40.539871 -74.593377
var zip = "08835";
var point = new GLatLng(40.539871,-74.593377);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08836 40.599962 -74.557191
var zip = "08836";
var point = new GLatLng(40.599962,-74.557191);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08837 40.532476 -74.337503
var zip = "08837";
var point = new GLatLng(40.532476,-74.337503);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08840 40.54493 -74.351721
var zip = "08840";
var point = new GLatLng(40.54493,-74.351721);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08844 40.4775 -74.627222
var zip = "08844";
var point = new GLatLng(40.4775,-74.627222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08846 40.575882 -74.500835
var zip = "08846";
var point = new GLatLng(40.575882,-74.500835);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08848 40.592942 -75.102519
var zip = "08848";
var point = new GLatLng(40.592942,-75.102519);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08850 40.449346 -74.439046
var zip = "08850";
var point = new GLatLng(40.449346,-74.439046);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08852 40.394391 -74.547021
var zip = "08852";
var point = new GLatLng(40.394391,-74.547021);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08853 40.509551 -74.71434
var zip = "08853";
var point = new GLatLng(40.509551,-74.71434);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08854 40.55152 -74.458996
var zip = "08854";
var point = new GLatLng(40.55152,-74.458996);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08855 40.499167 -74.399444
var zip = "08855";
var point = new GLatLng(40.499167,-74.399444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08857 40.398045 -74.323553
var zip = "08857";
var point = new GLatLng(40.398045,-74.323553);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08858 40.6725 -74.747778
var zip = "08858";
var point = new GLatLng(40.6725,-74.747778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08859 40.458701 -74.304981
var zip = "08859";
var point = new GLatLng(40.458701,-74.304981);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08861 40.517551 -74.275427
var zip = "08861";
var point = new GLatLng(40.517551,-74.275427);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08862 40.506667 -74.265833
var zip = "08862";
var point = new GLatLng(40.506667,-74.265833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08863 40.53925 -74.311707
var zip = "08863";
var point = new GLatLng(40.53925,-74.311707);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08865 40.692819 -75.1741
var zip = "08865";
var point = new GLatLng(40.692819,-75.1741);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08867 40.599169 -74.957587
var zip = "08867";
var point = new GLatLng(40.599169,-74.957587);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08868 40.565556 -74.941944
var zip = "08868";
var point = new GLatLng(40.565556,-74.941944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08869 40.57109 -74.637691
var zip = "08869";
var point = new GLatLng(40.57109,-74.637691);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08870 40.568611 -74.738056
var zip = "08870";
var point = new GLatLng(40.568611,-74.738056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08871 40.459167 -74.361389
var zip = "08871";
var point = new GLatLng(40.459167,-74.361389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08872 40.459958 -74.347808
var zip = "08872";
var point = new GLatLng(40.459958,-74.347808);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08873 40.500743 -74.50126
var zip = "08873";
var point = new GLatLng(40.500743,-74.50126);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08875 40.49 -74.476389
var zip = "08875";
var point = new GLatLng(40.49,-74.476389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08876 40.549393 -74.645926
var zip = "08876";
var point = new GLatLng(40.549393,-74.645926);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08879 40.464733 -74.278635
var zip = "08879";
var point = new GLatLng(40.464733,-74.278635);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08880 40.552804 -74.529078
var zip = "08880";
var point = new GLatLng(40.552804,-74.529078);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08882 40.444363 -74.380099
var zip = "08882";
var point = new GLatLng(40.444363,-74.380099);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08884 40.384679 -74.389377
var zip = "08884";
var point = new GLatLng(40.384679,-74.389377);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08885 40.575 -74.838056
var zip = "08885";
var point = new GLatLng(40.575,-74.838056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08886 40.695703 -75.082517
var zip = "08886";
var point = new GLatLng(40.695703,-75.082517);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08887 40.52156 -74.799805
var zip = "08887";
var point = new GLatLng(40.52156,-74.799805);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08888 40.618333 -74.744722
var zip = "08888";
var point = new GLatLng(40.618333,-74.744722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08889 40.599872 -74.764129
var zip = "08889";
var point = new GLatLng(40.599872,-74.764129);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//08890 40.536389 -74.575
var zip = "08890";
var point = new GLatLng(40.536389,-74.575);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08899 40.5261 -74.387
var zip = "08899";
var point = new GLatLng(40.5261,-74.387);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08901 40.489073 -74.448193
var zip = "08901";
var point = new GLatLng(40.489073,-74.448193);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08902 40.453767 -74.482285
var zip = "08902";
var point = new GLatLng(40.453767,-74.482285);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//08903 40.5203 -74.4143
var zip = "08903";
var point = new GLatLng(40.5203,-74.4143);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08904 40.499141 -74.426602
var zip = "08904";
var point = new GLatLng(40.499141,-74.426602);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08905 40.4587 -74.4648
var zip = "08905";
var point = new GLatLng(40.4587,-74.4648);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08906 40.4861 -74.4522
var zip = "08906";
var point = new GLatLng(40.4861,-74.4522);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08922 40.4861 -74.4522
var zip = "08922";
var point = new GLatLng(40.4861,-74.4522);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//08933 40.4861 -74.4522
var zip = "08933";
var point = new GLatLng(40.4861,-74.4522);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//08988 40.4502 -74.4804
var zip = "08988";
var point = new GLatLng(40.4502,-74.4804);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//08989 40.4502 -74.4804
var zip = "08989";
var point = new GLatLng(40.4502,-74.4804);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//06390 41.263934 -72.017834
var zip = "06390";
var point = new GLatLng(41.263934,-72.017834);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10001 40.74838 -73.996705
var zip = "10001";
var point = new GLatLng(40.74838,-73.996705);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10002 40.715231 -73.987681
var zip = "10002";
var point = new GLatLng(40.715231,-73.987681);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10003 40.731253 -73.989223
var zip = "10003";
var point = new GLatLng(40.731253,-73.989223);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10004 40.693604 -74.019025
var zip = "10004";
var point = new GLatLng(40.693604,-74.019025);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10005 40.705649 -74.008344
var zip = "10005";
var point = new GLatLng(40.705649,-74.008344);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10006 40.708451 -74.013474
var zip = "10006";
var point = new GLatLng(40.708451,-74.013474);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10007 40.713905 -74.007022
var zip = "10007";
var point = new GLatLng(40.713905,-74.007022);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10008 40.7121 -74.0102
var zip = "10008";
var point = new GLatLng(40.7121,-74.0102);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10009 40.726188 -73.979591
var zip = "10009";
var point = new GLatLng(40.726188,-73.979591);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10010 40.737476 -73.981328
var zip = "10010";
var point = new GLatLng(40.737476,-73.981328);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10011 40.740225 -73.99963
var zip = "10011";
var point = new GLatLng(40.740225,-73.99963);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10012 40.72553 -73.998284
var zip = "10012";
var point = new GLatLng(40.72553,-73.998284);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10013 40.718511 -74.002529
var zip = "10013";
var point = new GLatLng(40.718511,-74.002529);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10014 40.73393 -74.005421
var zip = "10014";
var point = new GLatLng(40.73393,-74.005421);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10015 40.7141 -74.0063
var zip = "10015";
var point = new GLatLng(40.7141,-74.0063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10016 40.744281 -73.978134
var zip = "10016";
var point = new GLatLng(40.744281,-73.978134);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10017 40.75172 -73.970661
var zip = "10017";
var point = new GLatLng(40.75172,-73.970661);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10018 40.754713 -73.992503
var zip = "10018";
var point = new GLatLng(40.754713,-73.992503);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10019 40.765069 -73.985834
var zip = "10019";
var point = new GLatLng(40.765069,-73.985834);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10020 40.759729 -73.982347
var zip = "10020";
var point = new GLatLng(40.759729,-73.982347);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10021 40.768476 -73.958805
var zip = "10021";
var point = new GLatLng(40.768476,-73.958805);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10022 40.757091 -73.965703
var zip = "10022";
var point = new GLatLng(40.757091,-73.965703);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10023 40.77638 -73.982652
var zip = "10023";
var point = new GLatLng(40.77638,-73.982652);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10024 40.786446 -73.976385
var zip = "10024";
var point = new GLatLng(40.786446,-73.976385);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10025 40.797466 -73.968312
var zip = "10025";
var point = new GLatLng(40.797466,-73.968312);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10026 40.801942 -73.953069
var zip = "10026";
var point = new GLatLng(40.801942,-73.953069);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10027 40.811556 -73.954978
var zip = "10027";
var point = new GLatLng(40.811556,-73.954978);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10028 40.776267 -73.952866
var zip = "10028";
var point = new GLatLng(40.776267,-73.952866);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10029 40.791817 -73.94475
var zip = "10029";
var point = new GLatLng(40.791817,-73.94475);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10030 40.818333 -73.942597
var zip = "10030";
var point = new GLatLng(40.818333,-73.942597);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10031 40.82455 -73.950712
var zip = "10031";
var point = new GLatLng(40.82455,-73.950712);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10032 40.83819 -73.941978
var zip = "10032";
var point = new GLatLng(40.83819,-73.941978);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10033 40.84955 -73.935649
var zip = "10033";
var point = new GLatLng(40.84955,-73.935649);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10034 40.866222 -73.922077
var zip = "10034";
var point = new GLatLng(40.866222,-73.922077);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10035 40.801116 -73.937098
var zip = "10035";
var point = new GLatLng(40.801116,-73.937098);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10036 40.759724 -73.991826
var zip = "10036";
var point = new GLatLng(40.759724,-73.991826);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10037 40.813491 -73.9381
var zip = "10037";
var point = new GLatLng(40.813491,-73.9381);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10038 40.710092 -74.001298
var zip = "10038";
var point = new GLatLng(40.710092,-74.001298);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10039 40.826458 -73.938266
var zip = "10039";
var point = new GLatLng(40.826458,-73.938266);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10040 40.858308 -73.929601
var zip = "10040";
var point = new GLatLng(40.858308,-73.929601);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10041 40.7051 -74.014
var zip = "10041";
var point = new GLatLng(40.7051,-74.014);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10043 40.7141 -74.0063
var zip = "10043";
var point = new GLatLng(40.7141,-74.0063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10044 40.762998 -73.949136
var zip = "10044";
var point = new GLatLng(40.762998,-73.949136);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10045 40.7056 -74.0081
var zip = "10045";
var point = new GLatLng(40.7056,-74.0081);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10046 40.7121 -74.0102
var zip = "10046";
var point = new GLatLng(40.7121,-74.0102);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10047 40.7102 -74.0128
var zip = "10047";
var point = new GLatLng(40.7102,-74.0128);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10048 40.7113 -74.0121
var zip = "10048";
var point = new GLatLng(40.7113,-74.0121);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10055 40.7589 -73.9735
var zip = "10055";
var point = new GLatLng(40.7589,-73.9735);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10060 40.7507 -73.9946
var zip = "10060";
var point = new GLatLng(40.7507,-73.9946);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10069 40.7543 -73.9997
var zip = "10069";
var point = new GLatLng(40.7543,-73.9997);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10072 40.7501 -73.9978
var zip = "10072";
var point = new GLatLng(40.7501,-73.9978);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10079 40.7141 -74.0063
var zip = "10079";
var point = new GLatLng(40.7141,-74.0063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10080 40.7121 -74.0102
var zip = "10080";
var point = new GLatLng(40.7121,-74.0102);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10081 40.7141 -74.0063
var zip = "10081";
var point = new GLatLng(40.7141,-74.0063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10082 40.7753 -73.9844
var zip = "10082";
var point = new GLatLng(40.7753,-73.9844);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10087 40.7507 -73.9946
var zip = "10087";
var point = new GLatLng(40.7507,-73.9946);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10090 40.7141 -74.0063
var zip = "10090";
var point = new GLatLng(40.7141,-74.0063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10094 40.7141 -74.0063
var zip = "10094";
var point = new GLatLng(40.7141,-74.0063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10095 40.7507 -73.9946
var zip = "10095";
var point = new GLatLng(40.7507,-73.9946);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10096 40.7141 -74.0063
var zip = "10096";
var point = new GLatLng(40.7141,-74.0063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10098 40.7507 -73.9946
var zip = "10098";
var point = new GLatLng(40.7507,-73.9946);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10099 40.7141 -74.0063
var zip = "10099";
var point = new GLatLng(40.7141,-74.0063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10101 40.7632 -73.9862
var zip = "10101";
var point = new GLatLng(40.7632,-73.9862);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10102 40.7632 -73.9862
var zip = "10102";
var point = new GLatLng(40.7632,-73.9862);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10103 40.7597 -73.9762
var zip = "10103";
var point = new GLatLng(40.7597,-73.9762);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10104 40.7603 -73.9794
var zip = "10104";
var point = new GLatLng(40.7603,-73.9794);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10105 40.7632 -73.9862
var zip = "10105";
var point = new GLatLng(40.7632,-73.9862);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10106 40.7647 -73.9804
var zip = "10106";
var point = new GLatLng(40.7647,-73.9804);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10107 40.7661 -73.9825
var zip = "10107";
var point = new GLatLng(40.7661,-73.9825);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10108 40.7574 -73.9918
var zip = "10108";
var point = new GLatLng(40.7574,-73.9918);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10109 40.7574 -73.9918
var zip = "10109";
var point = new GLatLng(40.7574,-73.9918);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10110 40.7533 -73.9808
var zip = "10110";
var point = new GLatLng(40.7533,-73.9808);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10111 40.7586 -73.9772
var zip = "10111";
var point = new GLatLng(40.7586,-73.9772);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10112 40.7584 -73.9784
var zip = "10112";
var point = new GLatLng(40.7584,-73.9784);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10113 40.7417 -74.0004
var zip = "10113";
var point = new GLatLng(40.7417,-74.0004);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10114 40.7417 -74.0004
var zip = "10114";
var point = new GLatLng(40.7417,-74.0004);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10115 40.8109 -73.954
var zip = "10115";
var point = new GLatLng(40.8109,-73.954);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10116 40.8113 -73.9534
var zip = "10116";
var point = new GLatLng(40.8113,-73.9534);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10117 40.7507 -73.9946
var zip = "10117";
var point = new GLatLng(40.7507,-73.9946);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10118 40.7483 -73.9865
var zip = "10118";
var point = new GLatLng(40.7483,-73.9865);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10119 40.7509 -73.9921
var zip = "10119";
var point = new GLatLng(40.7509,-73.9921);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10120 40.7496 -73.9884
var zip = "10120";
var point = new GLatLng(40.7496,-73.9884);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10121 40.7497 -73.9919
var zip = "10121";
var point = new GLatLng(40.7497,-73.9919);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10122 40.7507 -73.9946
var zip = "10122";
var point = new GLatLng(40.7507,-73.9946);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10123 40.7507 -73.9946
var zip = "10123";
var point = new GLatLng(40.7507,-73.9946);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10124 40.7577 -73.978
var zip = "10124";
var point = new GLatLng(40.7577,-73.978);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10125 40.7995 -73.9679
var zip = "10125";
var point = new GLatLng(40.7995,-73.9679);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10126 40.7586 -73.9724
var zip = "10126";
var point = new GLatLng(40.7586,-73.9724);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10128 40.781618 -73.951112
var zip = "10128";
var point = new GLatLng(40.781618,-73.951112);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10129 40.7574 -73.9918
var zip = "10129";
var point = new GLatLng(40.7574,-73.9918);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10130 40.7778 -73.9541
var zip = "10130";
var point = new GLatLng(40.7778,-73.9541);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10131 40.7679 -73.9611
var zip = "10131";
var point = new GLatLng(40.7679,-73.9611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10132 40.7849 -73.9748
var zip = "10132";
var point = new GLatLng(40.7849,-73.9748);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10133 40.7716 -73.9873
var zip = "10133";
var point = new GLatLng(40.7716,-73.9873);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10138 40.754 -73.9909
var zip = "10138";
var point = new GLatLng(40.754,-73.9909);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10149 40.7655 -73.9873
var zip = "10149";
var point = new GLatLng(40.7655,-73.9873);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10150 40.7583 -73.9688
var zip = "10150";
var point = new GLatLng(40.7583,-73.9688);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10151 40.7631 -73.9733
var zip = "10151";
var point = new GLatLng(40.7631,-73.9733);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10152 40.7583 -73.9688
var zip = "10152";
var point = new GLatLng(40.7583,-73.9688);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10153 40.7583 -73.9688
var zip = "10153";
var point = new GLatLng(40.7583,-73.9688);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10154 40.7578 -73.973
var zip = "10154";
var point = new GLatLng(40.7578,-73.973);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10155 40.7609 -73.9679
var zip = "10155";
var point = new GLatLng(40.7609,-73.9679);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10156 40.753 -73.9924
var zip = "10156";
var point = new GLatLng(40.753,-73.9924);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10157 40.753 -73.9924
var zip = "10157";
var point = new GLatLng(40.753,-73.9924);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10158 40.7487 -73.9753
var zip = "10158";
var point = new GLatLng(40.7487,-73.9753);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10159 40.7389 -73.9845
var zip = "10159";
var point = new GLatLng(40.7389,-73.9845);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10160 40.7389 -73.9845
var zip = "10160";
var point = new GLatLng(40.7389,-73.9845);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10161 40.7141 -74.0063
var zip = "10161";
var point = new GLatLng(40.7141,-74.0063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10162 40.7693 -73.9505
var zip = "10162";
var point = new GLatLng(40.7693,-73.9505);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10163 40.7516 -73.9761
var zip = "10163";
var point = new GLatLng(40.7516,-73.9761);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10164 40.7516 -73.9761
var zip = "10164";
var point = new GLatLng(40.7516,-73.9761);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10165 40.752 -73.9792
var zip = "10165";
var point = new GLatLng(40.752,-73.9792);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10166 40.7532 -73.9766
var zip = "10166";
var point = new GLatLng(40.7532,-73.9766);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10167 40.7516 -73.9761
var zip = "10167";
var point = new GLatLng(40.7516,-73.9761);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10168 40.7516 -73.9761
var zip = "10168";
var point = new GLatLng(40.7516,-73.9761);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10169 40.754 -73.9771
var zip = "10169";
var point = new GLatLng(40.754,-73.9771);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10170 40.7516 -73.9761
var zip = "10170";
var point = new GLatLng(40.7516,-73.9761);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10171 40.7516 -73.9761
var zip = "10171";
var point = new GLatLng(40.7516,-73.9761);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10172 40.7516 -73.9761
var zip = "10172";
var point = new GLatLng(40.7516,-73.9761);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10173 40.7537 -73.9784
var zip = "10173";
var point = new GLatLng(40.7537,-73.9784);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10174 40.7516 -73.9761
var zip = "10174";
var point = new GLatLng(40.7516,-73.9761);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10175 40.7538 -73.98
var zip = "10175";
var point = new GLatLng(40.7538,-73.98);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10176 40.7516 -73.9761
var zip = "10176";
var point = new GLatLng(40.7516,-73.9761);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10177 40.7516 -73.9761
var zip = "10177";
var point = new GLatLng(40.7516,-73.9761);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10178 40.7516 -73.9761
var zip = "10178";
var point = new GLatLng(40.7516,-73.9761);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10179 40.714167 -74.006667
var zip = "10179";
var point = new GLatLng(40.714167,-74.006667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10184 40.7141 -74.0063
var zip = "10184";
var point = new GLatLng(40.7141,-74.0063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10185 40.7577 -73.978
var zip = "10185";
var point = new GLatLng(40.7577,-73.978);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10196 40.7141 -74.0063
var zip = "10196";
var point = new GLatLng(40.7141,-74.0063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10197 40.7141 -74.0063
var zip = "10197";
var point = new GLatLng(40.7141,-74.0063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10199 40.7507 -73.9945
var zip = "10199";
var point = new GLatLng(40.7507,-73.9945);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10203 40.7121 -74.0102
var zip = "10203";
var point = new GLatLng(40.7121,-74.0102);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10211 40.7314 -73.9904
var zip = "10211";
var point = new GLatLng(40.7314,-73.9904);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10212 40.7051 -74.014
var zip = "10212";
var point = new GLatLng(40.7051,-74.014);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10213 40.720278 -74.005
var zip = "10213";
var point = new GLatLng(40.720278,-74.005);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10242 40.7121 -74.0102
var zip = "10242";
var point = new GLatLng(40.7121,-74.0102);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10249 40.7121 -74.0102
var zip = "10249";
var point = new GLatLng(40.7121,-74.0102);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10256 40.7121 -74.0102
var zip = "10256";
var point = new GLatLng(40.7121,-74.0102);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10257 40.7141 -74.0063
var zip = "10257";
var point = new GLatLng(40.7141,-74.0063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10258 40.7141 -74.0063
var zip = "10258";
var point = new GLatLng(40.7141,-74.0063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10259 40.7121 -74.0102
var zip = "10259";
var point = new GLatLng(40.7121,-74.0102);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10260 40.7121 -74.0102
var zip = "10260";
var point = new GLatLng(40.7121,-74.0102);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10261 40.7121 -74.0102
var zip = "10261";
var point = new GLatLng(40.7121,-74.0102);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10265 40.7056 -74.0081
var zip = "10265";
var point = new GLatLng(40.7056,-74.0081);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10268 40.7056 -74.0081
var zip = "10268";
var point = new GLatLng(40.7056,-74.0081);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10269 40.7056 -74.0081
var zip = "10269";
var point = new GLatLng(40.7056,-74.0081);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10270 40.7056 -74.0081
var zip = "10270";
var point = new GLatLng(40.7056,-74.0081);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10271 40.7056 -74.0081
var zip = "10271";
var point = new GLatLng(40.7056,-74.0081);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10272 40.7141 -74.0063
var zip = "10272";
var point = new GLatLng(40.7141,-74.0063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10273 40.7141 -74.0063
var zip = "10273";
var point = new GLatLng(40.7141,-74.0063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10274 40.7051 -74.014
var zip = "10274";
var point = new GLatLng(40.7051,-74.014);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10275 40.7051 -74.014
var zip = "10275";
var point = new GLatLng(40.7051,-74.014);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10276 40.7314 -73.9904
var zip = "10276";
var point = new GLatLng(40.7314,-73.9904);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10277 40.7121 -74.0102
var zip = "10277";
var point = new GLatLng(40.7121,-74.0102);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10278 40.715 -74.0042
var zip = "10278";
var point = new GLatLng(40.715,-74.0042);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10279 40.7141 -74.0063
var zip = "10279";
var point = new GLatLng(40.7141,-74.0063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10280 40.710537 -74.016323
var zip = "10280";
var point = new GLatLng(40.710537,-74.016323);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10281 40.7147 -74.016
var zip = "10281";
var point = new GLatLng(40.7147,-74.016);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10282 40.7121 -74.0102
var zip = "10282";
var point = new GLatLng(40.7121,-74.0102);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10285 40.7121 -74.0102
var zip = "10285";
var point = new GLatLng(40.7121,-74.0102);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10286 40.7121 -74.0102
var zip = "10286";
var point = new GLatLng(40.7121,-74.0102);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10292 40.7066 -74.0053
var zip = "10292";
var point = new GLatLng(40.7066,-74.0053);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10301 40.631602 -74.092663
var zip = "10301";
var point = new GLatLng(40.631602,-74.092663);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10302 40.630597 -74.137918
var zip = "10302";
var point = new GLatLng(40.630597,-74.137918);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10303 40.630062 -74.160679
var zip = "10303";
var point = new GLatLng(40.630062,-74.160679);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10304 40.610249 -74.087836
var zip = "10304";
var point = new GLatLng(40.610249,-74.087836);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10305 40.597296 -74.076795
var zip = "10305";
var point = new GLatLng(40.597296,-74.076795);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10306 40.568183 -74.118386
var zip = "10306";
var point = new GLatLng(40.568183,-74.118386);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10307 40.508452 -74.244482
var zip = "10307";
var point = new GLatLng(40.508452,-74.244482);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10308 40.55181 -74.152649
var zip = "10308";
var point = new GLatLng(40.55181,-74.152649);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10309 40.535179 -74.211572
var zip = "10309";
var point = new GLatLng(40.535179,-74.211572);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10310 40.632427 -74.11715
var zip = "10310";
var point = new GLatLng(40.632427,-74.11715);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10311 40.6047 -74.1781
var zip = "10311";
var point = new GLatLng(40.6047,-74.1781);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10312 40.545745 -74.179165
var zip = "10312";
var point = new GLatLng(40.545745,-74.179165);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10313 40.5781 -74.1697
var zip = "10313";
var point = new GLatLng(40.5781,-74.1697);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10314 40.603915 -74.147218
var zip = "10314";
var point = new GLatLng(40.603915,-74.147218);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10451 40.8222 -73.921735
var zip = "10451";
var point = new GLatLng(40.8222,-73.921735);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10452 40.837594 -73.921555
var zip = "10452";
var point = new GLatLng(40.837594,-73.921555);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10453 40.852047 -73.912937
var zip = "10453";
var point = new GLatLng(40.852047,-73.912937);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10454 40.808549 -73.919821
var zip = "10454";
var point = new GLatLng(40.808549,-73.919821);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10455 40.815309 -73.907172
var zip = "10455";
var point = new GLatLng(40.815309,-73.907172);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10456 40.831557 -73.909893
var zip = "10456";
var point = new GLatLng(40.831557,-73.909893);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10457 40.848635 -73.899907
var zip = "10457";
var point = new GLatLng(40.848635,-73.899907);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10458 40.863307 -73.889464
var zip = "10458";
var point = new GLatLng(40.863307,-73.889464);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10459 40.824699 -73.894047
var zip = "10459";
var point = new GLatLng(40.824699,-73.894047);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10460 40.840949 -73.879409
var zip = "10460";
var point = new GLatLng(40.840949,-73.879409);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10461 40.846506 -73.840953
var zip = "10461";
var point = new GLatLng(40.846506,-73.840953);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10462 40.843369 -73.860185
var zip = "10462";
var point = new GLatLng(40.843369,-73.860185);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10463 40.879812 -73.906737
var zip = "10463";
var point = new GLatLng(40.879812,-73.906737);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10464 40.846941 -73.787436
var zip = "10464";
var point = new GLatLng(40.846941,-73.787436);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10465 40.826065 -73.819581
var zip = "10465";
var point = new GLatLng(40.826065,-73.819581);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10466 40.890375 -73.850333
var zip = "10466";
var point = new GLatLng(40.890375,-73.850333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10467 40.873671 -73.871242
var zip = "10467";
var point = new GLatLng(40.873671,-73.871242);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10468 40.866231 -73.900259
var zip = "10468";
var point = new GLatLng(40.866231,-73.900259);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10469 40.870193 -73.849465
var zip = "10469";
var point = new GLatLng(40.870193,-73.849465);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10470 40.900029 -73.862194
var zip = "10470";
var point = new GLatLng(40.900029,-73.862194);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10471 40.901084 -73.905283
var zip = "10471";
var point = new GLatLng(40.901084,-73.905283);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10472 40.829464 -73.871557
var zip = "10472";
var point = new GLatLng(40.829464,-73.871557);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10473 40.819364 -73.860626
var zip = "10473";
var point = new GLatLng(40.819364,-73.860626);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10474 40.801518 -73.886376
var zip = "10474";
var point = new GLatLng(40.801518,-73.886376);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10475 40.872903 -73.827817
var zip = "10475";
var point = new GLatLng(40.872903,-73.827817);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10499 40.85 -73.866667
var zip = "10499";
var point = new GLatLng(40.85,-73.866667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10501 41.294618 -73.761079
var zip = "10501";
var point = new GLatLng(41.294618,-73.761079);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10502 41.011332 -73.841311
var zip = "10502";
var point = new GLatLng(41.011332,-73.841311);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10503 41.026111 -73.870833
var zip = "10503";
var point = new GLatLng(41.026111,-73.870833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10504 41.136002 -73.700942
var zip = "10504";
var point = new GLatLng(41.136002,-73.700942);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10505 41.3475 -73.7625
var zip = "10505";
var point = new GLatLng(41.3475,-73.7625);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10506 41.190913 -73.635548
var zip = "10506";
var point = new GLatLng(41.190913,-73.635548);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10507 41.234439 -73.691517
var zip = "10507";
var point = new GLatLng(41.234439,-73.691517);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10509 41.409704 -73.599179
var zip = "10509";
var point = new GLatLng(41.409704,-73.599179);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10510 41.144364 -73.834956
var zip = "10510";
var point = new GLatLng(41.144364,-73.834956);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10511 41.258285 -73.941238
var zip = "10511";
var point = new GLatLng(41.258285,-73.941238);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10512 41.443216 -73.681526
var zip = "10512";
var point = new GLatLng(41.443216,-73.681526);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10514 41.170497 -73.771458
var zip = "10514";
var point = new GLatLng(41.170497,-73.771458);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10516 41.44142 -73.933485
var zip = "10516";
var point = new GLatLng(41.44142,-73.933485);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10517 41.295 -73.865833
var zip = "10517";
var point = new GLatLng(41.295,-73.865833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10518 41.27218 -73.602027
var zip = "10518";
var point = new GLatLng(41.27218,-73.602027);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10519 41.347222 -73.661389
var zip = "10519";
var point = new GLatLng(41.347222,-73.661389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10520 41.218037 -73.892408
var zip = "10520";
var point = new GLatLng(41.218037,-73.892408);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10521 41.233333 -73.923056
var zip = "10521";
var point = new GLatLng(41.233333,-73.923056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10522 41.011835 -73.866494
var zip = "10522";
var point = new GLatLng(41.011835,-73.866494);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10523 41.057171 -73.813597
var zip = "10523";
var point = new GLatLng(41.057171,-73.813597);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10524 41.362065 -73.920003
var zip = "10524";
var point = new GLatLng(41.362065,-73.920003);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10526 41.293333 -73.677222
var zip = "10526";
var point = new GLatLng(41.293333,-73.677222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10527 41.309791 -73.753008
var zip = "10527";
var point = new GLatLng(41.309791,-73.753008);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10528 40.971876 -73.718068
var zip = "10528";
var point = new GLatLng(40.971876,-73.718068);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10530 41.019658 -73.807404
var zip = "10530";
var point = new GLatLng(41.019658,-73.807404);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10532 41.095316 -73.801685
var zip = "10532";
var point = new GLatLng(41.095316,-73.801685);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10533 41.038113 -73.859666
var zip = "10533";
var point = new GLatLng(41.038113,-73.859666);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10535 41.338522 -73.794697
var zip = "10535";
var point = new GLatLng(41.338522,-73.794697);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10536 41.270884 -73.684115
var zip = "10536";
var point = new GLatLng(41.270884,-73.684115);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10537 41.337437 -73.883787
var zip = "10537";
var point = new GLatLng(41.337437,-73.883787);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10538 40.935055 -73.75715
var zip = "10538";
var point = new GLatLng(40.935055,-73.75715);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10540 41.322778 -73.718611
var zip = "10540";
var point = new GLatLng(41.322778,-73.718611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10541 41.371708 -73.750755
var zip = "10541";
var point = new GLatLng(41.371708,-73.750755);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10542 41.371944 -73.762222
var zip = "10542";
var point = new GLatLng(41.371944,-73.762222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10543 40.952481 -73.735037
var zip = "10543";
var point = new GLatLng(40.952481,-73.735037);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10545 41.179167 -73.832778
var zip = "10545";
var point = new GLatLng(41.179167,-73.832778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10546 41.201519 -73.792626
var zip = "10546";
var point = new GLatLng(41.201519,-73.792626);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10547 41.314348 -73.850836
var zip = "10547";
var point = new GLatLng(41.314348,-73.850836);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10548 41.249585 -73.944593
var zip = "10548";
var point = new GLatLng(41.249585,-73.944593);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10549 41.204966 -73.729921
var zip = "10549";
var point = new GLatLng(41.204966,-73.729921);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10550 40.907863 -73.837961
var zip = "10550";
var point = new GLatLng(40.907863,-73.837961);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10551 40.9008 -73.8246
var zip = "10551";
var point = new GLatLng(40.9008,-73.8246);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10552 40.923056 -73.829919
var zip = "10552";
var point = new GLatLng(40.923056,-73.829919);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10553 40.908645 -73.822111
var zip = "10553";
var point = new GLatLng(40.908645,-73.822111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10557 40.9008 -73.8246
var zip = "10557";
var point = new GLatLng(40.9008,-73.8246);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10558 40.9008 -73.8246
var zip = "10558";
var point = new GLatLng(40.9008,-73.8246);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10560 41.341388 -73.592947
var zip = "10560";
var point = new GLatLng(41.341388,-73.592947);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10562 41.167344 -73.853791
var zip = "10562";
var point = new GLatLng(41.167344,-73.853791);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10566 41.293722 -73.902562
var zip = "10566";
var point = new GLatLng(41.293722,-73.902562);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10567 41.289722 -73.850556
var zip = "10567";
var point = new GLatLng(41.289722,-73.850556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10570 41.134977 -73.784484
var zip = "10570";
var point = new GLatLng(41.134977,-73.784484);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10571 41.1343 -73.7946
var zip = "10571";
var point = new GLatLng(41.1343,-73.7946);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10572 41.1343 -73.7946
var zip = "10572";
var point = new GLatLng(41.1343,-73.7946);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10573 41.007755 -73.672045
var zip = "10573";
var point = new GLatLng(41.007755,-73.672045);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10576 41.204196 -73.573215
var zip = "10576";
var point = new GLatLng(41.204196,-73.573215);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10577 41.038396 -73.715629
var zip = "10577";
var point = new GLatLng(41.038396,-73.715629);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10578 41.322427 -73.654313
var zip = "10578";
var point = new GLatLng(41.322427,-73.654313);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10579 41.372815 -73.85024
var zip = "10579";
var point = new GLatLng(41.372815,-73.85024);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10580 40.973403 -73.690721
var zip = "10580";
var point = new GLatLng(40.973403,-73.690721);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10583 40.988365 -73.797566
var zip = "10583";
var point = new GLatLng(40.988365,-73.797566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10587 41.331667 -73.738611
var zip = "10587";
var point = new GLatLng(41.331667,-73.738611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10588 41.328608 -73.82732
var zip = "10588";
var point = new GLatLng(41.328608,-73.82732);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10589 41.334568 -73.695145
var zip = "10589";
var point = new GLatLng(41.334568,-73.695145);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10590 41.255261 -73.540224
var zip = "10590";
var point = new GLatLng(41.255261,-73.540224);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10591 41.078108 -73.859335
var zip = "10591";
var point = new GLatLng(41.078108,-73.859335);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10594 41.118163 -73.773329
var zip = "10594";
var point = new GLatLng(41.118163,-73.773329);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10595 41.085559 -73.777596
var zip = "10595";
var point = new GLatLng(41.085559,-73.777596);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10596 41.252778 -73.960278
var zip = "10596";
var point = new GLatLng(41.252778,-73.960278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10597 41.303208 -73.603207
var zip = "10597";
var point = new GLatLng(41.303208,-73.603207);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10598 41.299947 -73.792398
var zip = "10598";
var point = new GLatLng(41.299947,-73.792398);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10601 41.032955 -73.765231
var zip = "10601";
var point = new GLatLng(41.032955,-73.765231);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10602 41.0274 -73.775
var zip = "10602";
var point = new GLatLng(41.0274,-73.775);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10603 41.049913 -73.77758
var zip = "10603";
var point = new GLatLng(41.049913,-73.77758);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10604 41.043295 -73.750727
var zip = "10604";
var point = new GLatLng(41.043295,-73.750727);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10605 41.014053 -73.755247
var zip = "10605";
var point = new GLatLng(41.014053,-73.755247);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10606 41.024714 -73.778097
var zip = "10606";
var point = new GLatLng(41.024714,-73.778097);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10607 41.039813 -73.811692
var zip = "10607";
var point = new GLatLng(41.039813,-73.811692);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10610 41.0276 -73.7744
var zip = "10610";
var point = new GLatLng(41.0276,-73.7744);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10701 40.940716 -73.888317
var zip = "10701";
var point = new GLatLng(40.940716,-73.888317);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10702 40.931111 -73.899167
var zip = "10702";
var point = new GLatLng(40.931111,-73.899167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10703 40.951763 -73.885163
var zip = "10703";
var point = new GLatLng(40.951763,-73.885163);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10704 40.917633 -73.859347
var zip = "10704";
var point = new GLatLng(40.917633,-73.859347);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10705 40.917665 -73.895041
var zip = "10705";
var point = new GLatLng(40.917665,-73.895041);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10706 40.99071 -73.875912
var zip = "10706";
var point = new GLatLng(40.99071,-73.875912);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10707 40.95691 -73.819771
var zip = "10707";
var point = new GLatLng(40.95691,-73.819771);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10708 40.939133 -73.835332
var zip = "10708";
var point = new GLatLng(40.939133,-73.835332);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10709 40.954966 -73.80858
var zip = "10709";
var point = new GLatLng(40.954966,-73.80858);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10710 40.965574 -73.843435
var zip = "10710";
var point = new GLatLng(40.965574,-73.843435);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10801 40.916628 -73.787729
var zip = "10801";
var point = new GLatLng(40.916628,-73.787729);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10802 40.911389 -73.782778
var zip = "10802";
var point = new GLatLng(40.911389,-73.782778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10803 40.904455 -73.807304
var zip = "10803";
var point = new GLatLng(40.904455,-73.807304);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10804 40.948335 -73.786018
var zip = "10804";
var point = new GLatLng(40.948335,-73.786018);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10805 40.900236 -73.781043
var zip = "10805";
var point = new GLatLng(40.900236,-73.781043);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10901 41.117654 -74.124098
var zip = "10901";
var point = new GLatLng(41.117654,-74.124098);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10910 41.274444 -74.153333
var zip = "10910";
var point = new GLatLng(41.274444,-74.153333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10911 41.306734 -73.996108
var zip = "10911";
var point = new GLatLng(41.306734,-73.996108);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10912 41.250278 -74.311111
var zip = "10912";
var point = new GLatLng(41.250278,-74.311111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10913 41.062597 -73.962924
var zip = "10913";
var point = new GLatLng(41.062597,-73.962924);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10914 41.409167 -74.195556
var zip = "10914";
var point = new GLatLng(41.409167,-74.195556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10915 41.544167 -74.361944
var zip = "10915";
var point = new GLatLng(41.544167,-74.361944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10916 41.442993 -74.250466
var zip = "10916";
var point = new GLatLng(41.442993,-74.250466);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10917 41.326836 -74.122036
var zip = "10917";
var point = new GLatLng(41.326836,-74.122036);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10918 41.355381 -74.265116
var zip = "10918";
var point = new GLatLng(41.355381,-74.265116);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10919 41.524387 -74.385044
var zip = "10919";
var point = new GLatLng(41.524387,-74.385044);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10920 41.148689 -73.94131
var zip = "10920";
var point = new GLatLng(41.148689,-73.94131);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10921 41.329507 -74.352805
var zip = "10921";
var point = new GLatLng(41.329507,-74.352805);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10922 41.323889 -73.987222
var zip = "10922";
var point = new GLatLng(41.323889,-73.987222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10923 41.202057 -74.000501
var zip = "10923";
var point = new GLatLng(41.202057,-74.000501);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10924 41.394586 -74.330162
var zip = "10924";
var point = new GLatLng(41.394586,-74.330162);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10925 41.212718 -74.300007
var zip = "10925";
var point = new GLatLng(41.212718,-74.300007);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10926 41.299681 -74.155805
var zip = "10926";
var point = new GLatLng(41.299681,-74.155805);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10927 41.197095 -73.968959
var zip = "10927";
var point = new GLatLng(41.197095,-73.968959);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10928 41.358177 -73.974618
var zip = "10928";
var point = new GLatLng(41.358177,-73.974618);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10930 41.353592 -74.119678
var zip = "10930";
var point = new GLatLng(41.353592,-74.119678);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10931 41.123981 -74.170195
var zip = "10931";
var point = new GLatLng(41.123981,-74.170195);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10932 41.479444 -74.465556
var zip = "10932";
var point = new GLatLng(41.479444,-74.465556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10933 41.366111 -74.506944
var zip = "10933";
var point = new GLatLng(41.366111,-74.506944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10940 41.457222 -74.412023
var zip = "10940";
var point = new GLatLng(41.457222,-74.412023);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10941 41.447222 -74.414444
var zip = "10941";
var point = new GLatLng(41.447222,-74.414444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10943 41.445833 -74.423333
var zip = "10943";
var point = new GLatLng(41.445833,-74.423333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10949 41.330556 -74.187222
var zip = "10949";
var point = new GLatLng(41.330556,-74.187222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10950 41.328578 -74.188521
var zip = "10950";
var point = new GLatLng(41.328578,-74.188521);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10952 41.116255 -74.0736
var zip = "10952";
var point = new GLatLng(41.116255,-74.0736);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10953 41.400833 -74.078889
var zip = "10953";
var point = new GLatLng(41.400833,-74.078889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10954 41.099176 -74.009589
var zip = "10954";
var point = new GLatLng(41.099176,-74.009589);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10956 41.147247 -73.996206
var zip = "10956";
var point = new GLatLng(41.147247,-73.996206);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10958 41.362714 -74.443483
var zip = "10958";
var point = new GLatLng(41.362714,-74.443483);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10959 41.234444 -74.414167
var zip = "10959";
var point = new GLatLng(41.234444,-74.414167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10960 41.091351 -73.925226
var zip = "10960";
var point = new GLatLng(41.091351,-73.925226);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10962 41.044183 -73.960873
var zip = "10962";
var point = new GLatLng(41.044183,-73.960873);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10963 41.481806 -74.529413
var zip = "10963";
var point = new GLatLng(41.481806,-74.529413);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10964 41.010263 -73.924985
var zip = "10964";
var point = new GLatLng(41.010263,-73.924985);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10965 41.062939 -74.01587
var zip = "10965";
var point = new GLatLng(41.062939,-74.01587);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10968 41.03955 -73.919187
var zip = "10968";
var point = new GLatLng(41.03955,-73.919187);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10969 41.323796 -74.379457
var zip = "10969";
var point = new GLatLng(41.323796,-74.379457);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10970 41.190105 -74.043564
var zip = "10970";
var point = new GLatLng(41.190105,-74.043564);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10973 41.376004 -74.484658
var zip = "10973";
var point = new GLatLng(41.376004,-74.484658);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10974 41.16047 -74.188107
var zip = "10974";
var point = new GLatLng(41.16047,-74.188107);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10975 41.247959 -74.176182
var zip = "10975";
var point = new GLatLng(41.247959,-74.176182);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10976 41.025573 -73.92288
var zip = "10976";
var point = new GLatLng(41.025573,-73.92288);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10977 41.117977 -74.046253
var zip = "10977";
var point = new GLatLng(41.117977,-74.046253);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10979 41.1825 -74.319167
var zip = "10979";
var point = new GLatLng(41.1825,-74.319167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10980 41.229174 -73.996164
var zip = "10980";
var point = new GLatLng(41.229174,-73.996164);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10981 41.320833 -74.285833
var zip = "10981";
var point = new GLatLng(41.320833,-74.285833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10982 41.111111 -74.100278
var zip = "10982";
var point = new GLatLng(41.111111,-74.100278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10983 41.027751 -73.949065
var zip = "10983";
var point = new GLatLng(41.027751,-73.949065);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10984 41.207826 -74.015441
var zip = "10984";
var point = new GLatLng(41.207826,-74.015441);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10985 41.580957 -74.377445
var zip = "10985";
var point = new GLatLng(41.580957,-74.377445);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//10986 41.259763 -73.98916
var zip = "10986";
var point = new GLatLng(41.259763,-73.98916);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10987 41.192486 -74.215912
var zip = "10987";
var point = new GLatLng(41.192486,-74.215912);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10988 41.301944 -74.561944
var zip = "10988";
var point = new GLatLng(41.301944,-74.561944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10989 41.118338 -73.943006
var zip = "10989";
var point = new GLatLng(41.118338,-73.943006);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10990 41.265563 -74.36037
var zip = "10990";
var point = new GLatLng(41.265563,-74.36037);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//10992 41.423701 -74.1601
var zip = "10992";
var point = new GLatLng(41.423701,-74.1601);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10993 41.209016 -73.982123
var zip = "10993";
var point = new GLatLng(41.209016,-73.982123);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10994 41.097324 -73.976846
var zip = "10994";
var point = new GLatLng(41.097324,-73.976846);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//10996 41.394545 -73.973666
var zip = "10996";
var point = new GLatLng(41.394545,-73.973666);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10997 41.391389 -73.956389
var zip = "10997";
var point = new GLatLng(41.391389,-73.956389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//10998 41.321414 -74.552946
var zip = "10998";
var point = new GLatLng(41.321414,-74.552946);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11001 40.723586 -73.70576
var zip = "11001";
var point = new GLatLng(40.723586,-73.70576);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11002 40.7264 -73.7088
var zip = "11002";
var point = new GLatLng(40.7264,-73.7088);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11003 40.699615 -73.705751
var zip = "11003";
var point = new GLatLng(40.699615,-73.705751);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11004 40.7481 -73.711436
var zip = "11004";
var point = new GLatLng(40.7481,-73.711436);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11005 40.7569 -73.712
var zip = "11005";
var point = new GLatLng(40.7569,-73.712);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11010 40.701049 -73.675807
var zip = "11010";
var point = new GLatLng(40.701049,-73.675807);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11020 40.774235 -73.718918
var zip = "11020";
var point = new GLatLng(40.774235,-73.718918);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11021 40.786674 -73.726984
var zip = "11021";
var point = new GLatLng(40.786674,-73.726984);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11022 40.7875 -73.725
var zip = "11022";
var point = new GLatLng(40.7875,-73.725);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11023 40.799307 -73.734257
var zip = "11023";
var point = new GLatLng(40.799307,-73.734257);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11024 40.813307 -73.741391
var zip = "11024";
var point = new GLatLng(40.813307,-73.741391);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11025 40.8005 -73.7288
var zip = "11025";
var point = new GLatLng(40.8005,-73.7288);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11026 40.8005 -73.7288
var zip = "11026";
var point = new GLatLng(40.8005,-73.7288);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11027 40.7875 -73.725
var zip = "11027";
var point = new GLatLng(40.7875,-73.725);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11030 40.798641 -73.688369
var zip = "11030";
var point = new GLatLng(40.798641,-73.688369);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11040 40.743926 -73.68042
var zip = "11040";
var point = new GLatLng(40.743926,-73.68042);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11041 40.735 -73.6883
var zip = "11041";
var point = new GLatLng(40.735,-73.6883);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11042 40.7602 -73.694978
var zip = "11042";
var point = new GLatLng(40.7602,-73.694978);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11043 40.7317 -73.6821
var zip = "11043";
var point = new GLatLng(40.7317,-73.6821);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11044 40.735 -73.6883
var zip = "11044";
var point = new GLatLng(40.735,-73.6883);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11050 40.834995 -73.696356
var zip = "11050";
var point = new GLatLng(40.834995,-73.696356);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11051 40.8308 -73.6842
var zip = "11051";
var point = new GLatLng(40.8308,-73.6842);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11052 40.8308 -73.6842
var zip = "11052";
var point = new GLatLng(40.8308,-73.6842);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11053 40.8255 -73.6986
var zip = "11053";
var point = new GLatLng(40.8255,-73.6986);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11054 40.8308 -73.6842
var zip = "11054";
var point = new GLatLng(40.8308,-73.6842);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11055 40.8255 -73.6986
var zip = "11055";
var point = new GLatLng(40.8255,-73.6986);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11096 40.621944 -73.747222
var zip = "11096";
var point = new GLatLng(40.621944,-73.747222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11099 40.735 -73.6883
var zip = "11099";
var point = new GLatLng(40.735,-73.6883);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11101 40.750316 -73.939393
var zip = "11101";
var point = new GLatLng(40.750316,-73.939393);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11102 40.77063 -73.926462
var zip = "11102";
var point = new GLatLng(40.77063,-73.926462);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11103 40.762651 -73.914886
var zip = "11103";
var point = new GLatLng(40.762651,-73.914886);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11104 40.743641 -73.921556
var zip = "11104";
var point = new GLatLng(40.743641,-73.921556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11105 40.77627 -73.910965
var zip = "11105";
var point = new GLatLng(40.77627,-73.910965);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11106 40.760813 -73.929527
var zip = "11106";
var point = new GLatLng(40.760813,-73.929527);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11109 40.7442 -73.9577
var zip = "11109";
var point = new GLatLng(40.7442,-73.9577);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11120 40.7447 -73.9491
var zip = "11120";
var point = new GLatLng(40.7447,-73.9491);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11201 40.694021 -73.99034
var zip = "11201";
var point = new GLatLng(40.694021,-73.99034);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11202 40.6959 -73.9934
var zip = "11202";
var point = new GLatLng(40.6959,-73.9934);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11203 40.650496 -73.934888
var zip = "11203";
var point = new GLatLng(40.650496,-73.934888);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11204 40.617871 -73.985623
var zip = "11204";
var point = new GLatLng(40.617871,-73.985623);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11205 40.692433 -73.96662
var zip = "11205";
var point = new GLatLng(40.692433,-73.96662);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11206 40.701195 -73.943617
var zip = "11206";
var point = new GLatLng(40.701195,-73.943617);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11207 40.670486 -73.893957
var zip = "11207";
var point = new GLatLng(40.670486,-73.893957);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11208 40.676191 -73.873649
var zip = "11208";
var point = new GLatLng(40.676191,-73.873649);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11209 40.625106 -74.030304
var zip = "11209";
var point = new GLatLng(40.625106,-74.030304);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11210 40.628064 -73.946682
var zip = "11210";
var point = new GLatLng(40.628064,-73.946682);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11211 40.709476 -73.956283
var zip = "11211";
var point = new GLatLng(40.709476,-73.956283);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11212 40.662474 -73.914483
var zip = "11212";
var point = new GLatLng(40.662474,-73.914483);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11213 40.669961 -73.93665
var zip = "11213";
var point = new GLatLng(40.669961,-73.93665);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11214 40.601563 -73.99681
var zip = "11214";
var point = new GLatLng(40.601563,-73.99681);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11215 40.666863 -73.982783
var zip = "11215";
var point = new GLatLng(40.666863,-73.982783);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11216 40.67943 -73.949639
var zip = "11216";
var point = new GLatLng(40.67943,-73.949639);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11217 40.68165 -73.979797
var zip = "11217";
var point = new GLatLng(40.68165,-73.979797);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11218 40.642373 -73.975806
var zip = "11218";
var point = new GLatLng(40.642373,-73.975806);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11219 40.633568 -73.996011
var zip = "11219";
var point = new GLatLng(40.633568,-73.996011);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11220 40.641165 -74.013287
var zip = "11220";
var point = new GLatLng(40.641165,-74.013287);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11221 40.690695 -73.927373
var zip = "11221";
var point = new GLatLng(40.690695,-73.927373);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11222 40.727164 -73.949846
var zip = "11222";
var point = new GLatLng(40.727164,-73.949846);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11223 40.597874 -73.974291
var zip = "11223";
var point = new GLatLng(40.597874,-73.974291);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11224 40.576729 -73.988395
var zip = "11224";
var point = new GLatLng(40.576729,-73.988395);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11225 40.662776 -73.954588
var zip = "11225";
var point = new GLatLng(40.662776,-73.954588);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11226 40.646694 -73.956985
var zip = "11226";
var point = new GLatLng(40.646694,-73.956985);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11228 40.617441 -74.012067
var zip = "11228";
var point = new GLatLng(40.617441,-74.012067);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11229 40.601094 -73.94749
var zip = "11229";
var point = new GLatLng(40.601094,-73.94749);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11230 40.622493 -73.965007
var zip = "11230";
var point = new GLatLng(40.622493,-73.965007);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11231 40.679437 -74.00141
var zip = "11231";
var point = new GLatLng(40.679437,-74.00141);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11232 40.652113 -74.001797
var zip = "11232";
var point = new GLatLng(40.652113,-74.001797);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11233 40.678415 -73.921104
var zip = "11233";
var point = new GLatLng(40.678415,-73.921104);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11234 40.620475 -73.923915
var zip = "11234";
var point = new GLatLng(40.620475,-73.923915);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11235 40.583898 -73.953599
var zip = "11235";
var point = new GLatLng(40.583898,-73.953599);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11236 40.640685 -73.902764
var zip = "11236";
var point = new GLatLng(40.640685,-73.902764);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11237 40.700616 -73.917979
var zip = "11237";
var point = new GLatLng(40.700616,-73.917979);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11238 40.679015 -73.964387
var zip = "11238";
var point = new GLatLng(40.679015,-73.964387);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11239 40.649748 -73.882375
var zip = "11239";
var point = new GLatLng(40.649748,-73.882375);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11240 40.6981 -73.986
var zip = "11240";
var point = new GLatLng(40.6981,-73.986);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11241 40.6932 -73.9911
var zip = "11241";
var point = new GLatLng(40.6932,-73.9911);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11242 40.6932 -73.9911
var zip = "11242";
var point = new GLatLng(40.6932,-73.9911);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11243 40.6846 -73.9804
var zip = "11243";
var point = new GLatLng(40.6846,-73.9804);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11244 40.6895 -73.9906
var zip = "11244";
var point = new GLatLng(40.6895,-73.9906);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11245 40.6873 -73.9896
var zip = "11245";
var point = new GLatLng(40.6873,-73.9896);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11247 40.68 -73.9476
var zip = "11247";
var point = new GLatLng(40.68,-73.9476);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11248 40.6991 -73.9928
var zip = "11248";
var point = new GLatLng(40.6991,-73.9928);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11249 40.6942 -73.9907
var zip = "11249";
var point = new GLatLng(40.6942,-73.9907);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11251 40.703578 -73.966511
var zip = "11251";
var point = new GLatLng(40.703578,-73.966511);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11252 40.618611 -74.033611
var zip = "11252";
var point = new GLatLng(40.618611,-74.033611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11254 40.6983 -73.9917
var zip = "11254";
var point = new GLatLng(40.6983,-73.9917);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11255 40.6953 -73.9899
var zip = "11255";
var point = new GLatLng(40.6953,-73.9899);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11256 40.6632 -73.8603
var zip = "11256";
var point = new GLatLng(40.6632,-73.8603);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11351 40.7816 -73.8272
var zip = "11351";
var point = new GLatLng(40.7816,-73.8272);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11352 40.7476 -73.8263
var zip = "11352";
var point = new GLatLng(40.7476,-73.8263);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11354 40.766722 -73.824142
var zip = "11354";
var point = new GLatLng(40.766722,-73.824142);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11355 40.753573 -73.822609
var zip = "11355";
var point = new GLatLng(40.753573,-73.822609);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11356 40.785511 -73.844955
var zip = "11356";
var point = new GLatLng(40.785511,-73.844955);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11357 40.785147 -73.809594
var zip = "11357";
var point = new GLatLng(40.785147,-73.809594);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11358 40.760636 -73.796788
var zip = "11358";
var point = new GLatLng(40.760636,-73.796788);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11359 40.789967 -73.777244
var zip = "11359";
var point = new GLatLng(40.789967,-73.777244);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11360 40.780684 -73.781216
var zip = "11360";
var point = new GLatLng(40.780684,-73.781216);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11361 40.76268 -73.774457
var zip = "11361";
var point = new GLatLng(40.76268,-73.774457);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11362 40.759131 -73.732622
var zip = "11362";
var point = new GLatLng(40.759131,-73.732622);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11363 40.772166 -73.745401
var zip = "11363";
var point = new GLatLng(40.772166,-73.745401);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11364 40.745847 -73.758646
var zip = "11364";
var point = new GLatLng(40.745847,-73.758646);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11365 40.737424 -73.79506
var zip = "11365";
var point = new GLatLng(40.737424,-73.79506);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11366 40.727231 -73.794922
var zip = "11366";
var point = new GLatLng(40.727231,-73.794922);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11367 40.727966 -73.81953
var zip = "11367";
var point = new GLatLng(40.727966,-73.81953);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11368 40.745288 -73.861069
var zip = "11368";
var point = new GLatLng(40.745288,-73.861069);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11369 40.761254 -73.873902
var zip = "11369";
var point = new GLatLng(40.761254,-73.873902);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11370 40.761111 -73.891586
var zip = "11370";
var point = new GLatLng(40.761111,-73.891586);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11371 40.772117 -73.873535
var zip = "11371";
var point = new GLatLng(40.772117,-73.873535);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11372 40.751329 -73.882975
var zip = "11372";
var point = new GLatLng(40.751329,-73.882975);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11373 40.740388 -73.878551
var zip = "11373";
var point = new GLatLng(40.740388,-73.878551);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11374 40.72775 -73.860191
var zip = "11374";
var point = new GLatLng(40.72775,-73.860191);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11375 40.722854 -73.847306
var zip = "11375";
var point = new GLatLng(40.722854,-73.847306);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11377 40.744972 -73.906911
var zip = "11377";
var point = new GLatLng(40.744972,-73.906911);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11378 40.723865 -73.899682
var zip = "11378";
var point = new GLatLng(40.723865,-73.899682);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11379 40.717286 -73.879228
var zip = "11379";
var point = new GLatLng(40.717286,-73.879228);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11380 40.715556 -73.879722
var zip = "11380";
var point = new GLatLng(40.715556,-73.879722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11381 40.7652 -73.8177
var zip = "11381";
var point = new GLatLng(40.7652,-73.8177);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11385 40.703613 -73.896122
var zip = "11385";
var point = new GLatLng(40.703613,-73.896122);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11386 40.7 -73.906111
var zip = "11386";
var point = new GLatLng(40.7,-73.906111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11390 40.7652 -73.8177
var zip = "11390";
var point = new GLatLng(40.7652,-73.8177);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11405 40.6913 -73.8061
var zip = "11405";
var point = new GLatLng(40.6913,-73.8061);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11411 40.694741 -73.737445
var zip = "11411";
var point = new GLatLng(40.694741,-73.737445);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11412 40.698097 -73.758641
var zip = "11412";
var point = new GLatLng(40.698097,-73.758641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11413 40.67295 -73.75071
var zip = "11413";
var point = new GLatLng(40.67295,-73.75071);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11414 40.660603 -73.845041
var zip = "11414";
var point = new GLatLng(40.660603,-73.845041);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11415 40.706865 -73.829715
var zip = "11415";
var point = new GLatLng(40.706865,-73.829715);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11416 40.683753 -73.851397
var zip = "11416";
var point = new GLatLng(40.683753,-73.851397);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11417 40.676854 -73.844778
var zip = "11417";
var point = new GLatLng(40.676854,-73.844778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11418 40.698171 -73.834484
var zip = "11418";
var point = new GLatLng(40.698171,-73.834484);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11419 40.688113 -73.823871
var zip = "11419";
var point = new GLatLng(40.688113,-73.823871);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11420 40.675379 -73.815773
var zip = "11420";
var point = new GLatLng(40.675379,-73.815773);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11421 40.691345 -73.858514
var zip = "11421";
var point = new GLatLng(40.691345,-73.858514);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11422 40.662141 -73.735265
var zip = "11422";
var point = new GLatLng(40.662141,-73.735265);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11423 40.714156 -73.767685
var zip = "11423";
var point = new GLatLng(40.714156,-73.767685);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11424 40.714167 -73.831389
var zip = "11424";
var point = new GLatLng(40.714167,-73.831389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11425 40.6913 -73.8061
var zip = "11425";
var point = new GLatLng(40.6913,-73.8061);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11426 40.734735 -73.723018
var zip = "11426";
var point = new GLatLng(40.734735,-73.723018);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11427 40.727707 -73.748908
var zip = "11427";
var point = new GLatLng(40.727707,-73.748908);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11428 40.720756 -73.743312
var zip = "11428";
var point = new GLatLng(40.720756,-73.743312);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11429 40.70902 -73.740064
var zip = "11429";
var point = new GLatLng(40.70902,-73.740064);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11430 40.647221 -73.782663
var zip = "11430";
var point = new GLatLng(40.647221,-73.782663);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11431 40.6913 -73.8061
var zip = "11431";
var point = new GLatLng(40.6913,-73.8061);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11432 40.711867 -73.79442
var zip = "11432";
var point = new GLatLng(40.711867,-73.79442);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11433 40.69691 -73.787669
var zip = "11433";
var point = new GLatLng(40.69691,-73.787669);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11434 40.677483 -73.77584
var zip = "11434";
var point = new GLatLng(40.677483,-73.77584);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11435 40.702934 -73.811121
var zip = "11435";
var point = new GLatLng(40.702934,-73.811121);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11436 40.676347 -73.796596
var zip = "11436";
var point = new GLatLng(40.676347,-73.796596);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11439 40.6913 -73.8061
var zip = "11439";
var point = new GLatLng(40.6913,-73.8061);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11451 40.7011 -73.8006
var zip = "11451";
var point = new GLatLng(40.7011,-73.8006);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11499 40.6913 -73.8061
var zip = "11499";
var point = new GLatLng(40.6913,-73.8061);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11501 40.746927 -73.639761
var zip = "11501";
var point = new GLatLng(40.746927,-73.639761);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11507 40.77032 -73.651419
var zip = "11507";
var point = new GLatLng(40.77032,-73.651419);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11509 40.588652 -73.725545
var zip = "11509";
var point = new GLatLng(40.588652,-73.725545);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11510 40.654755 -73.609688
var zip = "11510";
var point = new GLatLng(40.654755,-73.609688);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11514 40.75115 -73.611941
var zip = "11514";
var point = new GLatLng(40.75115,-73.611941);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11516 40.623619 -73.726404
var zip = "11516";
var point = new GLatLng(40.623619,-73.726404);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11518 40.640445 -73.667376
var zip = "11518";
var point = new GLatLng(40.640445,-73.667376);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11520 40.65359 -73.586615
var zip = "11520";
var point = new GLatLng(40.65359,-73.586615);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11530 40.72452 -73.648718
var zip = "11530";
var point = new GLatLng(40.72452,-73.648718);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11531 40.7235 -73.6334
var zip = "11531";
var point = new GLatLng(40.7235,-73.6334);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11535 40.7235 -73.6334
var zip = "11535";
var point = new GLatLng(40.7235,-73.6334);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11536 40.6743 -73.7042
var zip = "11536";
var point = new GLatLng(40.6743,-73.7042);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11542 40.864958 -73.62772
var zip = "11542";
var point = new GLatLng(40.864958,-73.62772);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11545 40.828098 -73.60763
var zip = "11545";
var point = new GLatLng(40.828098,-73.60763);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11547 40.830556 -73.639167
var zip = "11547";
var point = new GLatLng(40.830556,-73.639167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11548 40.812503 -73.626124
var zip = "11548";
var point = new GLatLng(40.812503,-73.626124);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11549 40.713889 -73.600278
var zip = "11549";
var point = new GLatLng(40.713889,-73.600278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11550 40.70492 -73.617641
var zip = "11550";
var point = new GLatLng(40.70492,-73.617641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11551 40.706111 -73.619167
var zip = "11551";
var point = new GLatLng(40.706111,-73.619167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11552 40.692915 -73.653859
var zip = "11552";
var point = new GLatLng(40.692915,-73.653859);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11553 40.702029 -73.591995
var zip = "11553";
var point = new GLatLng(40.702029,-73.591995);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11554 40.714915 -73.556088
var zip = "11554";
var point = new GLatLng(40.714915,-73.556088);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11555 40.7193 -73.5833
var zip = "11555";
var point = new GLatLng(40.7193,-73.5833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11556 40.6967 -73.5774
var zip = "11556";
var point = new GLatLng(40.6967,-73.5774);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11557 40.640392 -73.695667
var zip = "11557";
var point = new GLatLng(40.640392,-73.695667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11558 40.604044 -73.655411
var zip = "11558";
var point = new GLatLng(40.604044,-73.655411);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11559 40.61396 -73.732969
var zip = "11559";
var point = new GLatLng(40.61396,-73.732969);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11560 40.881728 -73.59271
var zip = "11560";
var point = new GLatLng(40.881728,-73.59271);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11561 40.587697 -73.659467
var zip = "11561";
var point = new GLatLng(40.587697,-73.659467);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11563 40.657107 -73.674143
var zip = "11563";
var point = new GLatLng(40.657107,-73.674143);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11565 40.674982 -73.673073
var zip = "11565";
var point = new GLatLng(40.674982,-73.673073);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11566 40.668312 -73.555001
var zip = "11566";
var point = new GLatLng(40.668312,-73.555001);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11568 40.78821 -73.587515
var zip = "11568";
var point = new GLatLng(40.78821,-73.587515);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11569 40.592222 -73.581111
var zip = "11569";
var point = new GLatLng(40.592222,-73.581111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11570 40.663745 -73.638
var zip = "11570";
var point = new GLatLng(40.663745,-73.638);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11571 40.6559 -73.6467
var zip = "11571";
var point = new GLatLng(40.6559,-73.6467);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11572 40.636199 -73.637533
var zip = "11572";
var point = new GLatLng(40.636199,-73.637533);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11575 40.680171 -73.586697
var zip = "11575";
var point = new GLatLng(40.680171,-73.586697);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11576 40.790668 -73.653362
var zip = "11576";
var point = new GLatLng(40.790668,-73.653362);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11577 40.784497 -73.640292
var zip = "11577";
var point = new GLatLng(40.784497,-73.640292);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11579 40.845984 -73.643598
var zip = "11579";
var point = new GLatLng(40.845984,-73.643598);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11580 40.674184 -73.705738
var zip = "11580";
var point = new GLatLng(40.674184,-73.705738);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11581 40.651838 -73.710705
var zip = "11581";
var point = new GLatLng(40.651838,-73.710705);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11582 40.664167 -73.708889
var zip = "11582";
var point = new GLatLng(40.664167,-73.708889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11590 40.755749 -73.57226
var zip = "11590";
var point = new GLatLng(40.755749,-73.57226);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11592 40.7566 -73.5729
var zip = "11592";
var point = new GLatLng(40.7566,-73.5729);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11594 40.7555 -73.588
var zip = "11594";
var point = new GLatLng(40.7555,-73.588);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11595 40.7556 -73.5863
var zip = "11595";
var point = new GLatLng(40.7556,-73.5863);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11596 40.759198 -73.644892
var zip = "11596";
var point = new GLatLng(40.759198,-73.644892);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11597 40.7555 -73.588
var zip = "11597";
var point = new GLatLng(40.7555,-73.588);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11598 40.63262 -73.714146
var zip = "11598";
var point = new GLatLng(40.63262,-73.714146);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11599 40.7266 -73.6347
var zip = "11599";
var point = new GLatLng(40.7266,-73.6347);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11690 40.599444 -73.764167
var zip = "11690";
var point = new GLatLng(40.599444,-73.764167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11691 40.600645 -73.757971
var zip = "11691";
var point = new GLatLng(40.600645,-73.757971);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11692 40.59257 -73.797446
var zip = "11692";
var point = new GLatLng(40.59257,-73.797446);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11693 40.607644 -73.819804
var zip = "11693";
var point = new GLatLng(40.607644,-73.819804);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11694 40.579471 -73.839192
var zip = "11694";
var point = new GLatLng(40.579471,-73.839192);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11695 40.562222 -73.891389
var zip = "11695";
var point = new GLatLng(40.562222,-73.891389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11697 40.560032 -73.914873
var zip = "11697";
var point = new GLatLng(40.560032,-73.914873);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11701 40.684197 -73.417106
var zip = "11701";
var point = new GLatLng(40.684197,-73.417106);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11702 40.634183 -73.324583
var zip = "11702";
var point = new GLatLng(40.634183,-73.324583);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11703 40.732102 -73.323581
var zip = "11703";
var point = new GLatLng(40.732102,-73.323581);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11704 40.713476 -73.354591
var zip = "11704";
var point = new GLatLng(40.713476,-73.354591);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11705 40.744408 -73.054207
var zip = "11705";
var point = new GLatLng(40.744408,-73.054207);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11706 40.733744 -73.252708
var zip = "11706";
var point = new GLatLng(40.733744,-73.252708);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11707 40.695556 -73.326111
var zip = "11707";
var point = new GLatLng(40.695556,-73.326111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11708 40.678889 -73.4175
var zip = "11708";
var point = new GLatLng(40.678889,-73.4175);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11709 40.907382 -73.560141
var zip = "11709";
var point = new GLatLng(40.907382,-73.560141);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11710 40.677028 -73.534517
var zip = "11710";
var point = new GLatLng(40.677028,-73.534517);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11713 40.77327 -72.946891
var zip = "11713";
var point = new GLatLng(40.77327,-72.946891);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11714 40.740014 -73.485727
var zip = "11714";
var point = new GLatLng(40.740014,-73.485727);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11715 40.750089 -73.035213
var zip = "11715";
var point = new GLatLng(40.750089,-73.035213);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11716 40.767788 -73.116339
var zip = "11716";
var point = new GLatLng(40.767788,-73.116339);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11717 40.777918 -73.248189
var zip = "11717";
var point = new GLatLng(40.777918,-73.248189);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11718 40.727957 -73.264639
var zip = "11718";
var point = new GLatLng(40.727957,-73.264639);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11719 40.78428 -72.892125
var zip = "11719";
var point = new GLatLng(40.78428,-72.892125);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11720 40.870508 -73.082163
var zip = "11720";
var point = new GLatLng(40.870508,-73.082163);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11721 40.892899 -73.3754
var zip = "11721";
var point = new GLatLng(40.892899,-73.3754);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11722 40.786618 -73.196145
var zip = "11722";
var point = new GLatLng(40.786618,-73.196145);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11724 40.863056 -73.450032
var zip = "11724";
var point = new GLatLng(40.863056,-73.450032);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11725 40.843032 -73.279924
var zip = "11725";
var point = new GLatLng(40.843032,-73.279924);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11726 40.677833 -73.396271
var zip = "11726";
var point = new GLatLng(40.677833,-73.396271);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11727 40.884988 -73.006881
var zip = "11727";
var point = new GLatLng(40.884988,-73.006881);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11729 40.759083 -73.32572
var zip = "11729";
var point = new GLatLng(40.759083,-73.32572);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11730 40.72816 -73.180471
var zip = "11730";
var point = new GLatLng(40.72816,-73.180471);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11731 40.867066 -73.319506
var zip = "11731";
var point = new GLatLng(40.867066,-73.319506);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11732 40.847162 -73.534876
var zip = "11732";
var point = new GLatLng(40.847162,-73.534876);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11733 40.930004 -73.101467
var zip = "11733";
var point = new GLatLng(40.930004,-73.101467);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11735 40.725061 -73.445055
var zip = "11735";
var point = new GLatLng(40.725061,-73.445055);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11736 40.7325 -73.4458
var zip = "11736";
var point = new GLatLng(40.7325,-73.4458);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11737 40.7301 -73.446
var zip = "11737";
var point = new GLatLng(40.7301,-73.446);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11738 40.836602 -73.04125
var zip = "11738";
var point = new GLatLng(40.836602,-73.04125);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11739 40.721111 -73.158056
var zip = "11739";
var point = new GLatLng(40.721111,-73.158056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11740 40.862121 -73.364641
var zip = "11740";
var point = new GLatLng(40.862121,-73.364641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11741 40.796426 -73.071789
var zip = "11741";
var point = new GLatLng(40.796426,-73.071789);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11742 40.810478 -73.04161
var zip = "11742";
var point = new GLatLng(40.810478,-73.04161);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11743 40.866945 -73.410924
var zip = "11743";
var point = new GLatLng(40.866945,-73.410924);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11746 40.821754 -73.375472
var zip = "11746";
var point = new GLatLng(40.821754,-73.375472);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11747 40.794606 -73.402963
var zip = "11747";
var point = new GLatLng(40.794606,-73.402963);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11749 40.790556 -73.202222
var zip = "11749";
var point = new GLatLng(40.790556,-73.202222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11750 40.8348 -73.3782
var zip = "11750";
var point = new GLatLng(40.8348,-73.3782);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11751 40.734821 -73.22211
var zip = "11751";
var point = new GLatLng(40.734821,-73.22211);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11752 40.75482 -73.182746
var zip = "11752";
var point = new GLatLng(40.75482,-73.182746);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11753 40.788118 -73.533067
var zip = "11753";
var point = new GLatLng(40.788118,-73.533067);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11754 40.886121 -73.243763
var zip = "11754";
var point = new GLatLng(40.886121,-73.243763);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11755 40.856681 -73.116751
var zip = "11755";
var point = new GLatLng(40.856681,-73.116751);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11756 40.725428 -73.516578
var zip = "11756";
var point = new GLatLng(40.725428,-73.516578);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11757 40.688373 -73.374493
var zip = "11757";
var point = new GLatLng(40.688373,-73.374493);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11758 40.685738 -73.469727
var zip = "11758";
var point = new GLatLng(40.685738,-73.469727);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11760 40.804167 -73.169444
var zip = "11760";
var point = new GLatLng(40.804167,-73.169444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11762 40.680673 -73.444447
var zip = "11762";
var point = new GLatLng(40.680673,-73.444447);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11763 40.817416 -72.985214
var zip = "11763";
var point = new GLatLng(40.817416,-72.985214);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11764 40.943572 -72.991349
var zip = "11764";
var point = new GLatLng(40.943572,-72.991349);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11765 40.88574 -73.552602
var zip = "11765";
var point = new GLatLng(40.88574,-73.552602);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11766 40.927092 -73.012732
var zip = "11766";
var point = new GLatLng(40.927092,-73.012732);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11767 40.846206 -73.1482
var zip = "11767";
var point = new GLatLng(40.846206,-73.1482);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11768 40.905062 -73.330889
var zip = "11768";
var point = new GLatLng(40.905062,-73.330889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11769 40.738224 -73.12969
var zip = "11769";
var point = new GLatLng(40.738224,-73.12969);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11770 40.646667 -73.1575
var zip = "11770";
var point = new GLatLng(40.646667,-73.1575);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11771 40.866012 -73.527212
var zip = "11771";
var point = new GLatLng(40.866012,-73.527212);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11772 40.773501 -72.998108
var zip = "11772";
var point = new GLatLng(40.773501,-72.998108);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11773 40.826111 -73.5025
var zip = "11773";
var point = new GLatLng(40.826111,-73.5025);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11774 40.7325 -73.4458
var zip = "11774";
var point = new GLatLng(40.7325,-73.4458);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11775 40.7912 -73.4164
var zip = "11775";
var point = new GLatLng(40.7912,-73.4164);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11776 40.911722 -73.052136
var zip = "11776";
var point = new GLatLng(40.911722,-73.052136);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11777 40.945687 -73.061093
var zip = "11777";
var point = new GLatLng(40.945687,-73.061093);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11778 40.949206 -72.935681
var zip = "11778";
var point = new GLatLng(40.949206,-72.935681);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11779 40.820763 -73.1208
var zip = "11779";
var point = new GLatLng(40.820763,-73.1208);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11780 40.881299 -73.159121
var zip = "11780";
var point = new GLatLng(40.881299,-73.159121);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11782 40.74606 -73.082297
var zip = "11782";
var point = new GLatLng(40.74606,-73.082297);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11783 40.679513 -73.491015
var zip = "11783";
var point = new GLatLng(40.679513,-73.491015);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11784 40.869883 -73.044848
var zip = "11784";
var point = new GLatLng(40.869883,-73.044848);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11786 40.948493 -72.892685
var zip = "11786";
var point = new GLatLng(40.948493,-72.892685);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11787 40.854186 -73.213816
var zip = "11787";
var point = new GLatLng(40.854186,-73.213816);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11788 40.823069 -73.195762
var zip = "11788";
var point = new GLatLng(40.823069,-73.195762);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11789 40.956707 -72.974172
var zip = "11789";
var point = new GLatLng(40.956707,-72.974172);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11790 40.900257 -73.125085
var zip = "11790";
var point = new GLatLng(40.900257,-73.125085);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11791 40.81462 -73.502397
var zip = "11791";
var point = new GLatLng(40.81462,-73.502397);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11792 40.952049 -72.834774
var zip = "11792";
var point = new GLatLng(40.952049,-72.834774);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11793 40.684998 -73.51033
var zip = "11793";
var point = new GLatLng(40.684998,-73.51033);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11794 40.914127 -73.125456
var zip = "11794";
var point = new GLatLng(40.914127,-73.125456);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11795 40.711734 -73.30072
var zip = "11795";
var point = new GLatLng(40.711734,-73.30072);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11796 40.731971 -73.100019
var zip = "11796";
var point = new GLatLng(40.731971,-73.100019);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11797 40.815441 -73.471612
var zip = "11797";
var point = new GLatLng(40.815441,-73.471612);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11798 40.753258 -73.36596
var zip = "11798";
var point = new GLatLng(40.753258,-73.36596);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11801 40.762305 -73.52297
var zip = "11801";
var point = new GLatLng(40.762305,-73.52297);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11802 40.7674 -73.5331
var zip = "11802";
var point = new GLatLng(40.7674,-73.5331);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11803 40.778099 -73.481638
var zip = "11803";
var point = new GLatLng(40.778099,-73.481638);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11804 40.764991 -73.457481
var zip = "11804";
var point = new GLatLng(40.764991,-73.457481);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11815 40.7683 -73.5255
var zip = "11815";
var point = new GLatLng(40.7683,-73.5255);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11819 40.7674 -73.5331
var zip = "11819";
var point = new GLatLng(40.7674,-73.5331);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11853 40.791944 -73.540278
var zip = "11853";
var point = new GLatLng(40.791944,-73.540278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11854 40.7683 -73.5255
var zip = "11854";
var point = new GLatLng(40.7683,-73.5255);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11855 40.7683 -73.5255
var zip = "11855";
var point = new GLatLng(40.7683,-73.5255);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11901 40.926202 -72.651966
var zip = "11901";
var point = new GLatLng(40.926202,-72.651966);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11930 40.973611 -72.144167
var zip = "11930";
var point = new GLatLng(40.973611,-72.144167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11931 40.944444 -72.6275
var zip = "11931";
var point = new GLatLng(40.944444,-72.6275);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11932 40.936667 -72.302778
var zip = "11932";
var point = new GLatLng(40.936667,-72.302778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11933 40.929662 -72.74229
var zip = "11933";
var point = new GLatLng(40.929662,-72.74229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11934 40.799657 -72.797048
var zip = "11934";
var point = new GLatLng(40.799657,-72.797048);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11935 41.013918 -72.480255
var zip = "11935";
var point = new GLatLng(41.013918,-72.480255);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11937 40.992964 -72.178958
var zip = "11937";
var point = new GLatLng(40.992964,-72.178958);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11939 41.126425 -72.34186
var zip = "11939";
var point = new GLatLng(41.126425,-72.34186);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//11940 40.808975 -72.753778
var zip = "11940";
var point = new GLatLng(40.808975,-72.753778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11941 40.809947 -72.705388
var zip = "11941";
var point = new GLatLng(40.809947,-72.705388);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11942 40.84277 -72.581297
var zip = "11942";
var point = new GLatLng(40.84277,-72.581297);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11944 41.103905 -72.367415
var zip = "11944";
var point = new GLatLng(41.103905,-72.367415);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11946 40.872596 -72.520209
var zip = "11946";
var point = new GLatLng(40.872596,-72.520209);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11947 40.949444 -72.581944
var zip = "11947";
var point = new GLatLng(40.949444,-72.581944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11948 40.9674 -72.55404
var zip = "11948";
var point = new GLatLng(40.9674,-72.55404);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11949 40.842102 -72.800208
var zip = "11949";
var point = new GLatLng(40.842102,-72.800208);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11950 40.80644 -72.856608
var zip = "11950";
var point = new GLatLng(40.80644,-72.856608);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11951 40.765653 -72.853701
var zip = "11951";
var point = new GLatLng(40.765653,-72.853701);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11952 40.994336 -72.536296
var zip = "11952";
var point = new GLatLng(40.994336,-72.536296);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11953 40.878212 -72.952539
var zip = "11953";
var point = new GLatLng(40.878212,-72.952539);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11954 41.045853 -71.943963
var zip = "11954";
var point = new GLatLng(41.045853,-71.943963);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11955 40.809502 -72.822918
var zip = "11955";
var point = new GLatLng(40.809502,-72.822918);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11956 40.991389 -72.476389
var zip = "11956";
var point = new GLatLng(40.991389,-72.476389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11957 41.143741 -72.287894
var zip = "11957";
var point = new GLatLng(41.143741,-72.287894);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11958 41.047778 -72.463611
var zip = "11958";
var point = new GLatLng(41.047778,-72.463611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11959 40.823056 -72.61
var zip = "11959";
var point = new GLatLng(40.823056,-72.61);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11960 40.8075 -72.709167
var zip = "11960";
var point = new GLatLng(40.8075,-72.709167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11961 40.901846 -72.888135
var zip = "11961";
var point = new GLatLng(40.901846,-72.888135);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11962 40.925278 -72.278611
var zip = "11962";
var point = new GLatLng(40.925278,-72.278611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11963 40.981996 -72.30674
var zip = "11963";
var point = new GLatLng(40.981996,-72.30674);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11964 41.064046 -72.336616
var zip = "11964";
var point = new GLatLng(41.064046,-72.336616);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11965 41.074205 -72.348082
var zip = "11965";
var point = new GLatLng(41.074205,-72.348082);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11967 40.743932 -72.876043
var zip = "11967";
var point = new GLatLng(40.743932,-72.876043);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11968 40.904341 -72.410271
var zip = "11968";
var point = new GLatLng(40.904341,-72.410271);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11969 40.884167 -72.39
var zip = "11969";
var point = new GLatLng(40.884167,-72.39);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11970 40.936389 -72.577778
var zip = "11970";
var point = new GLatLng(40.936389,-72.577778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//11971 41.05555 -72.429039
var zip = "11971";
var point = new GLatLng(41.05555,-72.429039);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//11972 40.819444 -72.705833
var zip = "11972";
var point = new GLatLng(40.819444,-72.705833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11973 40.869444 -72.887222
var zip = "11973";
var point = new GLatLng(40.869444,-72.887222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11975 40.936667 -72.243333
var zip = "11975";
var point = new GLatLng(40.936667,-72.243333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11976 40.920929 -72.349069
var zip = "11976";
var point = new GLatLng(40.920929,-72.349069);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//11977 40.818031 -72.669931
var zip = "11977";
var point = new GLatLng(40.818031,-72.669931);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//11978 40.822783 -72.644757
var zip = "11978";
var point = new GLatLng(40.822783,-72.644757);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//11980 40.837037 -72.917435
var zip = "11980";
var point = new GLatLng(40.837037,-72.917435);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12007 42.453818 -74.034721
var zip = "12007";
var point = new GLatLng(42.453818,-74.034721);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12008 42.857329 -73.900188
var zip = "12008";
var point = new GLatLng(42.857329,-73.900188);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12009 42.70627 -74.019339
var zip = "12009";
var point = new GLatLng(42.70627,-74.019339);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12010 42.948822 -74.18393
var zip = "12010";
var point = new GLatLng(42.948822,-74.18393);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12015 42.2736 -73.815175
var zip = "12015";
var point = new GLatLng(42.2736,-73.815175);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12016 42.929444 -74.316944
var zip = "12016";
var point = new GLatLng(42.929444,-74.316944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12017 42.322272 -73.454965
var zip = "12017";
var point = new GLatLng(42.322272,-73.454965);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12018 42.636511 -73.550437
var zip = "12018";
var point = new GLatLng(42.636511,-73.550437);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12019 42.919176 -73.855171
var zip = "12019";
var point = new GLatLng(42.919176,-73.855171);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12020 43.004956 -73.84858
var zip = "12020";
var point = new GLatLng(43.004956,-73.84858);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12022 42.691893 -73.370186
var zip = "12022";
var point = new GLatLng(42.691893,-73.370186);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12023 42.610848 -74.146577
var zip = "12023";
var point = new GLatLng(42.610848,-74.146577);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12024 42.405101 -73.615874
var zip = "12024";
var point = new GLatLng(42.405101,-73.615874);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12025 43.072687 -74.168367
var zip = "12025";
var point = new GLatLng(43.072687,-74.168367);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12027 42.932902 -73.896043
var zip = "12027";
var point = new GLatLng(42.932902,-73.896043);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12028 42.960134 -73.449677
var zip = "12028";
var point = new GLatLng(42.960134,-73.449677);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12029 42.413168 -73.415889
var zip = "12029";
var point = new GLatLng(42.413168,-73.415889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12031 42.749754 -74.456284
var zip = "12031";
var point = new GLatLng(42.749754,-74.456284);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12032 43.192159 -74.516915
var zip = "12032";
var point = new GLatLng(43.192159,-74.516915);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12033 42.538243 -73.709529
var zip = "12033";
var point = new GLatLng(42.538243,-73.709529);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12035 42.73696 -74.345107
var zip = "12035";
var point = new GLatLng(42.73696,-74.345107);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12036 42.533034 -74.681863
var zip = "12036";
var point = new GLatLng(42.533034,-74.681863);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12037 42.349578 -73.587281
var zip = "12037";
var point = new GLatLng(42.349578,-73.587281);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12040 42.666111 -73.376944
var zip = "12040";
var point = new GLatLng(42.666111,-73.376944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12041 42.566974 -73.968775
var zip = "12041";
var point = new GLatLng(42.566974,-73.968775);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12042 42.370808 -73.862459
var zip = "12042";
var point = new GLatLng(42.370808,-73.862459);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12043 42.684047 -74.493866
var zip = "12043";
var point = new GLatLng(42.684047,-74.493866);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12045 42.473889 -73.792778
var zip = "12045";
var point = new GLatLng(42.473889,-73.792778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12046 42.486537 -73.920588
var zip = "12046";
var point = new GLatLng(42.486537,-73.920588);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12047 42.775362 -73.712356
var zip = "12047";
var point = new GLatLng(42.775362,-73.712356);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12050 42.318333 -73.753611
var zip = "12050";
var point = new GLatLng(42.318333,-73.753611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12051 42.350142 -73.819881
var zip = "12051";
var point = new GLatLng(42.350142,-73.819881);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12052 42.766718 -73.471869
var zip = "12052";
var point = new GLatLng(42.766718,-73.471869);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12053 42.74802 -74.18681
var zip = "12053";
var point = new GLatLng(42.74802,-74.18681);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12054 42.61579 -73.837329
var zip = "12054";
var point = new GLatLng(42.61579,-73.837329);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12055 42.437859 -74.198966
var zip = "12055";
var point = new GLatLng(42.437859,-74.198966);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12056 42.770839 -74.083911
var zip = "12056";
var point = new GLatLng(42.770839,-74.083911);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12057 42.961527 -73.351974
var zip = "12057";
var point = new GLatLng(42.961527,-73.351974);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12058 42.352689 -73.906222
var zip = "12058";
var point = new GLatLng(42.352689,-73.906222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12059 42.61913 -74.055488
var zip = "12059";
var point = new GLatLng(42.61913,-74.055488);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12060 42.433028 -73.49026
var zip = "12060";
var point = new GLatLng(42.433028,-73.49026);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12061 42.595096 -73.682644
var zip = "12061";
var point = new GLatLng(42.595096,-73.682644);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12062 42.535215 -73.498407
var zip = "12062";
var point = new GLatLng(42.535215,-73.498407);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12063 42.561944 -73.633889
var zip = "12063";
var point = new GLatLng(42.561944,-73.633889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12064 42.621423 -74.676348
var zip = "12064";
var point = new GLatLng(42.621423,-74.676348);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12065 42.849865 -73.785094
var zip = "12065";
var point = new GLatLng(42.849865,-73.785094);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12066 42.771677 -74.288246
var zip = "12066";
var point = new GLatLng(42.771677,-74.288246);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12067 42.554998 -73.923743
var zip = "12067";
var point = new GLatLng(42.554998,-73.923743);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12068 42.957078 -74.402129
var zip = "12068";
var point = new GLatLng(42.957078,-74.402129);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12069 42.942222 -74.285556
var zip = "12069";
var point = new GLatLng(42.942222,-74.285556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12070 42.976535 -74.248436
var zip = "12070";
var point = new GLatLng(42.976535,-74.248436);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12071 42.585914 -74.38759
var zip = "12071";
var point = new GLatLng(42.585914,-74.38759);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12072 42.903601 -74.359765
var zip = "12072";
var point = new GLatLng(42.903601,-74.359765);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12073 42.6625 -74.233056
var zip = "12073";
var point = new GLatLng(42.6625,-74.233056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12074 43.021693 -74.029043
var zip = "12074";
var point = new GLatLng(43.021693,-74.029043);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12075 42.303637 -73.64864
var zip = "12075";
var point = new GLatLng(42.303637,-73.64864);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12076 42.410835 -74.400275
var zip = "12076";
var point = new GLatLng(42.410835,-74.400275);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12077 42.597147 -73.795884
var zip = "12077";
var point = new GLatLng(42.597147,-73.795884);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12078 43.061603 -74.337526
var zip = "12078";
var point = new GLatLng(43.061603,-74.337526);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12082 42.768889 -73.451389
var zip = "12082";
var point = new GLatLng(42.768889,-73.451389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12083 42.411342 -74.022222
var zip = "12083";
var point = new GLatLng(42.411342,-74.022222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12084 42.697273 -73.897454
var zip = "12084";
var point = new GLatLng(42.697273,-73.897454);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12085 42.703056 -73.966389
var zip = "12085";
var point = new GLatLng(42.703056,-73.966389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12086 42.959715 -74.166764
var zip = "12086";
var point = new GLatLng(42.959715,-74.166764);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12087 42.428533 -73.868029
var zip = "12087";
var point = new GLatLng(42.428533,-73.868029);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12089 42.8625 -73.328611
var zip = "12089";
var point = new GLatLng(42.8625,-73.328611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12090 42.893712 -73.358105
var zip = "12090";
var point = new GLatLng(42.893712,-73.358105);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12092 42.704526 -74.364825
var zip = "12092";
var point = new GLatLng(42.704526,-74.364825);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12093 42.499869 -74.611744
var zip = "12093";
var point = new GLatLng(42.499869,-74.611744);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12094 42.876875 -73.498899
var zip = "12094";
var point = new GLatLng(42.876875,-73.498899);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12095 43.006923 -74.37149
var zip = "12095";
var point = new GLatLng(43.006923,-74.37149);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12106 42.376675 -73.718259
var zip = "12106";
var point = new GLatLng(42.376675,-73.718259);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12107 42.671111 -74.116111
var zip = "12107";
var point = new GLatLng(42.671111,-74.116111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12108 43.472543 -74.422563
var zip = "12108";
var point = new GLatLng(43.472543,-74.422563);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12110 42.74616 -73.762985
var zip = "12110";
var point = new GLatLng(42.74616,-73.762985);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12115 42.460201 -73.587958
var zip = "12115";
var point = new GLatLng(42.460201,-73.587958);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12116 42.537075 -74.903033
var zip = "12116";
var point = new GLatLng(42.537075,-74.903033);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12117 43.141133 -74.244397
var zip = "12117";
var point = new GLatLng(43.141133,-74.244397);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12118 42.967613 -73.673173
var zip = "12118";
var point = new GLatLng(42.967613,-73.673173);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12120 42.451504 -74.131524
var zip = "12120";
var point = new GLatLng(42.451504,-74.131524);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12121 42.841163 -73.607667
var zip = "12121";
var point = new GLatLng(42.841163,-73.607667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12122 42.563734 -74.329168
var zip = "12122";
var point = new GLatLng(42.563734,-74.329168);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12123 42.527141 -73.611753
var zip = "12123";
var point = new GLatLng(42.527141,-73.611753);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12124 42.446111 -73.788889
var zip = "12124";
var point = new GLatLng(42.446111,-73.788889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12125 42.475865 -73.377295
var zip = "12125";
var point = new GLatLng(42.475865,-73.377295);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12128 42.724444 -73.758889
var zip = "12128";
var point = new GLatLng(42.724444,-73.758889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12130 42.927575 -73.485614
var zip = "12130";
var point = new GLatLng(42.927575,-73.485614);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12131 42.489938 -74.428174
var zip = "12131";
var point = new GLatLng(42.489938,-74.428174);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12132 42.471944 -73.632222
var zip = "12132";
var point = new GLatLng(42.471944,-73.632222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12133 42.928056 -73.343333
var zip = "12133";
var point = new GLatLng(42.928056,-73.343333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12134 43.237126 -74.168361
var zip = "12134";
var point = new GLatLng(43.237126,-74.168361);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12136 42.435692 -73.55447
var zip = "12136";
var point = new GLatLng(42.435692,-73.55447);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12137 42.84995 -74.123126
var zip = "12137";
var point = new GLatLng(42.84995,-74.123126);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12138 42.736367 -73.371033
var zip = "12138";
var point = new GLatLng(42.736367,-73.371033);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12139 43.448125 -74.526282
var zip = "12139";
var point = new GLatLng(43.448125,-74.526282);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12140 42.679548 -73.588846
var zip = "12140";
var point = new GLatLng(42.679548,-73.588846);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12141 42.734722 -74.186667
var zip = "12141";
var point = new GLatLng(42.734722,-74.186667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12143 42.475371 -73.821991
var zip = "12143";
var point = new GLatLng(42.475371,-73.821991);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12144 42.635855 -73.721895
var zip = "12144";
var point = new GLatLng(42.635855,-73.721895);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12147 42.513288 -74.147431
var zip = "12147";
var point = new GLatLng(42.513288,-74.147431);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12148 42.852411 -73.8701
var zip = "12148";
var point = new GLatLng(42.852411,-73.8701);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12149 42.642445 -74.571001
var zip = "12149";
var point = new GLatLng(42.642445,-74.571001);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12150 42.87296 -74.046857
var zip = "12150";
var point = new GLatLng(42.87296,-74.046857);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12151 42.925994 -73.770127
var zip = "12151";
var point = new GLatLng(42.925994,-73.770127);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12153 42.637912 -73.498949
var zip = "12153";
var point = new GLatLng(42.637912,-73.498949);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12154 42.914356 -73.615428
var zip = "12154";
var point = new GLatLng(42.914356,-73.615428);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12155 42.59004 -74.814863
var zip = "12155";
var point = new GLatLng(42.59004,-74.814863);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12156 42.481644 -73.747996
var zip = "12156";
var point = new GLatLng(42.481644,-73.747996);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12157 42.661503 -74.30473
var zip = "12157";
var point = new GLatLng(42.661503,-74.30473);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12158 42.54861 -73.812863
var zip = "12158";
var point = new GLatLng(42.54861,-73.812863);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12159 42.648461 -73.871065
var zip = "12159";
var point = new GLatLng(42.648461,-73.871065);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12160 42.759852 -74.364174
var zip = "12160";
var point = new GLatLng(42.759852,-74.364174);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12161 42.531667 -73.847778
var zip = "12161";
var point = new GLatLng(42.531667,-73.847778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12164 43.504159 -74.36667
var zip = "12164";
var point = new GLatLng(43.504159,-74.36667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12165 42.30908 -73.500754
var zip = "12165";
var point = new GLatLng(42.30908,-73.500754);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12166 42.848446 -74.453558
var zip = "12166";
var point = new GLatLng(42.848446,-74.453558);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12167 42.417409 -74.609831
var zip = "12167";
var point = new GLatLng(42.417409,-74.609831);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12168 42.523323 -73.422447
var zip = "12168";
var point = new GLatLng(42.523323,-73.422447);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12169 42.556224 -73.374964
var zip = "12169";
var point = new GLatLng(42.556224,-73.374964);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12170 42.905652 -73.697163
var zip = "12170";
var point = new GLatLng(42.905652,-73.697163);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12172 42.286111 -73.739167
var zip = "12172";
var point = new GLatLng(42.286111,-73.739167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12173 42.359572 -73.761329
var zip = "12173";
var point = new GLatLng(42.359572,-73.761329);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12174 42.355278 -73.731389
var zip = "12174";
var point = new GLatLng(42.355278,-73.731389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12175 42.587122 -74.574952
var zip = "12175";
var point = new GLatLng(42.587122,-74.574952);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12176 42.361171 -73.951541
var zip = "12176";
var point = new GLatLng(42.361171,-73.951541);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12177 42.955278 -74.285556
var zip = "12177";
var point = new GLatLng(42.955278,-74.285556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12180 42.728748 -73.668263
var zip = "12180";
var point = new GLatLng(42.728748,-73.668263);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12181 42.728333 -73.692222
var zip = "12181";
var point = new GLatLng(42.728333,-73.692222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12182 42.782921 -73.664806
var zip = "12182";
var point = new GLatLng(42.782921,-73.664806);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12183 42.743812 -73.693707
var zip = "12183";
var point = new GLatLng(42.743812,-73.693707);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12184 42.432051 -73.668322
var zip = "12184";
var point = new GLatLng(42.432051,-73.668322);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12185 42.885458 -73.543674
var zip = "12185";
var point = new GLatLng(42.885458,-73.543674);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12186 42.643108 -73.944773
var zip = "12186";
var point = new GLatLng(42.643108,-73.944773);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12187 42.638826 -74.487046
var zip = "12187";
var point = new GLatLng(42.638826,-74.487046);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12188 42.809957 -73.699481
var zip = "12188";
var point = new GLatLng(42.809957,-73.699481);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12189 42.729843 -73.712342
var zip = "12189";
var point = new GLatLng(42.729843,-73.712342);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12190 43.401219 -74.288583
var zip = "12190";
var point = new GLatLng(43.401219,-74.288583);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12192 42.415055 -73.817033
var zip = "12192";
var point = new GLatLng(42.415055,-73.817033);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12193 42.515621 -74.039383
var zip = "12193";
var point = new GLatLng(42.515621,-74.039383);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12194 42.550615 -74.463105
var zip = "12194";
var point = new GLatLng(42.550615,-74.463105);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12195 42.486111 -73.466667
var zip = "12195";
var point = new GLatLng(42.486111,-73.466667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12196 42.637969 -73.610896
var zip = "12196";
var point = new GLatLng(42.637969,-73.610896);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12197 42.604889 -74.72992
var zip = "12197";
var point = new GLatLng(42.604889,-74.72992);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12198 42.687785 -73.63826
var zip = "12198";
var point = new GLatLng(42.687785,-73.63826);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12201 42.6525 -73.7566
var zip = "12201";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12202 42.641314 -73.764071
var zip = "12202";
var point = new GLatLng(42.641314,-73.764071);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12203 42.676757 -73.821988
var zip = "12203";
var point = new GLatLng(42.676757,-73.821988);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12204 42.684667 -73.735364
var zip = "12204";
var point = new GLatLng(42.684667,-73.735364);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12205 42.713116 -73.820174
var zip = "12205";
var point = new GLatLng(42.713116,-73.820174);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12206 42.668326 -73.774406
var zip = "12206";
var point = new GLatLng(42.668326,-73.774406);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12207 42.658133 -73.752327
var zip = "12207";
var point = new GLatLng(42.658133,-73.752327);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12208 42.655989 -73.796357
var zip = "12208";
var point = new GLatLng(42.655989,-73.796357);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12209 42.641665 -73.785385
var zip = "12209";
var point = new GLatLng(42.641665,-73.785385);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12210 42.65677 -73.76052
var zip = "12210";
var point = new GLatLng(42.65677,-73.76052);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12211 42.704693 -73.769982
var zip = "12211";
var point = new GLatLng(42.704693,-73.769982);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12212 42.6525 -73.7566
var zip = "12212";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12214 42.6525 -73.7566
var zip = "12214";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12220 42.6525 -73.7566
var zip = "12220";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12222 42.6525 -73.7566
var zip = "12222";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12223 42.6525 -73.7566
var zip = "12223";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12224 42.6525 -73.7566
var zip = "12224";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12225 42.6525 -73.7566
var zip = "12225";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12226 42.6525 -73.7566
var zip = "12226";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12227 42.6525 -73.7566
var zip = "12227";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12228 42.6525 -73.7566
var zip = "12228";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12229 42.6525 -73.7566
var zip = "12229";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12230 42.6525 -73.7566
var zip = "12230";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12231 42.6525 -73.7566
var zip = "12231";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12232 42.6525 -73.7566
var zip = "12232";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12233 42.7174 -73.8285
var zip = "12233";
var point = new GLatLng(42.7174,-73.8285);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12234 42.6525 -73.7566
var zip = "12234";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12235 42.7174 -73.8285
var zip = "12235";
var point = new GLatLng(42.7174,-73.8285);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12236 42.6525 -73.7566
var zip = "12236";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12237 42.6525 -73.7566
var zip = "12237";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12238 42.6525 -73.7566
var zip = "12238";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12239 42.6525 -73.7566
var zip = "12239";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12240 42.6525 -73.7566
var zip = "12240";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12241 42.6525 -73.7566
var zip = "12241";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12242 42.6525 -73.7566
var zip = "12242";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12243 42.6525 -73.7566
var zip = "12243";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12244 42.6525 -73.7566
var zip = "12244";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12245 42.6525 -73.7566
var zip = "12245";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12246 42.647 -73.75
var zip = "12246";
var point = new GLatLng(42.647,-73.75);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12247 42.6525 -73.7566
var zip = "12247";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12248 42.6525 -73.7566
var zip = "12248";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12249 42.6525 -73.7566
var zip = "12249";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12250 42.6525 -73.7566
var zip = "12250";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12252 42.6525 -73.7566
var zip = "12252";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12255 42.6525 -73.7566
var zip = "12255";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12256 42.6525 -73.7566
var zip = "12256";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12257 42.6525 -73.7566
var zip = "12257";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12260 42.6525 -73.7566
var zip = "12260";
var point = new GLatLng(42.6525,-73.7566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12261 42.7174 -73.8285
var zip = "12261";
var point = new GLatLng(42.7174,-73.8285);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12288 42.7174 -73.8285
var zip = "12288";
var point = new GLatLng(42.7174,-73.8285);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12301 42.8155 -73.9395
var zip = "12301";
var point = new GLatLng(42.8155,-73.9395);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12302 42.858839 -73.955051
var zip = "12302";
var point = new GLatLng(42.858839,-73.955051);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12303 42.769645 -73.938776
var zip = "12303";
var point = new GLatLng(42.769645,-73.938776);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12304 42.784083 -73.909432
var zip = "12304";
var point = new GLatLng(42.784083,-73.909432);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12305 42.816131 -73.939786
var zip = "12305";
var point = new GLatLng(42.816131,-73.939786);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12306 42.790384 -73.980876
var zip = "12306";
var point = new GLatLng(42.790384,-73.980876);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12307 42.804653 -73.936349
var zip = "12307";
var point = new GLatLng(42.804653,-73.936349);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12308 42.817928 -73.920591
var zip = "12308";
var point = new GLatLng(42.817928,-73.920591);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12309 42.796168 -73.878268
var zip = "12309";
var point = new GLatLng(42.796168,-73.878268);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12325 42.869 -73.9325
var zip = "12325";
var point = new GLatLng(42.869,-73.9325);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12345 42.8102 -73.9507
var zip = "12345";
var point = new GLatLng(42.8102,-73.9507);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12401 41.930126 -74.023575
var zip = "12401";
var point = new GLatLng(41.930126,-74.023575);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12402 41.926944 -73.997778
var zip = "12402";
var point = new GLatLng(41.926944,-73.997778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12404 41.808308 -74.235336
var zip = "12404";
var point = new GLatLng(41.808308,-74.235336);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12405 42.330367 -74.085723
var zip = "12405";
var point = new GLatLng(42.330367,-74.085723);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12406 42.082262 -74.554453
var zip = "12406";
var point = new GLatLng(42.082262,-74.554453);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12407 42.237174 -74.307925
var zip = "12407";
var point = new GLatLng(42.237174,-74.307925);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12409 42.041991 -74.171298
var zip = "12409";
var point = new GLatLng(42.041991,-74.171298);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12410 42.143884 -74.446655
var zip = "12410";
var point = new GLatLng(42.143884,-74.446655);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12411 41.856165 -74.066889
var zip = "12411";
var point = new GLatLng(41.856165,-74.066889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12412 42.004761 -74.265808
var zip = "12412";
var point = new GLatLng(42.004761,-74.265808);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12413 42.30965 -74.01154
var zip = "12413";
var point = new GLatLng(42.30965,-74.01154);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12414 42.227598 -73.898536
var zip = "12414";
var point = new GLatLng(42.227598,-73.898536);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12416 42.087965 -74.281565
var zip = "12416";
var point = new GLatLng(42.087965,-74.281565);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12417 41.91 -73.991667
var zip = "12417";
var point = new GLatLng(41.91,-73.991667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12418 42.362874 -74.163092
var zip = "12418";
var point = new GLatLng(42.362874,-74.163092);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12419 41.846706 -74.103774
var zip = "12419";
var point = new GLatLng(41.846706,-74.103774);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12420 41.673333 -74.385833
var zip = "12420";
var point = new GLatLng(41.673333,-74.385833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12421 42.252204 -74.540654
var zip = "12421";
var point = new GLatLng(42.252204,-74.540654);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12422 42.402037 -74.184926
var zip = "12422";
var point = new GLatLng(42.402037,-74.184926);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12423 42.385978 -74.11169
var zip = "12423";
var point = new GLatLng(42.385978,-74.11169);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12424 42.280567 -74.207981
var zip = "12424";
var point = new GLatLng(42.280567,-74.207981);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12427 42.164309 -74.124539
var zip = "12427";
var point = new GLatLng(42.164309,-74.124539);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12428 41.721805 -74.414125
var zip = "12428";
var point = new GLatLng(41.721805,-74.414125);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12429 41.827778 -73.965556
var zip = "12429";
var point = new GLatLng(41.827778,-73.965556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12430 42.178765 -74.531908
var zip = "12430";
var point = new GLatLng(42.178765,-74.531908);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12431 42.3815 -74.062266
var zip = "12431";
var point = new GLatLng(42.3815,-74.062266);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12432 42.043611 -73.947778
var zip = "12432";
var point = new GLatLng(42.043611,-73.947778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12433 42.005342 -74.153154
var zip = "12433";
var point = new GLatLng(42.005342,-74.153154);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12434 42.387358 -74.531173
var zip = "12434";
var point = new GLatLng(42.387358,-74.531173);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12435 41.728133 -74.520074
var zip = "12435";
var point = new GLatLng(41.728133,-74.520074);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12436 42.195833 -74.0975
var zip = "12436";
var point = new GLatLng(42.195833,-74.0975);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12438 42.208333 -74.601389
var zip = "12438";
var point = new GLatLng(42.208333,-74.601389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12439 42.259032 -74.213063
var zip = "12439";
var point = new GLatLng(42.259032,-74.213063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12440 41.816749 -74.131122
var zip = "12440";
var point = new GLatLng(41.816749,-74.131122);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12441 42.144167 -74.490278
var zip = "12441";
var point = new GLatLng(42.144167,-74.490278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12442 42.237316 -74.203753
var zip = "12442";
var point = new GLatLng(42.237316,-74.203753);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12443 41.932743 -74.06873
var zip = "12443";
var point = new GLatLng(41.932743,-74.06873);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12444 42.269383 -74.279274
var zip = "12444";
var point = new GLatLng(42.269383,-74.279274);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12446 41.793866 -74.303457
var zip = "12446";
var point = new GLatLng(41.793866,-74.303457);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12448 42.073271 -74.212338
var zip = "12448";
var point = new GLatLng(42.073271,-74.212338);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12449 41.991787 -73.992379
var zip = "12449";
var point = new GLatLng(41.991787,-73.992379);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12450 42.189149 -74.19715
var zip = "12450";
var point = new GLatLng(42.189149,-74.19715);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12451 42.304506 -73.945726
var zip = "12451";
var point = new GLatLng(42.304506,-73.945726);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12452 42.240278 -74.365833
var zip = "12452";
var point = new GLatLng(42.240278,-74.365833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12453 42.095278 -73.934444
var zip = "12453";
var point = new GLatLng(42.095278,-73.934444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12454 42.299485 -74.165522
var zip = "12454";
var point = new GLatLng(42.299485,-74.165522);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12455 42.163702 -74.648853
var zip = "12455";
var point = new GLatLng(42.163702,-74.648853);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12456 42.035704 -74.000211
var zip = "12456";
var point = new GLatLng(42.035704,-74.000211);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12457 42.043545 -74.248481
var zip = "12457";
var point = new GLatLng(42.043545,-74.248481);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12458 41.758965 -74.380354
var zip = "12458";
var point = new GLatLng(41.758965,-74.380354);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12459 42.213611 -74.6825
var zip = "12459";
var point = new GLatLng(42.213611,-74.6825);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12460 42.406902 -74.152832
var zip = "12460";
var point = new GLatLng(42.406902,-74.152832);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12461 41.895906 -74.246954
var zip = "12461";
var point = new GLatLng(41.895906,-74.246954);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12463 42.17294 -74.016674
var zip = "12463";
var point = new GLatLng(42.17294,-74.016674);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12464 42.054426 -74.339328
var zip = "12464";
var point = new GLatLng(42.054426,-74.339328);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12465 42.133974 -74.487562
var zip = "12465";
var point = new GLatLng(42.133974,-74.487562);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12466 41.913113 -73.987161
var zip = "12466";
var point = new GLatLng(41.913113,-73.987161);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12468 42.297904 -74.389502
var zip = "12468";
var point = new GLatLng(42.297904,-74.389502);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12469 42.456348 -74.24199
var zip = "12469";
var point = new GLatLng(42.456348,-74.24199);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12470 42.275497 -74.01138
var zip = "12470";
var point = new GLatLng(42.275497,-74.01138);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12471 41.8375 -74.037778
var zip = "12471";
var point = new GLatLng(41.8375,-74.037778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12472 41.840248 -74.072999
var zip = "12472";
var point = new GLatLng(41.840248,-74.072999);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12473 42.267782 -74.052279
var zip = "12473";
var point = new GLatLng(42.267782,-74.052279);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12474 42.311688 -74.540519
var zip = "12474";
var point = new GLatLng(42.311688,-74.540519);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12475 42.018056 -74.015278
var zip = "12475";
var point = new GLatLng(42.018056,-74.015278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12477 42.07376 -73.979684
var zip = "12477";
var point = new GLatLng(42.07376,-73.979684);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12480 42.108353 -74.409084
var zip = "12480";
var point = new GLatLng(42.108353,-74.409084);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12481 41.976678 -74.211943
var zip = "12481";
var point = new GLatLng(41.976678,-74.211943);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12482 42.27338 -73.963982
var zip = "12482";
var point = new GLatLng(42.27338,-73.963982);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12483 41.665556 -74.430278
var zip = "12483";
var point = new GLatLng(41.665556,-74.430278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12484 41.861562 -74.169748
var zip = "12484";
var point = new GLatLng(41.861562,-74.169748);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12485 42.203179 -74.101441
var zip = "12485";
var point = new GLatLng(42.203179,-74.101441);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12486 41.816279 -74.072219
var zip = "12486";
var point = new GLatLng(41.816279,-74.072219);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12487 41.865109 -73.994843
var zip = "12487";
var point = new GLatLng(41.865109,-73.994843);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12489 41.758889 -74.357778
var zip = "12489";
var point = new GLatLng(41.758889,-74.357778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12490 42.123056 -73.935278
var zip = "12490";
var point = new GLatLng(42.123056,-73.935278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12491 41.990816 -74.115232
var zip = "12491";
var point = new GLatLng(41.990816,-74.115232);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12492 42.204584 -74.361994
var zip = "12492";
var point = new GLatLng(42.204584,-74.361994);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12493 41.794444 -73.96
var zip = "12493";
var point = new GLatLng(41.794444,-73.96);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12494 41.955478 -74.285117
var zip = "12494";
var point = new GLatLng(41.955478,-74.285117);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12495 42.092318 -74.202537
var zip = "12495";
var point = new GLatLng(42.092318,-74.202537);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12496 42.317465 -74.262017
var zip = "12496";
var point = new GLatLng(42.317465,-74.262017);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12498 42.034793 -74.111974
var zip = "12498";
var point = new GLatLng(42.034793,-74.111974);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12501 41.844695 -73.554158
var zip = "12501";
var point = new GLatLng(41.844695,-73.554158);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12502 42.085093 -73.642368
var zip = "12502";
var point = new GLatLng(42.085093,-73.642368);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12503 42.038103 -73.58187
var zip = "12503";
var point = new GLatLng(42.038103,-73.58187);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12504 41.995278 -73.831111
var zip = "12504";
var point = new GLatLng(41.995278,-73.831111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12506 41.875556 -73.691667
var zip = "12506";
var point = new GLatLng(41.875556,-73.691667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12507 42.0006 -73.921484
var zip = "12507";
var point = new GLatLng(42.0006,-73.921484);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12508 41.509681 -73.963384
var zip = "12508";
var point = new GLatLng(41.509681,-73.963384);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12510 41.671111 -73.763611
var zip = "12510";
var point = new GLatLng(41.671111,-73.763611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12511 41.546111 -73.96
var zip = "12511";
var point = new GLatLng(41.546111,-73.96);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12512 41.553611 -73.967222
var zip = "12512";
var point = new GLatLng(41.553611,-73.967222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12513 42.2183 -73.722844
var zip = "12513";
var point = new GLatLng(42.2183,-73.722844);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12514 41.869262 -73.765867
var zip = "12514";
var point = new GLatLng(41.869262,-73.765867);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12515 41.674939 -74.055713
var zip = "12515";
var point = new GLatLng(41.674939,-74.055713);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12516 42.111329 -73.552588
var zip = "12516";
var point = new GLatLng(42.111329,-73.552588);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12517 42.136737 -73.510773
var zip = "12517";
var point = new GLatLng(42.136737,-73.510773);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12518 41.430944 -74.053877
var zip = "12518";
var point = new GLatLng(41.430944,-74.053877);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12520 41.443031 -74.016411
var zip = "12520";
var point = new GLatLng(41.443031,-74.016411);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12521 42.175961 -73.657128
var zip = "12521";
var point = new GLatLng(42.175961,-73.657128);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12522 41.735054 -73.587024
var zip = "12522";
var point = new GLatLng(41.735054,-73.587024);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12523 42.090173 -73.781814
var zip = "12523";
var point = new GLatLng(42.090173,-73.781814);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12524 41.540352 -73.89791
var zip = "12524";
var point = new GLatLng(41.540352,-73.89791);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12525 41.657615 -74.167155
var zip = "12525";
var point = new GLatLng(41.657615,-74.167155);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12526 42.1219 -73.862451
var zip = "12526";
var point = new GLatLng(42.1219,-73.862451);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12527 41.521667 -73.926944
var zip = "12527";
var point = new GLatLng(41.521667,-73.926944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12528 41.716691 -73.992825
var zip = "12528";
var point = new GLatLng(41.716691,-73.992825);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12529 42.186816 -73.548306
var zip = "12529";
var point = new GLatLng(42.186816,-73.548306);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12530 42.205278 -73.691667
var zip = "12530";
var point = new GLatLng(42.205278,-73.691667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12531 41.532461 -73.662751
var zip = "12531";
var point = new GLatLng(41.532461,-73.662751);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12533 41.576639 -73.797581
var zip = "12533";
var point = new GLatLng(41.576639,-73.797581);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12534 42.246978 -73.755248
var zip = "12534";
var point = new GLatLng(42.246978,-73.755248);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12537 41.580833 -73.9275
var zip = "12537";
var point = new GLatLng(41.580833,-73.9275);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12538 41.788724 -73.906347
var zip = "12538";
var point = new GLatLng(41.788724,-73.906347);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12540 41.661471 -73.744955
var zip = "12540";
var point = new GLatLng(41.661471,-73.744955);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12541 42.141944 -73.778333
var zip = "12541";
var point = new GLatLng(42.141944,-73.778333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12542 41.605612 -73.988017
var zip = "12542";
var point = new GLatLng(41.605612,-73.988017);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12543 41.48865 -74.216312
var zip = "12543";
var point = new GLatLng(41.48865,-74.216312);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12544 42.253056 -73.668056
var zip = "12544";
var point = new GLatLng(42.253056,-73.668056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12545 41.780334 -73.688491
var zip = "12545";
var point = new GLatLng(41.780334,-73.688491);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12546 41.953623 -73.528709
var zip = "12546";
var point = new GLatLng(41.953623,-73.528709);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12547 41.653487 -73.977194
var zip = "12547";
var point = new GLatLng(41.653487,-73.977194);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12548 41.650347 -74.103578
var zip = "12548";
var point = new GLatLng(41.650347,-74.103578);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12549 41.53332 -74.253417
var zip = "12549";
var point = new GLatLng(41.53332,-74.253417);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12550 41.517833 -74.03598
var zip = "12550";
var point = new GLatLng(41.517833,-74.03598);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12551 41.503 -74.011
var zip = "12551";
var point = new GLatLng(41.503,-74.011);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12552 41.503 -74.011
var zip = "12552";
var point = new GLatLng(41.503,-74.011);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12553 41.472374 -74.056596
var zip = "12553";
var point = new GLatLng(41.472374,-74.056596);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12555 41.5375 -74.047222
var zip = "12555";
var point = new GLatLng(41.5375,-74.047222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12561 41.743346 -74.083875
var zip = "12561";
var point = new GLatLng(41.743346,-74.083875);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12563 41.488761 -73.58149
var zip = "12563";
var point = new GLatLng(41.488761,-73.58149);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12564 41.574893 -73.594847
var zip = "12564";
var point = new GLatLng(41.574893,-73.594847);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12565 42.248333 -73.653611
var zip = "12565";
var point = new GLatLng(42.248333,-73.653611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12566 41.617758 -74.326311
var zip = "12566";
var point = new GLatLng(41.617758,-74.326311);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12567 41.989569 -73.660227
var zip = "12567";
var point = new GLatLng(41.989569,-73.660227);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12568 41.6175 -74.076389
var zip = "12568";
var point = new GLatLng(41.6175,-74.076389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12569 41.747032 -73.814276
var zip = "12569";
var point = new GLatLng(41.747032,-73.814276);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12570 41.61936 -73.678328
var zip = "12570";
var point = new GLatLng(41.61936,-73.678328);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12571 42.006439 -73.854577
var zip = "12571";
var point = new GLatLng(42.006439,-73.854577);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12572 41.927206 -73.888754
var zip = "12572";
var point = new GLatLng(41.927206,-73.888754);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12574 41.919444 -73.951667
var zip = "12574";
var point = new GLatLng(41.919444,-73.951667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12575 41.457523 -74.16588
var zip = "12575";
var point = new GLatLng(41.457523,-74.16588);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12577 41.449714 -74.121378
var zip = "12577";
var point = new GLatLng(41.449714,-74.121378);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12578 41.805041 -73.801329
var zip = "12578";
var point = new GLatLng(41.805041,-73.801329);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12580 41.850193 -73.898838
var zip = "12580";
var point = new GLatLng(41.850193,-73.898838);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12581 41.887726 -73.694467
var zip = "12581";
var point = new GLatLng(41.887726,-73.694467);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12582 41.551193 -73.725548
var zip = "12582";
var point = new GLatLng(41.551193,-73.725548);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12583 42.057945 -73.902514
var zip = "12583";
var point = new GLatLng(42.057945,-73.902514);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12584 41.454167 -74.058056
var zip = "12584";
var point = new GLatLng(41.454167,-74.058056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12585 41.722664 -73.71841
var zip = "12585";
var point = new GLatLng(41.722664,-73.71841);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12586 41.559631 -74.176395
var zip = "12586";
var point = new GLatLng(41.559631,-74.176395);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12588 41.628889 -74.371667
var zip = "12588";
var point = new GLatLng(41.628889,-74.371667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12589 41.615952 -74.143853
var zip = "12589";
var point = new GLatLng(41.615952,-74.143853);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12590 41.592199 -73.890588
var zip = "12590";
var point = new GLatLng(41.592199,-73.890588);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12592 41.775884 -73.554382
var zip = "12592";
var point = new GLatLng(41.775884,-73.554382);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12593 42.095833 -73.582778
var zip = "12593";
var point = new GLatLng(42.095833,-73.582778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12594 41.653824 -73.555621
var zip = "12594";
var point = new GLatLng(41.653824,-73.555621);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12601 41.702082 -73.9218
var zip = "12601";
var point = new GLatLng(41.702082,-73.9218);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12602 41.707 -73.9287
var zip = "12602";
var point = new GLatLng(41.707,-73.9287);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12603 41.676775 -73.885217
var zip = "12603";
var point = new GLatLng(41.676775,-73.885217);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12604 41.6858 -73.8978
var zip = "12604";
var point = new GLatLng(41.6858,-73.8978);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12701 41.65158 -74.700748
var zip = "12701";
var point = new GLatLng(41.65158,-74.700748);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12719 41.491162 -74.915234
var zip = "12719";
var point = new GLatLng(41.491162,-74.915234);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12720 41.669326 -74.893984
var zip = "12720";
var point = new GLatLng(41.669326,-74.893984);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12721 41.564427 -74.430351
var zip = "12721";
var point = new GLatLng(41.564427,-74.430351);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12722 41.59 -74.3825
var zip = "12722";
var point = new GLatLng(41.59,-74.3825);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12723 41.7754 -75.025688
var zip = "12723";
var point = new GLatLng(41.7754,-75.025688);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12724 41.836667 -74.946944
var zip = "12724";
var point = new GLatLng(41.836667,-74.946944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12725 41.965666 -74.529287
var zip = "12725";
var point = new GLatLng(41.965666,-74.529287);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12726 41.698208 -74.980687
var zip = "12726";
var point = new GLatLng(41.698208,-74.980687);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12727 41.645776 -74.977116
var zip = "12727";
var point = new GLatLng(41.645776,-74.977116);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12729 41.477601 -74.597564
var zip = "12729";
var point = new GLatLng(41.477601,-74.597564);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12732 41.532793 -74.896769
var zip = "12732";
var point = new GLatLng(41.532793,-74.896769);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12733 41.7273 -74.615409
var zip = "12733";
var point = new GLatLng(41.7273,-74.615409);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12734 41.730029 -74.754873
var zip = "12734";
var point = new GLatLng(41.730029,-74.754873);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12736 41.847134 -75.029635
var zip = "12736";
var point = new GLatLng(41.847134,-75.029635);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12737 41.48576 -74.799493
var zip = "12737";
var point = new GLatLng(41.48576,-74.799493);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12738 41.654536 -74.583289
var zip = "12738";
var point = new GLatLng(41.654536,-74.583289);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12740 41.880659 -74.512697
var zip = "12740";
var point = new GLatLng(41.880659,-74.512697);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12741 41.831288 -75.099809
var zip = "12741";
var point = new GLatLng(41.831288,-75.099809);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12742 41.714055 -74.7218
var zip = "12742";
var point = new GLatLng(41.714055,-74.7218);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12743 41.530925 -74.851615
var zip = "12743";
var point = new GLatLng(41.530925,-74.851615);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12745 41.78568 -75.026329
var zip = "12745";
var point = new GLatLng(41.78568,-75.026329);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12746 41.437162 -74.64261
var zip = "12746";
var point = new GLatLng(41.437162,-74.64261);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12747 41.760882 -74.65344
var zip = "12747";
var point = new GLatLng(41.760882,-74.65344);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12748 41.778394 -74.919574
var zip = "12748";
var point = new GLatLng(41.778394,-74.919574);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12749 41.690833 -74.829167
var zip = "12749";
var point = new GLatLng(41.690833,-74.829167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12750 41.777802 -74.935384
var zip = "12750";
var point = new GLatLng(41.777802,-74.935384);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12751 41.683825 -74.672402
var zip = "12751";
var point = new GLatLng(41.683825,-74.672402);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12752 41.678158 -74.994933
var zip = "12752";
var point = new GLatLng(41.678158,-74.994933);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12754 41.79618 -74.748397
var zip = "12754";
var point = new GLatLng(41.79618,-74.748397);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12758 41.87779 -74.827028
var zip = "12758";
var point = new GLatLng(41.87779,-74.827028);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12759 41.778899 -74.661406
var zip = "12759";
var point = new GLatLng(41.778899,-74.661406);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12760 41.864359 -75.094157
var zip = "12760";
var point = new GLatLng(41.864359,-75.094157);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12762 41.681017 -74.802772
var zip = "12762";
var point = new GLatLng(41.681017,-74.802772);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12763 41.691763 -74.535762
var zip = "12763";
var point = new GLatLng(41.691763,-74.535762);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12764 41.592108 -75.010687
var zip = "12764";
var point = new GLatLng(41.592108,-75.010687);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12765 41.849205 -74.612726
var zip = "12765";
var point = new GLatLng(41.849205,-74.612726);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12766 41.814184 -74.982388
var zip = "12766";
var point = new GLatLng(41.814184,-74.982388);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12767 41.844722 -75.0075
var zip = "12767";
var point = new GLatLng(41.844722,-75.0075);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12768 41.851686 -74.735933
var zip = "12768";
var point = new GLatLng(41.851686,-74.735933);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12769 41.639167 -74.446111
var zip = "12769";
var point = new GLatLng(41.639167,-74.446111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12770 41.451068 -74.841029
var zip = "12770";
var point = new GLatLng(41.451068,-74.841029);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12771 41.378557 -74.669097
var zip = "12771";
var point = new GLatLng(41.378557,-74.669097);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12775 41.613351 -74.587223
var zip = "12775";
var point = new GLatLng(41.613351,-74.587223);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12776 41.945774 -74.923704
var zip = "12776";
var point = new GLatLng(41.945774,-74.923704);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12777 41.569093 -74.724087
var zip = "12777";
var point = new GLatLng(41.569093,-74.724087);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12778 41.665278 -74.819722
var zip = "12778";
var point = new GLatLng(41.665278,-74.819722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12779 41.704192 -74.644401
var zip = "12779";
var point = new GLatLng(41.704192,-74.644401);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12780 41.435886 -74.723647
var zip = "12780";
var point = new GLatLng(41.435886,-74.723647);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12781 41.621389 -74.451111
var zip = "12781";
var point = new GLatLng(41.621389,-74.451111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12783 41.728479 -74.834092
var zip = "12783";
var point = new GLatLng(41.728479,-74.834092);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12784 41.668056 -74.625556
var zip = "12784";
var point = new GLatLng(41.668056,-74.625556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12785 41.375 -74.693056
var zip = "12785";
var point = new GLatLng(41.375,-74.693056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12786 41.648498 -74.865437
var zip = "12786";
var point = new GLatLng(41.648498,-74.865437);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12787 41.790042 -74.828065
var zip = "12787";
var point = new GLatLng(41.790042,-74.828065);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12788 41.770807 -74.592828
var zip = "12788";
var point = new GLatLng(41.770807,-74.592828);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12789 41.716955 -74.581518
var zip = "12789";
var point = new GLatLng(41.716955,-74.581518);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12790 41.587667 -74.503891
var zip = "12790";
var point = new GLatLng(41.587667,-74.503891);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12791 41.803238 -74.888776
var zip = "12791";
var point = new GLatLng(41.803238,-74.888776);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12792 41.538378 -74.926224
var zip = "12792";
var point = new GLatLng(41.538378,-74.926224);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12801 43.312539 -73.648816
var zip = "12801";
var point = new GLatLng(43.312539,-73.648816);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12803 43.283911 -73.637947
var zip = "12803";
var point = new GLatLng(43.283911,-73.637947);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12804 43.328983 -73.681846
var zip = "12804";
var point = new GLatLng(43.328983,-73.681846);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12808 43.716479 -73.782486
var zip = "12808";
var point = new GLatLng(43.716479,-73.782486);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12809 43.238084 -73.464076
var zip = "12809";
var point = new GLatLng(43.238084,-73.464076);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12810 43.483872 -73.881695
var zip = "12810";
var point = new GLatLng(43.483872,-73.881695);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12811 43.614722 -74.025278
var zip = "12811";
var point = new GLatLng(43.614722,-74.025278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12812 43.837499 -74.429831
var zip = "12812";
var point = new GLatLng(43.837499,-74.429831);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12814 43.576641 -73.671392
var zip = "12814";
var point = new GLatLng(43.576641,-73.671392);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12815 43.698875 -73.720458
var zip = "12815";
var point = new GLatLng(43.698875,-73.720458);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12816 43.046585 -73.381375
var zip = "12816";
var point = new GLatLng(43.046585,-73.381375);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12817 43.645053 -73.806641
var zip = "12817";
var point = new GLatLng(43.645053,-73.806641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12819 43.643544 -73.432613
var zip = "12819";
var point = new GLatLng(43.643544,-73.432613);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12820 43.477222 -73.643056
var zip = "12820";
var point = new GLatLng(43.477222,-73.643056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12821 43.456706 -73.360607
var zip = "12821";
var point = new GLatLng(43.456706,-73.360607);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12822 43.242569 -73.836901
var zip = "12822";
var point = new GLatLng(43.242569,-73.836901);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12823 43.175059 -73.41237
var zip = "12823";
var point = new GLatLng(43.175059,-73.41237);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12824 43.515553 -73.700123
var zip = "12824";
var point = new GLatLng(43.515553,-73.700123);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12827 43.428457 -73.478381
var zip = "12827";
var point = new GLatLng(43.428457,-73.478381);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12828 43.265321 -73.582169
var zip = "12828";
var point = new GLatLng(43.265321,-73.582169);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12831 43.180343 -73.705267
var zip = "12831";
var point = new GLatLng(43.180343,-73.705267);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12832 43.377562 -73.297825
var zip = "12832";
var point = new GLatLng(43.377562,-73.297825);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12833 43.122488 -73.860193
var zip = "12833";
var point = new GLatLng(43.122488,-73.860193);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12834 43.096183 -73.506658
var zip = "12834";
var point = new GLatLng(43.096183,-73.506658);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12835 43.301268 -73.949905
var zip = "12835";
var point = new GLatLng(43.301268,-73.949905);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12836 43.74631 -73.528172
var zip = "12836";
var point = new GLatLng(43.74631,-73.528172);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12837 43.462135 -73.273072
var zip = "12837";
var point = new GLatLng(43.462135,-73.273072);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12838 43.349281 -73.404946
var zip = "12838";
var point = new GLatLng(43.349281,-73.404946);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12839 43.314863 -73.574607
var zip = "12839";
var point = new GLatLng(43.314863,-73.574607);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12841 43.639167 -73.5075
var zip = "12841";
var point = new GLatLng(43.639167,-73.5075);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12842 43.760594 -74.276638
var zip = "12842";
var point = new GLatLng(43.760594,-74.276638);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12843 43.634081 -74.021254
var zip = "12843";
var point = new GLatLng(43.634081,-74.021254);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12844 43.515561 -73.629883
var zip = "12844";
var point = new GLatLng(43.515561,-73.629883);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12845 43.416725 -73.697547
var zip = "12845";
var point = new GLatLng(43.416725,-73.697547);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12846 43.316487 -73.822821
var zip = "12846";
var point = new GLatLng(43.316487,-73.822821);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12847 43.947653 -74.466243
var zip = "12847";
var point = new GLatLng(43.947653,-74.466243);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12848 43.100556 -73.525278
var zip = "12848";
var point = new GLatLng(43.100556,-73.525278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12849 43.450773 -73.303077
var zip = "12849";
var point = new GLatLng(43.450773,-73.303077);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12850 43.097548 -74.016687
var zip = "12850";
var point = new GLatLng(43.097548,-74.016687);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12851 43.781058 -73.983542
var zip = "12851";
var point = new GLatLng(43.781058,-73.983542);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12852 43.945991 -74.129911
var zip = "12852";
var point = new GLatLng(43.945991,-74.129911);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12853 43.713802 -73.892802
var zip = "12853";
var point = new GLatLng(43.713802,-73.892802);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12854 43.506212 -73.330114
var zip = "12854";
var point = new GLatLng(43.506212,-73.330114);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12855 43.986872 -73.712065
var zip = "12855";
var point = new GLatLng(43.986872,-73.712065);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12856 43.738611 -74.049167
var zip = "12856";
var point = new GLatLng(43.738611,-74.049167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12857 43.779931 -73.933479
var zip = "12857";
var point = new GLatLng(43.779931,-73.933479);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12858 43.891382 -73.644956
var zip = "12858";
var point = new GLatLng(43.891382,-73.644956);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12859 43.172358 -73.883918
var zip = "12859";
var point = new GLatLng(43.172358,-73.883918);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12860 43.692956 -73.756438
var zip = "12860";
var point = new GLatLng(43.692956,-73.756438);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12861 43.755976 -73.412299
var zip = "12861";
var point = new GLatLng(43.755976,-73.412299);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12862 43.661667 -73.8975
var zip = "12862";
var point = new GLatLng(43.661667,-73.8975);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12863 43.066248 -73.921523
var zip = "12863";
var point = new GLatLng(43.066248,-73.921523);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12864 43.728333 -74.306111
var zip = "12864";
var point = new GLatLng(43.728333,-74.306111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12865 43.182785 -73.332703
var zip = "12865";
var point = new GLatLng(43.182785,-73.332703);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12866 43.080094 -73.780644
var zip = "12866";
var point = new GLatLng(43.080094,-73.780644);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12870 43.841159 -73.767382
var zip = "12870";
var point = new GLatLng(43.841159,-73.767382);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12871 43.087778 -73.60068
var zip = "12871";
var point = new GLatLng(43.087778,-73.60068);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12872 43.876903 -73.730127
var zip = "12872";
var point = new GLatLng(43.876903,-73.730127);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12873 43.110575 -73.323148
var zip = "12873";
var point = new GLatLng(43.110575,-73.323148);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12874 43.697804 -73.507062
var zip = "12874";
var point = new GLatLng(43.697804,-73.507062);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12878 43.421389 -73.949467
var zip = "12878";
var point = new GLatLng(43.421389,-73.949467);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12879 43.969444 -74.165
var zip = "12879";
var point = new GLatLng(43.969444,-74.165);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12883 43.846302 -73.442592
var zip = "12883";
var point = new GLatLng(43.846302,-73.442592);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12884 43.087778 -73.594444
var zip = "12884";
var point = new GLatLng(43.087778,-73.594444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12885 43.500253 -73.792021
var zip = "12885";
var point = new GLatLng(43.500253,-73.792021);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12886 43.64129 -73.930909
var zip = "12886";
var point = new GLatLng(43.64129,-73.930909);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12887 43.5531 -73.386412
var zip = "12887";
var point = new GLatLng(43.5531,-73.386412);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12901 44.692715 -73.465969
var zip = "12901";
var point = new GLatLng(44.692715,-73.465969);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12903 44.699444 -73.453333
var zip = "12903";
var point = new GLatLng(44.699444,-73.453333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12910 44.881584 -73.640767
var zip = "12910";
var point = new GLatLng(44.881584,-73.640767);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12911 44.521594 -73.508976
var zip = "12911";
var point = new GLatLng(44.521594,-73.508976);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12912 44.44994 -73.685672
var zip = "12912";
var point = new GLatLng(44.44994,-73.685672);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12913 44.398477 -74.08293
var zip = "12913";
var point = new GLatLng(44.398477,-74.08293);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12914 44.947861 -74.594737
var zip = "12914";
var point = new GLatLng(44.947861,-74.594737);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12915 44.857778 -74.033889
var zip = "12915";
var point = new GLatLng(44.857778,-74.033889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12916 44.828212 -74.522274
var zip = "12916";
var point = new GLatLng(44.828212,-74.522274);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12917 44.917722 -74.173116
var zip = "12917";
var point = new GLatLng(44.917722,-74.173116);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12918 44.686473 -73.670242
var zip = "12918";
var point = new GLatLng(44.686473,-73.670242);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12919 44.977292 -73.446603
var zip = "12919";
var point = new GLatLng(44.977292,-73.446603);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12920 44.908768 -74.074098
var zip = "12920";
var point = new GLatLng(44.908768,-74.074098);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12921 44.888379 -73.450076
var zip = "12921";
var point = new GLatLng(44.888379,-73.450076);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12922 44.286715 -74.675878
var zip = "12922";
var point = new GLatLng(44.286715,-74.675878);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12923 44.943232 -73.935484
var zip = "12923";
var point = new GLatLng(44.943232,-73.935484);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12924 44.504814 -73.567971
var zip = "12924";
var point = new GLatLng(44.504814,-73.567971);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12926 44.941688 -74.329713
var zip = "12926";
var point = new GLatLng(44.941688,-74.329713);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12927 44.2225 -74.836667
var zip = "12927";
var point = new GLatLng(44.2225,-74.836667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12928 43.952633 -73.466486
var zip = "12928";
var point = new GLatLng(43.952633,-73.466486);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12929 44.721389 -73.724167
var zip = "12929";
var point = new GLatLng(44.721389,-73.724167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12930 44.723328 -74.552346
var zip = "12930";
var point = new GLatLng(44.723328,-74.552346);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12932 44.224518 -73.601131
var zip = "12932";
var point = new GLatLng(44.224518,-73.601131);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12933 44.893889 -73.836944
var zip = "12933";
var point = new GLatLng(44.893889,-73.836944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12934 44.844353 -73.868546
var zip = "12934";
var point = new GLatLng(44.844353,-73.868546);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12935 44.916266 -73.787572
var zip = "12935";
var point = new GLatLng(44.916266,-73.787572);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12936 44.280695 -73.373147
var zip = "12936";
var point = new GLatLng(44.280695,-73.373147);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12937 44.973096 -74.492879
var zip = "12937";
var point = new GLatLng(44.973096,-74.492879);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12939 44.431944 -74.181389
var zip = "12939";
var point = new GLatLng(44.431944,-74.181389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12941 44.373351 -73.724702
var zip = "12941";
var point = new GLatLng(44.373351,-73.724702);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12942 44.25548 -73.791457
var zip = "12942";
var point = new GLatLng(44.25548,-73.791457);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12943 44.177978 -73.795923
var zip = "12943";
var point = new GLatLng(44.177978,-73.795923);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12944 44.499933 -73.474538
var zip = "12944";
var point = new GLatLng(44.499933,-73.474538);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12945 44.359392 -74.243336
var zip = "12945";
var point = new GLatLng(44.359392,-74.243336);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12946 44.274986 -73.986354
var zip = "12946";
var point = new GLatLng(44.274986,-73.986354);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12949 44.758988 -74.662927
var zip = "12949";
var point = new GLatLng(44.758988,-74.662927);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12950 44.307507 -73.549129
var zip = "12950";
var point = new GLatLng(44.307507,-73.549129);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12952 44.725491 -73.919452
var zip = "12952";
var point = new GLatLng(44.725491,-73.919452);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12953 44.848164 -74.292808
var zip = "12953";
var point = new GLatLng(44.848164,-74.292808);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12955 44.799364 -73.977832
var zip = "12955";
var point = new GLatLng(44.799364,-73.977832);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12956 44.087631 -73.523588
var zip = "12956";
var point = new GLatLng(44.087631,-73.523588);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12957 44.850412 -74.560273
var zip = "12957";
var point = new GLatLng(44.850412,-74.560273);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12958 44.959244 -73.583413
var zip = "12958";
var point = new GLatLng(44.959244,-73.583413);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12959 44.960232 -73.672967
var zip = "12959";
var point = new GLatLng(44.960232,-73.672967);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12960 44.043755 -73.507862
var zip = "12960";
var point = new GLatLng(44.043755,-73.507862);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12961 44.066197 -73.511071
var zip = "12961";
var point = new GLatLng(44.066197,-73.511071);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12962 44.68936 -73.577168
var zip = "12962";
var point = new GLatLng(44.68936,-73.577168);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12964 44.159532 -73.605881
var zip = "12964";
var point = new GLatLng(44.159532,-73.605881);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12965 44.708182 -74.653379
var zip = "12965";
var point = new GLatLng(44.708182,-74.653379);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12966 44.829997 -74.413369
var zip = "12966";
var point = new GLatLng(44.829997,-74.413369);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12967 44.774982 -74.665307
var zip = "12967";
var point = new GLatLng(44.774982,-74.665307);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12969 44.730791 -74.134173
var zip = "12969";
var point = new GLatLng(44.730791,-74.134173);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12970 44.444967 -74.266432
var zip = "12970";
var point = new GLatLng(44.444967,-74.266432);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12972 44.585109 -73.529322
var zip = "12972";
var point = new GLatLng(44.585109,-73.529322);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12973 44.234037 -74.573228
var zip = "12973";
var point = new GLatLng(44.234037,-74.573228);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12974 44.04645 -73.470542
var zip = "12974";
var point = new GLatLng(44.04645,-73.470542);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12975 44.528056 -73.4075
var zip = "12975";
var point = new GLatLng(44.528056,-73.4075);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12976 44.466944 -74.173333
var zip = "12976";
var point = new GLatLng(44.466944,-74.173333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12977 44.3 -74.085833
var zip = "12977";
var point = new GLatLng(44.3,-74.085833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12978 44.606926 -73.801948
var zip = "12978";
var point = new GLatLng(44.606926,-73.801948);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12979 44.988413 -73.369083
var zip = "12979";
var point = new GLatLng(44.988413,-73.369083);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12980 44.677298 -74.66032
var zip = "12980";
var point = new GLatLng(44.677298,-74.66032);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//12981 44.703168 -73.748135
var zip = "12981";
var point = new GLatLng(44.703168,-73.748135);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12983 44.324331 -74.132951
var zip = "12983";
var point = new GLatLng(44.324331,-74.132951);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12985 44.588224 -73.689481
var zip = "12985";
var point = new GLatLng(44.588224,-73.689481);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12986 44.228461 -74.463172
var zip = "12986";
var point = new GLatLng(44.228461,-74.463172);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12987 44.325586 -73.807864
var zip = "12987";
var point = new GLatLng(44.325586,-73.807864);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12989 44.460134 -74.057278
var zip = "12989";
var point = new GLatLng(44.460134,-74.057278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12992 44.796967 -73.511188
var zip = "12992";
var point = new GLatLng(44.796967,-73.511188);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//12993 44.204983 -73.470223
var zip = "12993";
var point = new GLatLng(44.204983,-73.470223);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//12995 44.809722 -74.262222
var zip = "12995";
var point = new GLatLng(44.809722,-74.262222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//12996 44.360396 -73.396292
var zip = "12996";
var point = new GLatLng(44.360396,-73.396292);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//12997 44.387976 -73.816553
var zip = "12997";
var point = new GLatLng(44.387976,-73.816553);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//12998 44.0875 -73.533333
var zip = "12998";
var point = new GLatLng(44.0875,-73.533333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13020 42.818611 -76.072778
var zip = "13020";
var point = new GLatLng(42.818611,-76.072778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//13021 42.929958 -76.562605
var zip = "13021";
var point = new GLatLng(42.929958,-76.562605);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13022 42.9297 -76.5702
var zip = "13022";
var point = new GLatLng(42.9297,-76.5702);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13024 42.9356 -76.5707
var zip = "13024";
var point = new GLatLng(42.9356,-76.5707);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13026 42.747231 -76.67749
var zip = "13026";
var point = new GLatLng(42.747231,-76.67749);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13027 43.162039 -76.323718
var zip = "13027";
var point = new GLatLng(43.162039,-76.323718);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13028 43.271722 -75.937299
var zip = "13028";
var point = new GLatLng(43.271722,-75.937299);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13029 43.225194 -76.135132
var zip = "13029";
var point = new GLatLng(43.225194,-76.135132);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13030 43.159015 -75.970009
var zip = "13030";
var point = new GLatLng(43.159015,-75.970009);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13031 43.041651 -76.280728
var zip = "13031";
var point = new GLatLng(43.041651,-76.280728);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13032 43.087764 -75.760197
var zip = "13032";
var point = new GLatLng(43.087764,-75.760197);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13033 43.179443 -76.564791
var zip = "13033";
var point = new GLatLng(43.179443,-76.564791);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//13034 42.914198 -76.702402
var zip = "13034";
var point = new GLatLng(42.914198,-76.702402);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13035 42.937955 -75.839229
var zip = "13035";
var point = new GLatLng(42.937955,-75.839229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13036 43.308986 -76.184852
var zip = "13036";
var point = new GLatLng(43.308986,-76.184852);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13037 43.05524 -75.87684
var zip = "13037";
var point = new GLatLng(43.05524,-75.87684);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13039 43.170693 -76.096185
var zip = "13039";
var point = new GLatLng(43.170693,-76.096185);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13040 42.538539 -75.903029
var zip = "13040";
var point = new GLatLng(42.538539,-75.903029);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13041 43.173734 -76.170748
var zip = "13041";
var point = new GLatLng(43.173734,-76.170748);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13042 43.243199 -75.853691
var zip = "13042";
var point = new GLatLng(43.243199,-75.853691);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13043 43.041667 -75.745
var zip = "13043";
var point = new GLatLng(43.041667,-75.745);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13044 43.272751 -76.004155
var zip = "13044";
var point = new GLatLng(43.272751,-76.004155);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13045 42.595175 -76.185675
var zip = "13045";
var point = new GLatLng(42.595175,-76.185675);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13051 42.876389 -75.913889
var zip = "13051";
var point = new GLatLng(42.876389,-75.913889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13052 42.749444 -75.858226
var zip = "13052";
var point = new GLatLng(42.749444,-75.858226);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13053 42.486118 -76.287224
var zip = "13053";
var point = new GLatLng(42.486118,-76.287224);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13054 43.157912 -75.671409
var zip = "13054";
var point = new GLatLng(43.157912,-75.671409);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13056 42.666111 -76.101944
var zip = "13056";
var point = new GLatLng(42.666111,-76.101944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13057 43.073359 -76.05578
var zip = "13057";
var point = new GLatLng(43.073359,-76.05578);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13060 43.025246 -76.435164
var zip = "13060";
var point = new GLatLng(43.025246,-76.435164);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13061 42.856166 -75.754255
var zip = "13061";
var point = new GLatLng(42.856166,-75.754255);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13062 42.485 -76.383889
var zip = "13062";
var point = new GLatLng(42.485,-76.383889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13063 42.853117 -75.983645
var zip = "13063";
var point = new GLatLng(42.853117,-75.983645);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13064 43.316389 -76.7025
var zip = "13064";
var point = new GLatLng(43.316389,-76.7025);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13065 42.814167 -76.809444
var zip = "13065";
var point = new GLatLng(42.814167,-76.809444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13066 43.026774 -76.014503
var zip = "13066";
var point = new GLatLng(43.026774,-76.014503);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13068 42.499768 -76.363622
var zip = "13068";
var point = new GLatLng(42.499768,-76.363622);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13069 43.321108 -76.40342
var zip = "13069";
var point = new GLatLng(43.321108,-76.40342);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13071 42.674624 -76.541755
var zip = "13071";
var point = new GLatLng(42.674624,-76.541755);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13072 42.763059 -75.744279
var zip = "13072";
var point = new GLatLng(42.763059,-75.744279);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13073 42.58549 -76.363286
var zip = "13073";
var point = new GLatLng(42.58549,-76.363286);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13074 43.311115 -76.546034
var zip = "13074";
var point = new GLatLng(43.311115,-76.546034);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13076 43.35268 -76.147708
var zip = "13076";
var point = new GLatLng(43.35268,-76.147708);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13077 42.672586 -76.18783
var zip = "13077";
var point = new GLatLng(42.672586,-76.18783);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13078 42.982973 -76.076571
var zip = "13078";
var point = new GLatLng(42.982973,-76.076571);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13080 43.065141 -76.45978
var zip = "13080";
var point = new GLatLng(43.065141,-76.45978);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13081 42.66351 -76.621603
var zip = "13081";
var point = new GLatLng(42.66351,-76.621603);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13082 43.098095 -75.955003
var zip = "13082";
var point = new GLatLng(43.098095,-75.955003);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13083 43.642883 -76.050335
var zip = "13083";
var point = new GLatLng(43.642883,-76.050335);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13084 42.890959 -76.106116
var zip = "13084";
var point = new GLatLng(42.890959,-76.106116);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13087 42.695833 -76.164722
var zip = "13087";
var point = new GLatLng(42.695833,-76.164722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13088 43.109925 -76.186999
var zip = "13088";
var point = new GLatLng(43.109925,-76.186999);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13089 43.106389 -76.218056
var zip = "13089";
var point = new GLatLng(43.106389,-76.218056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13090 43.148048 -76.223269
var zip = "13090";
var point = new GLatLng(43.148048,-76.223269);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13092 42.655789 -76.415436
var zip = "13092";
var point = new GLatLng(42.655789,-76.415436);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13093 43.498611 -76.386111
var zip = "13093";
var point = new GLatLng(43.498611,-76.386111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13101 42.594758 -76.081958
var zip = "13101";
var point = new GLatLng(42.594758,-76.081958);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13102 42.560556 -76.2775
var zip = "13102";
var point = new GLatLng(42.560556,-76.2775);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13103 43.33782 -76.089208
var zip = "13103";
var point = new GLatLng(43.33782,-76.089208);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13104 42.990441 -75.970345
var zip = "13104";
var point = new GLatLng(42.990441,-75.970345);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13107 43.457222 -76.145556
var zip = "13107";
var point = new GLatLng(43.457222,-76.145556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13108 42.982056 -76.33228
var zip = "13108";
var point = new GLatLng(42.982056,-76.33228);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13110 42.897441 -76.28055
var zip = "13110";
var point = new GLatLng(42.897441,-76.28055);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13111 43.26608 -76.628936
var zip = "13111";
var point = new GLatLng(43.26608,-76.628936);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13112 43.093438 -76.40301
var zip = "13112";
var point = new GLatLng(43.093438,-76.40301);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13113 43.165556 -76.537222
var zip = "13113";
var point = new GLatLng(43.165556,-76.537222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13114 43.460533 -76.244588
var zip = "13114";
var point = new GLatLng(43.460533,-76.244588);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13115 43.398056 -76.477778
var zip = "13115";
var point = new GLatLng(43.398056,-76.477778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13116 43.077212 -76.009812
var zip = "13116";
var point = new GLatLng(43.077212,-76.009812);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13117 43.01 -76.703611
var zip = "13117";
var point = new GLatLng(43.01,-76.703611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13118 42.735456 -76.39898
var zip = "13118";
var point = new GLatLng(42.735456,-76.39898);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13119 42.973611 -76.442778
var zip = "13119";
var point = new GLatLng(42.973611,-76.442778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13120 42.955855 -76.152932
var zip = "13120";
var point = new GLatLng(42.955855,-76.152932);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13121 43.479722 -76.315556
var zip = "13121";
var point = new GLatLng(43.479722,-76.315556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13122 42.844135 -75.863526
var zip = "13122";
var point = new GLatLng(42.844135,-75.863526);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13123 43.23 -75.748611
var zip = "13123";
var point = new GLatLng(43.23,-75.748611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13124 42.637243 -75.816359
var zip = "13124";
var point = new GLatLng(42.637243,-75.816359);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13126 43.443836 -76.497489
var zip = "13126";
var point = new GLatLng(43.443836,-76.497489);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13131 43.415295 -76.100023
var zip = "13131";
var point = new GLatLng(43.415295,-76.100023);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13132 43.260946 -76.239466
var zip = "13132";
var point = new GLatLng(43.260946,-76.239466);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13134 42.967222 -75.688333
var zip = "13134";
var point = new GLatLng(42.967222,-75.688333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13135 43.24679 -76.306449
var zip = "13135";
var point = new GLatLng(43.24679,-76.306449);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13136 42.596941 -75.846464
var zip = "13136";
var point = new GLatLng(42.596941,-75.846464);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13137 43.159167 -76.4475
var zip = "13137";
var point = new GLatLng(43.159167,-76.4475);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13138 42.898889 -76.016389
var zip = "13138";
var point = new GLatLng(42.898889,-76.016389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13139 42.738333 -76.618333
var zip = "13139";
var point = new GLatLng(42.738333,-76.618333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13140 43.042653 -76.644919
var zip = "13140";
var point = new GLatLng(43.042653,-76.644919);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13141 42.79501 -76.214105
var zip = "13141";
var point = new GLatLng(42.79501,-76.214105);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13142 43.55617 -76.125231
var zip = "13142";
var point = new GLatLng(43.55617,-76.125231);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13143 43.229068 -76.714556
var zip = "13143";
var point = new GLatLng(43.229068,-76.714556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13144 43.577578 -76.002918
var zip = "13144";
var point = new GLatLng(43.577578,-76.002918);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13145 43.651681 -76.126439
var zip = "13145";
var point = new GLatLng(43.651681,-76.126439);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13146 43.093439 -76.75647
var zip = "13146";
var point = new GLatLng(43.093439,-76.75647);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13147 42.778472 -76.574175
var zip = "13147";
var point = new GLatLng(42.778472,-76.574175);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13148 42.909377 -76.792538
var zip = "13148";
var point = new GLatLng(42.909377,-76.792538);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13152 42.925751 -76.405174
var zip = "13152";
var point = new GLatLng(42.925751,-76.405174);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13153 42.993056 -76.456389
var zip = "13153";
var point = new GLatLng(42.993056,-76.456389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13154 43.131389 -76.766111
var zip = "13154";
var point = new GLatLng(43.131389,-76.766111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13155 42.66256 -75.766919
var zip = "13155";
var point = new GLatLng(42.66256,-75.766919);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13156 43.329578 -76.674731
var zip = "13156";
var point = new GLatLng(43.329578,-76.674731);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13157 43.196389 -75.730833
var zip = "13157";
var point = new GLatLng(43.196389,-75.730833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13158 42.708547 -76.018946
var zip = "13158";
var point = new GLatLng(42.708547,-76.018946);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13159 42.806977 -76.13936
var zip = "13159";
var point = new GLatLng(42.806977,-76.13936);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13160 42.833546 -76.673959
var zip = "13160";
var point = new GLatLng(42.833546,-76.673959);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13162 43.190833 -75.729444
var zip = "13162";
var point = new GLatLng(43.190833,-75.729444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13163 43.075278 -75.707222
var zip = "13163";
var point = new GLatLng(43.075278,-75.707222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13164 43.09317 -76.290413
var zip = "13164";
var point = new GLatLng(43.09317,-76.290413);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13165 42.904515 -76.875498
var zip = "13165";
var point = new GLatLng(42.904515,-76.875498);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//13166 43.048882 -76.542502
var zip = "13166";
var point = new GLatLng(43.048882,-76.542502);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13167 43.288235 -76.079747
var zip = "13167";
var point = new GLatLng(43.288235,-76.079747);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13201 43.0459 -76.1528
var zip = "13201";
var point = new GLatLng(43.0459,-76.1528);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13202 43.040988 -76.148856
var zip = "13202";
var point = new GLatLng(43.040988,-76.148856);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13203 43.060703 -76.136931
var zip = "13203";
var point = new GLatLng(43.060703,-76.136931);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13204 43.044398 -76.175767
var zip = "13204";
var point = new GLatLng(43.044398,-76.175767);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13205 43.012314 -76.14518
var zip = "13205";
var point = new GLatLng(43.012314,-76.14518);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13206 43.06773 -76.110226
var zip = "13206";
var point = new GLatLng(43.06773,-76.110226);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13207 43.019482 -76.16501
var zip = "13207";
var point = new GLatLng(43.019482,-76.16501);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13208 43.073007 -76.148616
var zip = "13208";
var point = new GLatLng(43.073007,-76.148616);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//13209 43.078204 -76.238448
var zip = "13209";
var point = new GLatLng(43.078204,-76.238448);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13210 43.035414 -76.128166
var zip = "13210";
var point = new GLatLng(43.035414,-76.128166);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//13211 43.09951 -76.142181
var zip = "13211";
var point = new GLatLng(43.09951,-76.142181);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//13212 43.130623 -76.137295
var zip = "13212";
var point = new GLatLng(43.130623,-76.137295);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13214 43.042529 -76.07844
var zip = "13214";
var point = new GLatLng(43.042529,-76.07844);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13215 42.997544 -76.211851
var zip = "13215";
var point = new GLatLng(42.997544,-76.211851);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13217 43.0512 -76.122
var zip = "13217";
var point = new GLatLng(43.0512,-76.122);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13218 43.0301 -76.1259
var zip = "13218";
var point = new GLatLng(43.0301,-76.1259);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13219 43.040943 -76.226159
var zip = "13219";
var point = new GLatLng(43.040943,-76.226159);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13220 43.1232 -76.1278
var zip = "13220";
var point = new GLatLng(43.1232,-76.1278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13221 43.1232 -76.1278
var zip = "13221";
var point = new GLatLng(43.1232,-76.1278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//13224 43.042134 -76.104609
var zip = "13224";
var point = new GLatLng(43.042134,-76.104609);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13225 43.1232 -76.1278
var zip = "13225";
var point = new GLatLng(43.1232,-76.1278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13235 43.0321 -76.1271
var zip = "13235";
var point = new GLatLng(43.0321,-76.1271);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13244 43.0394 -76.1361
var zip = "13244";
var point = new GLatLng(43.0394,-76.1361);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//13250 43.0435 -76.151
var zip = "13250";
var point = new GLatLng(43.0435,-76.151);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13251 43.0435 -76.151
var zip = "13251";
var point = new GLatLng(43.0435,-76.151);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13252 43.0435 -76.151
var zip = "13252";
var point = new GLatLng(43.0435,-76.151);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13261 43.0433 -76.1508
var zip = "13261";
var point = new GLatLng(43.0433,-76.1508);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13290 43.0685 -76.1709
var zip = "13290";
var point = new GLatLng(43.0685,-76.1709);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13301 43.415659 -75.213748
var zip = "13301";
var point = new GLatLng(43.415659,-75.213748);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13302 43.497022 -75.971934
var zip = "13302";
var point = new GLatLng(43.497022,-75.971934);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13303 43.344519 -75.450919
var zip = "13303";
var point = new GLatLng(43.344519,-75.450919);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13304 43.223697 -75.161156
var zip = "13304";
var point = new GLatLng(43.223697,-75.161156);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13305 43.879722 -75.445833
var zip = "13305";
var point = new GLatLng(43.879722,-75.445833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13308 43.230293 -75.687313
var zip = "13308";
var point = new GLatLng(43.230293,-75.687313);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13309 43.478615 -75.343973
var zip = "13309";
var point = new GLatLng(43.478615,-75.343973);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13310 42.894024 -75.567841
var zip = "13310";
var point = new GLatLng(42.894024,-75.567841);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13312 43.710278 -75.4025
var zip = "13312";
var point = new GLatLng(43.710278,-75.4025);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13313 42.879167 -75.251389
var zip = "13313";
var point = new GLatLng(42.879167,-75.251389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13314 42.807538 -75.343859
var zip = "13314";
var point = new GLatLng(42.807538,-75.343859);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13315 42.75162 -75.169044
var zip = "13315";
var point = new GLatLng(42.75162,-75.169044);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13316 43.339197 -75.754258
var zip = "13316";
var point = new GLatLng(43.339197,-75.754258);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13317 42.88239 -74.583522
var zip = "13317";
var point = new GLatLng(42.88239,-74.583522);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13318 42.906931 -75.260704
var zip = "13318";
var point = new GLatLng(42.906931,-75.260704);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13319 43.022563 -75.265645
var zip = "13319";
var point = new GLatLng(43.022563,-75.265645);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13320 42.782315 -74.744439
var zip = "13320";
var point = new GLatLng(42.782315,-74.744439);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13321 43.092222 -75.38
var zip = "13321";
var point = new GLatLng(43.092222,-75.38);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13322 42.97119 -75.206126
var zip = "13322";
var point = new GLatLng(42.97119,-75.206126);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13323 43.05856 -75.38079
var zip = "13323";
var point = new GLatLng(43.05856,-75.38079);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13324 43.302391 -74.997651
var zip = "13324";
var point = new GLatLng(43.302391,-74.997651);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13325 43.562982 -75.458406
var zip = "13325";
var point = new GLatLng(43.562982,-75.458406);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13326 42.70319 -74.918148
var zip = "13326";
var point = new GLatLng(42.70319,-74.918148);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13327 43.909461 -75.354192
var zip = "13327";
var point = new GLatLng(43.909461,-75.354192);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//13328 42.981788 -75.438309
var zip = "13328";
var point = new GLatLng(42.981788,-75.438309);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13329 43.104161 -74.764305
var zip = "13329";
var point = new GLatLng(43.104161,-74.764305);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13331 43.723659 -74.965381
var zip = "13331";
var point = new GLatLng(43.723659,-74.965381);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13332 42.752218 -75.541653
var zip = "13332";
var point = new GLatLng(42.752218,-75.541653);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13333 42.832947 -74.759741
var zip = "13333";
var point = new GLatLng(42.832947,-74.759741);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13334 42.848417 -75.631359
var zip = "13334";
var point = new GLatLng(42.848417,-75.631359);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//13335 42.730281 -75.252522
var zip = "13335";
var point = new GLatLng(42.730281,-75.252522);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13337 42.725177 -74.986921
var zip = "13337";
var point = new GLatLng(42.725177,-74.986921);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13338 43.473651 -75.178742
var zip = "13338";
var point = new GLatLng(43.473651,-75.178742);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13339 42.937158 -74.643298
var zip = "13339";
var point = new GLatLng(42.937158,-74.643298);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13340 43.044041 -75.107155
var zip = "13340";
var point = new GLatLng(43.044041,-75.107155);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13341 43.036667 -75.3925
var zip = "13341";
var point = new GLatLng(43.036667,-75.3925);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13342 42.635634 -75.232701
var zip = "13342";
var point = new GLatLng(42.635634,-75.232701);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13343 43.732306 -75.366902
var zip = "13343";
var point = new GLatLng(43.732306,-75.366902);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13345 43.689184 -75.312393
var zip = "13345";
var point = new GLatLng(43.689184,-75.312393);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13346 42.82306 -75.543382
var zip = "13346";
var point = new GLatLng(42.82306,-75.543382);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13348 42.695033 -75.055009
var zip = "13348";
var point = new GLatLng(42.695033,-75.055009);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13350 43.030696 -74.98757
var zip = "13350";
var point = new GLatLng(43.030696,-74.98757);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13352 43.312222 -75.122222
var zip = "13352";
var point = new GLatLng(43.312222,-75.122222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//13353 43.391545 -74.739974
var zip = "13353";
var point = new GLatLng(43.391545,-74.739974);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13354 43.248406 -75.253506
var zip = "13354";
var point = new GLatLng(43.248406,-75.253506);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13355 42.823663 -75.436707
var zip = "13355";
var point = new GLatLng(42.823663,-75.436707);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13357 43.006391 -75.04836
var zip = "13357";
var point = new GLatLng(43.006391,-75.04836);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13360 43.748024 -74.784631
var zip = "13360";
var point = new GLatLng(43.748024,-74.784631);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13361 42.89478 -74.820919
var zip = "13361";
var point = new GLatLng(42.89478,-74.820919);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13362 42.986389 -75.5175
var zip = "13362";
var point = new GLatLng(42.986389,-75.5175);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13363 43.314804 -75.505532
var zip = "13363";
var point = new GLatLng(43.314804,-75.505532);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13364 42.808611 -75.253056
var zip = "13364";
var point = new GLatLng(42.808611,-75.253056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13365 43.047371 -74.860598
var zip = "13365";
var point = new GLatLng(43.047371,-74.860598);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13367 43.801055 -75.475378
var zip = "13367";
var point = new GLatLng(43.801055,-75.475378);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13368 43.626165 -75.355312
var zip = "13368";
var point = new GLatLng(43.626165,-75.355312);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13401 43.289552 -75.652477
var zip = "13401";
var point = new GLatLng(43.289552,-75.652477);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13402 42.896854 -75.507562
var zip = "13402";
var point = new GLatLng(42.896854,-75.507562);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//13403 43.163926 -75.278335
var zip = "13403";
var point = new GLatLng(43.163926,-75.278335);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13404 43.7375 -75.47
var zip = "13404";
var point = new GLatLng(43.7375,-75.47);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13406 43.136933 -74.923978
var zip = "13406";
var point = new GLatLng(43.136933,-74.923978);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13407 42.989986 -74.985298
var zip = "13407";
var point = new GLatLng(42.989986,-74.985298);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13408 42.910805 -75.648656
var zip = "13408";
var point = new GLatLng(42.910805,-75.648656);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13409 42.986326 -75.594032
var zip = "13409";
var point = new GLatLng(42.986326,-75.594032);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13410 42.934722 -74.613889
var zip = "13410";
var point = new GLatLng(42.934722,-74.613889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13411 42.622414 -75.347406
var zip = "13411";
var point = new GLatLng(42.622414,-75.347406);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13413 43.065412 -75.290551
var zip = "13413";
var point = new GLatLng(43.065412,-75.290551);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13415 42.578968 -75.327436
var zip = "13415";
var point = new GLatLng(42.578968,-75.327436);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13416 43.180002 -74.986133
var zip = "13416";
var point = new GLatLng(43.180002,-74.986133);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13417 43.100038 -75.29369
var zip = "13417";
var point = new GLatLng(43.100038,-75.29369);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13418 42.850088 -75.381489
var zip = "13418";
var point = new GLatLng(42.850088,-75.381489);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13420 43.74347 -74.893511
var zip = "13420";
var point = new GLatLng(43.74347,-74.893511);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13421 43.086248 -75.650814
var zip = "13421";
var point = new GLatLng(43.086248,-75.650814);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13424 43.152427 -75.343437
var zip = "13424";
var point = new GLatLng(43.152427,-75.343437);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13425 42.957585 -75.483807
var zip = "13425";
var point = new GLatLng(42.957585,-75.483807);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13426 43.574722 -75.996667
var zip = "13426";
var point = new GLatLng(43.574722,-75.996667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13428 42.922119 -74.570825
var zip = "13428";
var point = new GLatLng(42.922119,-74.570825);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13431 43.211458 -75.07313
var zip = "13431";
var point = new GLatLng(43.211458,-75.07313);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13433 43.580245 -75.326257
var zip = "13433";
var point = new GLatLng(43.580245,-75.326257);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13435 43.304167 -75.1525
var zip = "13435";
var point = new GLatLng(43.304167,-75.1525);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13436 43.866224 -74.537959
var zip = "13436";
var point = new GLatLng(43.866224,-74.537959);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13437 43.565794 -75.82423
var zip = "13437";
var point = new GLatLng(43.565794,-75.82423);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13438 43.338456 -75.161618
var zip = "13438";
var point = new GLatLng(43.338456,-75.161618);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13439 42.850298 -74.992214
var zip = "13439";
var point = new GLatLng(42.850298,-74.992214);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13440 43.219349 -75.449758
var zip = "13440";
var point = new GLatLng(43.219349,-75.449758);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13441 43.219 -75.4108
var zip = "13441";
var point = new GLatLng(43.219,-75.4108);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13442 43.2196 -75.45
var zip = "13442";
var point = new GLatLng(43.2196,-75.45);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13449 43.2196 -75.45
var zip = "13449";
var point = new GLatLng(43.2196,-75.45);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13450 42.788246 -74.74161
var zip = "13450";
var point = new GLatLng(42.788246,-74.74161);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13452 43.016995 -74.64604
var zip = "13452";
var point = new GLatLng(43.016995,-74.64604);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13454 43.162509 -74.780932
var zip = "13454";
var point = new GLatLng(43.162509,-74.780932);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13455 42.913889 -75.379444
var zip = "13455";
var point = new GLatLng(42.913889,-75.379444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13456 43.007291 -75.26259
var zip = "13456";
var point = new GLatLng(43.007291,-75.26259);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13457 42.780278 -75.028333
var zip = "13457";
var point = new GLatLng(42.780278,-75.028333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13459 42.763357 -74.591911
var zip = "13459";
var point = new GLatLng(42.763357,-74.591911);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13460 42.685885 -75.483027
var zip = "13460";
var point = new GLatLng(42.685885,-75.483027);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13461 43.070397 -75.598975
var zip = "13461";
var point = new GLatLng(43.070397,-75.598975);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13464 42.689565 -75.612124
var zip = "13464";
var point = new GLatLng(42.689565,-75.612124);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13465 42.910556 -75.518056
var zip = "13465";
var point = new GLatLng(42.910556,-75.518056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13468 42.850106 -74.938051
var zip = "13468";
var point = new GLatLng(42.850106,-74.938051);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13469 43.222889 -75.289854
var zip = "13469";
var point = new GLatLng(43.222889,-75.289854);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13470 43.179101 -74.676786
var zip = "13470";
var point = new GLatLng(43.179101,-74.676786);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13471 43.336571 -75.602706
var zip = "13471";
var point = new GLatLng(43.336571,-75.602706);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13472 43.7 -75.002222
var zip = "13472";
var point = new GLatLng(43.7,-75.002222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13473 43.644074 -75.413199
var zip = "13473";
var point = new GLatLng(43.644074,-75.413199);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13475 42.894812 -74.834662
var zip = "13475";
var point = new GLatLng(42.894812,-74.834662);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13476 43.094509 -75.56272
var zip = "13476";
var point = new GLatLng(43.094509,-75.56272);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13477 43.044309 -75.521028
var zip = "13477";
var point = new GLatLng(43.044309,-75.521028);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13478 43.147311 -75.572399
var zip = "13478";
var point = new GLatLng(43.147311,-75.572399);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13479 43.05 -75.273333
var zip = "13479";
var point = new GLatLng(43.05,-75.273333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13480 42.933244 -75.381466
var zip = "13480";
var point = new GLatLng(42.933244,-75.381466);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13482 42.706229 -75.190603
var zip = "13482";
var point = new GLatLng(42.706229,-75.190603);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13483 43.411671 -75.822587
var zip = "13483";
var point = new GLatLng(43.411671,-75.822587);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13484 42.854444 -75.656389
var zip = "13484";
var point = new GLatLng(42.854444,-75.656389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13485 42.794543 -75.303723
var zip = "13485";
var point = new GLatLng(42.794543,-75.303723);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13486 43.329413 -75.315118
var zip = "13486";
var point = new GLatLng(43.329413,-75.315118);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13488 42.503512 -75.100378
var zip = "13488";
var point = new GLatLng(42.503512,-75.100378);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13489 43.459713 -75.512707
var zip = "13489";
var point = new GLatLng(43.459713,-75.512707);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13490 43.101686 -75.453259
var zip = "13490";
var point = new GLatLng(43.101686,-75.453259);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13491 42.882566 -75.183491
var zip = "13491";
var point = new GLatLng(42.882566,-75.183491);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13492 43.115805 -75.309479
var zip = "13492";
var point = new GLatLng(43.115805,-75.309479);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13493 43.410559 -75.904411
var zip = "13493";
var point = new GLatLng(43.410559,-75.904411);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13494 43.54881 -75.119111
var zip = "13494";
var point = new GLatLng(43.54881,-75.119111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13495 43.111582 -75.275565
var zip = "13495";
var point = new GLatLng(43.111582,-75.275565);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13501 43.087112 -75.231463
var zip = "13501";
var point = new GLatLng(43.087112,-75.231463);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13502 43.106723 -75.231383
var zip = "13502";
var point = new GLatLng(43.106723,-75.231383);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13503 43.1015 -75.2319
var zip = "13503";
var point = new GLatLng(43.1015,-75.2319);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13504 43.1008 -75.233
var zip = "13504";
var point = new GLatLng(43.1008,-75.233);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13505 43.1008 -75.233
var zip = "13505";
var point = new GLatLng(43.1008,-75.233);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13599 43.1008 -75.233
var zip = "13599";
var point = new GLatLng(43.1008,-75.233);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13601 43.974258 -75.912212
var zip = "13601";
var point = new GLatLng(43.974258,-75.912212);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13602 44.035434 -75.753972
var zip = "13602";
var point = new GLatLng(44.035434,-75.753972);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13603 44.072122 -75.791884
var zip = "13603";
var point = new GLatLng(44.072122,-75.791884);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13605 43.81614 -76.054302
var zip = "13605";
var point = new GLatLng(43.81614,-76.054302);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13606 43.863106 -76.00415
var zip = "13606";
var point = new GLatLng(43.863106,-76.00415);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13607 44.326982 -75.930619
var zip = "13607";
var point = new GLatLng(44.326982,-75.930619);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13608 44.235775 -75.600484
var zip = "13608";
var point = new GLatLng(44.235775,-75.600484);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13611 43.785373 -76.115053
var zip = "13611";
var point = new GLatLng(43.785373,-76.115053);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//13612 44.004156 -75.795777
var zip = "13612";
var point = new GLatLng(44.004156,-75.795777);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13613 44.846718 -74.747303
var zip = "13613";
var point = new GLatLng(44.846718,-74.747303);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13614 44.552542 -75.672203
var zip = "13614";
var point = new GLatLng(44.552542,-75.672203);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//13615 44.006944 -75.984444
var zip = "13615";
var point = new GLatLng(44.006944,-75.984444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13616 44.026484 -75.849884
var zip = "13616";
var point = new GLatLng(44.026484,-75.849884);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13617 44.592442 -75.162792
var zip = "13617";
var point = new GLatLng(44.592442,-75.162792);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13618 44.124419 -76.316443
var zip = "13618";
var point = new GLatLng(44.124419,-76.316443);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13619 43.981039 -75.616008
var zip = "13619";
var point = new GLatLng(43.981039,-75.616008);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13620 43.88432 -75.460432
var zip = "13620";
var point = new GLatLng(43.88432,-75.460432);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13621 44.867246 -75.073002
var zip = "13621";
var point = new GLatLng(44.867246,-75.073002);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13622 44.08481 -76.123163
var zip = "13622";
var point = new GLatLng(44.08481,-76.123163);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13623 44.441944 -75.757222
var zip = "13623";
var point = new GLatLng(44.441944,-75.757222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13624 44.217016 -76.107056
var zip = "13624";
var point = new GLatLng(44.217016,-76.107056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13625 44.50156 -74.932672
var zip = "13625";
var point = new GLatLng(44.50156,-74.932672);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13626 43.880136 -75.683913
var zip = "13626";
var point = new GLatLng(43.880136,-75.683913);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13627 43.929722 -75.589444
var zip = "13627";
var point = new GLatLng(43.929722,-75.589444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13628 44.035556 -75.684167
var zip = "13628";
var point = new GLatLng(44.035556,-75.684167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13630 44.489551 -75.287088
var zip = "13630";
var point = new GLatLng(44.489551,-75.287088);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13631 43.899722 -75.582778
var zip = "13631";
var point = new GLatLng(43.899722,-75.582778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13632 44.138333 -76.065833
var zip = "13632";
var point = new GLatLng(44.138333,-76.065833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13633 44.541341 -75.432814
var zip = "13633";
var point = new GLatLng(44.541341,-75.432814);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13634 44.006923 -76.06499
var zip = "13634";
var point = new GLatLng(44.006923,-76.06499);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13635 44.311048 -75.252226
var zip = "13635";
var point = new GLatLng(44.311048,-75.252226);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13636 43.737202 -76.125871
var zip = "13636";
var point = new GLatLng(43.737202,-76.125871);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13637 44.081668 -75.830516
var zip = "13637";
var point = new GLatLng(44.081668,-75.830516);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13638 44.020374 -75.752443
var zip = "13638";
var point = new GLatLng(44.020374,-75.752443);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13639 44.247778 -75.138056
var zip = "13639";
var point = new GLatLng(44.247778,-75.138056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13640 44.2875 -76.0125
var zip = "13640";
var point = new GLatLng(44.2875,-76.0125);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13641 44.276389 -76.008333
var zip = "13641";
var point = new GLatLng(44.276389,-76.008333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13642 44.328302 -75.465061
var zip = "13642";
var point = new GLatLng(44.328302,-75.465061);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13643 44.034167 -75.719167
var zip = "13643";
var point = new GLatLng(44.034167,-75.719167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13645 44.31 -75.446667
var zip = "13645";
var point = new GLatLng(44.31,-75.446667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13646 44.450155 -75.672749
var zip = "13646";
var point = new GLatLng(44.450155,-75.672749);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13647 44.612222 -74.971389
var zip = "13647";
var point = new GLatLng(44.612222,-74.971389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13648 44.161294 -75.325151
var zip = "13648";
var point = new GLatLng(44.161294,-75.325151);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13649 44.921667 -74.726667
var zip = "13649";
var point = new GLatLng(44.921667,-74.726667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13650 43.846742 -76.235212
var zip = "13650";
var point = new GLatLng(43.846742,-76.235212);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13651 43.864722 -76.202222
var zip = "13651";
var point = new GLatLng(43.864722,-76.202222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13652 44.444845 -75.198664
var zip = "13652";
var point = new GLatLng(44.444845,-75.198664);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13654 44.593034 -75.420345
var zip = "13654";
var point = new GLatLng(44.593034,-75.420345);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13655 44.982511 -74.662649
var zip = "13655";
var point = new GLatLng(44.982511,-74.662649);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13656 44.198709 -75.956902
var zip = "13656";
var point = new GLatLng(44.198709,-75.956902);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13657 44.029167 -76.043333
var zip = "13657";
var point = new GLatLng(44.029167,-76.043333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13658 44.718424 -75.269364
var zip = "13658";
var point = new GLatLng(44.718424,-75.269364);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13659 43.756845 -75.905339
var zip = "13659";
var point = new GLatLng(43.756845,-75.905339);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13660 44.768978 -75.14134
var zip = "13660";
var point = new GLatLng(44.768978,-75.14134);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13661 43.717905 -76.08203
var zip = "13661";
var point = new GLatLng(43.717905,-76.08203);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13662 44.932411 -74.886205
var zip = "13662";
var point = new GLatLng(44.932411,-74.886205);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13664 44.586389 -75.648611
var zip = "13664";
var point = new GLatLng(44.586389,-75.648611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13665 44.062982 -75.503883
var zip = "13665";
var point = new GLatLng(44.062982,-75.503883);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13666 44.198584 -74.98456
var zip = "13666";
var point = new GLatLng(44.198584,-74.98456);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13667 44.84235 -74.957736
var zip = "13667";
var point = new GLatLng(44.84235,-74.957736);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13668 44.747193 -74.999188
var zip = "13668";
var point = new GLatLng(44.747193,-74.999188);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13669 44.690203 -75.477403
var zip = "13669";
var point = new GLatLng(44.690203,-75.477403);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13670 44.193328 -75.065947
var zip = "13670";
var point = new GLatLng(44.193328,-75.065947);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13671 44.287222 -75.623333
var zip = "13671";
var point = new GLatLng(44.287222,-75.623333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//13672 44.592655 -74.794062
var zip = "13672";
var point = new GLatLng(44.592655,-74.794062);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13673 44.158896 -75.709917
var zip = "13673";
var point = new GLatLng(44.158896,-75.709917);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13674 43.735 -76.059167
var zip = "13674";
var point = new GLatLng(43.735,-76.059167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13675 44.277364 -75.849577
var zip = "13675";
var point = new GLatLng(44.277364,-75.849577);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13676 44.659246 -74.968076
var zip = "13676";
var point = new GLatLng(44.659246,-74.968076);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13677 44.514722 -75.186111
var zip = "13677";
var point = new GLatLng(44.514722,-75.186111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13678 44.838056 -74.978333
var zip = "13678";
var point = new GLatLng(44.838056,-74.978333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13679 44.321077 -75.814975
var zip = "13679";
var point = new GLatLng(44.321077,-75.814975);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13680 44.590635 -75.32261
var zip = "13680";
var point = new GLatLng(44.590635,-75.32261);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13681 44.40454 -75.402455
var zip = "13681";
var point = new GLatLng(44.40454,-75.402455);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13682 43.862217 -75.871879
var zip = "13682";
var point = new GLatLng(43.862217,-75.871879);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13683 44.972778 -74.731389
var zip = "13683";
var point = new GLatLng(44.972778,-74.731389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13684 44.380668 -75.113778
var zip = "13684";
var point = new GLatLng(44.380668,-75.113778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13685 43.93983 -76.105039
var zip = "13685";
var point = new GLatLng(43.93983,-76.105039);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13687 44.504097 -74.860726
var zip = "13687";
var point = new GLatLng(44.504097,-74.860726);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13690 44.157762 -75.033015
var zip = "13690";
var point = new GLatLng(44.157762,-75.033015);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13691 44.211288 -75.801419
var zip = "13691";
var point = new GLatLng(44.211288,-75.801419);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13692 44.286944 -76.028056
var zip = "13692";
var point = new GLatLng(44.286944,-76.028056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13693 44.055102 -76.26893
var zip = "13693";
var point = new GLatLng(44.055102,-76.26893);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13694 44.856373 -75.204887
var zip = "13694";
var point = new GLatLng(44.856373,-75.204887);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13695 44.2184 -75.090765
var zip = "13695";
var point = new GLatLng(44.2184,-75.090765);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13696 44.728951 -74.891932
var zip = "13696";
var point = new GLatLng(44.728951,-74.891932);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13697 44.758289 -74.806586
var zip = "13697";
var point = new GLatLng(44.758289,-74.806586);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13699 44.669722 -74.981667
var zip = "13699";
var point = new GLatLng(44.669722,-74.981667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13730 42.241737 -75.536604
var zip = "13730";
var point = new GLatLng(42.241737,-75.536604);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13731 42.156925 -74.788726
var zip = "13731";
var point = new GLatLng(42.156925,-74.788726);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13732 42.055579 -76.15194
var zip = "13732";
var point = new GLatLng(42.055579,-76.15194);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13733 42.311975 -75.489411
var zip = "13733";
var point = new GLatLng(42.311975,-75.489411);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13734 42.069534 -76.398349
var zip = "13734";
var point = new GLatLng(42.069534,-76.398349);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13736 42.307435 -76.192008
var zip = "13736";
var point = new GLatLng(42.307435,-76.192008);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13737 42.114722 -76.074722
var zip = "13737";
var point = new GLatLng(42.114722,-76.074722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13738 42.568333 -76.126111
var zip = "13738";
var point = new GLatLng(42.568333,-76.126111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13739 42.352236 -74.807118
var zip = "13739";
var point = new GLatLng(42.352236,-74.807118);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13740 42.27094 -74.766112
var zip = "13740";
var point = new GLatLng(42.27094,-74.766112);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13743 42.206274 -76.332196
var zip = "13743";
var point = new GLatLng(42.206274,-76.332196);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13744 42.256805 -75.908746
var zip = "13744";
var point = new GLatLng(42.256805,-75.908746);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//13745 42.166667 -75.862778
var zip = "13745";
var point = new GLatLng(42.166667,-75.862778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13746 42.263659 -75.824236
var zip = "13746";
var point = new GLatLng(42.263659,-75.824236);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13747 42.490833 -74.9825
var zip = "13747";
var point = new GLatLng(42.490833,-74.9825);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13748 42.045429 -75.807624
var zip = "13748";
var point = new GLatLng(42.045429,-75.807624);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13749 42.015556 -75.790833
var zip = "13749";
var point = new GLatLng(42.015556,-75.790833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13750 42.471081 -74.835709
var zip = "13750";
var point = new GLatLng(42.471081,-74.835709);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13751 42.452303 -74.906975
var zip = "13751";
var point = new GLatLng(42.452303,-74.906975);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13752 42.188984 -74.922899
var zip = "13752";
var point = new GLatLng(42.188984,-74.922899);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13753 42.287851 -74.922823
var zip = "13753";
var point = new GLatLng(42.287851,-74.922823);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13754 42.066581 -75.428745
var zip = "13754";
var point = new GLatLng(42.066581,-75.428745);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13755 42.071634 -75.015216
var zip = "13755";
var point = new GLatLng(42.071634,-75.015216);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13756 41.984366 -75.125189
var zip = "13756";
var point = new GLatLng(41.984366,-75.125189);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13757 42.410098 -74.898699
var zip = "13757";
var point = new GLatLng(42.410098,-74.898699);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13758 42.558056 -75.7175
var zip = "13758";
var point = new GLatLng(42.558056,-75.7175);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13760 42.114089 -76.056927
var zip = "13760";
var point = new GLatLng(42.114089,-76.056927);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13761 42.1007 -76.0485
var zip = "13761";
var point = new GLatLng(42.1007,-76.0485);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13762 42.112778 -76.021389
var zip = "13762";
var point = new GLatLng(42.112778,-76.021389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13763 42.0952 -76.0653
var zip = "13763";
var point = new GLatLng(42.0952,-76.0653);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13774 41.963611 -75.175278
var zip = "13774";
var point = new GLatLng(41.963611,-75.175278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13775 42.342117 -75.148475
var zip = "13775";
var point = new GLatLng(42.342117,-75.148475);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13776 42.432951 -75.360929
var zip = "13776";
var point = new GLatLng(42.432951,-75.360929);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13777 42.257289 -75.980544
var zip = "13777";
var point = new GLatLng(42.257289,-75.980544);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13778 42.337301 -75.75954
var zip = "13778";
var point = new GLatLng(42.337301,-75.75954);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13780 42.426901 -75.482318
var zip = "13780";
var point = new GLatLng(42.426901,-75.482318);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13782 42.17873 -74.998391
var zip = "13782";
var point = new GLatLng(42.17873,-74.998391);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13783 41.959667 -75.265306
var zip = "13783";
var point = new GLatLng(41.959667,-75.265306);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13784 42.426111 -76.226944
var zip = "13784";
var point = new GLatLng(42.426111,-76.226944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13786 42.449901 -74.687059
var zip = "13786";
var point = new GLatLng(42.449901,-74.687059);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13787 42.18232 -75.654538
var zip = "13787";
var point = new GLatLng(42.18232,-75.654538);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13788 42.359409 -74.675889
var zip = "13788";
var point = new GLatLng(42.359409,-74.675889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13790 42.126683 -75.968492
var zip = "13790";
var point = new GLatLng(42.126683,-75.968492);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13794 42.400556 -76.021111
var zip = "13794";
var point = new GLatLng(42.400556,-76.021111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13795 42.069463 -75.796711
var zip = "13795";
var point = new GLatLng(42.069463,-75.796711);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13796 42.538261 -75.127947
var zip = "13796";
var point = new GLatLng(42.538261,-75.127947);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13797 42.340923 -76.030237
var zip = "13797";
var point = new GLatLng(42.340923,-76.030237);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13801 42.506807 -75.762305
var zip = "13801";
var point = new GLatLng(42.506807,-75.762305);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13802 42.196204 -76.059526
var zip = "13802";
var point = new GLatLng(42.196204,-76.059526);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13803 42.452725 -76.039526
var zip = "13803";
var point = new GLatLng(42.452725,-76.039526);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13804 42.262346 -75.215485
var zip = "13804";
var point = new GLatLng(42.262346,-75.215485);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13806 42.377987 -74.980258
var zip = "13806";
var point = new GLatLng(42.377987,-74.980258);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13807 42.614801 -74.968498
var zip = "13807";
var point = new GLatLng(42.614801,-74.968498);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13808 42.547807 -75.244764
var zip = "13808";
var point = new GLatLng(42.547807,-75.244764);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13809 42.408064 -75.400268
var zip = "13809";
var point = new GLatLng(42.408064,-75.400268);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13810 42.606763 -75.126366
var zip = "13810";
var point = new GLatLng(42.606763,-75.126366);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13811 42.228136 -76.16248
var zip = "13811";
var point = new GLatLng(42.228136,-76.16248);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//13812 42.031961 -76.361039
var zip = "13812";
var point = new GLatLng(42.031961,-76.361039);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13813 42.162481 -75.548409
var zip = "13813";
var point = new GLatLng(42.162481,-75.548409);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13814 42.616944 -75.527222
var zip = "13814";
var point = new GLatLng(42.616944,-75.527222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13815 42.54145 -75.527431
var zip = "13815";
var point = new GLatLng(42.54145,-75.527431);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13820 42.462453 -75.049072
var zip = "13820";
var point = new GLatLng(42.462453,-75.049072);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13825 42.41333 -75.207883
var zip = "13825";
var point = new GLatLng(42.41333,-75.207883);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13826 42.119293 -75.647351
var zip = "13826";
var point = new GLatLng(42.119293,-75.647351);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13827 42.113809 -76.252797
var zip = "13827";
var point = new GLatLng(42.113809,-76.252797);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13830 42.443375 -75.606256
var zip = "13830";
var point = new GLatLng(42.443375,-75.606256);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13832 42.633592 -75.617163
var zip = "13832";
var point = new GLatLng(42.633592,-75.617163);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13833 42.195735 -75.790978
var zip = "13833";
var point = new GLatLng(42.195735,-75.790978);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13834 42.510303 -74.976059
var zip = "13834";
var point = new GLatLng(42.510303,-74.976059);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13835 42.394521 -76.186501
var zip = "13835";
var point = new GLatLng(42.394521,-76.186501);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13837 42.038611 -75.068056
var zip = "13837";
var point = new GLatLng(42.038611,-75.068056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13838 42.307368 -75.3908
var zip = "13838";
var point = new GLatLng(42.307368,-75.3908);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13839 42.244085 -75.287057
var zip = "13839";
var point = new GLatLng(42.244085,-75.287057);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13840 42.033889 -76.400556
var zip = "13840";
var point = new GLatLng(42.033889,-76.400556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13841 42.398894 -75.823719
var zip = "13841";
var point = new GLatLng(42.398894,-75.823719);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13842 42.376994 -74.725901
var zip = "13842";
var point = new GLatLng(42.376994,-74.725901);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13843 42.530569 -75.35249
var zip = "13843";
var point = new GLatLng(42.530569,-75.35249);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13844 42.605254 -75.633
var zip = "13844";
var point = new GLatLng(42.605254,-75.633);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13845 42.056111 -76.348333
var zip = "13845";
var point = new GLatLng(42.056111,-76.348333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13846 42.362963 -75.058754
var zip = "13846";
var point = new GLatLng(42.362963,-75.058754);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13847 42.203611 -75.279722
var zip = "13847";
var point = new GLatLng(42.203611,-75.279722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13848 42.216111 -75.726944
var zip = "13848";
var point = new GLatLng(42.216111,-75.726944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13849 42.325199 -75.336589
var zip = "13849";
var point = new GLatLng(42.325199,-75.336589);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13850 42.077106 -76.011757
var zip = "13850";
var point = new GLatLng(42.077106,-76.011757);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13851 42.085 -76.054167
var zip = "13851";
var point = new GLatLng(42.085,-76.054167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13856 42.175647 -75.153177
var zip = "13856";
var point = new GLatLng(42.175647,-75.153177);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//13859 42.357973 -75.256565
var zip = "13859";
var point = new GLatLng(42.357973,-75.256565);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13860 42.445833 -74.963611
var zip = "13860";
var point = new GLatLng(42.445833,-74.963611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13861 42.453854 -75.095689
var zip = "13861";
var point = new GLatLng(42.453854,-75.095689);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13862 42.338449 -75.952231
var zip = "13862";
var point = new GLatLng(42.338449,-75.952231);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13863 42.452044 -75.901434
var zip = "13863";
var point = new GLatLng(42.452044,-75.901434);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//13864 42.302915 -76.389721
var zip = "13864";
var point = new GLatLng(42.302915,-76.389721);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13865 42.074482 -75.672828
var zip = "13865";
var point = new GLatLng(42.074482,-75.672828);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//13901 42.146307 -75.886517
var zip = "13901";
var point = new GLatLng(42.146307,-75.886517);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13902 42.098611 -75.918333
var zip = "13902";
var point = new GLatLng(42.098611,-75.918333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//13903 42.081102 -75.897676
var zip = "13903";
var point = new GLatLng(42.081102,-75.897676);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13904 42.11714 -75.865269
var zip = "13904";
var point = new GLatLng(42.11714,-75.865269);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//13905 42.115051 -75.930865
var zip = "13905";
var point = new GLatLng(42.115051,-75.930865);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14001 43.024944 -78.508365
var zip = "14001";
var point = new GLatLng(43.024944,-78.508365);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14004 42.89839 -78.525707
var zip = "14004";
var point = new GLatLng(42.89839,-78.525707);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14005 42.915851 -78.25889
var zip = "14005";
var point = new GLatLng(42.915851,-78.25889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14006 42.636581 -79.049651
var zip = "14006";
var point = new GLatLng(42.636581,-79.049651);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14008 43.310535 -78.637217
var zip = "14008";
var point = new GLatLng(43.310535,-78.637217);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14009 42.562995 -78.413418
var zip = "14009";
var point = new GLatLng(42.562995,-78.413418);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14010 42.769722 -78.866667
var zip = "14010";
var point = new GLatLng(42.769722,-78.866667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14011 42.849918 -78.279826
var zip = "14011";
var point = new GLatLng(42.849918,-78.279826);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14012 43.336779 -78.542004
var zip = "14012";
var point = new GLatLng(43.336779,-78.542004);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14013 43.080724 -78.395143
var zip = "14013";
var point = new GLatLng(43.080724,-78.395143);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14020 43.000316 -78.192869
var zip = "14020";
var point = new GLatLng(43.000316,-78.192869);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14021 42.998056 -78.187778
var zip = "14021";
var point = new GLatLng(42.998056,-78.187778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14024 42.579936 -78.258084
var zip = "14024";
var point = new GLatLng(42.579936,-78.258084);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14025 42.631384 -78.73909
var zip = "14025";
var point = new GLatLng(42.631384,-78.73909);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14026 42.947826 -78.682961
var zip = "14026";
var point = new GLatLng(42.947826,-78.682961);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14027 42.588333 -79.018056
var zip = "14027";
var point = new GLatLng(42.588333,-79.018056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14028 43.322089 -78.714097
var zip = "14028";
var point = new GLatLng(43.322089,-78.714097);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14029 42.479722 -78.25
var zip = "14029";
var point = new GLatLng(42.479722,-78.25);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14030 42.560492 -78.502543
var zip = "14030";
var point = new GLatLng(42.560492,-78.502543);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14031 42.980965 -78.616228
var zip = "14031";
var point = new GLatLng(42.980965,-78.616228);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14032 43.0362 -78.63903
var zip = "14032";
var point = new GLatLng(43.0362,-78.63903);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14033 42.655052 -78.692078
var zip = "14033";
var point = new GLatLng(42.655052,-78.692078);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14034 42.500082 -78.892974
var zip = "14034";
var point = new GLatLng(42.500082,-78.892974);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14035 42.493611 -78.851667
var zip = "14035";
var point = new GLatLng(42.493611,-78.851667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14036 42.977734 -78.392906
var zip = "14036";
var point = new GLatLng(42.977734,-78.392906);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14037 42.811245 -78.448136
var zip = "14037";
var point = new GLatLng(42.811245,-78.448136);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14038 42.946111 -78.485
var zip = "14038";
var point = new GLatLng(42.946111,-78.485);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14039 42.826284 -78.174865
var zip = "14039";
var point = new GLatLng(42.826284,-78.174865);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14040 42.894806 -78.387782
var zip = "14040";
var point = new GLatLng(42.894806,-78.387782);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14041 42.423075 -78.981842
var zip = "14041";
var point = new GLatLng(42.423075,-78.981842);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14042 42.492598 -78.479326
var zip = "14042";
var point = new GLatLng(42.492598,-78.479326);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14043 42.904973 -78.704052
var zip = "14043";
var point = new GLatLng(42.904973,-78.704052);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14047 42.697445 -78.983365
var zip = "14047";
var point = new GLatLng(42.697445,-78.983365);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14048 42.475907 -79.329366
var zip = "14048";
var point = new GLatLng(42.475907,-79.329366);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14051 43.029168 -78.705035
var zip = "14051";
var point = new GLatLng(43.029168,-78.705035);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14052 42.770138 -78.601992
var zip = "14052";
var point = new GLatLng(42.770138,-78.601992);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14054 42.916619 -78.134206
var zip = "14054";
var point = new GLatLng(42.916619,-78.134206);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14055 42.546585 -78.610972
var zip = "14055";
var point = new GLatLng(42.546585,-78.610972);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14056 42.995556 -78.310278
var zip = "14056";
var point = new GLatLng(42.995556,-78.310278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14057 42.650552 -78.878077
var zip = "14057";
var point = new GLatLng(42.650552,-78.878077);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14058 43.089739 -78.170383
var zip = "14058";
var point = new GLatLng(43.089739,-78.170383);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14059 42.834002 -78.634257
var zip = "14059";
var point = new GLatLng(42.834002,-78.634257);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14060 42.44827 -78.291533
var zip = "14060";
var point = new GLatLng(42.44827,-78.291533);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14061 42.594444 -79.091389
var zip = "14061";
var point = new GLatLng(42.594444,-79.091389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14062 42.448229 -79.160743
var zip = "14062";
var point = new GLatLng(42.448229,-79.160743);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14063 42.433345 -79.333914
var zip = "14063";
var point = new GLatLng(42.433345,-79.333914);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14065 42.489693 -78.35013
var zip = "14065";
var point = new GLatLng(42.489693,-78.35013);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14066 42.61897 -78.179516
var zip = "14066";
var point = new GLatLng(42.61897,-78.179516);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14067 43.210587 -78.574536
var zip = "14067";
var point = new GLatLng(43.210587,-78.574536);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14068 43.023989 -78.753184
var zip = "14068";
var point = new GLatLng(43.023989,-78.753184);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14069 42.600094 -78.638634
var zip = "14069";
var point = new GLatLng(42.600094,-78.638634);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14070 42.471202 -78.933902
var zip = "14070";
var point = new GLatLng(42.471202,-78.933902);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14072 43.018266 -78.959059
var zip = "14072";
var point = new GLatLng(43.018266,-78.959059);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14075 42.733404 -78.838853
var zip = "14075";
var point = new GLatLng(42.733404,-78.838853);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14080 42.639582 -78.543889
var zip = "14080";
var point = new GLatLng(42.639582,-78.543889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14081 42.573866 -79.059634
var zip = "14081";
var point = new GLatLng(42.573866,-79.059634);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14082 42.66342 -78.392527
var zip = "14082";
var point = new GLatLng(42.66342,-78.392527);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14083 42.676852 -78.44101
var zip = "14083";
var point = new GLatLng(42.676852,-78.44101);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14085 42.721535 -78.932693
var zip = "14085";
var point = new GLatLng(42.721535,-78.932693);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14086 42.901681 -78.663085
var zip = "14086";
var point = new GLatLng(42.901681,-78.663085);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14091 42.540364 -78.921222
var zip = "14091";
var point = new GLatLng(42.540364,-78.921222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14092 43.172165 -79.021547
var zip = "14092";
var point = new GLatLng(43.172165,-79.021547);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14094 43.159987 -78.692344
var zip = "14094";
var point = new GLatLng(43.159987,-78.692344);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14095 43.170556 -78.690556
var zip = "14095";
var point = new GLatLng(43.170556,-78.690556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14098 43.323312 -78.381057
var zip = "14098";
var point = new GLatLng(43.323312,-78.381057);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14101 42.408271 -78.50586
var zip = "14101";
var point = new GLatLng(42.408271,-78.50586);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14102 42.833216 -78.558656
var zip = "14102";
var point = new GLatLng(42.833216,-78.558656);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14103 43.218428 -78.387422
var zip = "14103";
var point = new GLatLng(43.218428,-78.387422);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14105 43.218257 -78.484055
var zip = "14105";
var point = new GLatLng(43.218257,-78.484055);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14107 43.185 -78.983889
var zip = "14107";
var point = new GLatLng(43.185,-78.983889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14108 43.272443 -78.706972
var zip = "14108";
var point = new GLatLng(43.272443,-78.706972);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14109 43.138333 -79.039167
var zip = "14109";
var point = new GLatLng(43.138333,-79.039167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14110 42.685556 -78.776944
var zip = "14110";
var point = new GLatLng(42.685556,-78.776944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14111 42.589648 -78.91073
var zip = "14111";
var point = new GLatLng(42.589648,-78.91073);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14112 42.696944 -78.941667
var zip = "14112";
var point = new GLatLng(42.696944,-78.941667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14113 42.677631 -78.337958
var zip = "14113";
var point = new GLatLng(42.677631,-78.337958);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14120 43.049828 -78.850997
var zip = "14120";
var point = new GLatLng(43.049828,-78.850997);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14125 43.071726 -78.270179
var zip = "14125";
var point = new GLatLng(43.071726,-78.270179);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14126 43.337778 -78.715
var zip = "14126";
var point = new GLatLng(43.337778,-78.715);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14127 42.763891 -78.751834
var zip = "14127";
var point = new GLatLng(42.763891,-78.751834);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14129 42.472289 -78.998108
var zip = "14129";
var point = new GLatLng(42.472289,-78.998108);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14130 42.556389 -78.153056
var zip = "14130";
var point = new GLatLng(42.556389,-78.153056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14131 43.228602 -78.898159
var zip = "14131";
var point = new GLatLng(43.228602,-78.898159);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14132 43.141879 -78.878522
var zip = "14132";
var point = new GLatLng(43.141879,-78.878522);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14133 42.495833 -78.384722
var zip = "14133";
var point = new GLatLng(42.495833,-78.384722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14134 42.532976 -78.506415
var zip = "14134";
var point = new GLatLng(42.532976,-78.506415);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14135 42.488333 -79.2375
var zip = "14135";
var point = new GLatLng(42.488333,-79.2375);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14136 42.535675 -79.162805
var zip = "14136";
var point = new GLatLng(42.535675,-79.162805);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14138 42.371803 -79.050132
var zip = "14138";
var point = new GLatLng(42.371803,-79.050132);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14139 42.706271 -78.545219
var zip = "14139";
var point = new GLatLng(42.706271,-78.545219);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14140 42.818056 -78.675833
var zip = "14140";
var point = new GLatLng(42.818056,-78.675833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14141 42.519982 -78.684717
var zip = "14141";
var point = new GLatLng(42.519982,-78.684717);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14143 42.982894 -78.089783
var zip = "14143";
var point = new GLatLng(42.982894,-78.089783);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14144 43.201944 -79.0425
var zip = "14144";
var point = new GLatLng(43.201944,-79.0425);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14145 42.724892 -78.434714
var zip = "14145";
var point = new GLatLng(42.724892,-78.434714);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14150 43.002837 -78.85472
var zip = "14150";
var point = new GLatLng(43.002837,-78.85472);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14151 43.020278 -78.880556
var zip = "14151";
var point = new GLatLng(43.020278,-78.880556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14166 42.479444 -79.334167
var zip = "14166";
var point = new GLatLng(42.479444,-79.334167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14167 42.745935 -78.316749
var zip = "14167";
var point = new GLatLng(42.745935,-78.316749);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14168 42.518889 -78.996111
var zip = "14168";
var point = new GLatLng(42.518889,-78.996111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14169 42.768333 -78.530278
var zip = "14169";
var point = new GLatLng(42.768333,-78.530278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14170 42.70532 -78.677937
var zip = "14170";
var point = new GLatLng(42.70532,-78.677937);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14171 42.43153 -78.627978
var zip = "14171";
var point = new GLatLng(42.43153,-78.627978);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14172 43.29681 -78.824396
var zip = "14172";
var point = new GLatLng(43.29681,-78.824396);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14173 42.53 -78.473056
var zip = "14173";
var point = new GLatLng(42.53,-78.473056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14174 43.246075 -79.024545
var zip = "14174";
var point = new GLatLng(43.246075,-79.024545);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14201 42.896659 -78.884575
var zip = "14201";
var point = new GLatLng(42.896659,-78.884575);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14202 42.887038 -78.877948
var zip = "14202";
var point = new GLatLng(42.887038,-78.877948);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14203 42.893938 -78.868143
var zip = "14203";
var point = new GLatLng(42.893938,-78.868143);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14204 42.883978 -78.859736
var zip = "14204";
var point = new GLatLng(42.883978,-78.859736);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14205 42.8925 -78.8707
var zip = "14205";
var point = new GLatLng(42.8925,-78.8707);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14206 42.881132 -78.810375
var zip = "14206";
var point = new GLatLng(42.881132,-78.810375);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14207 42.949062 -78.897815
var zip = "14207";
var point = new GLatLng(42.949062,-78.897815);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14208 42.915416 -78.850487
var zip = "14208";
var point = new GLatLng(42.915416,-78.850487);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14209 42.913 -78.865629
var zip = "14209";
var point = new GLatLng(42.913,-78.865629);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14210 42.861432 -78.82055
var zip = "14210";
var point = new GLatLng(42.861432,-78.82055);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14211 42.908153 -78.822477
var zip = "14211";
var point = new GLatLng(42.908153,-78.822477);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14212 42.894553 -78.824458
var zip = "14212";
var point = new GLatLng(42.894553,-78.824458);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14213 42.916675 -78.889461
var zip = "14213";
var point = new GLatLng(42.916675,-78.889461);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14214 42.941429 -78.837403
var zip = "14214";
var point = new GLatLng(42.941429,-78.837403);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14215 42.933536 -78.811504
var zip = "14215";
var point = new GLatLng(42.933536,-78.811504);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14216 42.949914 -78.859865
var zip = "14216";
var point = new GLatLng(42.949914,-78.859865);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14217 42.968618 -78.872948
var zip = "14217";
var point = new GLatLng(42.968618,-78.872948);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14218 42.818301 -78.817263
var zip = "14218";
var point = new GLatLng(42.818301,-78.817263);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14219 42.790039 -78.822228
var zip = "14219";
var point = new GLatLng(42.790039,-78.822228);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14220 42.844138 -78.818205
var zip = "14220";
var point = new GLatLng(42.844138,-78.818205);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14221 42.985621 -78.738044
var zip = "14221";
var point = new GLatLng(42.985621,-78.738044);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14222 42.916401 -78.876333
var zip = "14222";
var point = new GLatLng(42.916401,-78.876333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14223 42.973088 -78.845
var zip = "14223";
var point = new GLatLng(42.973088,-78.845);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14224 42.836162 -78.75109
var zip = "14224";
var point = new GLatLng(42.836162,-78.75109);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14225 42.928642 -78.760855
var zip = "14225";
var point = new GLatLng(42.928642,-78.760855);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14226 42.967232 -78.799849
var zip = "14226";
var point = new GLatLng(42.967232,-78.799849);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14227 42.877467 -78.741936
var zip = "14227";
var point = new GLatLng(42.877467,-78.741936);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14228 43.018414 -78.774604
var zip = "14228";
var point = new GLatLng(43.018414,-78.774604);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14231 42.963889 -78.738056
var zip = "14231";
var point = new GLatLng(42.963889,-78.738056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14233 42.8849 -78.8265
var zip = "14233";
var point = new GLatLng(42.8849,-78.8265);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14240 42.8849 -78.8265
var zip = "14240";
var point = new GLatLng(42.8849,-78.8265);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14241 42.8849 -78.8265
var zip = "14241";
var point = new GLatLng(42.8849,-78.8265);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14260 43.0003 -78.7902
var zip = "14260";
var point = new GLatLng(43.0003,-78.7902);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14261 43.0013 -78.7853
var zip = "14261";
var point = new GLatLng(43.0013,-78.7853);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14263 42.8849 -78.8265
var zip = "14263";
var point = new GLatLng(42.8849,-78.8265);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14264 42.8849 -78.8265
var zip = "14264";
var point = new GLatLng(42.8849,-78.8265);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14265 42.8849 -78.8265
var zip = "14265";
var point = new GLatLng(42.8849,-78.8265);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14267 42.8849 -78.8265
var zip = "14267";
var point = new GLatLng(42.8849,-78.8265);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14269 42.8849 -78.8265
var zip = "14269";
var point = new GLatLng(42.8849,-78.8265);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14270 42.8849 -78.8265
var zip = "14270";
var point = new GLatLng(42.8849,-78.8265);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14272 42.8849 -78.8265
var zip = "14272";
var point = new GLatLng(42.8849,-78.8265);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14273 42.8849 -78.8265
var zip = "14273";
var point = new GLatLng(42.8849,-78.8265);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14276 42.8849 -78.8265
var zip = "14276";
var point = new GLatLng(42.8849,-78.8265);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14280 42.8849 -78.8265
var zip = "14280";
var point = new GLatLng(42.8849,-78.8265);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14301 43.095467 -79.041443
var zip = "14301";
var point = new GLatLng(43.095467,-79.041443);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14302 43.094444 -79.056944
var zip = "14302";
var point = new GLatLng(43.094444,-79.056944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14303 43.087777 -79.036958
var zip = "14303";
var point = new GLatLng(43.087777,-79.036958);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14304 43.090844 -78.964375
var zip = "14304";
var point = new GLatLng(43.090844,-78.964375);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14305 43.114648 -79.037804
var zip = "14305";
var point = new GLatLng(43.114648,-79.037804);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14410 43.190644 -77.853905
var zip = "14410";
var point = new GLatLng(43.190644,-77.853905);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14411 43.239827 -78.206846
var zip = "14411";
var point = new GLatLng(43.239827,-78.206846);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14413 43.211111 -76.980833
var zip = "14413";
var point = new GLatLng(43.211111,-76.980833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14414 42.903034 -77.727398
var zip = "14414";
var point = new GLatLng(42.903034,-77.727398);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14415 42.755442 -77.021737
var zip = "14415";
var point = new GLatLng(42.755442,-77.021737);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14416 43.086937 -77.96033
var zip = "14416";
var point = new GLatLng(43.086937,-77.96033);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14418 42.606537 -77.205165
var zip = "14418";
var point = new GLatLng(42.606537,-77.205165);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14420 43.21284 -77.936797
var zip = "14420";
var point = new GLatLng(43.21284,-77.936797);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14422 43.073794 -78.062912
var zip = "14422";
var point = new GLatLng(43.073794,-78.062912);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14423 42.956661 -77.849295
var zip = "14423";
var point = new GLatLng(42.956661,-77.849295);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14424 42.868866 -77.284561
var zip = "14424";
var point = new GLatLng(42.868866,-77.284561);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14425 42.959591 -77.341139
var zip = "14425";
var point = new GLatLng(42.959591,-77.341139);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14427 42.635883 -78.054728
var zip = "14427";
var point = new GLatLng(42.635883,-78.054728);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14428 43.089617 -77.860339
var zip = "14428";
var point = new GLatLng(43.089617,-77.860339);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14429 43.193333 -78.065
var zip = "14429";
var point = new GLatLng(43.193333,-78.065);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14430 43.233056 -77.927778
var zip = "14430";
var point = new GLatLng(43.233056,-77.927778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14432 42.963175 -77.143975
var zip = "14432";
var point = new GLatLng(42.963175,-77.143975);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14433 43.085549 -76.872464
var zip = "14433";
var point = new GLatLng(43.085549,-76.872464);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14435 42.721643 -77.67469
var zip = "14435";
var point = new GLatLng(42.721643,-77.67469);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14437 42.569975 -77.710907
var zip = "14437";
var point = new GLatLng(42.569975,-77.710907);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14441 42.684565 -76.956389
var zip = "14441";
var point = new GLatLng(42.684565,-76.956389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14443 42.895 -77.435
var zip = "14443";
var point = new GLatLng(42.895,-77.435);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14445 43.112808 -77.490596
var zip = "14445";
var point = new GLatLng(43.112808,-77.490596);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14449 43.230556 -77.145556
var zip = "14449";
var point = new GLatLng(43.230556,-77.145556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14450 43.089198 -77.435956
var zip = "14450";
var point = new GLatLng(43.089198,-77.435956);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14452 43.244722 -78.091389
var zip = "14452";
var point = new GLatLng(43.244722,-78.091389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14453 43.008611 -77.465
var zip = "14453";
var point = new GLatLng(43.008611,-77.465);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14454 42.793783 -77.799552
var zip = "14454";
var point = new GLatLng(42.793783,-77.799552);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14456 42.86372 -76.991349
var zip = "14456";
var point = new GLatLng(42.86372,-76.991349);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14461 42.798889 -77.131944
var zip = "14461";
var point = new GLatLng(42.798889,-77.131944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14462 42.676046 -77.757334
var zip = "14462";
var point = new GLatLng(42.676046,-77.757334);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14463 42.793889 -77.066667
var zip = "14463";
var point = new GLatLng(42.793889,-77.066667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14464 43.307577 -77.926996
var zip = "14464";
var point = new GLatLng(43.307577,-77.926996);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14466 42.779957 -77.58199
var zip = "14466";
var point = new GLatLng(42.779957,-77.58199);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14467 43.048264 -77.612224
var zip = "14467";
var point = new GLatLng(43.048264,-77.612224);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14468 43.292344 -77.790511
var zip = "14468";
var point = new GLatLng(43.292344,-77.790511);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14469 42.885101 -77.459983
var zip = "14469";
var point = new GLatLng(42.885101,-77.459983);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14470 43.225494 -78.040392
var zip = "14470";
var point = new GLatLng(43.225494,-78.040392);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14471 42.768637 -77.505434
var zip = "14471";
var point = new GLatLng(42.768637,-77.505434);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14472 42.969499 -77.57812
var zip = "14472";
var point = new GLatLng(42.969499,-77.57812);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14475 42.938002 -77.50086
var zip = "14475";
var point = new GLatLng(42.938002,-77.50086);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14476 43.328415 -78.030359
var zip = "14476";
var point = new GLatLng(43.328415,-78.030359);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14477 43.334064 -78.135533
var zip = "14477";
var point = new GLatLng(43.334064,-78.135533);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14478 42.601032 -77.105197
var zip = "14478";
var point = new GLatLng(42.601032,-77.105197);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14479 43.241944 -78.310833
var zip = "14479";
var point = new GLatLng(43.241944,-78.310833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14480 42.82957 -77.714865
var zip = "14480";
var point = new GLatLng(42.82957,-77.714865);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14481 42.773903 -77.898976
var zip = "14481";
var point = new GLatLng(42.773903,-77.898976);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14482 42.977377 -77.985097
var zip = "14482";
var point = new GLatLng(42.977377,-77.985097);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14485 42.901234 -77.608305
var zip = "14485";
var point = new GLatLng(42.901234,-77.608305);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14486 42.884721 -77.910422
var zip = "14486";
var point = new GLatLng(42.884721,-77.910422);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14487 42.813514 -77.663472
var zip = "14487";
var point = new GLatLng(42.813514,-77.663472);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14488 42.821389 -77.638889
var zip = "14488";
var point = new GLatLng(42.821389,-77.638889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14489 43.07768 -76.989575
var zip = "14489";
var point = new GLatLng(43.07768,-76.989575);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14502 43.078366 -77.337199
var zip = "14502";
var point = new GLatLng(43.078366,-77.337199);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14504 42.969874 -77.229733
var zip = "14504";
var point = new GLatLng(42.969874,-77.229733);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14505 43.154612 -77.186277
var zip = "14505";
var point = new GLatLng(43.154612,-77.186277);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14506 42.995307 -77.50013
var zip = "14506";
var point = new GLatLng(42.995307,-77.50013);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14507 42.697624 -77.280509
var zip = "14507";
var point = new GLatLng(42.697624,-77.280509);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14508 43.328056 -77.995556
var zip = "14508";
var point = new GLatLng(43.328056,-77.995556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14510 42.705431 -77.861083
var zip = "14510";
var point = new GLatLng(42.705431,-77.861083);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14511 42.992778 -77.860556
var zip = "14511";
var point = new GLatLng(42.992778,-77.860556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14512 42.640425 -77.390106
var zip = "14512";
var point = new GLatLng(42.640425,-77.390106);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14513 43.051909 -77.094602
var zip = "14513";
var point = new GLatLng(43.051909,-77.094602);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14514 43.118601 -77.800518
var zip = "14514";
var point = new GLatLng(43.118601,-77.800518);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14515 43.253611 -77.732778
var zip = "14515";
var point = new GLatLng(43.253611,-77.732778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14516 43.196439 -76.915152
var zip = "14516";
var point = new GLatLng(43.196439,-76.915152);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14517 42.586708 -77.918006
var zip = "14517";
var point = new GLatLng(42.586708,-77.918006);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14518 42.932222 -77.012778
var zip = "14518";
var point = new GLatLng(42.932222,-77.012778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14519 43.229092 -77.308781
var zip = "14519";
var point = new GLatLng(43.229092,-77.308781);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14520 43.225833 -77.306111
var zip = "14520";
var point = new GLatLng(43.225833,-77.306111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14521 42.676979 -76.821575
var zip = "14521";
var point = new GLatLng(42.676979,-76.821575);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14522 43.062192 -77.221798
var zip = "14522";
var point = new GLatLng(43.062192,-77.221798);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14525 42.880088 -78.014698
var zip = "14525";
var point = new GLatLng(42.880088,-78.014698);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14526 43.139638 -77.456043
var zip = "14526";
var point = new GLatLng(43.139638,-77.456043);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14527 42.664548 -77.05687
var zip = "14527";
var point = new GLatLng(42.664548,-77.05687);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14529 42.539722 -77.628611
var zip = "14529";
var point = new GLatLng(42.539722,-77.628611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14530 42.722852 -78.005882
var zip = "14530";
var point = new GLatLng(42.722852,-78.005882);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14532 42.958178 -77.047264
var zip = "14532";
var point = new GLatLng(42.958178,-77.047264);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14533 42.84269 -77.882545
var zip = "14533";
var point = new GLatLng(42.84269,-77.882545);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14534 43.069511 -77.514067
var zip = "14534";
var point = new GLatLng(43.069511,-77.514067);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14536 42.556957 -78.085635
var zip = "14536";
var point = new GLatLng(42.556957,-78.085635);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14537 43.034444 -77.157778
var zip = "14537";
var point = new GLatLng(43.034444,-77.157778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14538 43.279722 -77.186389
var zip = "14538";
var point = new GLatLng(43.279722,-77.186389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14539 42.835278 -77.879167
var zip = "14539";
var point = new GLatLng(42.835278,-77.879167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14541 42.761378 -76.853582
var zip = "14541";
var point = new GLatLng(42.761378,-76.853582);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14542 43.153611 -76.878889
var zip = "14542";
var point = new GLatLng(43.153611,-76.878889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14543 42.998934 -77.665381
var zip = "14543";
var point = new GLatLng(42.998934,-77.665381);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14544 42.75973 -77.239538
var zip = "14544";
var point = new GLatLng(42.75973,-77.239538);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14545 42.658907 -77.682633
var zip = "14545";
var point = new GLatLng(42.658907,-77.682633);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14546 43.02462 -77.774256
var zip = "14546";
var point = new GLatLng(43.02462,-77.774256);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14547 42.886944 -77.096389
var zip = "14547";
var point = new GLatLng(42.886944,-77.096389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14548 42.969034 -77.227312
var zip = "14548";
var point = new GLatLng(42.969034,-77.227312);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14549 42.701667 -78.022222
var zip = "14549";
var point = new GLatLng(42.701667,-78.022222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14550 42.669446 -78.092994
var zip = "14550";
var point = new GLatLng(42.669446,-78.092994);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14551 43.221681 -77.05141
var zip = "14551";
var point = new GLatLng(43.221681,-77.05141);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14555 43.265058 -76.98833
var zip = "14555";
var point = new GLatLng(43.265058,-76.98833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14556 42.678889 -77.8275
var zip = "14556";
var point = new GLatLng(42.678889,-77.8275);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14557 43.048333 -78.065833
var zip = "14557";
var point = new GLatLng(43.048333,-78.065833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14558 42.855278 -77.675556
var zip = "14558";
var point = new GLatLng(42.855278,-77.675556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14559 43.189502 -77.804333
var zip = "14559";
var point = new GLatLng(43.189502,-77.804333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14560 42.677598 -77.577503
var zip = "14560";
var point = new GLatLng(42.677598,-77.577503);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14561 42.830277 -77.120702
var zip = "14561";
var point = new GLatLng(42.830277,-77.120702);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14563 43.222778 -77.371944
var zip = "14563";
var point = new GLatLng(43.222778,-77.371944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14564 42.986597 -77.417982
var zip = "14564";
var point = new GLatLng(42.986597,-77.417982);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14568 43.140161 -77.28582
var zip = "14568";
var point = new GLatLng(43.140161,-77.28582);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14569 42.741035 -78.142899
var zip = "14569";
var point = new GLatLng(42.741035,-78.142899);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14571 43.332563 -78.242958
var zip = "14571";
var point = new GLatLng(43.332563,-78.242958);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14572 42.559274 -77.590613
var zip = "14572";
var point = new GLatLng(42.559274,-77.590613);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14580 43.219563 -77.461587
var zip = "14580";
var point = new GLatLng(43.219563,-77.461587);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14585 42.905833 -77.539444
var zip = "14585";
var point = new GLatLng(42.905833,-77.539444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14586 43.039667 -77.687131
var zip = "14586";
var point = new GLatLng(43.039667,-77.687131);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14588 42.682222 -76.868889
var zip = "14588";
var point = new GLatLng(42.682222,-76.868889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14589 43.242071 -77.170011
var zip = "14589";
var point = new GLatLng(43.242071,-77.170011);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14590 43.234129 -76.821748
var zip = "14590";
var point = new GLatLng(43.234129,-76.821748);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14591 42.83175 -78.083292
var zip = "14591";
var point = new GLatLng(42.83175,-78.083292);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14592 42.871111 -77.885556
var zip = "14592";
var point = new GLatLng(42.871111,-77.885556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14602 43.1683 -77.6026
var zip = "14602";
var point = new GLatLng(43.1683,-77.6026);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14603 43.1615 -77.6073
var zip = "14603";
var point = new GLatLng(43.1615,-77.6073);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14604 43.157729 -77.607978
var zip = "14604";
var point = new GLatLng(43.157729,-77.607978);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14605 43.169758 -77.600711
var zip = "14605";
var point = new GLatLng(43.169758,-77.600711);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14606 43.168455 -77.684488
var zip = "14606";
var point = new GLatLng(43.168455,-77.684488);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14607 43.150086 -77.588976
var zip = "14607";
var point = new GLatLng(43.150086,-77.588976);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14608 43.152144 -77.625803
var zip = "14608";
var point = new GLatLng(43.152144,-77.625803);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14609 43.174001 -77.563701
var zip = "14609";
var point = new GLatLng(43.174001,-77.563701);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14610 43.14524 -77.549501
var zip = "14610";
var point = new GLatLng(43.14524,-77.549501);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14611 43.148375 -77.639353
var zip = "14611";
var point = new GLatLng(43.148375,-77.639353);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14612 43.256576 -77.665228
var zip = "14612";
var point = new GLatLng(43.256576,-77.665228);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14613 43.18308 -77.639276
var zip = "14613";
var point = new GLatLng(43.18308,-77.639276);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14614 43.155823 -77.61419
var zip = "14614";
var point = new GLatLng(43.155823,-77.61419);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14615 43.20575 -77.652118
var zip = "14615";
var point = new GLatLng(43.20575,-77.652118);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14616 43.232359 -77.651238
var zip = "14616";
var point = new GLatLng(43.232359,-77.651238);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14617 43.220258 -77.599442
var zip = "14617";
var point = new GLatLng(43.220258,-77.599442);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14618 43.115416 -77.558801
var zip = "14618";
var point = new GLatLng(43.115416,-77.558801);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14619 43.136685 -77.6481
var zip = "14619";
var point = new GLatLng(43.136685,-77.6481);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14620 43.131711 -77.606239
var zip = "14620";
var point = new GLatLng(43.131711,-77.606239);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14621 43.183362 -77.604284
var zip = "14621";
var point = new GLatLng(43.183362,-77.604284);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14622 43.213959 -77.55549
var zip = "14622";
var point = new GLatLng(43.213959,-77.55549);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14623 43.083371 -77.634412
var zip = "14623";
var point = new GLatLng(43.083371,-77.634412);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14624 43.12589 -77.733552
var zip = "14624";
var point = new GLatLng(43.12589,-77.733552);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14625 43.14949 -77.503188
var zip = "14625";
var point = new GLatLng(43.14949,-77.503188);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14626 43.21257 -77.703996
var zip = "14626";
var point = new GLatLng(43.21257,-77.703996);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14627 43.1284 -77.6295
var zip = "14627";
var point = new GLatLng(43.1284,-77.6295);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14638 43.1572 -77.6064
var zip = "14638";
var point = new GLatLng(43.1572,-77.6064);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14639 43.1572 -77.6064
var zip = "14639";
var point = new GLatLng(43.1572,-77.6064);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14642 43.1242 -77.6231
var zip = "14642";
var point = new GLatLng(43.1242,-77.6231);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14643 43.1572 -77.6064
var zip = "14643";
var point = new GLatLng(43.1572,-77.6064);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14644 43.1572 -77.6064
var zip = "14644";
var point = new GLatLng(43.1572,-77.6064);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14645 43.1572 -77.6064
var zip = "14645";
var point = new GLatLng(43.1572,-77.6064);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14646 43.1572 -77.6064
var zip = "14646";
var point = new GLatLng(43.1572,-77.6064);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14647 43.1572 -77.6064
var zip = "14647";
var point = new GLatLng(43.1572,-77.6064);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14649 43.1572 -77.6064
var zip = "14649";
var point = new GLatLng(43.1572,-77.6064);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14650 43.1541 -77.6255
var zip = "14650";
var point = new GLatLng(43.1541,-77.6255);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14651 43.1541 -77.6255
var zip = "14651";
var point = new GLatLng(43.1541,-77.6255);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14652 43.1541 -77.6255
var zip = "14652";
var point = new GLatLng(43.1541,-77.6255);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14653 43.1541 -77.6255
var zip = "14653";
var point = new GLatLng(43.1541,-77.6255);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14664 43.1572 -77.6064
var zip = "14664";
var point = new GLatLng(43.1572,-77.6064);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14673 43.1572 -77.6064
var zip = "14673";
var point = new GLatLng(43.1572,-77.6064);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14683 43.1572 -77.6064
var zip = "14683";
var point = new GLatLng(43.1572,-77.6064);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14692 43.0869 -77.5973
var zip = "14692";
var point = new GLatLng(43.0869,-77.5973);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14694 43.1541 -77.6255
var zip = "14694";
var point = new GLatLng(43.1541,-77.6255);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14701 42.092845 -79.243989
var zip = "14701";
var point = new GLatLng(42.092845,-79.243989);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14702 42.096944 -79.235556
var zip = "14702";
var point = new GLatLng(42.096944,-79.235556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14706 42.091827 -78.499883
var zip = "14706";
var point = new GLatLng(42.091827,-78.499883);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14707 42.083611 -78.064722
var zip = "14707";
var point = new GLatLng(42.083611,-78.064722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14708 42.016859 -78.040012
var zip = "14708";
var point = new GLatLng(42.016859,-78.040012);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14709 42.326339 -77.994671
var zip = "14709";
var point = new GLatLng(42.326339,-77.994671);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14710 42.108376 -79.405624
var zip = "14710";
var point = new GLatLng(42.108376,-79.405624);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14711 42.320013 -78.094281
var zip = "14711";
var point = new GLatLng(42.320013,-78.094281);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14712 42.151346 -79.35808
var zip = "14712";
var point = new GLatLng(42.151346,-79.35808);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14714 42.285528 -78.231249
var zip = "14714";
var point = new GLatLng(42.285528,-78.231249);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14715 42.070442 -78.144834
var zip = "14715";
var point = new GLatLng(42.070442,-78.144834);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14716 42.393973 -79.43443
var zip = "14716";
var point = new GLatLng(42.393973,-79.43443);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14717 42.370304 -78.197321
var zip = "14717";
var point = new GLatLng(42.370304,-78.197321);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14718 42.350356 -79.299282
var zip = "14718";
var point = new GLatLng(42.350356,-79.299282);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14719 42.333291 -78.888528
var zip = "14719";
var point = new GLatLng(42.333291,-78.888528);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14720 42.109444 -79.283333
var zip = "14720";
var point = new GLatLng(42.109444,-79.283333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14721 41.99939 -78.272686
var zip = "14721";
var point = new GLatLng(41.99939,-78.272686);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14722 42.209722 -79.466944
var zip = "14722";
var point = new GLatLng(42.209722,-79.466944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14723 42.312725 -79.120275
var zip = "14723";
var point = new GLatLng(42.312725,-79.120275);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14724 42.055699 -79.668532
var zip = "14724";
var point = new GLatLng(42.055699,-79.668532);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14726 42.262467 -79.021956
var zip = "14726";
var point = new GLatLng(42.262467,-79.021956);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14727 42.18819 -78.275074
var zip = "14727";
var point = new GLatLng(42.18819,-78.275074);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14728 42.239413 -79.419303
var zip = "14728";
var point = new GLatLng(42.239413,-79.419303);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14729 42.3971 -78.743167
var zip = "14729";
var point = new GLatLng(42.3971,-78.743167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14730 42.172778 -78.948056
var zip = "14730";
var point = new GLatLng(42.172778,-78.948056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14731 42.295873 -78.66064
var zip = "14731";
var point = new GLatLng(42.295873,-78.66064);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14732 42.216667 -79.108056
var zip = "14732";
var point = new GLatLng(42.216667,-79.108056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14733 42.123915 -79.189499
var zip = "14733";
var point = new GLatLng(42.123915,-79.189499);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14735 42.463605 -78.106232
var zip = "14735";
var point = new GLatLng(42.463605,-78.106232);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14736 42.120401 -79.734908
var zip = "14736";
var point = new GLatLng(42.120401,-79.734908);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14737 42.338823 -78.440043
var zip = "14737";
var point = new GLatLng(42.338823,-78.440043);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14738 42.052753 -79.131797
var zip = "14738";
var point = new GLatLng(42.052753,-79.131797);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14739 42.190666 -78.13588
var zip = "14739";
var point = new GLatLng(42.190666,-78.13588);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14740 42.214728 -79.164865
var zip = "14740";
var point = new GLatLng(42.214728,-79.164865);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14741 42.208292 -78.620811
var zip = "14741";
var point = new GLatLng(42.208292,-78.620811);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14742 42.119444 -79.310556
var zip = "14742";
var point = new GLatLng(42.119444,-79.310556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14743 42.179747 -78.400611
var zip = "14743";
var point = new GLatLng(42.179747,-78.400611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14744 42.411567 -78.109506
var zip = "14744";
var point = new GLatLng(42.411567,-78.109506);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14745 42.472778 -78.136667
var zip = "14745";
var point = new GLatLng(42.472778,-78.136667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14747 42.150776 -79.096416
var zip = "14747";
var point = new GLatLng(42.150776,-79.096416);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14748 42.141005 -78.642604
var zip = "14748";
var point = new GLatLng(42.141005,-78.642604);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14750 42.097256 -79.329124
var zip = "14750";
var point = new GLatLng(42.097256,-79.329124);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14751 42.293056 -79.016667
var zip = "14751";
var point = new GLatLng(42.293056,-79.016667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14752 42.351667 -79.324444
var zip = "14752";
var point = new GLatLng(42.351667,-79.324444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14753 42.063945 -78.631979
var zip = "14753";
var point = new GLatLng(42.063945,-78.631979);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14754 42.023964 -78.235056
var zip = "14754";
var point = new GLatLng(42.023964,-78.235056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14755 42.254121 -78.809286
var zip = "14755";
var point = new GLatLng(42.254121,-78.809286);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14756 42.196667 -79.424167
var zip = "14756";
var point = new GLatLng(42.196667,-79.424167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14757 42.240906 -79.496325
var zip = "14757";
var point = new GLatLng(42.240906,-79.496325);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14758 42.0125 -79.449722
var zip = "14758";
var point = new GLatLng(42.0125,-79.449722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14760 42.0787 -78.423265
var zip = "14760";
var point = new GLatLng(42.0787,-78.423265);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14766 42.356111 -78.831944
var zip = "14766";
var point = new GLatLng(42.356111,-78.831944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14767 42.056965 -79.481536
var zip = "14767";
var point = new GLatLng(42.056965,-79.481536);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14769 42.385792 -79.458894
var zip = "14769";
var point = new GLatLng(42.385792,-79.458894);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14770 42.027253 -78.331353
var zip = "14770";
var point = new GLatLng(42.027253,-78.331353);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14772 42.163143 -78.960034
var zip = "14772";
var point = new GLatLng(42.163143,-78.960034);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14774 42.088333 -78.153611
var zip = "14774";
var point = new GLatLng(42.088333,-78.153611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14775 42.248175 -79.712103
var zip = "14775";
var point = new GLatLng(42.248175,-79.712103);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14777 42.417216 -78.186704
var zip = "14777";
var point = new GLatLng(42.417216,-78.186704);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14778 42.086111 -78.476944
var zip = "14778";
var point = new GLatLng(42.086111,-78.476944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14779 42.16035 -78.73042
var zip = "14779";
var point = new GLatLng(42.16035,-78.73042);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14781 42.163124 -79.585742
var zip = "14781";
var point = new GLatLng(42.163124,-79.585742);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14782 42.24548 -79.267297
var zip = "14782";
var point = new GLatLng(42.24548,-79.267297);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14783 42.108056 -78.904444
var zip = "14783";
var point = new GLatLng(42.108056,-78.904444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14784 42.318195 -79.375792
var zip = "14784";
var point = new GLatLng(42.318195,-79.375792);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14785 42.156667 -79.401667
var zip = "14785";
var point = new GLatLng(42.156667,-79.401667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14786 42.128056 -78.243333
var zip = "14786";
var point = new GLatLng(42.128056,-78.243333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14787 42.321977 -79.572646
var zip = "14787";
var point = new GLatLng(42.321977,-79.572646);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14788 42.062222 -78.3775
var zip = "14788";
var point = new GLatLng(42.062222,-78.3775);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14801 42.09825 -77.266027
var zip = "14801";
var point = new GLatLng(42.09825,-77.266027);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14802 42.255165 -77.79295
var zip = "14802";
var point = new GLatLng(42.255165,-77.79295);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14803 42.255799 -77.778084
var zip = "14803";
var point = new GLatLng(42.255799,-77.778084);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14804 42.316036 -77.777965
var zip = "14804";
var point = new GLatLng(42.316036,-77.777965);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14805 42.351014 -76.734775
var zip = "14805";
var point = new GLatLng(42.351014,-76.734775);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14806 42.157454 -77.792008
var zip = "14806";
var point = new GLatLng(42.157454,-77.792008);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14807 42.422466 -77.691778
var zip = "14807";
var point = new GLatLng(42.422466,-77.691778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14808 42.556269 -77.480091
var zip = "14808";
var point = new GLatLng(42.556269,-77.480091);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14809 42.41513 -77.434254
var zip = "14809";
var point = new GLatLng(42.41513,-77.434254);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14810 42.345451 -77.323255
var zip = "14810";
var point = new GLatLng(42.345451,-77.323255);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14812 42.279763 -76.971953
var zip = "14812";
var point = new GLatLng(42.279763,-76.971953);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14813 42.233409 -78.01103
var zip = "14813";
var point = new GLatLng(42.233409,-78.01103);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14814 42.145509 -76.952721
var zip = "14814";
var point = new GLatLng(42.145509,-76.952721);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14815 42.382517 -77.09134
var zip = "14815";
var point = new GLatLng(42.382517,-77.09134);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14816 42.19392 -76.73612
var zip = "14816";
var point = new GLatLng(42.19392,-76.73612);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14817 42.37653 -76.366844
var zip = "14817";
var point = new GLatLng(42.37653,-76.366844);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14818 42.439442 -76.829219
var zip = "14818";
var point = new GLatLng(42.439442,-76.829219);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14819 42.21284 -77.440341
var zip = "14819";
var point = new GLatLng(42.21284,-77.440341);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14820 42.192547 -77.364976
var zip = "14820";
var point = new GLatLng(42.192547,-77.364976);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14821 42.238569 -77.206619
var zip = "14821";
var point = new GLatLng(42.238569,-77.206619);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14822 42.458504 -77.795374
var zip = "14822";
var point = new GLatLng(42.458504,-77.795374);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14823 42.263503 -77.589706
var zip = "14823";
var point = new GLatLng(42.263503,-77.589706);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14824 42.277445 -76.697367
var zip = "14824";
var point = new GLatLng(42.277445,-76.697367);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14825 42.039243 -76.620224
var zip = "14825";
var point = new GLatLng(42.039243,-76.620224);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14826 42.500315 -77.499763
var zip = "14826";
var point = new GLatLng(42.500315,-77.499763);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14827 42.182222 -77.141944
var zip = "14827";
var point = new GLatLng(42.182222,-77.141944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14830 42.138331 -77.047546
var zip = "14830";
var point = new GLatLng(42.138331,-77.047546);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14831 42.142778 -77.055
var zip = "14831";
var point = new GLatLng(42.142778,-77.055);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14836 42.544895 -77.928889
var zip = "14836";
var point = new GLatLng(42.544895,-77.928889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14837 42.505261 -77.002773
var zip = "14837";
var point = new GLatLng(42.505261,-77.002773);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14838 42.185898 -76.681942
var zip = "14838";
var point = new GLatLng(42.185898,-76.681942);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14839 42.139809 -77.636041
var zip = "14839";
var point = new GLatLng(42.139809,-77.636041);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14840 42.431217 -77.197702
var zip = "14840";
var point = new GLatLng(42.431217,-77.197702);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14841 42.49658 -76.878597
var zip = "14841";
var point = new GLatLng(42.49658,-76.878597);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14842 42.594455 -76.950774
var zip = "14842";
var point = new GLatLng(42.594455,-76.950774);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14843 42.327393 -77.656907
var zip = "14843";
var point = new GLatLng(42.327393,-77.656907);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14845 42.180493 -76.834539
var zip = "14845";
var point = new GLatLng(42.180493,-76.834539);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14846 42.538821 -77.981839
var zip = "14846";
var point = new GLatLng(42.538821,-77.981839);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14847 42.616524 -76.726798
var zip = "14847";
var point = new GLatLng(42.616524,-76.726798);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14850 42.448497 -76.492911
var zip = "14850";
var point = new GLatLng(42.448497,-76.492911);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14851 42.4355 -76.5014
var zip = "14851";
var point = new GLatLng(42.4355,-76.5014);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14852 42.5047 -76.4712
var zip = "14852";
var point = new GLatLng(42.5047,-76.4712);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14853 42.443087 -76.488707
var zip = "14853";
var point = new GLatLng(42.443087,-76.488707);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14854 42.508333 -76.615278
var zip = "14854";
var point = new GLatLng(42.508333,-76.615278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14855 42.128962 -77.499909
var zip = "14855";
var point = new GLatLng(42.128962,-77.499909);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14856 42.372222 -77.366111
var zip = "14856";
var point = new GLatLng(42.372222,-77.366111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14857 42.516111 -76.928333
var zip = "14857";
var point = new GLatLng(42.516111,-76.928333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14858 42.042483 -77.154132
var zip = "14858";
var point = new GLatLng(42.042483,-77.154132);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14859 42.114943 -76.536618
var zip = "14859";
var point = new GLatLng(42.114943,-76.536618);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14860 42.596555 -76.833904
var zip = "14860";
var point = new GLatLng(42.596555,-76.833904);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14861 42.06938 -76.693005
var zip = "14861";
var point = new GLatLng(42.06938,-76.693005);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14863 42.4575 -76.710556
var zip = "14863";
var point = new GLatLng(42.4575,-76.710556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14864 42.258084 -76.839233
var zip = "14864";
var point = new GLatLng(42.258084,-76.839233);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14865 42.343678 -76.839581
var zip = "14865";
var point = new GLatLng(42.343678,-76.839581);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14867 42.362137 -76.591978
var zip = "14867";
var point = new GLatLng(42.362137,-76.591978);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14869 42.360947 -76.771698
var zip = "14869";
var point = new GLatLng(42.360947,-76.771698);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14870 42.170967 -77.119375
var zip = "14870";
var point = new GLatLng(42.170967,-77.119375);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14871 42.041938 -76.881519
var zip = "14871";
var point = new GLatLng(42.041938,-76.881519);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14872 42.234795 -76.865206
var zip = "14872";
var point = new GLatLng(42.234795,-76.865206);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14873 42.526918 -77.282455
var zip = "14873";
var point = new GLatLng(42.526918,-77.282455);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14874 42.523275 -77.169108
var zip = "14874";
var point = new GLatLng(42.523275,-77.169108);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14876 42.430278 -76.933056
var zip = "14876";
var point = new GLatLng(42.430278,-76.933056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14877 42.072645 -77.676663
var zip = "14877";
var point = new GLatLng(42.072645,-77.676663);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//14878 42.448511 -76.936436
var zip = "14878";
var point = new GLatLng(42.448511,-76.936436);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14879 42.30407 -77.208345
var zip = "14879";
var point = new GLatLng(42.30407,-77.208345);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14880 42.169703 -77.990026
var zip = "14880";
var point = new GLatLng(42.169703,-77.990026);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14881 42.401119 -76.315677
var zip = "14881";
var point = new GLatLng(42.401119,-76.315677);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14882 42.564494 -76.537455
var zip = "14882";
var point = new GLatLng(42.564494,-76.537455);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14883 42.246736 -76.489853
var zip = "14883";
var point = new GLatLng(42.246736,-76.489853);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14884 42.477314 -77.88899
var zip = "14884";
var point = new GLatLng(42.477314,-77.88899);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14885 42.050083 -77.550208
var zip = "14885";
var point = new GLatLng(42.050083,-77.550208);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14886 42.520987 -76.668145
var zip = "14886";
var point = new GLatLng(42.520987,-76.668145);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14887 42.408056 -77.058611
var zip = "14887";
var point = new GLatLng(42.408056,-77.058611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//14889 42.208455 -76.571663
var zip = "14889";
var point = new GLatLng(42.208455,-76.571663);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14891 42.377121 -76.90215
var zip = "14891";
var point = new GLatLng(42.377121,-76.90215);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14892 42.017228 -76.533308
var zip = "14892";
var point = new GLatLng(42.017228,-76.533308);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//14893 42.470278 -77.105556
var zip = "14893";
var point = new GLatLng(42.470278,-77.105556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14894 42.027317 -76.772315
var zip = "14894";
var point = new GLatLng(42.027317,-76.772315);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14895 42.110757 -77.94191
var zip = "14895";
var point = new GLatLng(42.110757,-77.94191);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14897 42.045586 -77.810615
var zip = "14897";
var point = new GLatLng(42.045586,-77.810615);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14898 42.073638 -77.420333
var zip = "14898";
var point = new GLatLng(42.073638,-77.420333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14901 42.100769 -76.811977
var zip = "14901";
var point = new GLatLng(42.100769,-76.811977);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14902 42.0909 -76.8061
var zip = "14902";
var point = new GLatLng(42.0909,-76.8061);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14903 42.130203 -76.843572
var zip = "14903";
var point = new GLatLng(42.130203,-76.843572);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//14904 42.072866 -76.803735
var zip = "14904";
var point = new GLatLng(42.072866,-76.803735);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//14905 42.086919 -76.839686
var zip = "14905";
var point = new GLatLng(42.086919,-76.839686);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//14925 42.1146 -76.8055
var zip = "14925";
var point = new GLatLng(42.1146,-76.8055);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//10065 40.7142691 -74.0059729
var zip = "10065";
var point = new GLatLng(40.7142691,-74.0059729);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//10075 40.7142691 -74.0059729
var zip = "10075";
var point = new GLatLng(40.7142691,-74.0059729);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//00501 40.8152 -73.0455
var zip = "00501";
var point = new GLatLng(40.8152,-73.0455);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//00544 40.8152 -73.0455
var zip = "00544";
var point = new GLatLng(40.8152,-73.0455);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15001 40.604424 -80.281567
var zip = "15001";
var point = new GLatLng(40.604424,-80.281567);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15003 40.595368 -80.219778
var zip = "15003";
var point = new GLatLng(40.595368,-80.219778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15004 40.341111 -80.383056
var zip = "15004";
var point = new GLatLng(40.341111,-80.383056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15005 40.641595 -80.198471
var zip = "15005";
var point = new GLatLng(40.641595,-80.198471);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15006 40.631111 -79.881667
var zip = "15006";
var point = new GLatLng(40.631111,-79.881667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15007 40.647826 -79.930956
var zip = "15007";
var point = new GLatLng(40.647826,-79.930956);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15009 40.697184 -80.336528
var zip = "15009";
var point = new GLatLng(40.697184,-80.336528);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15010 40.766234 -80.33988
var zip = "15010";
var point = new GLatLng(40.766234,-80.33988);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15012 40.14368 -79.83454
var zip = "15012";
var point = new GLatLng(40.14368,-79.83454);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15014 40.608223 -79.741375
var zip = "15014";
var point = new GLatLng(40.608223,-79.741375);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15015 40.634175 -80.082305
var zip = "15015";
var point = new GLatLng(40.634175,-80.082305);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15017 40.347195 -80.115293
var zip = "15017";
var point = new GLatLng(40.347195,-80.115293);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15018 40.278635 -79.791874
var zip = "15018";
var point = new GLatLng(40.278635,-79.791874);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15019 40.405119 -80.362192
var zip = "15019";
var point = new GLatLng(40.405119,-80.362192);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15020 40.237222 -79.950833
var zip = "15020";
var point = new GLatLng(40.237222,-79.950833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15021 40.390114 -80.444485
var zip = "15021";
var point = new GLatLng(40.390114,-80.444485);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15022 40.140402 -79.92002
var zip = "15022";
var point = new GLatLng(40.140402,-79.92002);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15024 40.568117 -79.841002
var zip = "15024";
var point = new GLatLng(40.568117,-79.841002);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15025 40.298917 -79.910096
var zip = "15025";
var point = new GLatLng(40.298917,-79.910096);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15026 40.513148 -80.342282
var zip = "15026";
var point = new GLatLng(40.513148,-80.342282);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15027 40.664917 -80.234899
var zip = "15027";
var point = new GLatLng(40.664917,-80.234899);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15028 40.303056 -79.794444
var zip = "15028";
var point = new GLatLng(40.303056,-79.794444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15030 40.582051 -79.78177
var zip = "15030";
var point = new GLatLng(40.582051,-79.78177);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15031 40.360069 -80.164432
var zip = "15031";
var point = new GLatLng(40.360069,-80.164432);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15032 40.642222 -79.851111
var zip = "15032";
var point = new GLatLng(40.642222,-79.851111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15033 40.176821 -79.861858
var zip = "15033";
var point = new GLatLng(40.176821,-79.861858);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15034 40.352676 -79.889461
var zip = "15034";
var point = new GLatLng(40.352676,-79.889461);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15035 40.383944 -79.807881
var zip = "15035";
var point = new GLatLng(40.383944,-79.807881);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15037 40.265575 -79.856842
var zip = "15037";
var point = new GLatLng(40.265575,-79.856842);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15038 40.251944 -79.925278
var zip = "15038";
var point = new GLatLng(40.251944,-79.925278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15042 40.683023 -80.214663
var zip = "15042";
var point = new GLatLng(40.683023,-80.214663);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15043 40.574275 -80.490023
var zip = "15043";
var point = new GLatLng(40.574275,-80.490023);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15044 40.625233 -79.944307
var zip = "15044";
var point = new GLatLng(40.625233,-79.944307);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15045 40.325952 -79.888324
var zip = "15045";
var point = new GLatLng(40.325952,-79.888324);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15046 40.5575 -80.230278
var zip = "15046";
var point = new GLatLng(40.5575,-80.230278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15047 40.312222 -79.806944
var zip = "15047";
var point = new GLatLng(40.312222,-79.806944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15049 40.557433 -79.805115
var zip = "15049";
var point = new GLatLng(40.557433,-79.805115);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15050 40.542929 -80.436268
var zip = "15050";
var point = new GLatLng(40.542929,-80.436268);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15051 40.576605 -79.881765
var zip = "15051";
var point = new GLatLng(40.576605,-79.881765);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15052 40.667101 -80.415085
var zip = "15052";
var point = new GLatLng(40.667101,-80.415085);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15053 40.381027 -80.391542
var zip = "15053";
var point = new GLatLng(40.381027,-80.391542);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15054 40.365 -80.414167
var zip = "15054";
var point = new GLatLng(40.365,-80.414167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15055 40.311615 -80.144029
var zip = "15055";
var point = new GLatLng(40.311615,-80.144029);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15056 40.566165 -80.209874
var zip = "15056";
var point = new GLatLng(40.566165,-80.209874);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15057 40.369664 -80.256204
var zip = "15057";
var point = new GLatLng(40.369664,-80.256204);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15059 40.658962 -80.468952
var zip = "15059";
var point = new GLatLng(40.658962,-80.468952);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15060 40.367974 -80.29209
var zip = "15060";
var point = new GLatLng(40.367974,-80.29209);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15061 40.671847 -80.291743
var zip = "15061";
var point = new GLatLng(40.671847,-80.291743);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15062 40.152379 -79.883526
var zip = "15062";
var point = new GLatLng(40.152379,-79.883526);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15063 40.193728 -79.924127
var zip = "15063";
var point = new GLatLng(40.193728,-79.924127);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15064 40.360433 -80.154064
var zip = "15064";
var point = new GLatLng(40.360433,-80.154064);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15065 40.628862 -79.725621
var zip = "15065";
var point = new GLatLng(40.628862,-79.725621);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15066 40.739333 -80.29722
var zip = "15066";
var point = new GLatLng(40.739333,-80.29722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15067 40.206573 -79.953408
var zip = "15067";
var point = new GLatLng(40.206573,-79.953408);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15068 40.571179 -79.741547
var zip = "15068";
var point = new GLatLng(40.571179,-79.741547);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15069 40.569722 -79.765
var zip = "15069";
var point = new GLatLng(40.569722,-79.765);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15071 40.428734 -80.202615
var zip = "15071";
var point = new GLatLng(40.428734,-80.202615);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15072 40.131389 -79.844444
var zip = "15072";
var point = new GLatLng(40.131389,-79.844444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15074 40.715745 -80.260315
var zip = "15074";
var point = new GLatLng(40.715745,-80.260315);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15075 40.585556 -79.828889
var zip = "15075";
var point = new GLatLng(40.585556,-79.828889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15076 40.614344 -79.837102
var zip = "15076";
var point = new GLatLng(40.614344,-79.837102);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15077 40.626012 -80.419866
var zip = "15077";
var point = new GLatLng(40.626012,-80.419866);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15078 40.363086 -80.399239
var zip = "15078";
var point = new GLatLng(40.363086,-80.399239);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15081 40.573611 -80.235833
var zip = "15081";
var point = new GLatLng(40.573611,-80.235833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15082 40.384722 -80.211111
var zip = "15082";
var point = new GLatLng(40.384722,-80.211111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15083 40.238207 -79.792223
var zip = "15083";
var point = new GLatLng(40.238207,-79.792223);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15084 40.618651 -79.785204
var zip = "15084";
var point = new GLatLng(40.618651,-79.785204);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15085 40.385155 -79.755157
var zip = "15085";
var point = new GLatLng(40.385155,-79.755157);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15086 40.664149 -80.080705
var zip = "15086";
var point = new GLatLng(40.664149,-80.080705);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15087 40.185 -79.848889
var zip = "15087";
var point = new GLatLng(40.185,-79.848889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15088 40.270833 -79.899444
var zip = "15088";
var point = new GLatLng(40.270833,-79.899444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15089 40.207549 -79.757976
var zip = "15089";
var point = new GLatLng(40.207549,-79.757976);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15090 40.612044 -80.064879
var zip = "15090";
var point = new GLatLng(40.612044,-80.064879);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15091 40.594167 -79.970278
var zip = "15091";
var point = new GLatLng(40.594167,-79.970278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15095 40.6533 -80.0797
var zip = "15095";
var point = new GLatLng(40.6533,-80.0797);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15096 40.6533 -80.0797
var zip = "15096";
var point = new GLatLng(40.6533,-80.0797);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15101 40.569975 -79.966512
var zip = "15101";
var point = new GLatLng(40.569975,-79.966512);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15102 40.320984 -80.039793
var zip = "15102";
var point = new GLatLng(40.320984,-80.039793);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15104 40.406304 -79.864352
var zip = "15104";
var point = new GLatLng(40.406304,-79.864352);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15106 40.402941 -80.091532
var zip = "15106";
var point = new GLatLng(40.402941,-80.091532);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15108 40.513245 -80.18969
var zip = "15108";
var point = new GLatLng(40.513245,-80.18969);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15110 40.370449 -79.852244
var zip = "15110";
var point = new GLatLng(40.370449,-79.852244);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15112 40.403577 -79.83889
var zip = "15112";
var point = new GLatLng(40.403577,-79.83889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15116 40.537492 -79.964351
var zip = "15116";
var point = new GLatLng(40.537492,-79.964351);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15120 40.394171 -79.904199
var zip = "15120";
var point = new GLatLng(40.394171,-79.904199);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15122 40.366535 -79.89429
var zip = "15122";
var point = new GLatLng(40.366535,-79.89429);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15123 40.363333 -79.866667
var zip = "15123";
var point = new GLatLng(40.363333,-79.866667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15126 40.458384 -80.264861
var zip = "15126";
var point = new GLatLng(40.458384,-80.264861);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15127 40.580833 -80.061111
var zip = "15127";
var point = new GLatLng(40.580833,-80.061111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15129 40.292199 -80.001144
var zip = "15129";
var point = new GLatLng(40.292199,-80.001144);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15131 40.341147 -79.810519
var zip = "15131";
var point = new GLatLng(40.341147,-79.810519);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15132 40.341713 -79.8452
var zip = "15132";
var point = new GLatLng(40.341713,-79.8452);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15133 40.332835 -79.866759
var zip = "15133";
var point = new GLatLng(40.332835,-79.866759);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15134 40.338333 -79.839722
var zip = "15134";
var point = new GLatLng(40.338333,-79.839722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15135 40.304412 -79.812844
var zip = "15135";
var point = new GLatLng(40.304412,-79.812844);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15136 40.471742 -80.087567
var zip = "15136";
var point = new GLatLng(40.471742,-80.087567);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15137 40.376248 -79.812427
var zip = "15137";
var point = new GLatLng(40.376248,-79.812427);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15139 40.519647 -79.836865
var zip = "15139";
var point = new GLatLng(40.519647,-79.836865);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15140 40.404787 -79.776951
var zip = "15140";
var point = new GLatLng(40.404787,-79.776951);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15142 40.384664 -80.120922
var zip = "15142";
var point = new GLatLng(40.384664,-80.120922);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15143 40.557031 -80.157848
var zip = "15143";
var point = new GLatLng(40.557031,-80.157848);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15144 40.543999 -79.784447
var zip = "15144";
var point = new GLatLng(40.543999,-79.784447);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15145 40.41135 -79.822046
var zip = "15145";
var point = new GLatLng(40.41135,-79.822046);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15146 40.429026 -79.762279
var zip = "15146";
var point = new GLatLng(40.429026,-79.762279);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15147 40.492727 -79.834535
var zip = "15147";
var point = new GLatLng(40.492727,-79.834535);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15148 40.393416 -79.803033
var zip = "15148";
var point = new GLatLng(40.393416,-79.803033);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15201 40.474536 -79.952524
var zip = "15201";
var point = new GLatLng(40.474536,-79.952524);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15202 40.501321 -80.066966
var zip = "15202";
var point = new GLatLng(40.501321,-80.066966);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15203 40.425439 -79.977556
var zip = "15203";
var point = new GLatLng(40.425439,-79.977556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15204 40.455569 -80.061056
var zip = "15204";
var point = new GLatLng(40.455569,-80.061056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15205 40.438045 -80.073393
var zip = "15205";
var point = new GLatLng(40.438045,-80.073393);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15206 40.468885 -79.919267
var zip = "15206";
var point = new GLatLng(40.468885,-79.919267);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15207 40.401206 -79.933935
var zip = "15207";
var point = new GLatLng(40.401206,-79.933935);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15208 40.454955 -79.898474
var zip = "15208";
var point = new GLatLng(40.454955,-79.898474);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15209 40.49718 -79.97401
var zip = "15209";
var point = new GLatLng(40.49718,-79.97401);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15210 40.408541 -79.987405
var zip = "15210";
var point = new GLatLng(40.408541,-79.987405);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15211 40.42908 -80.012156
var zip = "15211";
var point = new GLatLng(40.42908,-80.012156);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15212 40.468873 -80.013128
var zip = "15212";
var point = new GLatLng(40.468873,-80.013128);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15213 40.44372 -79.954428
var zip = "15213";
var point = new GLatLng(40.44372,-79.954428);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15214 40.481309 -80.01393
var zip = "15214";
var point = new GLatLng(40.481309,-80.01393);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15215 40.499225 -79.917513
var zip = "15215";
var point = new GLatLng(40.499225,-79.917513);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15216 40.399584 -80.035727
var zip = "15216";
var point = new GLatLng(40.399584,-80.035727);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15217 40.431852 -79.924973
var zip = "15217";
var point = new GLatLng(40.431852,-79.924973);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15218 40.424468 -79.887591
var zip = "15218";
var point = new GLatLng(40.424468,-79.887591);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15219 40.44539 -79.977229
var zip = "15219";
var point = new GLatLng(40.44539,-79.977229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15220 40.417405 -80.051202
var zip = "15220";
var point = new GLatLng(40.417405,-80.051202);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15221 40.438352 -79.870243
var zip = "15221";
var point = new GLatLng(40.438352,-79.870243);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15222 40.442111 -80.000556
var zip = "15222";
var point = new GLatLng(40.442111,-80.000556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15223 40.50428 -79.95145
var zip = "15223";
var point = new GLatLng(40.50428,-79.95145);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15224 40.464215 -79.945445
var zip = "15224";
var point = new GLatLng(40.464215,-79.945445);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15225 40.513819 -80.137027
var zip = "15225";
var point = new GLatLng(40.513819,-80.137027);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15226 40.394628 -80.015759
var zip = "15226";
var point = new GLatLng(40.394628,-80.015759);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15227 40.37619 -79.975816
var zip = "15227";
var point = new GLatLng(40.37619,-79.975816);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15228 40.371326 -80.043186
var zip = "15228";
var point = new GLatLng(40.371326,-80.043186);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15229 40.519321 -80.035685
var zip = "15229";
var point = new GLatLng(40.519321,-80.035685);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15230 40.5085 -80.0786
var zip = "15230";
var point = new GLatLng(40.5085,-80.0786);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15231 40.502778 -80.188333
var zip = "15231";
var point = new GLatLng(40.502778,-80.188333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15232 40.453598 -79.932557
var zip = "15232";
var point = new GLatLng(40.453598,-79.932557);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15233 40.460425 -80.029965
var zip = "15233";
var point = new GLatLng(40.460425,-80.029965);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15234 40.369424 -80.017907
var zip = "15234";
var point = new GLatLng(40.369424,-80.017907);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15235 40.4605 -79.826892
var zip = "15235";
var point = new GLatLng(40.4605,-79.826892);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15236 40.345244 -79.976894
var zip = "15236";
var point = new GLatLng(40.345244,-79.976894);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15237 40.552238 -80.034939
var zip = "15237";
var point = new GLatLng(40.552238,-80.034939);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15238 40.515077 -79.877423
var zip = "15238";
var point = new GLatLng(40.515077,-79.877423);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15239 40.477693 -79.734505
var zip = "15239";
var point = new GLatLng(40.477693,-79.734505);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15240 40.4405 -79.9961
var zip = "15240";
var point = new GLatLng(40.4405,-79.9961);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15241 40.332174 -80.07921
var zip = "15241";
var point = new GLatLng(40.332174,-80.07921);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15242 40.420278 -80.05
var zip = "15242";
var point = new GLatLng(40.420278,-80.05);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15243 40.373797 -80.072425
var zip = "15243";
var point = new GLatLng(40.373797,-80.072425);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15244 40.444444 -80.146111
var zip = "15244";
var point = new GLatLng(40.444444,-80.146111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15250 40.4432 -79.955
var zip = "15250";
var point = new GLatLng(40.4432,-79.955);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15251 40.4432 -79.955
var zip = "15251";
var point = new GLatLng(40.4432,-79.955);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15252 40.4432 -79.955
var zip = "15252";
var point = new GLatLng(40.4432,-79.955);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15253 40.4432 -79.955
var zip = "15253";
var point = new GLatLng(40.4432,-79.955);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15254 40.4432 -79.955
var zip = "15254";
var point = new GLatLng(40.4432,-79.955);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15255 40.4432 -79.9818
var zip = "15255";
var point = new GLatLng(40.4432,-79.9818);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15257 40.4432 -79.955
var zip = "15257";
var point = new GLatLng(40.4432,-79.955);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15258 40.4432 -79.955
var zip = "15258";
var point = new GLatLng(40.4432,-79.955);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15259 40.4432 -79.955
var zip = "15259";
var point = new GLatLng(40.4432,-79.955);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15260 40.4424 -79.9507
var zip = "15260";
var point = new GLatLng(40.4424,-79.9507);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15261 40.4442 -79.9617
var zip = "15261";
var point = new GLatLng(40.4442,-79.9617);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15262 40.4983 -80.0618
var zip = "15262";
var point = new GLatLng(40.4983,-80.0618);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15263 40.4432 -79.9818
var zip = "15263";
var point = new GLatLng(40.4432,-79.9818);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15264 40.4432 -79.955
var zip = "15264";
var point = new GLatLng(40.4432,-79.955);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15265 40.4473 -79.9939
var zip = "15265";
var point = new GLatLng(40.4473,-79.9939);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15267 40.4432 -79.9818
var zip = "15267";
var point = new GLatLng(40.4432,-79.9818);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15268 40.4983 -80.0618
var zip = "15268";
var point = new GLatLng(40.4983,-80.0618);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15270 40.4036 -80.0344
var zip = "15270";
var point = new GLatLng(40.4036,-80.0344);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15272 40.4473 -79.9939
var zip = "15272";
var point = new GLatLng(40.4473,-79.9939);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15274 40.4432 -79.955
var zip = "15274";
var point = new GLatLng(40.4432,-79.955);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15275 40.4513 -80.1788
var zip = "15275";
var point = new GLatLng(40.4513,-80.1788);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15276 40.4292 -80.1253
var zip = "15276";
var point = new GLatLng(40.4292,-80.1253);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15277 40.4405 -79.9961
var zip = "15277";
var point = new GLatLng(40.4405,-79.9961);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15278 40.4983 -80.0618
var zip = "15278";
var point = new GLatLng(40.4983,-80.0618);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15279 40.4432 -79.9818
var zip = "15279";
var point = new GLatLng(40.4432,-79.9818);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15281 40.4432 -79.9818
var zip = "15281";
var point = new GLatLng(40.4432,-79.9818);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15282 40.4371 -79.9929
var zip = "15282";
var point = new GLatLng(40.4371,-79.9929);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15283 40.4199 -80.0499
var zip = "15283";
var point = new GLatLng(40.4199,-80.0499);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15285 40.4405 -79.9961
var zip = "15285";
var point = new GLatLng(40.4405,-79.9961);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15286 40.4983 -80.0618
var zip = "15286";
var point = new GLatLng(40.4983,-80.0618);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15289 40.4406 -79.9961
var zip = "15289";
var point = new GLatLng(40.4406,-79.9961);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15290 40.4983 -80.0618
var zip = "15290";
var point = new GLatLng(40.4983,-80.0618);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15295 40.4747 -79.9521
var zip = "15295";
var point = new GLatLng(40.4747,-79.9521);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15301 40.171687 -80.255957
var zip = "15301";
var point = new GLatLng(40.171687,-80.255957);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15310 39.824647 -80.457918
var zip = "15310";
var point = new GLatLng(39.824647,-80.457918);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15311 40.061786 -80.194865
var zip = "15311";
var point = new GLatLng(40.061786,-80.194865);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15312 40.273386 -80.456503
var zip = "15312";
var point = new GLatLng(40.273386,-80.456503);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15313 40.064503 -80.025056
var zip = "15313";
var point = new GLatLng(40.064503,-80.025056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15314 40.118702 -80.006987
var zip = "15314";
var point = new GLatLng(40.118702,-80.006987);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15315 39.761111 -79.981667
var zip = "15315";
var point = new GLatLng(39.761111,-79.981667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15316 39.724722 -80.260278
var zip = "15316";
var point = new GLatLng(39.724722,-80.260278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15317 40.270743 -80.153153
var zip = "15317";
var point = new GLatLng(40.270743,-80.153153);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15320 39.882548 -79.971007
var zip = "15320";
var point = new GLatLng(39.882548,-79.971007);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15321 40.322813 -80.20437
var zip = "15321";
var point = new GLatLng(40.322813,-80.20437);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15322 39.994064 -80.012386
var zip = "15322";
var point = new GLatLng(39.994064,-80.012386);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15323 40.137557 -80.385904
var zip = "15323";
var point = new GLatLng(40.137557,-80.385904);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15324 40.100801 -80.065152
var zip = "15324";
var point = new GLatLng(40.100801,-80.065152);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15325 39.948333 -79.965
var zip = "15325";
var point = new GLatLng(39.948333,-79.965);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15327 39.755536 -79.977135
var zip = "15327";
var point = new GLatLng(39.755536,-79.977135);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15329 40.0224 -80.261257
var zip = "15329";
var point = new GLatLng(40.0224,-80.261257);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15330 40.186821 -80.062695
var zip = "15330";
var point = new GLatLng(40.186821,-80.062695);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15331 40.107321 -80.020364
var zip = "15331";
var point = new GLatLng(40.107321,-80.020364);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15332 40.259301 -79.97531
var zip = "15332";
var point = new GLatLng(40.259301,-79.97531);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15333 40.023749 -80.030937
var zip = "15333";
var point = new GLatLng(40.023749,-80.030937);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15334 39.815833 -80.026667
var zip = "15334";
var point = new GLatLng(39.815833,-80.026667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15336 40.257222 -79.996111
var zip = "15336";
var point = new GLatLng(40.257222,-79.996111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15337 39.909165 -80.395223
var zip = "15337";
var point = new GLatLng(39.909165,-80.395223);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15338 39.804482 -79.93992
var zip = "15338";
var point = new GLatLng(39.804482,-79.93992);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15339 40.299167 -80.1525
var zip = "15339";
var point = new GLatLng(40.299167,-80.1525);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15340 40.292511 -80.302508
var zip = "15340";
var point = new GLatLng(40.292511,-80.302508);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15341 39.848878 -80.338455
var zip = "15341";
var point = new GLatLng(39.848878,-80.338455);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15342 40.242492 -80.220937
var zip = "15342";
var point = new GLatLng(40.242492,-80.220937);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15344 39.933391 -80.050286
var zip = "15344";
var point = new GLatLng(39.933391,-80.050286);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15345 40.033067 -80.114506
var zip = "15345";
var point = new GLatLng(40.033067,-80.114506);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15346 39.945226 -80.085353
var zip = "15346";
var point = new GLatLng(39.945226,-80.085353);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15347 40.219167 -80.220833
var zip = "15347";
var point = new GLatLng(40.219167,-80.220833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15348 39.986667 -79.993889
var zip = "15348";
var point = new GLatLng(39.986667,-79.993889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15349 39.744289 -80.096763
var zip = "15349";
var point = new GLatLng(39.744289,-80.096763);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15350 40.292778 -80.200556
var zip = "15350";
var point = new GLatLng(40.292778,-80.200556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15351 39.878333 -79.925
var zip = "15351";
var point = new GLatLng(39.878333,-79.925);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15352 39.750728 -80.454228
var zip = "15352";
var point = new GLatLng(39.750728,-80.454228);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15353 39.974328 -80.312809
var zip = "15353";
var point = new GLatLng(39.974328,-80.312809);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15357 39.943993 -79.985701
var zip = "15357";
var point = new GLatLng(39.943993,-79.985701);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15358 40.053333 -80.002222
var zip = "15358";
var point = new GLatLng(40.053333,-80.002222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15359 39.900515 -80.283665
var zip = "15359";
var point = new GLatLng(39.900515,-80.283665);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15360 40.099378 -80.091414
var zip = "15360";
var point = new GLatLng(40.099378,-80.091414);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15361 40.327778 -80.259167
var zip = "15361";
var point = new GLatLng(40.327778,-80.259167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15362 39.761038 -80.262186
var zip = "15362";
var point = new GLatLng(39.761038,-80.262186);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15363 40.216914 -80.146156
var zip = "15363";
var point = new GLatLng(40.216914,-80.146156);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15364 39.95273 -80.228199
var zip = "15364";
var point = new GLatLng(39.95273,-80.228199);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15365 40.159722 -80.378333
var zip = "15365";
var point = new GLatLng(40.159722,-80.378333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15366 40.156111 -79.974444
var zip = "15366";
var point = new GLatLng(40.156111,-79.974444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15367 40.275451 -80.059849
var zip = "15367";
var point = new GLatLng(40.275451,-80.059849);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15368 40.016111 -79.99
var zip = "15368";
var point = new GLatLng(40.016111,-79.99);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15370 39.891691 -80.179524
var zip = "15370";
var point = new GLatLng(39.891691,-80.179524);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15376 40.106514 -80.497769
var zip = "15376";
var point = new GLatLng(40.106514,-80.497769);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15377 39.991397 -80.440806
var zip = "15377";
var point = new GLatLng(39.991397,-80.440806);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15378 40.277222 -80.273333
var zip = "15378";
var point = new GLatLng(40.277222,-80.273333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15379 40.242778 -80.4275
var zip = "15379";
var point = new GLatLng(40.242778,-80.4275);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15380 39.897106 -80.464665
var zip = "15380";
var point = new GLatLng(39.897106,-80.464665);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15401 39.889733 -79.728216
var zip = "15401";
var point = new GLatLng(39.889733,-79.728216);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15410 39.883101 -79.890827
var zip = "15410";
var point = new GLatLng(39.883101,-79.890827);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15411 39.761195 -79.319334
var zip = "15411";
var point = new GLatLng(39.761195,-79.319334);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15412 40.089845 -79.854194
var zip = "15412";
var point = new GLatLng(40.089845,-79.854194);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15413 39.982566 -79.875675
var zip = "15413";
var point = new GLatLng(39.982566,-79.875675);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15415 39.980278 -79.828333
var zip = "15415";
var point = new GLatLng(39.980278,-79.828333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15416 39.856944 -79.712222
var zip = "15416";
var point = new GLatLng(39.856944,-79.712222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15417 40.02671 -79.920609
var zip = "15417";
var point = new GLatLng(40.02671,-79.920609);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15419 40.062529 -79.895319
var zip = "15419";
var point = new GLatLng(40.062529,-79.895319);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15420 39.956667 -79.866389
var zip = "15420";
var point = new GLatLng(39.956667,-79.866389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15421 39.830278 -79.6025
var zip = "15421";
var point = new GLatLng(39.830278,-79.6025);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15422 39.980278 -79.806667
var zip = "15422";
var point = new GLatLng(39.980278,-79.806667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15423 40.097272 -79.8839
var zip = "15423";
var point = new GLatLng(40.097272,-79.8839);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15424 39.821247 -79.351304
var zip = "15424";
var point = new GLatLng(39.821247,-79.351304);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15425 40.025037 -79.587838
var zip = "15425";
var point = new GLatLng(40.025037,-79.587838);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15427 40.074349 -79.967036
var zip = "15427";
var point = new GLatLng(40.074349,-79.967036);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15428 40.063767 -79.660224
var zip = "15428";
var point = new GLatLng(40.063767,-79.660224);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15429 40.012222 -79.931944
var zip = "15429";
var point = new GLatLng(40.012222,-79.931944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15430 40.045556 -79.666667
var zip = "15430";
var point = new GLatLng(40.045556,-79.666667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15431 39.972171 -79.64305
var zip = "15431";
var point = new GLatLng(39.972171,-79.64305);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15432 40.115077 -79.862703
var zip = "15432";
var point = new GLatLng(40.115077,-79.862703);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15433 39.982214 -79.966442
var zip = "15433";
var point = new GLatLng(39.982214,-79.966442);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15434 40.079671 -79.875836
var zip = "15434";
var point = new GLatLng(40.079671,-79.875836);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15435 39.943333 -79.849722
var zip = "15435";
var point = new GLatLng(39.943333,-79.849722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15436 39.822876 -79.755051
var zip = "15436";
var point = new GLatLng(39.822876,-79.755051);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15437 39.806995 -79.583185
var zip = "15437";
var point = new GLatLng(39.806995,-79.583185);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15438 40.098799 -79.836584
var zip = "15438";
var point = new GLatLng(40.098799,-79.836584);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15439 39.742778 -79.824444
var zip = "15439";
var point = new GLatLng(39.742778,-79.824444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15440 39.736357 -79.573603
var zip = "15440";
var point = new GLatLng(39.736357,-79.573603);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15442 40.008415 -79.840447
var zip = "15442";
var point = new GLatLng(40.008415,-79.840447);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15443 39.931667 -79.882778
var zip = "15443";
var point = new GLatLng(39.931667,-79.882778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15444 40.004496 -79.899936
var zip = "15444";
var point = new GLatLng(40.004496,-79.899936);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15445 39.868868 -79.705945
var zip = "15445";
var point = new GLatLng(39.868868,-79.705945);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15446 40.020195 -79.393387
var zip = "15446";
var point = new GLatLng(40.020195,-79.393387);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15447 39.943889 -79.936389
var zip = "15447";
var point = new GLatLng(39.943889,-79.936389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15448 40.133056 -79.741944
var zip = "15448";
var point = new GLatLng(40.133056,-79.741944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15449 39.961389 -79.782778
var zip = "15449";
var point = new GLatLng(39.961389,-79.782778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15450 39.973829 -79.937024
var zip = "15450";
var point = new GLatLng(39.973829,-79.937024);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15451 39.750065 -79.86184
var zip = "15451";
var point = new GLatLng(39.750065,-79.86184);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15454 39.861389 -79.870278
var zip = "15454";
var point = new GLatLng(39.861389,-79.870278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15455 39.998333 -79.643056
var zip = "15455";
var point = new GLatLng(39.998333,-79.643056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15456 39.931057 -79.647684
var zip = "15456";
var point = new GLatLng(39.931057,-79.647684);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15458 39.890185 -79.859022
var zip = "15458";
var point = new GLatLng(39.890185,-79.859022);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15459 39.759723 -79.46003
var zip = "15459";
var point = new GLatLng(39.759723,-79.46003);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15460 39.806389 -79.91
var zip = "15460";
var point = new GLatLng(39.806389,-79.91);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15461 39.83495 -79.893813
var zip = "15461";
var point = new GLatLng(39.83495,-79.893813);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15462 40.064789 -79.3587
var zip = "15462";
var point = new GLatLng(40.064789,-79.3587);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15463 39.964854 -79.874447
var zip = "15463";
var point = new GLatLng(39.964854,-79.874447);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15464 39.967985 -79.462219
var zip = "15464";
var point = new GLatLng(39.967985,-79.462219);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15465 39.942778 -79.644722
var zip = "15465";
var point = new GLatLng(39.942778,-79.644722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15466 40.075556 -79.898333
var zip = "15466";
var point = new GLatLng(40.075556,-79.898333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15467 39.788333 -79.909444
var zip = "15467";
var point = new GLatLng(39.788333,-79.909444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15468 39.940747 -79.80407
var zip = "15468";
var point = new GLatLng(39.940747,-79.80407);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15469 40.041793 -79.415061
var zip = "15469";
var point = new GLatLng(40.041793,-79.415061);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15470 39.873202 -79.48846
var zip = "15470";
var point = new GLatLng(39.873202,-79.48846);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15472 39.911659 -79.715601
var zip = "15472";
var point = new GLatLng(39.911659,-79.715601);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15473 40.085724 -79.754384
var zip = "15473";
var point = new GLatLng(40.085724,-79.754384);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15474 39.735124 -79.898986
var zip = "15474";
var point = new GLatLng(39.735124,-79.898986);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15475 39.961427 -79.902914
var zip = "15475";
var point = new GLatLng(39.961427,-79.902914);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15476 39.869722 -79.920556
var zip = "15476";
var point = new GLatLng(39.869722,-79.920556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15477 40.078686 -79.865617
var zip = "15477";
var point = new GLatLng(40.078686,-79.865617);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15478 39.792306 -79.81268
var zip = "15478";
var point = new GLatLng(39.792306,-79.81268);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15479 40.144267 -79.731277
var zip = "15479";
var point = new GLatLng(40.144267,-79.731277);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15480 39.996096 -79.767828
var zip = "15480";
var point = new GLatLng(39.996096,-79.767828);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15482 40.083198 -79.755461
var zip = "15482";
var point = new GLatLng(40.083198,-79.755461);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15483 40.082567 -79.850103
var zip = "15483";
var point = new GLatLng(40.082567,-79.850103);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15484 39.896111 -79.790556
var zip = "15484";
var point = new GLatLng(39.896111,-79.790556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15485 39.8175 -79.328056
var zip = "15485";
var point = new GLatLng(39.8175,-79.328056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15486 40.024581 -79.695518
var zip = "15486";
var point = new GLatLng(40.024581,-79.695518);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15488 39.990465 -79.780336
var zip = "15488";
var point = new GLatLng(39.990465,-79.780336);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15489 39.959167 -79.6975
var zip = "15489";
var point = new GLatLng(39.959167,-79.6975);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15490 40.072596 -79.425117
var zip = "15490";
var point = new GLatLng(40.072596,-79.425117);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15492 40.123056 -79.773056
var zip = "15492";
var point = new GLatLng(40.123056,-79.773056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15501 40.024813 -79.080814
var zip = "15501";
var point = new GLatLng(40.024813,-79.080814);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15502 40.045 -79.118333
var zip = "15502";
var point = new GLatLng(40.045,-79.118333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15510 40.008333 -79.078333
var zip = "15510";
var point = new GLatLng(40.008333,-79.078333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15520 40.110278 -79.069167
var zip = "15520";
var point = new GLatLng(40.110278,-79.069167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15521 40.185833 -78.620591
var zip = "15521";
var point = new GLatLng(40.185833,-78.620591);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15522 39.990838 -78.526071
var zip = "15522";
var point = new GLatLng(39.990838,-78.526071);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15530 39.918847 -78.963692
var zip = "15530";
var point = new GLatLng(39.918847,-78.963692);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15531 40.191807 -79.036179
var zip = "15531";
var point = new GLatLng(40.191807,-79.036179);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15532 39.766667 -79.066944
var zip = "15532";
var point = new GLatLng(39.766667,-79.066944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15533 39.990521 -78.245271
var zip = "15533";
var point = new GLatLng(39.990521,-78.245271);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15534 39.922025 -78.69962
var zip = "15534";
var point = new GLatLng(39.922025,-78.69962);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15535 39.853284 -78.43918
var zip = "15535";
var point = new GLatLng(39.853284,-78.43918);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15536 39.919973 -78.225836
var zip = "15536";
var point = new GLatLng(39.919973,-78.225836);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15537 40.009808 -78.371315
var zip = "15537";
var point = new GLatLng(40.009808,-78.371315);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15538 39.909046 -78.827522
var zip = "15538";
var point = new GLatLng(39.909046,-78.827522);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15539 40.121667 -78.585833
var zip = "15539";
var point = new GLatLng(40.121667,-78.585833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15540 39.877282 -79.23535
var zip = "15540";
var point = new GLatLng(39.877282,-79.23535);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15541 40.010997 -78.903298
var zip = "15541";
var point = new GLatLng(40.010997,-78.903298);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15542 39.864581 -79.061561
var zip = "15542";
var point = new GLatLng(39.864581,-79.061561);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15544 40.135833 -79.093056
var zip = "15544";
var point = new GLatLng(40.135833,-79.093056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15545 39.804857 -78.733512
var zip = "15545";
var point = new GLatLng(39.804857,-78.733512);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15546 40.147321 -79.054571
var zip = "15546";
var point = new GLatLng(40.147321,-79.054571);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15547 40.159722 -79.066667
var zip = "15547";
var point = new GLatLng(40.159722,-79.066667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15548 40.101667 -78.937222
var zip = "15548";
var point = new GLatLng(40.101667,-78.937222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15549 40.028056 -79.013611
var zip = "15549";
var point = new GLatLng(40.028056,-79.013611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15550 39.980787 -78.642259
var zip = "15550";
var point = new GLatLng(39.980787,-78.642259);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15551 39.869096 -79.287851
var zip = "15551";
var point = new GLatLng(39.869096,-79.287851);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15552 39.790489 -79.026141
var zip = "15552";
var point = new GLatLng(39.790489,-79.026141);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15553 39.985833 -78.773056
var zip = "15553";
var point = new GLatLng(39.985833,-78.773056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15554 40.118876 -78.588569
var zip = "15554";
var point = new GLatLng(40.118876,-78.588569);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15555 40.089722 -79.079444
var zip = "15555";
var point = new GLatLng(40.089722,-79.079444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15557 39.937296 -79.186546
var zip = "15557";
var point = new GLatLng(39.937296,-79.186546);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15558 39.753052 -79.083516
var zip = "15558";
var point = new GLatLng(39.753052,-79.083516);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15559 40.04869 -78.648194
var zip = "15559";
var point = new GLatLng(40.04869,-78.648194);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15560 40.017778 -78.9075
var zip = "15560";
var point = new GLatLng(40.017778,-78.9075);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15561 40.099167 -79.091389
var zip = "15561";
var point = new GLatLng(40.099167,-79.091389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15562 39.748895 -79.08895
var zip = "15562";
var point = new GLatLng(39.748895,-79.08895);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15563 40.109886 -78.955978
var zip = "15563";
var point = new GLatLng(40.109886,-78.955978);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15564 39.732778 -78.850556
var zip = "15564";
var point = new GLatLng(39.732778,-78.850556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15565 39.754167 -79.095278
var zip = "15565";
var point = new GLatLng(39.754167,-79.095278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15601 40.307359 -79.542439
var zip = "15601";
var point = new GLatLng(40.307359,-79.542439);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15605 40.3013 -79.5391
var zip = "15605";
var point = new GLatLng(40.3013,-79.5391);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15606 40.3013 -79.5391
var zip = "15606";
var point = new GLatLng(40.3013,-79.5391);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15610 40.104891 -79.482747
var zip = "15610";
var point = new GLatLng(40.104891,-79.482747);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15611 40.312577 -79.656469
var zip = "15611";
var point = new GLatLng(40.312577,-79.656469);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15612 40.127866 -79.558608
var zip = "15612";
var point = new GLatLng(40.127866,-79.558608);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15613 40.556481 -79.577158
var zip = "15613";
var point = new GLatLng(40.556481,-79.577158);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15615 40.362993 -79.733533
var zip = "15615";
var point = new GLatLng(40.362993,-79.733533);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15616 40.236097 -79.553884
var zip = "15616";
var point = new GLatLng(40.236097,-79.553884);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15617 40.26799 -79.659104
var zip = "15617";
var point = new GLatLng(40.26799,-79.659104);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15618 40.522125 -79.485264
var zip = "15618";
var point = new GLatLng(40.522125,-79.485264);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15619 40.319722 -79.503611
var zip = "15619";
var point = new GLatLng(40.319722,-79.503611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15620 40.296094 -79.309679
var zip = "15620";
var point = new GLatLng(40.296094,-79.309679);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15621 40.210833 -79.485556
var zip = "15621";
var point = new GLatLng(40.210833,-79.485556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15622 40.043976 -79.324719
var zip = "15622";
var point = new GLatLng(40.043976,-79.324719);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15623 40.365556 -79.6225
var zip = "15623";
var point = new GLatLng(40.365556,-79.6225);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15624 40.362222 -79.470833
var zip = "15624";
var point = new GLatLng(40.362222,-79.470833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15625 40.260377 -79.678036
var zip = "15625";
var point = new GLatLng(40.260377,-79.678036);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15626 40.413901 -79.57638
var zip = "15626";
var point = new GLatLng(40.413901,-79.57638);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15627 40.334931 -79.332585
var zip = "15627";
var point = new GLatLng(40.334931,-79.332585);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15628 40.099613 -79.381043
var zip = "15628";
var point = new GLatLng(40.099613,-79.381043);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15629 40.598056 -79.561389
var zip = "15629";
var point = new GLatLng(40.598056,-79.561389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15631 40.091144 -79.587277
var zip = "15631";
var point = new GLatLng(40.091144,-79.587277);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15632 40.425185 -79.611021
var zip = "15632";
var point = new GLatLng(40.425185,-79.611021);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15633 40.353889 -79.521944
var zip = "15633";
var point = new GLatLng(40.353889,-79.521944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15634 40.303804 -79.603189
var zip = "15634";
var point = new GLatLng(40.303804,-79.603189);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15635 40.353611 -79.496944
var zip = "15635";
var point = new GLatLng(40.353611,-79.496944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15636 40.372455 -79.679754
var zip = "15636";
var point = new GLatLng(40.372455,-79.679754);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15637 40.245485 -79.717164
var zip = "15637";
var point = new GLatLng(40.245485,-79.717164);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15638 40.266111 -79.398611
var zip = "15638";
var point = new GLatLng(40.266111,-79.398611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15639 40.214947 -79.582364
var zip = "15639";
var point = new GLatLng(40.214947,-79.582364);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15640 40.226111 -79.731944
var zip = "15640";
var point = new GLatLng(40.226111,-79.731944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15641 40.631102 -79.589884
var zip = "15641";
var point = new GLatLng(40.631102,-79.589884);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15642 40.319227 -79.723855
var zip = "15642";
var point = new GLatLng(40.319227,-79.723855);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15644 40.32947 -79.614412
var zip = "15644";
var point = new GLatLng(40.32947,-79.614412);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15646 40.07977 -79.339933
var zip = "15646";
var point = new GLatLng(40.07977,-79.339933);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15647 40.351842 -79.736627
var zip = "15647";
var point = new GLatLng(40.351842,-79.736627);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15650 40.292625 -79.410278
var zip = "15650";
var point = new GLatLng(40.292625,-79.410278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15655 40.208025 -79.18058
var zip = "15655";
var point = new GLatLng(40.208025,-79.18058);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15656 40.634398 -79.620101
var zip = "15656";
var point = new GLatLng(40.634398,-79.620101);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15658 40.245133 -79.236666
var zip = "15658";
var point = new GLatLng(40.245133,-79.236666);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15660 40.245833 -79.771111
var zip = "15660";
var point = new GLatLng(40.245833,-79.771111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15661 40.30199 -79.344157
var zip = "15661";
var point = new GLatLng(40.30199,-79.344157);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15662 40.334167 -79.478333
var zip = "15662";
var point = new GLatLng(40.334167,-79.478333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15663 40.246669 -79.675978
var zip = "15663";
var point = new GLatLng(40.246669,-79.675978);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15664 40.200833 -79.463333
var zip = "15664";
var point = new GLatLng(40.200833,-79.463333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15665 40.33822 -79.671221
var zip = "15665";
var point = new GLatLng(40.33822,-79.671221);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15666 40.174179 -79.513383
var zip = "15666";
var point = new GLatLng(40.174179,-79.513383);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15668 40.446674 -79.684154
var zip = "15668";
var point = new GLatLng(40.446674,-79.684154);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15670 40.398112 -79.396594
var zip = "15670";
var point = new GLatLng(40.398112,-79.396594);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15671 40.333334 -79.300863
var zip = "15671";
var point = new GLatLng(40.333334,-79.300863);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15672 40.223345 -79.618187
var zip = "15672";
var point = new GLatLng(40.223345,-79.618187);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15673 40.596111 -79.555833
var zip = "15673";
var point = new GLatLng(40.596111,-79.555833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15674 40.208056 -79.497778
var zip = "15674";
var point = new GLatLng(40.208056,-79.497778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15675 40.330081 -79.641336
var zip = "15675";
var point = new GLatLng(40.330081,-79.641336);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15676 40.239444 -79.451111
var zip = "15676";
var point = new GLatLng(40.239444,-79.451111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15677 40.186444 -79.247331
var zip = "15677";
var point = new GLatLng(40.186444,-79.247331);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15678 40.282454 -79.728211
var zip = "15678";
var point = new GLatLng(40.282454,-79.728211);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15679 40.158458 -79.627743
var zip = "15679";
var point = new GLatLng(40.158458,-79.627743);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15680 40.521667 -79.498333
var zip = "15680";
var point = new GLatLng(40.521667,-79.498333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15681 40.479239 -79.442844
var zip = "15681";
var point = new GLatLng(40.479239,-79.442844);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15682 40.684444 -79.661944
var zip = "15682";
var point = new GLatLng(40.684444,-79.661944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15683 40.102948 -79.593017
var zip = "15683";
var point = new GLatLng(40.102948,-79.593017);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15684 40.465347 -79.506654
var zip = "15684";
var point = new GLatLng(40.465347,-79.506654);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15685 40.198889 -79.521111
var zip = "15685";
var point = new GLatLng(40.198889,-79.521111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15686 40.615329 -79.454487
var zip = "15686";
var point = new GLatLng(40.615329,-79.454487);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15687 40.138593 -79.344473
var zip = "15687";
var point = new GLatLng(40.138593,-79.344473);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15688 40.161915 -79.566101
var zip = "15688";
var point = new GLatLng(40.161915,-79.566101);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15689 40.218333 -79.488056
var zip = "15689";
var point = new GLatLng(40.218333,-79.488056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15690 40.605883 -79.565531
var zip = "15690";
var point = new GLatLng(40.605883,-79.565531);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15691 40.295556 -79.686667
var zip = "15691";
var point = new GLatLng(40.295556,-79.686667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15692 40.276802 -79.547696
var zip = "15692";
var point = new GLatLng(40.276802,-79.547696);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15693 40.253333 -79.410556
var zip = "15693";
var point = new GLatLng(40.253333,-79.410556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15695 40.197222 -79.6975
var zip = "15695";
var point = new GLatLng(40.197222,-79.6975);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15696 40.279722 -79.365833
var zip = "15696";
var point = new GLatLng(40.279722,-79.365833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15697 40.239482 -79.582291
var zip = "15697";
var point = new GLatLng(40.239482,-79.582291);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15698 40.215529 -79.684941
var zip = "15698";
var point = new GLatLng(40.215529,-79.684941);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15701 40.619628 -79.159596
var zip = "15701";
var point = new GLatLng(40.619628,-79.159596);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15705 40.621389 -79.152778
var zip = "15705";
var point = new GLatLng(40.621389,-79.152778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15710 40.630278 -78.857222
var zip = "15710";
var point = new GLatLng(40.630278,-78.857222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15711 41.001806 -78.966637
var zip = "15711";
var point = new GLatLng(41.001806,-78.966637);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15712 40.781111 -78.852778
var zip = "15712";
var point = new GLatLng(40.781111,-78.852778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15713 40.540083 -79.219791
var zip = "15713";
var point = new GLatLng(40.540083,-79.219791);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15714 40.673307 -78.777058
var zip = "15714";
var point = new GLatLng(40.673307,-78.777058);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15715 40.966944 -78.878611
var zip = "15715";
var point = new GLatLng(40.966944,-78.878611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15716 40.466905 -79.193231
var zip = "15716";
var point = new GLatLng(40.466905,-79.193231);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15717 40.441262 -79.253329
var zip = "15717";
var point = new GLatLng(40.441262,-79.253329);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15720 40.528565 -79.058765
var zip = "15720";
var point = new GLatLng(40.528565,-79.058765);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15721 40.813431 -78.786488
var zip = "15721";
var point = new GLatLng(40.813431,-78.786488);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15722 40.589054 -78.703676
var zip = "15722";
var point = new GLatLng(40.589054,-78.703676);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15723 40.705278 -79.158056
var zip = "15723";
var point = new GLatLng(40.705278,-79.158056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15724 40.755387 -78.847357
var zip = "15724";
var point = new GLatLng(40.755387,-78.847357);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15725 40.503933 -79.367676
var zip = "15725";
var point = new GLatLng(40.503933,-79.367676);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15727 40.553611 -79.306667
var zip = "15727";
var point = new GLatLng(40.553611,-79.306667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15728 40.668811 -79.011863
var zip = "15728";
var point = new GLatLng(40.668811,-79.011863);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15729 40.701588 -78.913371
var zip = "15729";
var point = new GLatLng(40.701588,-78.913371);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15730 40.951816 -78.922015
var zip = "15730";
var point = new GLatLng(40.951816,-78.922015);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15731 40.499167 -79.174167
var zip = "15731";
var point = new GLatLng(40.499167,-79.174167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15732 40.719892 -79.201396
var zip = "15732";
var point = new GLatLng(40.719892,-79.201396);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15733 40.981389 -78.979444
var zip = "15733";
var point = new GLatLng(40.981389,-78.979444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15734 40.716389 -79.007222
var zip = "15734";
var point = new GLatLng(40.716389,-79.007222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15736 40.695 -79.341667
var zip = "15736";
var point = new GLatLng(40.695,-79.341667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15737 40.5925 -78.740556
var zip = "15737";
var point = new GLatLng(40.5925,-78.740556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15738 40.694722 -78.787222
var zip = "15738";
var point = new GLatLng(40.694722,-78.787222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15739 40.704255 -79.096937
var zip = "15739";
var point = new GLatLng(40.704255,-79.096937);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15740 40.964444 -79.033611
var zip = "15740";
var point = new GLatLng(40.964444,-79.033611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15741 40.807222 -78.876667
var zip = "15741";
var point = new GLatLng(40.807222,-78.876667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15742 40.850766 -78.855538
var zip = "15742";
var point = new GLatLng(40.850766,-78.855538);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15744 40.921432 -79.093987
var zip = "15744";
var point = new GLatLng(40.921432,-79.093987);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15745 40.620833 -78.915278
var zip = "15745";
var point = new GLatLng(40.620833,-78.915278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15746 40.751667 -78.885278
var zip = "15746";
var point = new GLatLng(40.751667,-78.885278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15747 40.783441 -79.164082
var zip = "15747";
var point = new GLatLng(40.783441,-79.164082);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15748 40.538375 -79.183942
var zip = "15748";
var point = new GLatLng(40.538375,-79.183942);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15750 40.477222 -79.181667
var zip = "15750";
var point = new GLatLng(40.477222,-79.181667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15752 40.535556 -79.288611
var zip = "15752";
var point = new GLatLng(40.535556,-79.288611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15753 40.830118 -78.62337
var zip = "15753";
var point = new GLatLng(40.830118,-78.62337);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15754 40.545313 -79.157349
var zip = "15754";
var point = new GLatLng(40.545313,-79.157349);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15756 40.567222 -79.295833
var zip = "15756";
var point = new GLatLng(40.567222,-79.295833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15757 40.889251 -78.72039
var zip = "15757";
var point = new GLatLng(40.889251,-78.72039);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15758 40.875411 -79.045151
var zip = "15758";
var point = new GLatLng(40.875411,-79.045151);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15759 40.78135 -79.02524
var zip = "15759";
var point = new GLatLng(40.78135,-79.02524);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15760 40.65004 -78.813356
var zip = "15760";
var point = new GLatLng(40.65004,-78.813356);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15761 40.637222 -78.8825
var zip = "15761";
var point = new GLatLng(40.637222,-78.8825);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15762 40.601623 -78.811394
var zip = "15762";
var point = new GLatLng(40.601623,-78.811394);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15763 40.903703 -79.125657
var zip = "15763";
var point = new GLatLng(40.903703,-79.125657);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15764 40.996379 -79.038197
var zip = "15764";
var point = new GLatLng(40.996379,-79.038197);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15765 40.626825 -78.971597
var zip = "15765";
var point = new GLatLng(40.626825,-78.971597);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15767 40.947937 -78.968056
var zip = "15767";
var point = new GLatLng(40.947937,-78.968056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15770 40.999731 -79.176581
var zip = "15770";
var point = new GLatLng(40.999731,-79.176581);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15771 40.819482 -78.997985
var zip = "15771";
var point = new GLatLng(40.819482,-78.997985);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15772 40.884553 -78.941353
var zip = "15772";
var point = new GLatLng(40.884553,-78.941353);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15773 40.611845 -78.738332
var zip = "15773";
var point = new GLatLng(40.611845,-78.738332);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15774 40.638787 -79.31907
var zip = "15774";
var point = new GLatLng(40.638787,-79.31907);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15775 40.648082 -78.769061
var zip = "15775";
var point = new GLatLng(40.648082,-78.769061);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15776 41.01846 -79.077809
var zip = "15776";
var point = new GLatLng(41.01846,-79.077809);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15777 40.700971 -78.980317
var zip = "15777";
var point = new GLatLng(40.700971,-78.980317);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15778 40.968387 -79.20135
var zip = "15778";
var point = new GLatLng(40.968387,-79.20135);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15779 40.417222 -79.223056
var zip = "15779";
var point = new GLatLng(40.417222,-79.223056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15780 40.922851 -79.083263
var zip = "15780";
var point = new GLatLng(40.922851,-79.083263);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15781 40.965 -78.995
var zip = "15781";
var point = new GLatLng(40.965,-78.995);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15783 40.6025 -79.353889
var zip = "15783";
var point = new GLatLng(40.6025,-79.353889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15784 41.023767 -79.138685
var zip = "15784";
var point = new GLatLng(41.023767,-79.138685);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15801 41.126039 -78.752698
var zip = "15801";
var point = new GLatLng(41.126039,-78.752698);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15821 41.325318 -78.357621
var zip = "15821";
var point = new GLatLng(41.325318,-78.357621);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15822 41.320833 -78.687778
var zip = "15822";
var point = new GLatLng(41.320833,-78.687778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15823 41.28217 -78.712829
var zip = "15823";
var point = new GLatLng(41.28217,-78.712829);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15824 41.240564 -78.811568
var zip = "15824";
var point = new GLatLng(41.240564,-78.811568);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15825 41.159986 -79.064101
var zip = "15825";
var point = new GLatLng(41.159986,-79.064101);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15827 41.286459 -78.505126
var zip = "15827";
var point = new GLatLng(41.286459,-78.505126);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15828 41.323272 -79.146557
var zip = "15828";
var point = new GLatLng(41.323272,-79.146557);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15829 41.182983 -79.175567
var zip = "15829";
var point = new GLatLng(41.182983,-79.175567);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15831 41.353889 -78.605833
var zip = "15831";
var point = new GLatLng(41.353889,-78.605833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15832 41.376396 -78.163194
var zip = "15832";
var point = new GLatLng(41.376396,-78.163194);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15834 41.517689 -78.25361
var zip = "15834";
var point = new GLatLng(41.517689,-78.25361);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15840 41.145505 -78.812791
var zip = "15840";
var point = new GLatLng(41.145505,-78.812791);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15841 41.257778 -78.501389
var zip = "15841";
var point = new GLatLng(41.257778,-78.501389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15845 41.492823 -78.67826
var zip = "15845";
var point = new GLatLng(41.492823,-78.67826);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15846 41.356271 -78.60152
var zip = "15846";
var point = new GLatLng(41.356271,-78.60152);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15847 41.086111 -79.026667
var zip = "15847";
var point = new GLatLng(41.086111,-79.026667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15848 41.05321 -78.742758
var zip = "15848";
var point = new GLatLng(41.05321,-78.742758);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15849 41.208519 -78.579111
var zip = "15849";
var point = new GLatLng(41.208519,-78.579111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15851 41.062935 -78.896147
var zip = "15851";
var point = new GLatLng(41.062935,-78.896147);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15853 41.431566 -78.729715
var zip = "15853";
var point = new GLatLng(41.431566,-78.729715);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15856 41.080571 -78.657662
var zip = "15856";
var point = new GLatLng(41.080571,-78.657662);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15857 41.428949 -78.550533
var zip = "15857";
var point = new GLatLng(41.428949,-78.550533);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15860 41.309921 -79.053957
var zip = "15860";
var point = new GLatLng(41.309921,-79.053957);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15861 41.376197 -78.06607
var zip = "15861";
var point = new GLatLng(41.376197,-78.06607);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15863 41.0125 -78.8375
var zip = "15863";
var point = new GLatLng(41.0125,-78.8375);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15864 41.105822 -79.172583
var zip = "15864";
var point = new GLatLng(41.105822,-79.172583);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15865 41.05137 -78.819508
var zip = "15865";
var point = new GLatLng(41.05137,-78.819508);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15866 41.025556 -78.785556
var zip = "15866";
var point = new GLatLng(41.025556,-78.785556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15868 41.268502 -78.495165
var zip = "15868";
var point = new GLatLng(41.268502,-78.495165);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15870 41.573471 -78.682295
var zip = "15870";
var point = new GLatLng(41.573471,-78.682295);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15901 40.325957 -78.91408
var zip = "15901";
var point = new GLatLng(40.325957,-78.91408);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15902 40.307787 -78.896905
var zip = "15902";
var point = new GLatLng(40.307787,-78.896905);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15904 40.285026 -78.865383
var zip = "15904";
var point = new GLatLng(40.285026,-78.865383);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15905 40.307188 -78.943006
var zip = "15905";
var point = new GLatLng(40.307188,-78.943006);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15906 40.352193 -78.938317
var zip = "15906";
var point = new GLatLng(40.352193,-78.938317);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15907 40.3259 -78.917
var zip = "15907";
var point = new GLatLng(40.3259,-78.917);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15909 40.387965 -78.862284
var zip = "15909";
var point = new GLatLng(40.387965,-78.862284);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15915 40.3259 -78.917
var zip = "15915";
var point = new GLatLng(40.3259,-78.917);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15920 40.442452 -79.013055
var zip = "15920";
var point = new GLatLng(40.442452,-79.013055);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15921 40.321944 -78.697222
var zip = "15921";
var point = new GLatLng(40.321944,-78.697222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15922 40.519444 -78.871389
var zip = "15922";
var point = new GLatLng(40.519444,-78.871389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15923 40.367289 -79.160546
var zip = "15923";
var point = new GLatLng(40.367289,-79.160546);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15924 40.114472 -78.810082
var zip = "15924";
var point = new GLatLng(40.114472,-78.810082);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15925 40.408611 -78.640833
var zip = "15925";
var point = new GLatLng(40.408611,-78.640833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15926 40.091257 -78.844753
var zip = "15926";
var point = new GLatLng(40.091257,-78.844753);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15927 40.541086 -78.778432
var zip = "15927";
var point = new GLatLng(40.541086,-78.778432);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15928 40.224451 -78.936333
var zip = "15928";
var point = new GLatLng(40.224451,-78.936333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15929 40.466389 -79.002778
var zip = "15929";
var point = new GLatLng(40.466389,-79.002778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15930 40.294444 -78.721389
var zip = "15930";
var point = new GLatLng(40.294444,-78.721389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15931 40.480105 -78.726294
var zip = "15931";
var point = new GLatLng(40.480105,-78.726294);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15934 40.279722 -78.8025
var zip = "15934";
var point = new GLatLng(40.279722,-78.8025);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15935 40.234301 -78.951471
var zip = "15935";
var point = new GLatLng(40.234301,-78.951471);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15936 40.148776 -78.914071
var zip = "15936";
var point = new GLatLng(40.148776,-78.914071);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15937 40.208889 -78.983889
var zip = "15937";
var point = new GLatLng(40.208889,-78.983889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15938 40.423844 -78.62306
var zip = "15938";
var point = new GLatLng(40.423844,-78.62306);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//15940 40.510484 -78.629357
var zip = "15940";
var point = new GLatLng(40.510484,-78.629357);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15942 40.379253 -78.835201
var zip = "15942";
var point = new GLatLng(40.379253,-78.835201);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15943 40.470435 -78.837504
var zip = "15943";
var point = new GLatLng(40.470435,-78.837504);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15944 40.382266 -79.096803
var zip = "15944";
var point = new GLatLng(40.382266,-79.096803);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15945 40.359385 -78.869432
var zip = "15945";
var point = new GLatLng(40.359385,-78.869432);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15946 40.384201 -78.671753
var zip = "15946";
var point = new GLatLng(40.384201,-78.671753);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15948 40.492222 -78.764444
var zip = "15948";
var point = new GLatLng(40.492222,-78.764444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15949 40.407655 -79.137928
var zip = "15949";
var point = new GLatLng(40.407655,-79.137928);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15951 40.336248 -78.782999
var zip = "15951";
var point = new GLatLng(40.336248,-78.782999);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15952 40.300627 -78.743704
var zip = "15952";
var point = new GLatLng(40.300627,-78.743704);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15953 40.231191 -78.890897
var zip = "15953";
var point = new GLatLng(40.231191,-78.890897);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//15954 40.409907 -79.023224
var zip = "15954";
var point = new GLatLng(40.409907,-79.023224);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15955 40.329873 -78.745966
var zip = "15955";
var point = new GLatLng(40.329873,-78.745966);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15956 40.362877 -78.788671
var zip = "15956";
var point = new GLatLng(40.362877,-78.788671);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//15957 40.56279 -78.912961
var zip = "15957";
var point = new GLatLng(40.56279,-78.912961);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//15958 40.388959 -78.755979
var zip = "15958";
var point = new GLatLng(40.388959,-78.755979);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//15959 40.268611 -78.916111
var zip = "15959";
var point = new GLatLng(40.268611,-78.916111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15960 40.518254 -78.860488
var zip = "15960";
var point = new GLatLng(40.518254,-78.860488);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15961 40.493949 -78.94267
var zip = "15961";
var point = new GLatLng(40.493949,-78.94267);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15962 40.388611 -78.718889
var zip = "15962";
var point = new GLatLng(40.388611,-78.718889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//15963 40.228695 -78.830289
var zip = "15963";
var point = new GLatLng(40.228695,-78.830289);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16001 40.862096 -79.902717
var zip = "16001";
var point = new GLatLng(40.862096,-79.902717);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16002 40.8209 -79.8622
var zip = "16002";
var point = new GLatLng(40.8209,-79.8622);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16003 40.9095 -79.9399
var zip = "16003";
var point = new GLatLng(40.9095,-79.9399);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16016 41.1083 -79.8991
var zip = "16016";
var point = new GLatLng(41.1083,-79.8991);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16017 41.1083 -79.8991
var zip = "16017";
var point = new GLatLng(41.1083,-79.8991);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16018 41.091111 -79.893056
var zip = "16018";
var point = new GLatLng(41.091111,-79.893056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16020 41.109205 -79.904692
var zip = "16020";
var point = new GLatLng(41.109205,-79.904692);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16021 41.0725 -79.985833
var zip = "16021";
var point = new GLatLng(41.0725,-79.985833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16022 41.057078 -79.729051
var zip = "16022";
var point = new GLatLng(41.057078,-79.729051);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16023 40.779723 -79.770851
var zip = "16023";
var point = new GLatLng(40.779723,-79.770851);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16024 40.740556 -80.036667
var zip = "16024";
var point = new GLatLng(40.740556,-80.036667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16025 40.945768 -79.746237
var zip = "16025";
var point = new GLatLng(40.945768,-79.746237);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16027 40.817778 -80.014444
var zip = "16027";
var point = new GLatLng(40.817778,-80.014444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16028 40.974373 -79.630187
var zip = "16028";
var point = new GLatLng(40.974373,-79.630187);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16029 40.877778 -79.846667
var zip = "16029";
var point = new GLatLng(40.877778,-79.846667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16030 41.13478 -79.798093
var zip = "16030";
var point = new GLatLng(41.13478,-79.798093);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16033 40.780795 -80.059195
var zip = "16033";
var point = new GLatLng(40.780795,-80.059195);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16034 40.855464 -79.737152
var zip = "16034";
var point = new GLatLng(40.855464,-79.737152);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16035 41.105833 -80.006111
var zip = "16035";
var point = new GLatLng(41.105833,-80.006111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16036 41.160239 -79.653443
var zip = "16036";
var point = new GLatLng(41.160239,-79.653443);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16037 40.849646 -80.138117
var zip = "16037";
var point = new GLatLng(40.849646,-80.138117);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16038 41.163087 -79.979639
var zip = "16038";
var point = new GLatLng(41.163087,-79.979639);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16039 40.83 -79.811389
var zip = "16039";
var point = new GLatLng(40.83,-79.811389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16040 41.100894 -79.821456
var zip = "16040";
var point = new GLatLng(41.100894,-79.821456);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16041 41.002193 -79.716017
var zip = "16041";
var point = new GLatLng(41.002193,-79.716017);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16045 40.855071 -79.921401
var zip = "16045";
var point = new GLatLng(40.855071,-79.921401);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16046 40.700514 -80.035769
var zip = "16046";
var point = new GLatLng(40.700514,-80.035769);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16048 41.047778 -79.813611
var zip = "16048";
var point = new GLatLng(41.047778,-79.813611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16049 41.100891 -79.688888
var zip = "16049";
var point = new GLatLng(41.100891,-79.688888);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16050 41.044208 -79.771069
var zip = "16050";
var point = new GLatLng(41.044208,-79.771069);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16051 40.948651 -80.172965
var zip = "16051";
var point = new GLatLng(40.948651,-80.172965);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16052 40.904941 -80.067903
var zip = "16052";
var point = new GLatLng(40.904941,-80.067903);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16053 40.810003 -79.977004
var zip = "16053";
var point = new GLatLng(40.810003,-79.977004);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16054 41.161667 -79.653056
var zip = "16054";
var point = new GLatLng(41.161667,-79.653056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16055 40.714285 -79.74243
var zip = "16055";
var point = new GLatLng(40.714285,-79.74243);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16056 40.736099 -79.835222
var zip = "16056";
var point = new GLatLng(40.736099,-79.835222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16057 41.045412 -80.046847
var zip = "16057";
var point = new GLatLng(41.045412,-80.046847);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16058 41.185278 -79.613611
var zip = "16058";
var point = new GLatLng(41.185278,-79.613611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16059 40.701831 -79.923527
var zip = "16059";
var point = new GLatLng(40.701831,-79.923527);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16061 41.002601 -79.875134
var zip = "16061";
var point = new GLatLng(41.002601,-79.875134);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16063 40.73136 -80.128564
var zip = "16063";
var point = new GLatLng(40.73136,-80.128564);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16066 40.692222 -80.123333
var zip = "16066";
var point = new GLatLng(40.692222,-80.123333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16101 40.99222 -80.328449
var zip = "16101";
var point = new GLatLng(40.99222,-80.328449);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16102 40.967745 -80.390704
var zip = "16102";
var point = new GLatLng(40.967745,-80.390704);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16103 41.0036 -80.3472
var zip = "16103";
var point = new GLatLng(41.0036,-80.3472);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16105 41.033502 -80.342191
var zip = "16105";
var point = new GLatLng(41.033502,-80.342191);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16107 41.0036 -80.3472
var zip = "16107";
var point = new GLatLng(41.0036,-80.3472);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16108 41.0036 -80.3472
var zip = "16108";
var point = new GLatLng(41.0036,-80.3472);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16110 41.506677 -80.376544
var zip = "16110";
var point = new GLatLng(41.506677,-80.376544);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16111 41.533313 -80.286251
var zip = "16111";
var point = new GLatLng(41.533313,-80.286251);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16112 40.975493 -80.493689
var zip = "16112";
var point = new GLatLng(40.975493,-80.493689);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16113 41.286111 -80.427778
var zip = "16113";
var point = new GLatLng(41.286111,-80.427778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16114 41.385141 -80.175223
var zip = "16114";
var point = new GLatLng(41.385141,-80.175223);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16115 40.796839 -80.455611
var zip = "16115";
var point = new GLatLng(40.796839,-80.455611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16116 41.027614 -80.463178
var zip = "16116";
var point = new GLatLng(41.027614,-80.463178);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16117 40.859024 -80.274606
var zip = "16117";
var point = new GLatLng(40.859024,-80.274606);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16120 40.8721 -80.461182
var zip = "16120";
var point = new GLatLng(40.8721,-80.461182);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16121 41.210995 -80.494442
var zip = "16121";
var point = new GLatLng(41.210995,-80.494442);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16123 40.812527 -80.207312
var zip = "16123";
var point = new GLatLng(40.812527,-80.207312);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16124 41.324141 -80.269871
var zip = "16124";
var point = new GLatLng(41.324141,-80.269871);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16125 41.399403 -80.380344
var zip = "16125";
var point = new GLatLng(41.399403,-80.380344);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16127 41.160704 -80.084138
var zip = "16127";
var point = new GLatLng(41.160704,-80.084138);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16130 41.43302 -80.153544
var zip = "16130";
var point = new GLatLng(41.43302,-80.153544);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16131 41.550875 -80.381321
var zip = "16131";
var point = new GLatLng(41.550875,-80.381321);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16132 41.007778 -80.496944
var zip = "16132";
var point = new GLatLng(41.007778,-80.496944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16133 41.280134 -80.103726
var zip = "16133";
var point = new GLatLng(41.280134,-80.103726);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16134 41.506031 -80.456459
var zip = "16134";
var point = new GLatLng(41.506031,-80.456459);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16136 40.834167 -80.3225
var zip = "16136";
var point = new GLatLng(40.834167,-80.3225);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16137 41.23254 -80.234018
var zip = "16137";
var point = new GLatLng(41.23254,-80.234018);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16140 41.097222 -80.505
var zip = "16140";
var point = new GLatLng(41.097222,-80.505);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16141 40.856891 -80.393904
var zip = "16141";
var point = new GLatLng(40.856891,-80.393904);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16142 41.138155 -80.324541
var zip = "16142";
var point = new GLatLng(41.138155,-80.324541);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16143 41.094215 -80.468515
var zip = "16143";
var point = new GLatLng(41.094215,-80.468515);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16145 41.338337 -80.04974
var zip = "16145";
var point = new GLatLng(41.338337,-80.04974);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16146 41.231552 -80.499342
var zip = "16146";
var point = new GLatLng(41.231552,-80.499342);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16148 41.232601 -80.45303
var zip = "16148";
var point = new GLatLng(41.232601,-80.45303);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16150 41.267648 -80.465642
var zip = "16150";
var point = new GLatLng(41.267648,-80.465642);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16151 41.442778 -80.208056
var zip = "16151";
var point = new GLatLng(41.442778,-80.208056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16153 41.34385 -80.097613
var zip = "16153";
var point = new GLatLng(41.34385,-80.097613);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16154 41.324401 -80.419742
var zip = "16154";
var point = new GLatLng(41.324401,-80.419742);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16155 41.073611 -80.5075
var zip = "16155";
var point = new GLatLng(41.073611,-80.5075);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16156 41.093767 -80.244129
var zip = "16156";
var point = new GLatLng(41.093767,-80.244129);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16157 40.881879 -80.339184
var zip = "16157";
var point = new GLatLng(40.881879,-80.339184);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16159 41.174054 -80.452759
var zip = "16159";
var point = new GLatLng(41.174054,-80.452759);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16160 40.932778 -80.363611
var zip = "16160";
var point = new GLatLng(40.932778,-80.363611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16161 41.200833 -80.498056
var zip = "16161";
var point = new GLatLng(41.200833,-80.498056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16172 41.122222 -80.333056
var zip = "16172";
var point = new GLatLng(41.122222,-80.333056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16201 40.815516 -79.510675
var zip = "16201";
var point = new GLatLng(40.815516,-79.510675);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16210 40.904902 -79.507444
var zip = "16210";
var point = new GLatLng(40.904902,-79.507444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16211 40.786389 -79.201389
var zip = "16211";
var point = new GLatLng(40.786389,-79.201389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16212 40.75392 -79.579827
var zip = "16212";
var point = new GLatLng(40.75392,-79.579827);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16213 41.132379 -79.55695
var zip = "16213";
var point = new GLatLng(41.132379,-79.55695);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16214 41.212272 -79.377268
var zip = "16214";
var point = new GLatLng(41.212272,-79.377268);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16215 40.816389 -79.522222
var zip = "16215";
var point = new GLatLng(40.816389,-79.522222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16217 41.338366 -79.19708
var zip = "16217";
var point = new GLatLng(41.338366,-79.19708);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16218 40.922985 -79.594607
var zip = "16218";
var point = new GLatLng(40.922985,-79.594607);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16220 41.389722 -79.271111
var zip = "16220";
var point = new GLatLng(41.389722,-79.271111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16221 41.098611 -79.446944
var zip = "16221";
var point = new GLatLng(41.098611,-79.446944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16222 40.874101 -79.268551
var zip = "16222";
var point = new GLatLng(40.874101,-79.268551);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16223 40.969444 -79.356944
var zip = "16223";
var point = new GLatLng(40.969444,-79.356944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16224 41.042861 -79.278405
var zip = "16224";
var point = new GLatLng(41.042861,-79.278405);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16225 41.266737 -79.247033
var zip = "16225";
var point = new GLatLng(41.266737,-79.247033);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16226 40.738407 -79.51222
var zip = "16226";
var point = new GLatLng(40.738407,-79.51222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16228 40.760278 -79.533889
var zip = "16228";
var point = new GLatLng(40.760278,-79.533889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16229 40.703277 -79.662991
var zip = "16229";
var point = new GLatLng(40.703277,-79.662991);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16230 41.02 -79.274722
var zip = "16230";
var point = new GLatLng(41.02,-79.274722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16232 41.224518 -79.519404
var zip = "16232";
var point = new GLatLng(41.224518,-79.519404);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16233 41.367074 -79.302179
var zip = "16233";
var point = new GLatLng(41.367074,-79.302179);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16234 41.133396 -79.299292
var zip = "16234";
var point = new GLatLng(41.133396,-79.299292);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16235 41.312377 -79.375372
var zip = "16235";
var point = new GLatLng(41.312377,-79.375372);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16236 40.76929 -79.53086
var zip = "16236";
var point = new GLatLng(40.76929,-79.53086);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16238 40.786256 -79.521333
var zip = "16238";
var point = new GLatLng(40.786256,-79.521333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16239 41.462237 -79.130581
var zip = "16239";
var point = new GLatLng(41.462237,-79.130581);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16240 40.99059 -79.261701
var zip = "16240";
var point = new GLatLng(40.99059,-79.261701);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16242 40.9999 -79.352654
var zip = "16242";
var point = new GLatLng(40.9999,-79.352654);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16244 40.796111 -79.283333
var zip = "16244";
var point = new GLatLng(40.796111,-79.283333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16245 41.0075 -79.296111
var zip = "16245";
var point = new GLatLng(41.0075,-79.296111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16246 40.793056 -79.180833
var zip = "16246";
var point = new GLatLng(40.793056,-79.180833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16248 41.039434 -79.510677
var zip = "16248";
var point = new GLatLng(41.039434,-79.510677);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16249 40.788488 -79.299102
var zip = "16249";
var point = new GLatLng(40.788488,-79.299102);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16250 40.78 -79.228056
var zip = "16250";
var point = new GLatLng(40.78,-79.228056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16253 40.954722 -79.343056
var zip = "16253";
var point = new GLatLng(40.954722,-79.343056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16254 41.247491 -79.433199
var zip = "16254";
var point = new GLatLng(41.247491,-79.433199);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16255 41.11394 -79.480485
var zip = "16255";
var point = new GLatLng(41.11394,-79.480485);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16256 40.837193 -79.161432
var zip = "16256";
var point = new GLatLng(40.837193,-79.161432);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16257 41.332778 -79.355833
var zip = "16257";
var point = new GLatLng(41.332778,-79.355833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16258 41.195498 -79.308188
var zip = "16258";
var point = new GLatLng(41.195498,-79.308188);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16259 40.941884 -79.449884
var zip = "16259";
var point = new GLatLng(40.941884,-79.449884);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16260 41.378642 -79.274553
var zip = "16260";
var point = new GLatLng(41.378642,-79.274553);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16261 40.961111 -79.4675
var zip = "16261";
var point = new GLatLng(40.961111,-79.4675);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16262 40.834442 -79.638525
var zip = "16262";
var point = new GLatLng(40.834442,-79.638525);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16263 40.8 -79.334444
var zip = "16263";
var point = new GLatLng(40.8,-79.334444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16301 41.431936 -79.691648
var zip = "16301";
var point = new GLatLng(41.431936,-79.691648);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16311 41.481541 -80.020302
var zip = "16311";
var point = new GLatLng(41.481541,-80.020302);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16312 41.934167 -79.303889
var zip = "16312";
var point = new GLatLng(41.934167,-79.303889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16313 41.730224 -79.171949
var zip = "16313";
var point = new GLatLng(41.730224,-79.171949);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16314 41.520487 -80.057269
var zip = "16314";
var point = new GLatLng(41.520487,-80.057269);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16316 41.6189 -80.308567
var zip = "16316";
var point = new GLatLng(41.6189,-80.308567);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16317 41.497998 -79.875676
var zip = "16317";
var point = new GLatLng(41.497998,-79.875676);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16319 41.337184 -79.719121
var zip = "16319";
var point = new GLatLng(41.337184,-79.719121);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16321 41.5691 -79.385483
var zip = "16321";
var point = new GLatLng(41.5691,-79.385483);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16322 41.589444 -79.385278
var zip = "16322";
var point = new GLatLng(41.589444,-79.385278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16323 41.404775 -79.83089
var zip = "16323";
var point = new GLatLng(41.404775,-79.83089);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16326 41.371736 -79.413401
var zip = "16326";
var point = new GLatLng(41.371736,-79.413401);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16327 41.633265 -79.971437
var zip = "16327";
var point = new GLatLng(41.633265,-79.971437);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16328 41.6525 -79.727222
var zip = "16328";
var point = new GLatLng(41.6525,-79.727222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16329 41.843283 -79.286303
var zip = "16329";
var point = new GLatLng(41.843283,-79.286303);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16331 41.290215 -79.588249
var zip = "16331";
var point = new GLatLng(41.290215,-79.588249);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16332 41.3789 -79.371516
var zip = "16332";
var point = new GLatLng(41.3789,-79.371516);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16333 41.728409 -78.924345
var zip = "16333";
var point = new GLatLng(41.728409,-78.924345);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16334 41.326077 -79.445929
var zip = "16334";
var point = new GLatLng(41.326077,-79.445929);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16335 41.633847 -80.148787
var zip = "16335";
var point = new GLatLng(41.633847,-80.148787);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16340 41.836629 -79.419619
var zip = "16340";
var point = new GLatLng(41.836629,-79.419619);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16341 41.586696 -79.5685
var zip = "16341";
var point = new GLatLng(41.586696,-79.5685);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16342 41.358315 -79.93461
var zip = "16342";
var point = new GLatLng(41.358315,-79.93461);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16343 41.409722 -79.7525
var zip = "16343";
var point = new GLatLng(41.409722,-79.7525);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16344 41.468889 -79.691111
var zip = "16344";
var point = new GLatLng(41.468889,-79.691111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16345 41.946106 -79.127079
var zip = "16345";
var point = new GLatLng(41.946106,-79.127079);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16346 41.374436 -79.675902
var zip = "16346";
var point = new GLatLng(41.374436,-79.675902);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16347 41.70053 -79.034814
var zip = "16347";
var point = new GLatLng(41.70053,-79.034814);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16350 41.947542 -79.318609
var zip = "16350";
var point = new GLatLng(41.947542,-79.318609);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16351 41.703008 -79.375224
var zip = "16351";
var point = new GLatLng(41.703008,-79.375224);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16352 41.746944 -79.0675
var zip = "16352";
var point = new GLatLng(41.746944,-79.0675);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16353 41.511616 -79.366332
var zip = "16353";
var point = new GLatLng(41.511616,-79.366332);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16354 41.638163 -79.685494
var zip = "16354";
var point = new GLatLng(41.638163,-79.685494);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16360 41.685581 -79.876679
var zip = "16360";
var point = new GLatLng(41.685581,-79.876679);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16361 41.384722 -79.3225
var zip = "16361";
var point = new GLatLng(41.384722,-79.3225);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16362 41.479848 -79.940292
var zip = "16362";
var point = new GLatLng(41.479848,-79.940292);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16364 41.376113 -79.504765
var zip = "16364";
var point = new GLatLng(41.376113,-79.504765);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16365 41.845265 -79.14286
var zip = "16365";
var point = new GLatLng(41.845265,-79.14286);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16366 41.8467 -79.1463
var zip = "16366";
var point = new GLatLng(41.8467,-79.1463);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16367 41.8467 -79.1463
var zip = "16367";
var point = new GLatLng(41.8467,-79.1463);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16368 41.8391 -79.2686
var zip = "16368";
var point = new GLatLng(41.8391,-79.2686);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16369 41.8391 -79.2686
var zip = "16369";
var point = new GLatLng(41.8391,-79.2686);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16370 41.568611 -79.408333
var zip = "16370";
var point = new GLatLng(41.568611,-79.408333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16371 41.853654 -79.318708
var zip = "16371";
var point = new GLatLng(41.853654,-79.318708);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16372 41.20022 -79.87338
var zip = "16372";
var point = new GLatLng(41.20022,-79.87338);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16373 41.202769 -79.746996
var zip = "16373";
var point = new GLatLng(41.202769,-79.746996);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16374 41.284762 -79.739313
var zip = "16374";
var point = new GLatLng(41.284762,-79.739313);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16375 41.2225 -79.634167
var zip = "16375";
var point = new GLatLng(41.2225,-79.634167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16388 41.641389 -80.151667
var zip = "16388";
var point = new GLatLng(41.641389,-80.151667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16401 41.885882 -80.375273
var zip = "16401";
var point = new GLatLng(41.885882,-80.375273);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16402 41.97006 -79.461365
var zip = "16402";
var point = new GLatLng(41.97006,-79.461365);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16403 41.794611 -80.028003
var zip = "16403";
var point = new GLatLng(41.794611,-80.028003);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16404 41.724316 -79.79004
var zip = "16404";
var point = new GLatLng(41.724316,-79.79004);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16405 41.938152 -79.573073
var zip = "16405";
var point = new GLatLng(41.938152,-79.573073);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16406 41.745455 -80.344516
var zip = "16406";
var point = new GLatLng(41.745455,-80.344516);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16407 41.922593 -79.656742
var zip = "16407";
var point = new GLatLng(41.922593,-79.656742);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16410 41.916222 -80.308528
var zip = "16410";
var point = new GLatLng(41.916222,-80.308528);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16411 41.979363 -80.430336
var zip = "16411";
var point = new GLatLng(41.979363,-80.430336);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16412 41.875629 -80.135604
var zip = "16412";
var point = new GLatLng(41.875629,-80.135604);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16413 41.903056 -79.743889
var zip = "16413";
var point = new GLatLng(41.903056,-79.743889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16415 42.040741 -80.239508
var zip = "16415";
var point = new GLatLng(42.040741,-80.239508);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16416 41.816111 -79.444167
var zip = "16416";
var point = new GLatLng(41.816111,-79.444167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16417 41.989573 -80.317756
var zip = "16417";
var point = new GLatLng(41.989573,-80.317756);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16420 41.77315 -79.546944
var zip = "16420";
var point = new GLatLng(41.77315,-79.546944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16421 42.176719 -79.941648
var zip = "16421";
var point = new GLatLng(42.176719,-79.941648);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16422 41.660833 -80.318056
var zip = "16422";
var point = new GLatLng(41.660833,-80.318056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16423 42.020361 -80.338834
var zip = "16423";
var point = new GLatLng(42.020361,-80.338834);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16424 41.663535 -80.426911
var zip = "16424";
var point = new GLatLng(41.663535,-80.426911);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16426 41.999035 -80.147336
var zip = "16426";
var point = new GLatLng(41.999035,-80.147336);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16427 41.876389 -79.971667
var zip = "16427";
var point = new GLatLng(41.876389,-79.971667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16428 42.200793 -79.833179
var zip = "16428";
var point = new GLatLng(42.200793,-79.833179);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16430 41.994444 -80.425278
var zip = "16430";
var point = new GLatLng(41.994444,-80.425278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16432 41.7775 -79.803056
var zip = "16432";
var point = new GLatLng(41.7775,-79.803056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16433 41.726753 -80.147857
var zip = "16433";
var point = new GLatLng(41.726753,-80.147857);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16434 41.793648 -79.684916
var zip = "16434";
var point = new GLatLng(41.793648,-79.684916);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16435 41.811348 -80.375276
var zip = "16435";
var point = new GLatLng(41.811348,-80.375276);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16436 41.846832 -79.56554
var zip = "16436";
var point = new GLatLng(41.846832,-79.56554);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16438 41.893851 -79.845464
var zip = "16438";
var point = new GLatLng(41.893851,-79.845464);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16440 41.791968 -80.125353
var zip = "16440";
var point = new GLatLng(41.791968,-80.125353);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16441 41.960266 -79.99963
var zip = "16441";
var point = new GLatLng(41.960266,-79.99963);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16442 42.039114 -79.836282
var zip = "16442";
var point = new GLatLng(42.039114,-79.836282);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16443 41.94646 -80.46501
var zip = "16443";
var point = new GLatLng(41.94646,-80.46501);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16444 41.874167 -80.131944
var zip = "16444";
var point = new GLatLng(41.874167,-80.131944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16475 41.890556 -80.366667
var zip = "16475";
var point = new GLatLng(41.890556,-80.366667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16501 42.125962 -80.08601
var zip = "16501";
var point = new GLatLng(42.125962,-80.08601);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16502 42.113332 -80.097607
var zip = "16502";
var point = new GLatLng(42.113332,-80.097607);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16503 42.126506 -80.063976
var zip = "16503";
var point = new GLatLng(42.126506,-80.063976);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16504 42.1108 -80.05208
var zip = "16504";
var point = new GLatLng(42.1108,-80.05208);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16505 42.097526 -80.161902
var zip = "16505";
var point = new GLatLng(42.097526,-80.161902);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16506 42.073801 -80.14844
var zip = "16506";
var point = new GLatLng(42.073801,-80.14844);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16507 42.131579 -80.086424
var zip = "16507";
var point = new GLatLng(42.131579,-80.086424);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16508 42.097577 -80.093544
var zip = "16508";
var point = new GLatLng(42.097577,-80.093544);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16509 42.076326 -80.066827
var zip = "16509";
var point = new GLatLng(42.076326,-80.066827);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16510 42.123673 -80.003752
var zip = "16510";
var point = new GLatLng(42.123673,-80.003752);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16511 42.15529 -80.017665
var zip = "16511";
var point = new GLatLng(42.15529,-80.017665);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16512 42.1185 -80.0229
var zip = "16512";
var point = new GLatLng(42.1185,-80.0229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16514 42.1185 -80.0229
var zip = "16514";
var point = new GLatLng(42.1185,-80.0229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16515 42.1185 -80.0229
var zip = "16515";
var point = new GLatLng(42.1185,-80.0229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16522 42.1185 -80.0229
var zip = "16522";
var point = new GLatLng(42.1185,-80.0229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16530 42.1185 -80.0229
var zip = "16530";
var point = new GLatLng(42.1185,-80.0229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16531 42.1185 -80.0229
var zip = "16531";
var point = new GLatLng(42.1185,-80.0229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16532 42.1185 -80.0229
var zip = "16532";
var point = new GLatLng(42.1185,-80.0229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16533 42.1185 -80.0229
var zip = "16533";
var point = new GLatLng(42.1185,-80.0229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16534 42.1185 -80.0229
var zip = "16534";
var point = new GLatLng(42.1185,-80.0229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16538 42.1185 -80.0229
var zip = "16538";
var point = new GLatLng(42.1185,-80.0229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16541 42.1185 -80.0229
var zip = "16541";
var point = new GLatLng(42.1185,-80.0229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16544 42.1185 -80.0229
var zip = "16544";
var point = new GLatLng(42.1185,-80.0229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16546 42.1073 -80.0486
var zip = "16546";
var point = new GLatLng(42.1073,-80.0486);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16550 42.1185 -80.0229
var zip = "16550";
var point = new GLatLng(42.1185,-80.0229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16553 42.1185 -80.0229
var zip = "16553";
var point = new GLatLng(42.1185,-80.0229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16554 42.1185 -80.0229
var zip = "16554";
var point = new GLatLng(42.1185,-80.0229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16563 42.1185 -80.0229
var zip = "16563";
var point = new GLatLng(42.1185,-80.0229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16565 42.0687 -80.10011
var zip = "16565";
var point = new GLatLng(42.0687,-80.10011);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16601 40.520945 -78.408901
var zip = "16601";
var point = new GLatLng(40.520945,-78.408901);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16602 40.50524 -78.390533
var zip = "16602";
var point = new GLatLng(40.50524,-78.390533);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16603 40.518611 -78.395
var zip = "16603";
var point = new GLatLng(40.518611,-78.395);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16611 40.549901 -78.107066
var zip = "16611";
var point = new GLatLng(40.549901,-78.107066);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16613 40.551266 -78.534639
var zip = "16613";
var point = new GLatLng(40.551266,-78.534639);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16616 40.757938 -78.508036
var zip = "16616";
var point = new GLatLng(40.757938,-78.508036);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16617 40.60394 -78.337234
var zip = "16617";
var point = new GLatLng(40.60394,-78.337234);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16619 40.686944 -78.411111
var zip = "16619";
var point = new GLatLng(40.686944,-78.411111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16620 40.838711 -78.352634
var zip = "16620";
var point = new GLatLng(40.838711,-78.352634);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16621 40.201891 -78.1406
var zip = "16621";
var point = new GLatLng(40.201891,-78.1406);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16622 40.298667 -78.023697
var zip = "16622";
var point = new GLatLng(40.298667,-78.023697);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16623 40.293977 -78.027178
var zip = "16623";
var point = new GLatLng(40.293977,-78.027178);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16624 40.58 -78.607222
var zip = "16624";
var point = new GLatLng(40.58,-78.607222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16625 40.329243 -78.479658
var zip = "16625";
var point = new GLatLng(40.329243,-78.479658);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16627 40.750323 -78.535238
var zip = "16627";
var point = new GLatLng(40.750323,-78.535238);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16629 40.536667 -78.515278
var zip = "16629";
var point = new GLatLng(40.536667,-78.515278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16630 40.460779 -78.586068
var zip = "16630";
var point = new GLatLng(40.460779,-78.586068);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16631 40.275833 -78.338611
var zip = "16631";
var point = new GLatLng(40.275833,-78.338611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16633 40.161111 -78.23
var zip = "16633";
var point = new GLatLng(40.161111,-78.23);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16634 40.219453 -78.183823
var zip = "16634";
var point = new GLatLng(40.219453,-78.183823);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16635 40.426228 -78.43833
var zip = "16635";
var point = new GLatLng(40.426228,-78.43833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16636 40.60885 -78.527072
var zip = "16636";
var point = new GLatLng(40.60885,-78.527072);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16637 40.328197 -78.447519
var zip = "16637";
var point = new GLatLng(40.328197,-78.447519);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16638 40.333889 -78.199167
var zip = "16638";
var point = new GLatLng(40.333889,-78.199167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16639 40.671924 -78.465912
var zip = "16639";
var point = new GLatLng(40.671924,-78.465912);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16640 40.701615 -78.48149
var zip = "16640";
var point = new GLatLng(40.701615,-78.48149);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16641 40.48772 -78.555435
var zip = "16641";
var point = new GLatLng(40.48772,-78.555435);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16644 40.7075 -78.446111
var zip = "16644";
var point = new GLatLng(40.7075,-78.446111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16645 40.798405 -78.499869
var zip = "16645";
var point = new GLatLng(40.798405,-78.499869);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16646 40.665874 -78.702924
var zip = "16646";
var point = new GLatLng(40.665874,-78.702924);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16647 40.412139 -78.128109
var zip = "16647";
var point = new GLatLng(40.412139,-78.128109);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16648 40.438727 -78.368627
var zip = "16648";
var point = new GLatLng(40.438727,-78.368627);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16650 40.119225 -78.312897
var zip = "16650";
var point = new GLatLng(40.119225,-78.312897);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16651 40.830538 -78.3618
var zip = "16651";
var point = new GLatLng(40.830538,-78.3618);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16652 40.502274 -78.005028
var zip = "16652";
var point = new GLatLng(40.502274,-78.005028);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16654 40.484722 -78.010556
var zip = "16654";
var point = new GLatLng(40.484722,-78.010556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16655 40.23186 -78.516719
var zip = "16655";
var point = new GLatLng(40.23186,-78.516719);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16656 40.801744 -78.560243
var zip = "16656";
var point = new GLatLng(40.801744,-78.560243);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16657 40.356672 -78.188678
var zip = "16657";
var point = new GLatLng(40.356672,-78.188678);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16659 40.174577 -78.386435
var zip = "16659";
var point = new GLatLng(40.174577,-78.386435);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16660 40.462222 -78.059444
var zip = "16660";
var point = new GLatLng(40.462222,-78.059444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16661 40.827086 -78.427475
var zip = "16661";
var point = new GLatLng(40.827086,-78.427475);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16662 40.295082 -78.324367
var zip = "16662";
var point = new GLatLng(40.295082,-78.324367);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16663 40.786389 -78.367222
var zip = "16663";
var point = new GLatLng(40.786389,-78.367222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16664 40.200013 -78.425916
var zip = "16664";
var point = new GLatLng(40.200013,-78.425916);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16665 40.393611 -78.435833
var zip = "16665";
var point = new GLatLng(40.393611,-78.435833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16666 40.872208 -78.275705
var zip = "16666";
var point = new GLatLng(40.872208,-78.275705);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16667 40.158583 -78.509928
var zip = "16667";
var point = new GLatLng(40.158583,-78.509928);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16668 40.623045 -78.635028
var zip = "16668";
var point = new GLatLng(40.623045,-78.635028);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16669 40.602968 -77.998402
var zip = "16669";
var point = new GLatLng(40.602968,-77.998402);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16670 40.259167 -78.507778
var zip = "16670";
var point = new GLatLng(40.259167,-78.507778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16671 40.801511 -78.399821
var zip = "16671";
var point = new GLatLng(40.801511,-78.399821);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16672 40.161944 -78.254722
var zip = "16672";
var point = new GLatLng(40.161944,-78.254722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16673 40.327747 -78.39284
var zip = "16673";
var point = new GLatLng(40.327747,-78.39284);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16674 40.178674 -78.111696
var zip = "16674";
var point = new GLatLng(40.178674,-78.111696);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16675 40.666667 -78.681111
var zip = "16675";
var point = new GLatLng(40.666667,-78.681111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16677 40.814722 -78.235833
var zip = "16677";
var point = new GLatLng(40.814722,-78.235833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16678 40.223301 -78.247137
var zip = "16678";
var point = new GLatLng(40.223301,-78.247137);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16679 40.157583 -78.210814
var zip = "16679";
var point = new GLatLng(40.157583,-78.210814);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16680 40.767808 -78.399442
var zip = "16680";
var point = new GLatLng(40.767808,-78.399442);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16681 40.794722 -78.427778
var zip = "16681";
var point = new GLatLng(40.794722,-78.427778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16682 40.2725 -78.460833
var zip = "16682";
var point = new GLatLng(40.2725,-78.460833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16683 40.621767 -78.136083
var zip = "16683";
var point = new GLatLng(40.621767,-78.136083);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16684 40.635833 -78.296111
var zip = "16684";
var point = new GLatLng(40.635833,-78.296111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16685 40.25775 -78.100354
var zip = "16685";
var point = new GLatLng(40.25775,-78.100354);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16686 40.661905 -78.241905
var zip = "16686";
var point = new GLatLng(40.661905,-78.241905);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16689 40.073871 -78.047708
var zip = "16689";
var point = new GLatLng(40.073871,-78.047708);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16691 40.100996 -78.140269
var zip = "16691";
var point = new GLatLng(40.100996,-78.140269);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16692 40.76152 -78.735481
var zip = "16692";
var point = new GLatLng(40.76152,-78.735481);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16693 40.437356 -78.22555
var zip = "16693";
var point = new GLatLng(40.437356,-78.22555);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16694 40.168333 -78.136667
var zip = "16694";
var point = new GLatLng(40.168333,-78.136667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16695 40.21847 -78.366573
var zip = "16695";
var point = new GLatLng(40.21847,-78.366573);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16698 40.825 -78.351389
var zip = "16698";
var point = new GLatLng(40.825,-78.351389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16699 40.459722 -78.591944
var zip = "16699";
var point = new GLatLng(40.459722,-78.591944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16701 41.954678 -78.653967
var zip = "16701";
var point = new GLatLng(41.954678,-78.653967);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16720 41.629649 -78.090812
var zip = "16720";
var point = new GLatLng(41.629649,-78.090812);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16724 41.713356 -78.374637
var zip = "16724";
var point = new GLatLng(41.713356,-78.374637);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16725 41.905833 -78.651944
var zip = "16725";
var point = new GLatLng(41.905833,-78.651944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16726 41.826327 -78.566743
var zip = "16726";
var point = new GLatLng(41.826327,-78.566743);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16727 41.972577 -78.562564
var zip = "16727";
var point = new GLatLng(41.972577,-78.562564);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16728 41.574722 -78.911944
var zip = "16728";
var point = new GLatLng(41.574722,-78.911944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16729 41.954017 -78.492269
var zip = "16729";
var point = new GLatLng(41.954017,-78.492269);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16730 41.808611 -78.419722
var zip = "16730";
var point = new GLatLng(41.808611,-78.419722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16731 41.948925 -78.388439
var zip = "16731";
var point = new GLatLng(41.948925,-78.388439);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16732 41.860715 -78.584604
var zip = "16732";
var point = new GLatLng(41.860715,-78.584604);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16733 41.705833 -78.582778
var zip = "16733";
var point = new GLatLng(41.705833,-78.582778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16734 41.593116 -78.85052
var zip = "16734";
var point = new GLatLng(41.593116,-78.85052);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16735 41.661861 -78.797778
var zip = "16735";
var point = new GLatLng(41.661861,-78.797778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16738 41.821123 -78.680498
var zip = "16738";
var point = new GLatLng(41.821123,-78.680498);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16740 41.724737 -78.644613
var zip = "16740";
var point = new GLatLng(41.724737,-78.644613);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16743 41.816919 -78.279909
var zip = "16743";
var point = new GLatLng(41.816919,-78.279909);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16744 41.912222 -78.535406
var zip = "16744";
var point = new GLatLng(41.912222,-78.535406);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16745 41.934606 -78.458647
var zip = "16745";
var point = new GLatLng(41.934606,-78.458647);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16746 41.773795 -78.153843
var zip = "16746";
var point = new GLatLng(41.773795,-78.153843);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16748 41.957176 -78.19062
var zip = "16748";
var point = new GLatLng(41.957176,-78.19062);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16749 41.802063 -78.470229
var zip = "16749";
var point = new GLatLng(41.802063,-78.470229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16750 41.884665 -78.330793
var zip = "16750";
var point = new GLatLng(41.884665,-78.330793);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16801 40.792522 -77.852279
var zip = "16801";
var point = new GLatLng(40.792522,-77.852279);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16802 40.801944 -77.856667
var zip = "16802";
var point = new GLatLng(40.801944,-77.856667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16803 40.808162 -77.892578
var zip = "16803";
var point = new GLatLng(40.808162,-77.892578);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16804 40.7915 -77.8604
var zip = "16804";
var point = new GLatLng(40.7915,-77.8604);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16805 40.7915 -77.8604
var zip = "16805";
var point = new GLatLng(40.7915,-77.8604);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16820 40.876944 -77.387977
var zip = "16820";
var point = new GLatLng(40.876944,-77.387977);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16821 40.975039 -78.21038
var zip = "16821";
var point = new GLatLng(40.975039,-78.21038);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16822 41.084507 -77.585118
var zip = "16822";
var point = new GLatLng(41.084507,-77.585118);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16823 40.909377 -77.7642
var zip = "16823";
var point = new GLatLng(40.909377,-77.7642);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16825 40.984722 -78.306667
var zip = "16825";
var point = new GLatLng(40.984722,-78.306667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16826 41.064167 -77.598056
var zip = "16826";
var point = new GLatLng(41.064167,-77.598056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16827 40.779344 -77.782236
var zip = "16827";
var point = new GLatLng(40.779344,-77.782236);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16828 40.825429 -77.674225
var zip = "16828";
var point = new GLatLng(40.825429,-77.674225);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16829 41.058482 -77.931213
var zip = "16829";
var point = new GLatLng(41.058482,-77.931213);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16830 41.02103 -78.443488
var zip = "16830";
var point = new GLatLng(41.02103,-78.443488);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16832 40.867818 -77.492173
var zip = "16832";
var point = new GLatLng(40.867818,-77.492173);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16833 40.965972 -78.527247
var zip = "16833";
var point = new GLatLng(40.965972,-78.527247);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16834 41.024167 -78.108611
var zip = "16834";
var point = new GLatLng(41.024167,-78.108611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16835 40.9125 -77.928611
var zip = "16835";
var point = new GLatLng(40.9125,-77.928611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16836 41.103794 -78.234465
var zip = "16836";
var point = new GLatLng(41.103794,-78.234465);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16837 40.938209 -78.475215
var zip = "16837";
var point = new GLatLng(40.938209,-78.475215);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16838 40.981768 -78.594913
var zip = "16838";
var point = new GLatLng(40.981768,-78.594913);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16839 40.995881 -78.128354
var zip = "16839";
var point = new GLatLng(40.995881,-78.128354);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16840 40.941215 -78.213787
var zip = "16840";
var point = new GLatLng(40.941215,-78.213787);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16841 41.020315 -77.670178
var zip = "16841";
var point = new GLatLng(41.020315,-77.670178);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16843 41.0025 -78.462778
var zip = "16843";
var point = new GLatLng(41.0025,-78.462778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16844 40.891709 -77.933243
var zip = "16844";
var point = new GLatLng(40.891709,-77.933243);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16845 41.113635 -78.087509
var zip = "16845";
var point = new GLatLng(41.113635,-78.087509);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16847 40.993333 -78.1675
var zip = "16847";
var point = new GLatLng(40.993333,-78.1675);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16848 41.016111 -77.531389
var zip = "16848";
var point = new GLatLng(41.016111,-77.531389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16849 40.975 -78.129722
var zip = "16849";
var point = new GLatLng(40.975,-78.129722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16850 41.083056 -78.283611
var zip = "16850";
var point = new GLatLng(41.083056,-78.283611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16851 40.810556 -77.818611
var zip = "16851";
var point = new GLatLng(40.810556,-77.818611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16852 40.933407 -77.494959
var zip = "16852";
var point = new GLatLng(40.933407,-77.494959);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16853 40.941667 -77.785278
var zip = "16853";
var point = new GLatLng(40.941667,-77.785278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16854 40.896314 -77.450531
var zip = "16854";
var point = new GLatLng(40.896314,-77.450531);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16855 40.998056 -78.363889
var zip = "16855";
var point = new GLatLng(40.998056,-78.363889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16856 40.932222 -77.648333
var zip = "16856";
var point = new GLatLng(40.932222,-77.648333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16858 41.000128 -78.235717
var zip = "16858";
var point = new GLatLng(41.000128,-78.235717);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16859 41.03419 -78.009469
var zip = "16859";
var point = new GLatLng(41.03419,-78.009469);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16860 40.966704 -78.18621
var zip = "16860";
var point = new GLatLng(40.966704,-78.18621);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16861 40.885302 -78.494543
var zip = "16861";
var point = new GLatLng(40.885302,-78.494543);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16863 40.905621 -78.500079
var zip = "16863";
var point = new GLatLng(40.905621,-78.500079);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16864 41.075386 -77.620306
var zip = "16864";
var point = new GLatLng(41.075386,-77.620306);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16865 40.728194 -77.954068
var zip = "16865";
var point = new GLatLng(40.728194,-77.954068);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16866 40.886252 -78.219008
var zip = "16866";
var point = new GLatLng(40.886252,-78.219008);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16868 40.733611 -77.885833
var zip = "16868";
var point = new GLatLng(40.733611,-77.885833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16870 40.801819 -78.078795
var zip = "16870";
var point = new GLatLng(40.801819,-78.078795);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16871 41.186798 -78.034056
var zip = "16871";
var point = new GLatLng(41.186798,-78.034056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16872 40.954906 -77.405322
var zip = "16872";
var point = new GLatLng(40.954906,-77.405322);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16873 41.069167 -78.358333
var zip = "16873";
var point = new GLatLng(41.069167,-78.358333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16874 41.037581 -77.95228
var zip = "16874";
var point = new GLatLng(41.037581,-77.95228);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16875 40.857753 -77.574031
var zip = "16875";
var point = new GLatLng(40.857753,-77.574031);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16876 40.959722 -78.289167
var zip = "16876";
var point = new GLatLng(40.959722,-78.289167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16877 40.741414 -78.077478
var zip = "16877";
var point = new GLatLng(40.741414,-78.077478);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16878 40.949305 -78.312936
var zip = "16878";
var point = new GLatLng(40.949305,-78.312936);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16879 40.967779 -78.156235
var zip = "16879";
var point = new GLatLng(40.967779,-78.156235);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16881 41.009833 -78.321445
var zip = "16881";
var point = new GLatLng(41.009833,-78.321445);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16882 40.911574 -77.348269
var zip = "16882";
var point = new GLatLng(40.911574,-77.348269);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16901 41.737343 -77.30802
var zip = "16901";
var point = new GLatLng(41.737343,-77.30802);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16910 41.705 -76.828611
var zip = "16910";
var point = new GLatLng(41.705,-76.828611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16911 41.6625 -77.123333
var zip = "16911";
var point = new GLatLng(41.6625,-77.123333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16912 41.669771 -77.079711
var zip = "16912";
var point = new GLatLng(41.669771,-77.079711);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16914 41.846282 -76.793242
var zip = "16914";
var point = new GLatLng(41.846282,-76.793242);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16915 41.781529 -78.003861
var zip = "16915";
var point = new GLatLng(41.781529,-78.003861);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16917 41.739297 -77.108795
var zip = "16917";
var point = new GLatLng(41.739297,-77.108795);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16918 41.933056 -77.4975
var zip = "16918";
var point = new GLatLng(41.933056,-77.4975);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16920 41.988165 -77.313392
var zip = "16920";
var point = new GLatLng(41.988165,-77.313392);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//16921 41.747134 -77.568001
var zip = "16921";
var point = new GLatLng(41.747134,-77.568001);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16922 41.723006 -77.654756
var zip = "16922";
var point = new GLatLng(41.723006,-77.654756);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16923 41.935312 -77.873585
var zip = "16923";
var point = new GLatLng(41.935312,-77.873585);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16925 41.956826 -76.771329
var zip = "16925";
var point = new GLatLng(41.956826,-76.771329);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16926 41.697299 -76.721829
var zip = "16926";
var point = new GLatLng(41.697299,-76.721829);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16927 41.949824 -77.687665
var zip = "16927";
var point = new GLatLng(41.949824,-77.687665);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16928 41.959557 -77.435678
var zip = "16928";
var point = new GLatLng(41.959557,-77.435678);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16929 41.978266 -77.11355
var zip = "16929";
var point = new GLatLng(41.978266,-77.11355);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16930 41.565571 -77.119505
var zip = "16930";
var point = new GLatLng(41.565571,-77.119505);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16932 41.790029 -76.968156
var zip = "16932";
var point = new GLatLng(41.790029,-76.968156);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16933 41.812288 -77.07163
var zip = "16933";
var point = new GLatLng(41.812288,-77.07163);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16935 41.891706 -77.314764
var zip = "16935";
var point = new GLatLng(41.891706,-77.314764);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16936 41.962467 -76.974766
var zip = "16936";
var point = new GLatLng(41.962467,-76.974766);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16937 41.902482 -77.762051
var zip = "16937";
var point = new GLatLng(41.902482,-77.762051);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16938 41.54752 -77.291975
var zip = "16938";
var point = new GLatLng(41.54752,-77.291975);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16939 41.672943 -77.027769
var zip = "16939";
var point = new GLatLng(41.672943,-77.027769);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//16940 41.978719 -77.241909
var zip = "16940";
var point = new GLatLng(41.978719,-77.241909);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16941 41.981963 -77.773995
var zip = "16941";
var point = new GLatLng(41.981963,-77.773995);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16942 41.984765 -77.353983
var zip = "16942";
var point = new GLatLng(41.984765,-77.353983);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16943 41.856414 -77.537825
var zip = "16943";
var point = new GLatLng(41.856414,-77.537825);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//16945 41.805 -76.857222
var zip = "16945";
var point = new GLatLng(41.805,-76.857222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16946 41.912454 -77.139294
var zip = "16946";
var point = new GLatLng(41.912454,-77.139294);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//16947 41.77815 -76.771143
var zip = "16947";
var point = new GLatLng(41.77815,-76.771143);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//16948 41.845903 -77.712557
var zip = "16948";
var point = new GLatLng(41.845903,-77.712557);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//16950 41.919063 -77.530975
var zip = "16950";
var point = new GLatLng(41.919063,-77.530975);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17001 40.2397 -76.9202
var zip = "17001";
var point = new GLatLng(40.2397,-76.9202);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17002 40.524921 -77.829396
var zip = "17002";
var point = new GLatLng(40.524921,-77.829396);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17003 40.345608 -76.544676
var zip = "17003";
var point = new GLatLng(40.345608,-76.544676);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17004 40.601571 -77.735823
var zip = "17004";
var point = new GLatLng(40.601571,-77.735823);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17005 40.60199 -76.811207
var zip = "17005";
var point = new GLatLng(40.60199,-76.811207);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17006 40.329314 -77.511736
var zip = "17006";
var point = new GLatLng(40.329314,-77.511736);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17007 40.144873 -77.119489
var zip = "17007";
var point = new GLatLng(40.144873,-77.119489);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17008 40.166111 -76.978333
var zip = "17008";
var point = new GLatLng(40.166111,-76.978333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17009 40.636119 -77.562459
var zip = "17009";
var point = new GLatLng(40.636119,-77.562459);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17010 40.2775 -76.585556
var zip = "17010";
var point = new GLatLng(40.2775,-76.585556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17011 40.238071 -76.929111
var zip = "17011";
var point = new GLatLng(40.238071,-76.929111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17012 40.2397 -76.9202
var zip = "17012";
var point = new GLatLng(40.2397,-76.9202);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17013 40.203877 -77.199526
var zip = "17013";
var point = new GLatLng(40.203877,-77.199526);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17014 40.656706 -77.106749
var zip = "17014";
var point = new GLatLng(40.656706,-77.106749);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17015 40.185099 -77.217413
var zip = "17015";
var point = new GLatLng(40.185099,-77.217413);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17016 40.273611 -76.406389
var zip = "17016";
var point = new GLatLng(40.273611,-76.406389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17017 40.648315 -76.879713
var zip = "17017";
var point = new GLatLng(40.648315,-76.879713);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17018 40.384581 -76.928304
var zip = "17018";
var point = new GLatLng(40.384581,-76.928304);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17019 40.096373 -77.03387
var zip = "17019";
var point = new GLatLng(40.096373,-77.03387);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17020 40.408678 -77.047254
var zip = "17020";
var point = new GLatLng(40.408678,-77.047254);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17021 40.354191 -77.652789
var zip = "17021";
var point = new GLatLng(40.354191,-77.652789);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17022 40.155331 -76.602545
var zip = "17022";
var point = new GLatLng(40.155331,-76.602545);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17023 40.55497 -76.835484
var zip = "17023";
var point = new GLatLng(40.55497,-76.835484);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17024 40.362428 -77.270348
var zip = "17024";
var point = new GLatLng(40.362428,-77.270348);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17025 40.292178 -76.943208
var zip = "17025";
var point = new GLatLng(40.292178,-76.943208);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17026 40.452392 -76.42674
var zip = "17026";
var point = new GLatLng(40.452392,-76.42674);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17027 40.156389 -76.989167
var zip = "17027";
var point = new GLatLng(40.156389,-76.989167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17028 40.360629 -76.671331
var zip = "17028";
var point = new GLatLng(40.360629,-76.671331);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17029 40.547868 -77.613358
var zip = "17029";
var point = new GLatLng(40.547868,-77.613358);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17030 40.610424 -76.718851
var zip = "17030";
var point = new GLatLng(40.610424,-76.718851);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17032 40.47603 -76.89404
var zip = "17032";
var point = new GLatLng(40.47603,-76.89404);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17033 40.263767 -76.654518
var zip = "17033";
var point = new GLatLng(40.263767,-76.654518);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17034 40.208348 -76.785303
var zip = "17034";
var point = new GLatLng(40.208348,-76.785303);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17035 40.430903 -77.57607
var zip = "17035";
var point = new GLatLng(40.430903,-77.57607);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17036 40.278199 -76.709375
var zip = "17036";
var point = new GLatLng(40.278199,-76.709375);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17037 40.434154 -77.34291
var zip = "17037";
var point = new GLatLng(40.434154,-77.34291);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17038 40.43607 -76.503842
var zip = "17038";
var point = new GLatLng(40.43607,-76.503842);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17039 40.300833 -76.249444
var zip = "17039";
var point = new GLatLng(40.300833,-76.249444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17040 40.332644 -77.319146
var zip = "17040";
var point = new GLatLng(40.332644,-77.319146);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17041 40.22 -76.539444
var zip = "17041";
var point = new GLatLng(40.22,-76.539444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17042 40.335912 -76.425895
var zip = "17042";
var point = new GLatLng(40.335912,-76.425895);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17043 40.247158 -76.89757
var zip = "17043";
var point = new GLatLng(40.247158,-76.89757);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17044 40.599439 -77.57558
var zip = "17044";
var point = new GLatLng(40.599439,-77.57558);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17045 40.575272 -77.008327
var zip = "17045";
var point = new GLatLng(40.575272,-77.008327);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17046 40.3602 -76.4261
var zip = "17046";
var point = new GLatLng(40.3602,-76.4261);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17047 40.36576 -77.413823
var zip = "17047";
var point = new GLatLng(40.36576,-77.413823);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17048 40.590919 -76.70736
var zip = "17048";
var point = new GLatLng(40.590919,-76.70736);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17049 40.646916 -77.2602
var zip = "17049";
var point = new GLatLng(40.646916,-77.2602);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17050 40.214167 -77.008889
var zip = "17050";
var point = new GLatLng(40.214167,-77.008889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17051 40.504593 -77.718625
var zip = "17051";
var point = new GLatLng(40.504593,-77.718625);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17052 40.386414 -77.960444
var zip = "17052";
var point = new GLatLng(40.386414,-77.960444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17053 40.335062 -76.972204
var zip = "17053";
var point = new GLatLng(40.335062,-76.972204);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17054 40.496111 -77.729722
var zip = "17054";
var point = new GLatLng(40.496111,-77.729722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17055 40.212669 -76.99493
var zip = "17055";
var point = new GLatLng(40.212669,-76.99493);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17056 40.5375 -77.353611
var zip = "17056";
var point = new GLatLng(40.5375,-77.353611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17057 40.204086 -76.733127
var zip = "17057";
var point = new GLatLng(40.204086,-76.733127);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17058 40.570842 -77.41314
var zip = "17058";
var point = new GLatLng(40.570842,-77.41314);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17059 40.572666 -77.376119
var zip = "17059";
var point = new GLatLng(40.572666,-77.376119);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17060 40.447102 -77.917689
var zip = "17060";
var point = new GLatLng(40.447102,-77.917689);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17061 40.558743 -76.930483
var zip = "17061";
var point = new GLatLng(40.558743,-76.930483);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17062 40.550548 -77.129776
var zip = "17062";
var point = new GLatLng(40.550548,-77.129776);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17063 40.72033 -77.556739
var zip = "17063";
var point = new GLatLng(40.72033,-77.556739);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17064 40.2475 -76.469722
var zip = "17064";
var point = new GLatLng(40.2475,-76.469722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17065 40.118356 -77.190807
var zip = "17065";
var point = new GLatLng(40.118356,-77.190807);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17066 40.390106 -77.863704
var zip = "17066";
var point = new GLatLng(40.390106,-77.863704);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17067 40.378949 -76.314328
var zip = "17067";
var point = new GLatLng(40.378949,-76.314328);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17068 40.419325 -77.193836
var zip = "17068";
var point = new GLatLng(40.419325,-77.193836);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17069 40.454167 -76.97
var zip = "17069";
var point = new GLatLng(40.454167,-76.97);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17070 40.215105 -76.868909
var zip = "17070";
var point = new GLatLng(40.215105,-76.868909);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17071 40.305749 -77.579701
var zip = "17071";
var point = new GLatLng(40.305749,-77.579701);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17072 40.233056 -77.08
var zip = "17072";
var point = new GLatLng(40.233056,-77.08);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17073 40.317938 -76.2426
var zip = "17073";
var point = new GLatLng(40.317938,-76.2426);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17074 40.482662 -77.165866
var zip = "17074";
var point = new GLatLng(40.482662,-77.165866);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17075 40.391667 -77.837222
var zip = "17075";
var point = new GLatLng(40.391667,-77.837222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17076 40.614748 -77.319244
var zip = "17076";
var point = new GLatLng(40.614748,-77.319244);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17077 40.402778 -76.535
var zip = "17077";
var point = new GLatLng(40.402778,-76.535);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17078 40.301055 -76.58861
var zip = "17078";
var point = new GLatLng(40.301055,-76.58861);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17080 40.640833 -76.802778
var zip = "17080";
var point = new GLatLng(40.640833,-76.802778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17081 40.203056 -77.290278
var zip = "17081";
var point = new GLatLng(40.203056,-77.290278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17082 40.51068 -77.430958
var zip = "17082";
var point = new GLatLng(40.51068,-77.430958);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17083 40.279444 -76.438611
var zip = "17083";
var point = new GLatLng(40.279444,-76.438611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17084 40.672189 -77.611589
var zip = "17084";
var point = new GLatLng(40.672189,-77.611589);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17085 40.277222 -76.382778
var zip = "17085";
var point = new GLatLng(40.277222,-76.382778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17086 40.688424 -77.122296
var zip = "17086";
var point = new GLatLng(40.688424,-77.122296);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17087 40.380595 -76.265447
var zip = "17087";
var point = new GLatLng(40.380595,-76.265447);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17088 40.298333 -76.294722
var zip = "17088";
var point = new GLatLng(40.298333,-76.294722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17089 40.2397 -76.9202
var zip = "17089";
var point = new GLatLng(40.2397,-76.9202);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17090 40.329898 -77.180856
var zip = "17090";
var point = new GLatLng(40.329898,-77.180856);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17091 40.2397 -76.9205
var zip = "17091";
var point = new GLatLng(40.2397,-76.9205);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17093 40.308889 -76.927778
var zip = "17093";
var point = new GLatLng(40.308889,-76.927778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17094 40.590782 -77.207551
var zip = "17094";
var point = new GLatLng(40.590782,-77.207551);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17097 40.567511 -76.709084
var zip = "17097";
var point = new GLatLng(40.567511,-76.709084);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17098 40.580761 -76.622259
var zip = "17098";
var point = new GLatLng(40.580761,-76.622259);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17099 40.643558 -77.568823
var zip = "17099";
var point = new GLatLng(40.643558,-77.568823);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17101 40.261767 -76.883079
var zip = "17101";
var point = new GLatLng(40.261767,-76.883079);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17102 40.27278 -76.891044
var zip = "17102";
var point = new GLatLng(40.27278,-76.891044);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17103 40.273852 -76.863812
var zip = "17103";
var point = new GLatLng(40.273852,-76.863812);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17104 40.259683 -76.859397
var zip = "17104";
var point = new GLatLng(40.259683,-76.859397);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17105 40.2846 -76.8736
var zip = "17105";
var point = new GLatLng(40.2846,-76.8736);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17106 40.2315 -76.8195
var zip = "17106";
var point = new GLatLng(40.2315,-76.8195);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17107 40.2315 -76.8195
var zip = "17107";
var point = new GLatLng(40.2315,-76.8195);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17108 40.2615 -76.8831
var zip = "17108";
var point = new GLatLng(40.2615,-76.8831);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17109 40.29122 -76.822612
var zip = "17109";
var point = new GLatLng(40.29122,-76.822612);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17110 40.302957 -76.886246
var zip = "17110";
var point = new GLatLng(40.302957,-76.886246);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17111 40.266058 -76.793918
var zip = "17111";
var point = new GLatLng(40.266058,-76.793918);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17112 40.335208 -76.791438
var zip = "17112";
var point = new GLatLng(40.335208,-76.791438);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17113 40.234007 -76.827568
var zip = "17113";
var point = new GLatLng(40.234007,-76.827568);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17120 40.2315 -76.8195
var zip = "17120";
var point = new GLatLng(40.2315,-76.8195);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17121 40.3136 -76.875
var zip = "17121";
var point = new GLatLng(40.3136,-76.875);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17122 40.2315 -76.8195
var zip = "17122";
var point = new GLatLng(40.2315,-76.8195);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17123 40.2315 -76.8195
var zip = "17123";
var point = new GLatLng(40.2315,-76.8195);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17124 40.2315 -76.8195
var zip = "17124";
var point = new GLatLng(40.2315,-76.8195);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17125 40.2315 -76.8195
var zip = "17125";
var point = new GLatLng(40.2315,-76.8195);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17126 40.2315 -76.8195
var zip = "17126";
var point = new GLatLng(40.2315,-76.8195);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17127 40.2315 -76.8195
var zip = "17127";
var point = new GLatLng(40.2315,-76.8195);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17128 40.2315 -76.8195
var zip = "17128";
var point = new GLatLng(40.2315,-76.8195);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17129 40.2315 -76.8195
var zip = "17129";
var point = new GLatLng(40.2315,-76.8195);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17130 40.2315 -76.8195
var zip = "17130";
var point = new GLatLng(40.2315,-76.8195);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17140 40.2315 -76.8195
var zip = "17140";
var point = new GLatLng(40.2315,-76.8195);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17177 40.2959 -76.8553
var zip = "17177";
var point = new GLatLng(40.2959,-76.8553);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17201 39.931318 -77.657928
var zip = "17201";
var point = new GLatLng(39.931318,-77.657928);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17210 40.170278 -77.6775
var zip = "17210";
var point = new GLatLng(40.170278,-77.6775);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17211 39.757465 -78.40314
var zip = "17211";
var point = new GLatLng(39.757465,-78.40314);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17212 39.889704 -78.012366
var zip = "17212";
var point = new GLatLng(39.889704,-78.012366);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17213 40.254804 -77.769473
var zip = "17213";
var point = new GLatLng(40.254804,-77.769473);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17214 39.726951 -77.469836
var zip = "17214";
var point = new GLatLng(39.726951,-77.469836);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17215 40.075278 -77.901718
var zip = "17215";
var point = new GLatLng(40.075278,-77.901718);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17217 40.245842 -77.703133
var zip = "17217";
var point = new GLatLng(40.245842,-77.703133);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17219 40.217195 -77.686203
var zip = "17219";
var point = new GLatLng(40.217195,-77.686203);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17220 40.174744 -77.76457
var zip = "17220";
var point = new GLatLng(40.174744,-77.76457);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17221 40.071692 -77.82101
var zip = "17221";
var point = new GLatLng(40.071692,-77.82101);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17222 39.906543 -77.53096
var zip = "17222";
var point = new GLatLng(39.906543,-77.53096);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17223 40.054372 -77.975678
var zip = "17223";
var point = new GLatLng(40.054372,-77.975678);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17224 39.954692 -77.898365
var zip = "17224";
var point = new GLatLng(39.954692,-77.898365);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17225 39.781827 -77.746956
var zip = "17225";
var point = new GLatLng(39.781827,-77.746956);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17228 39.976137 -78.084077
var zip = "17228";
var point = new GLatLng(39.976137,-78.084077);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17229 40.044111 -78.014835
var zip = "17229";
var point = new GLatLng(40.044111,-78.014835);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17231 39.861111 -77.859722
var zip = "17231";
var point = new GLatLng(39.861111,-77.859722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17232 40.127422 -77.635063
var zip = "17232";
var point = new GLatLng(40.127422,-77.635063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17233 39.944251 -77.990117
var zip = "17233";
var point = new GLatLng(39.944251,-77.990117);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17235 39.857222 -77.695556
var zip = "17235";
var point = new GLatLng(39.857222,-77.695556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17236 39.819519 -77.907259
var zip = "17236";
var point = new GLatLng(39.819519,-77.907259);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17237 39.841689 -77.553676
var zip = "17237";
var point = new GLatLng(39.841689,-77.553676);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17238 39.871279 -78.143935
var zip = "17238";
var point = new GLatLng(39.871279,-78.143935);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17239 40.137051 -77.858015
var zip = "17239";
var point = new GLatLng(40.137051,-77.858015);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17240 40.13333 -77.566915
var zip = "17240";
var point = new GLatLng(40.13333,-77.566915);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17241 40.185468 -77.411401
var zip = "17241";
var point = new GLatLng(40.185468,-77.411401);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17243 40.238872 -77.906924
var zip = "17243";
var point = new GLatLng(40.238872,-77.906924);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17244 40.07305 -77.639762
var zip = "17244";
var point = new GLatLng(40.07305,-77.639762);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17246 40.04135 -77.703148
var zip = "17246";
var point = new GLatLng(40.04135,-77.703148);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17247 39.803333 -77.574722
var zip = "17247";
var point = new GLatLng(39.803333,-77.574722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17249 40.242778 -77.900278
var zip = "17249";
var point = new GLatLng(40.242778,-77.900278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17250 39.736667 -77.535278
var zip = "17250";
var point = new GLatLng(39.736667,-77.535278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17251 40.110278 -77.662222
var zip = "17251";
var point = new GLatLng(40.110278,-77.662222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17252 39.924052 -77.7908
var zip = "17252";
var point = new GLatLng(39.924052,-77.7908);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17253 40.210556 -78.006944
var zip = "17253";
var point = new GLatLng(40.210556,-78.006944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17254 39.968611 -77.5875
var zip = "17254";
var point = new GLatLng(39.968611,-77.5875);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17255 40.172976 -77.868045
var zip = "17255";
var point = new GLatLng(40.172976,-77.868045);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17256 39.777778 -77.668889
var zip = "17256";
var point = new GLatLng(39.777778,-77.668889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17257 40.051359 -77.519477
var zip = "17257";
var point = new GLatLng(40.051359,-77.519477);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17260 40.316768 -77.870062
var zip = "17260";
var point = new GLatLng(40.316768,-77.870062);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17261 39.846389 -77.488056
var zip = "17261";
var point = new GLatLng(39.846389,-77.488056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17262 40.14663 -77.740525
var zip = "17262";
var point = new GLatLng(40.14663,-77.740525);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17263 39.724722 -77.724722
var zip = "17263";
var point = new GLatLng(39.724722,-77.724722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17264 40.183437 -77.99412
var zip = "17264";
var point = new GLatLng(40.183437,-77.99412);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17265 40.05799 -77.736791
var zip = "17265";
var point = new GLatLng(40.05799,-77.736791);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17266 40.086042 -77.408984
var zip = "17266";
var point = new GLatLng(40.086042,-77.408984);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17267 39.769765 -78.198627
var zip = "17267";
var point = new GLatLng(39.769765,-78.198627);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17268 39.763504 -77.567363
var zip = "17268";
var point = new GLatLng(39.763504,-77.567363);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17270 39.853056 -77.797778
var zip = "17270";
var point = new GLatLng(39.853056,-77.797778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17271 40.113694 -77.796947
var zip = "17271";
var point = new GLatLng(40.113694,-77.796947);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17272 39.77 -77.63
var zip = "17272";
var point = new GLatLng(39.77,-77.63);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17301 39.888099 -76.993077
var zip = "17301";
var point = new GLatLng(39.888099,-76.993077);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17302 39.821012 -76.401179
var zip = "17302";
var point = new GLatLng(39.821012,-76.401179);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17303 39.923056 -77.298889
var zip = "17303";
var point = new GLatLng(39.923056,-77.298889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17304 39.976533 -77.228657
var zip = "17304";
var point = new GLatLng(39.976533,-77.228657);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17306 39.9825 -77.249722
var zip = "17306";
var point = new GLatLng(39.9825,-77.249722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17307 39.928119 -77.288549
var zip = "17307";
var point = new GLatLng(39.928119,-77.288549);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17309 39.883044 -76.488236
var zip = "17309";
var point = new GLatLng(39.883044,-76.488236);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17310 39.884444 -77.359722
var zip = "17310";
var point = new GLatLng(39.884444,-77.359722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17311 39.817222 -76.841389
var zip = "17311";
var point = new GLatLng(39.817222,-76.841389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17312 39.9475 -76.510833
var zip = "17312";
var point = new GLatLng(39.9475,-76.510833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17313 39.900127 -76.644794
var zip = "17313";
var point = new GLatLng(39.900127,-76.644794);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17314 39.751754 -76.344101
var zip = "17314";
var point = new GLatLng(39.751754,-76.344101);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17315 40.006158 -76.855485
var zip = "17315";
var point = new GLatLng(40.006158,-76.855485);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17316 39.964546 -77.007252
var zip = "17316";
var point = new GLatLng(39.964546,-77.007252);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17317 39.971944 -76.520278
var zip = "17317";
var point = new GLatLng(39.971944,-76.520278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17318 40.021667 -76.728333
var zip = "17318";
var point = new GLatLng(40.021667,-76.728333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17319 40.154506 -76.801861
var zip = "17319";
var point = new GLatLng(40.154506,-76.801861);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17320 39.762694 -77.376824
var zip = "17320";
var point = new GLatLng(39.762694,-77.376824);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17321 39.751024 -76.439237
var zip = "17321";
var point = new GLatLng(39.751024,-76.439237);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17322 39.836006 -76.593721
var zip = "17322";
var point = new GLatLng(39.836006,-76.593721);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17323 40.076667 -77.028611
var zip = "17323";
var point = new GLatLng(40.076667,-77.028611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17324 40.042759 -77.187725
var zip = "17324";
var point = new GLatLng(40.042759,-77.187725);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17325 39.832044 -77.222313
var zip = "17325";
var point = new GLatLng(39.832044,-77.222313);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17326 39.830833 -77.231389
var zip = "17326";
var point = new GLatLng(39.830833,-77.231389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17327 39.781326 -76.747713
var zip = "17327";
var point = new GLatLng(39.781326,-76.747713);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17329 39.759907 -76.862046
var zip = "17329";
var point = new GLatLng(39.759907,-76.862046);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17331 39.794286 -76.981196
var zip = "17331";
var point = new GLatLng(39.794286,-76.981196);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17332 39.8 -76.9869
var zip = "17332";
var point = new GLatLng(39.8,-76.9869);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17333 39.8005 -76.9833
var zip = "17333";
var point = new GLatLng(39.8005,-76.9833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17334 39.8009 -76.9835
var zip = "17334";
var point = new GLatLng(39.8009,-76.9835);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17337 40.014722 -77.203056
var zip = "17337";
var point = new GLatLng(40.014722,-77.203056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17339 40.146295 -76.870004
var zip = "17339";
var point = new GLatLng(40.146295,-76.870004);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17340 39.749549 -77.100326
var zip = "17340";
var point = new GLatLng(39.749549,-77.100326);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17342 39.855556 -76.707778
var zip = "17342";
var point = new GLatLng(39.855556,-76.707778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17343 39.870556 -77.325833
var zip = "17343";
var point = new GLatLng(39.870556,-77.325833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17344 39.804832 -77.01496
var zip = "17344";
var point = new GLatLng(39.804832,-77.01496);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17345 40.069461 -76.733245
var zip = "17345";
var point = new GLatLng(40.069461,-76.733245);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17347 40.071126 -76.696576
var zip = "17347";
var point = new GLatLng(40.071126,-76.696576);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17349 39.742266 -76.684064
var zip = "17349";
var point = new GLatLng(39.742266,-76.684064);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17350 39.877459 -77.06433
var zip = "17350";
var point = new GLatLng(39.877459,-77.06433);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17352 39.760027 -76.504167
var zip = "17352";
var point = new GLatLng(39.760027,-76.504167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17353 39.881032 -77.380592
var zip = "17353";
var point = new GLatLng(39.881032,-77.380592);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17354 39.825278 -76.895
var zip = "17354";
var point = new GLatLng(39.825278,-76.895);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17355 39.760556 -76.698611
var zip = "17355";
var point = new GLatLng(39.760556,-76.698611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17356 39.902572 -76.608075
var zip = "17356";
var point = new GLatLng(39.902572,-76.608075);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17358 40.072222 -76.9275
var zip = "17358";
var point = new GLatLng(40.072222,-76.9275);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17360 39.855613 -76.738336
var zip = "17360";
var point = new GLatLng(39.855613,-76.738336);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17361 39.760133 -76.674827
var zip = "17361";
var point = new GLatLng(39.760133,-76.674827);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17362 39.857208 -76.877356
var zip = "17362";
var point = new GLatLng(39.857208,-76.877356);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17363 39.771962 -76.597037
var zip = "17363";
var point = new GLatLng(39.771962,-76.597037);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17364 39.934619 -76.882159
var zip = "17364";
var point = new GLatLng(39.934619,-76.882159);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17365 40.055721 -76.944315
var zip = "17365";
var point = new GLatLng(40.055721,-76.944315);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17366 39.923271 -76.559126
var zip = "17366";
var point = new GLatLng(39.923271,-76.559126);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17368 39.996559 -76.526971
var zip = "17368";
var point = new GLatLng(39.996559,-76.526971);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17370 40.122154 -76.773725
var zip = "17370";
var point = new GLatLng(40.122154,-76.773725);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17371 39.903056 -76.789167
var zip = "17371";
var point = new GLatLng(39.903056,-76.789167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17372 40.00839 -77.106136
var zip = "17372";
var point = new GLatLng(40.00839,-77.106136);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17375 40.023056 -77.230278
var zip = "17375";
var point = new GLatLng(40.023056,-77.230278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17401 39.963539 -76.726887
var zip = "17401";
var point = new GLatLng(39.963539,-76.726887);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17402 39.971508 -76.674578
var zip = "17402";
var point = new GLatLng(39.971508,-76.674578);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17403 39.94943 -76.712998
var zip = "17403";
var point = new GLatLng(39.94943,-76.712998);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17404 39.961988 -76.768987
var zip = "17404";
var point = new GLatLng(39.961988,-76.768987);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17405 39.9594 -76.7263
var zip = "17405";
var point = new GLatLng(39.9594,-76.7263);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17406 39.998249 -76.592646
var zip = "17406";
var point = new GLatLng(39.998249,-76.592646);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17407 39.880203 -76.714634
var zip = "17407";
var point = new GLatLng(39.880203,-76.714634);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17408 39.9492 -76.8018
var zip = "17408";
var point = new GLatLng(39.9492,-76.8018);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17415 39.9933 -76.6475
var zip = "17415";
var point = new GLatLng(39.9933,-76.6475);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17501 40.157086 -76.205295
var zip = "17501";
var point = new GLatLng(40.157086,-76.205295);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17502 40.1086 -76.672589
var zip = "17502";
var point = new GLatLng(40.1086,-76.672589);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17503 39.923333 -76.076389
var zip = "17503";
var point = new GLatLng(39.923333,-76.076389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17504 40.024167 -76.331111
var zip = "17504";
var point = new GLatLng(40.024167,-76.331111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17505 40.056109 -76.183036
var zip = "17505";
var point = new GLatLng(40.056109,-76.183036);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17506 40.118611 -76.0475
var zip = "17506";
var point = new GLatLng(40.118611,-76.0475);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17507 40.196667 -76.017778
var zip = "17507";
var point = new GLatLng(40.196667,-76.017778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17508 40.123611 -76.214167
var zip = "17508";
var point = new GLatLng(40.123611,-76.214167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17509 39.935632 -76.025983
var zip = "17509";
var point = new GLatLng(39.935632,-76.025983);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17512 40.039079 -76.48622
var zip = "17512";
var point = new GLatLng(40.039079,-76.48622);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17516 39.940303 -76.357475
var zip = "17516";
var point = new GLatLng(39.940303,-76.357475);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17517 40.229671 -76.115688
var zip = "17517";
var point = new GLatLng(40.229671,-76.115688);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17518 39.838399 -76.245684
var zip = "17518";
var point = new GLatLng(39.838399,-76.245684);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17519 40.139475 -76.027634
var zip = "17519";
var point = new GLatLng(40.139475,-76.027634);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17520 40.100781 -76.351169
var zip = "17520";
var point = new GLatLng(40.100781,-76.351169);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17521 40.203889 -76.349167
var zip = "17521";
var point = new GLatLng(40.203889,-76.349167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17522 40.175641 -76.182093
var zip = "17522";
var point = new GLatLng(40.175641,-76.182093);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17527 40.002018 -75.997801
var zip = "17527";
var point = new GLatLng(40.002018,-75.997801);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17528 40.125556 -76.003611
var zip = "17528";
var point = new GLatLng(40.125556,-76.003611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17529 40.035304 -76.11063
var zip = "17529";
var point = new GLatLng(40.035304,-76.11063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17532 39.863146 -76.300822
var zip = "17532";
var point = new GLatLng(39.863146,-76.300822);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17533 40.233611 -76.2625
var zip = "17533";
var point = new GLatLng(40.233611,-76.2625);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17534 40.0375 -76.105278
var zip = "17534";
var point = new GLatLng(40.0375,-76.105278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17535 40.005326 -76.049326
var zip = "17535";
var point = new GLatLng(40.005326,-76.049326);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17536 39.82571 -76.093315
var zip = "17536";
var point = new GLatLng(39.82571,-76.093315);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17537 39.99 -76.24
var zip = "17537";
var point = new GLatLng(39.99,-76.24);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17538 40.08825 -76.414975
var zip = "17538";
var point = new GLatLng(40.08825,-76.414975);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17540 40.096448 -76.192109
var zip = "17540";
var point = new GLatLng(40.096448,-76.192109);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17543 40.162573 -76.29926
var zip = "17543";
var point = new GLatLng(40.162573,-76.29926);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17545 40.170229 -76.416794
var zip = "17545";
var point = new GLatLng(40.170229,-76.416794);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17547 40.066442 -76.564527
var zip = "17547";
var point = new GLatLng(40.066442,-76.564527);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17549 40.153056 -76.088889
var zip = "17549";
var point = new GLatLng(40.153056,-76.088889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17550 40.075278 -76.5825
var zip = "17550";
var point = new GLatLng(40.075278,-76.5825);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17551 39.998213 -76.356568
var zip = "17551";
var point = new GLatLng(39.998213,-76.356568);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17552 40.106828 -76.507551
var zip = "17552";
var point = new GLatLng(40.106828,-76.507551);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17554 40.042742 -76.427694
var zip = "17554";
var point = new GLatLng(40.042742,-76.427694);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17555 40.125165 -75.975584
var zip = "17555";
var point = new GLatLng(40.125165,-75.975584);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17557 40.100511 -76.080136
var zip = "17557";
var point = new GLatLng(40.100511,-76.080136);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17560 39.909776 -76.224319
var zip = "17560";
var point = new GLatLng(39.909776,-76.224319);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17562 39.985249 -76.108074
var zip = "17562";
var point = new GLatLng(39.985249,-76.108074);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17563 39.770511 -76.179083
var zip = "17563";
var point = new GLatLng(39.770511,-76.179083);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17564 40.205 -76.368611
var zip = "17564";
var point = new GLatLng(40.205,-76.368611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17565 39.905765 -76.320866
var zip = "17565";
var point = new GLatLng(39.905765,-76.320866);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17566 39.894932 -76.146462
var zip = "17566";
var point = new GLatLng(39.894932,-76.146462);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17567 40.211389 -76.123611
var zip = "17567";
var point = new GLatLng(40.211389,-76.123611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17568 39.947222 -76.233056
var zip = "17568";
var point = new GLatLng(39.947222,-76.233056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17569 40.268758 -76.101332
var zip = "17569";
var point = new GLatLng(40.268758,-76.101332);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17570 40.13 -76.570833
var zip = "17570";
var point = new GLatLng(40.13,-76.570833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17572 40.020754 -76.166132
var zip = "17572";
var point = new GLatLng(40.020754,-76.166132);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17573 40.026111 -76.168889
var zip = "17573";
var point = new GLatLng(40.026111,-76.168889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17575 40.064167 -76.4375
var zip = "17575";
var point = new GLatLng(40.064167,-76.4375);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17576 40.040651 -76.22007
var zip = "17576";
var point = new GLatLng(40.040651,-76.22007);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17578 40.219397 -76.162604
var zip = "17578";
var point = new GLatLng(40.219397,-76.162604);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17579 39.970075 -76.184824
var zip = "17579";
var point = new GLatLng(39.970075,-76.184824);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17580 40 -76.213611
var zip = "17580";
var point = new GLatLng(40,-76.213611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17581 40.158539 -76.051083
var zip = "17581";
var point = new GLatLng(40.158539,-76.051083);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17582 39.988118 -76.4402
var zip = "17582";
var point = new GLatLng(39.988118,-76.4402);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17583 39.972778 -76.288333
var zip = "17583";
var point = new GLatLng(39.972778,-76.288333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17584 39.967003 -76.27524
var zip = "17584";
var point = new GLatLng(39.967003,-76.27524);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17585 40.048056 -76.211667
var zip = "17585";
var point = new GLatLng(40.048056,-76.211667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17601 40.075381 -76.319888
var zip = "17601";
var point = new GLatLng(40.075381,-76.319888);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17602 40.033514 -76.284364
var zip = "17602";
var point = new GLatLng(40.033514,-76.284364);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17603 40.030475 -76.331583
var zip = "17603";
var point = new GLatLng(40.030475,-76.331583);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17604 40.0598 -76.3357
var zip = "17604";
var point = new GLatLng(40.0598,-76.3357);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17605 40.0494 -76.2506
var zip = "17605";
var point = new GLatLng(40.0494,-76.2506);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17606 40.0932 -76.3036
var zip = "17606";
var point = new GLatLng(40.0932,-76.3036);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17607 40.0516 -76.3608
var zip = "17607";
var point = new GLatLng(40.0516,-76.3608);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17608 40.0405 -76.308
var zip = "17608";
var point = new GLatLng(40.0405,-76.308);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17611 40.0092 -76.372
var zip = "17611";
var point = new GLatLng(40.0092,-76.372);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17699 40.0377 -76.3058
var zip = "17699";
var point = new GLatLng(40.0377,-76.3058);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17701 41.247217 -77.020571
var zip = "17701";
var point = new GLatLng(41.247217,-77.020571);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17702 41.228333 -77.006111
var zip = "17702";
var point = new GLatLng(41.228333,-77.006111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17703 41.2411 -77.0013
var zip = "17703";
var point = new GLatLng(41.2411,-77.0013);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17705 41.2239 -77.0817
var zip = "17705";
var point = new GLatLng(41.2239,-77.0817);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17720 41.191667 -77.224167
var zip = "17720";
var point = new GLatLng(41.191667,-77.224167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17721 41.184722 -77.314167
var zip = "17721";
var point = new GLatLng(41.184722,-77.314167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17723 41.380901 -77.462021
var zip = "17723";
var point = new GLatLng(41.380901,-77.462021);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17724 41.653784 -76.858188
var zip = "17724";
var point = new GLatLng(41.653784,-76.858188);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17726 41.124722 -77.43
var zip = "17726";
var point = new GLatLng(41.124722,-77.43);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17727 41.498972 -77.48891
var zip = "17727";
var point = new GLatLng(41.498972,-77.48891);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17728 41.31517 -77.068996
var zip = "17728";
var point = new GLatLng(41.31517,-77.068996);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17729 41.473672 -77.80953
var zip = "17729";
var point = new GLatLng(41.473672,-77.80953);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17730 41.109167 -76.876944
var zip = "17730";
var point = new GLatLng(41.109167,-76.876944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17731 41.410833 -76.582222
var zip = "17731";
var point = new GLatLng(41.410833,-76.582222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17735 41.614444 -76.8675
var zip = "17735";
var point = new GLatLng(41.614444,-76.8675);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17737 41.255952 -76.71411
var zip = "17737";
var point = new GLatLng(41.255952,-76.71411);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17738 41.331667 -77.644444
var zip = "17738";
var point = new GLatLng(41.331667,-77.644444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17739 41.357222 -77.406944
var zip = "17739";
var point = new GLatLng(41.357222,-77.406944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17740 41.200733 -77.242704
var zip = "17740";
var point = new GLatLng(41.200733,-77.242704);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17742 41.233549 -76.58893
var zip = "17742";
var point = new GLatLng(41.233549,-76.58893);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17744 41.247216 -77.152652
var zip = "17744";
var point = new GLatLng(41.247216,-77.152652);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17745 41.142497 -77.443588
var zip = "17745";
var point = new GLatLng(41.142497,-77.443588);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17747 41.028317 -77.320397
var zip = "17747";
var point = new GLatLng(41.028317,-77.320397);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17748 41.161667 -77.355
var zip = "17748";
var point = new GLatLng(41.161667,-77.355);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17749 41.072778 -76.818056
var zip = "17749";
var point = new GLatLng(41.072778,-76.818056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17750 41.054444 -77.461667
var zip = "17750";
var point = new GLatLng(41.054444,-77.461667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17751 41.086688 -77.483609
var zip = "17751";
var point = new GLatLng(41.086688,-77.483609);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17752 41.178778 -76.883933
var zip = "17752";
var point = new GLatLng(41.178778,-76.883933);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17754 41.266252 -76.903035
var zip = "17754";
var point = new GLatLng(41.266252,-76.903035);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17756 41.213715 -76.763258
var zip = "17756";
var point = new GLatLng(41.213715,-76.763258);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17758 41.381206 -76.541518
var zip = "17758";
var point = new GLatLng(41.381206,-76.541518);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17760 41.35 -77.7025
var zip = "17760";
var point = new GLatLng(41.35,-77.7025);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17762 41.279722 -76.713333
var zip = "17762";
var point = new GLatLng(41.279722,-76.713333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17763 41.503817 -76.95835
var zip = "17763";
var point = new GLatLng(41.503817,-76.95835);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17764 41.333376 -77.74479
var zip = "17764";
var point = new GLatLng(41.333376,-77.74479);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17765 41.569234 -76.942053
var zip = "17765";
var point = new GLatLng(41.569234,-76.942053);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17767 41.084167 -77.463333
var zip = "17767";
var point = new GLatLng(41.084167,-77.463333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17768 41.553574 -76.745521
var zip = "17768";
var point = new GLatLng(41.553574,-76.745521);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17769 41.472778 -77.501944
var zip = "17769";
var point = new GLatLng(41.472778,-77.501944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17771 41.412481 -77.009776
var zip = "17771";
var point = new GLatLng(41.412481,-77.009776);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17772 41.111867 -76.742493
var zip = "17772";
var point = new GLatLng(41.111867,-76.742493);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17773 40.990556 -77.425278
var zip = "17773";
var point = new GLatLng(40.990556,-77.425278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17774 41.243552 -76.518318
var zip = "17774";
var point = new GLatLng(41.243552,-76.518318);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17776 41.31136 -77.360368
var zip = "17776";
var point = new GLatLng(41.31136,-77.360368);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17777 41.102006 -76.853192
var zip = "17777";
var point = new GLatLng(41.102006,-76.853192);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17778 41.27445 -77.931496
var zip = "17778";
var point = new GLatLng(41.27445,-77.931496);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17779 41.188734 -77.331307
var zip = "17779";
var point = new GLatLng(41.188734,-77.331307);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17801 40.855122 -76.777611
var zip = "17801";
var point = new GLatLng(40.855122,-76.777611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17810 41.126424 -76.972362
var zip = "17810";
var point = new GLatLng(41.126424,-76.972362);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17812 40.752766 -77.231801
var zip = "17812";
var point = new GLatLng(40.752766,-77.231801);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17813 40.777378 -77.169112
var zip = "17813";
var point = new GLatLng(40.777378,-77.169112);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17814 41.223142 -76.340632
var zip = "17814";
var point = new GLatLng(41.223142,-76.340632);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17815 41.011528 -76.438379
var zip = "17815";
var point = new GLatLng(41.011528,-76.438379);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17820 40.918031 -76.441586
var zip = "17820";
var point = new GLatLng(40.918031,-76.441586);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17821 40.979895 -76.622897
var zip = "17821";
var point = new GLatLng(40.979895,-76.622897);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17822 40.963333 -76.613056
var zip = "17822";
var point = new GLatLng(40.963333,-76.613056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17823 40.757092 -76.7626
var zip = "17823";
var point = new GLatLng(40.757092,-76.7626);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17824 40.863871 -76.556924
var zip = "17824";
var point = new GLatLng(40.863871,-76.556924);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17827 40.767498 -76.942963
var zip = "17827";
var point = new GLatLng(40.767498,-76.942963);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17829 40.900556 -77.156389
var zip = "17829";
var point = new GLatLng(40.900556,-77.156389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17830 40.691789 -76.800761
var zip = "17830";
var point = new GLatLng(40.691789,-76.800761);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17831 40.831667 -76.836111
var zip = "17831";
var point = new GLatLng(40.831667,-76.836111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17832 40.804576 -76.465137
var zip = "17832";
var point = new GLatLng(40.804576,-76.465137);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17833 40.803056 -76.964167
var zip = "17833";
var point = new GLatLng(40.803056,-76.964167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17834 40.793278 -76.474384
var zip = "17834";
var point = new GLatLng(40.793278,-76.474384);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17835 40.91268 -77.205211
var zip = "17835";
var point = new GLatLng(40.91268,-77.205211);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17836 40.710135 -76.627108
var zip = "17836";
var point = new GLatLng(40.710135,-76.627108);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17837 40.970205 -76.909878
var zip = "17837";
var point = new GLatLng(40.970205,-76.909878);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17839 41.036111 -76.423889
var zip = "17839";
var point = new GLatLng(41.036111,-76.423889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17840 40.771667 -76.441667
var zip = "17840";
var point = new GLatLng(40.771667,-76.441667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17841 40.699084 -77.375791
var zip = "17841";
var point = new GLatLng(40.699084,-77.375791);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17842 40.797656 -77.046798
var zip = "17842";
var point = new GLatLng(40.797656,-77.046798);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17843 40.810917 -76.970366
var zip = "17843";
var point = new GLatLng(40.810917,-76.970366);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17844 40.921826 -77.050515
var zip = "17844";
var point = new GLatLng(40.921826,-77.050515);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17845 40.880324 -77.194142
var zip = "17845";
var point = new GLatLng(40.880324,-77.194142);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17846 41.126051 -76.520767
var zip = "17846";
var point = new GLatLng(41.126051,-76.520767);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17847 41.01681 -76.839817
var zip = "17847";
var point = new GLatLng(41.01681,-76.839817);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17850 40.975936 -76.851024
var zip = "17850";
var point = new GLatLng(40.975936,-76.851024);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17851 40.795535 -76.419466
var zip = "17851";
var point = new GLatLng(40.795535,-76.419466);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17853 40.700185 -77.005241
var zip = "17853";
var point = new GLatLng(40.700185,-77.005241);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17855 40.880212 -76.986124
var zip = "17855";
var point = new GLatLng(40.880212,-76.986124);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17856 41.054108 -76.901851
var zip = "17856";
var point = new GLatLng(41.054108,-76.901851);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17857 40.904355 -76.790794
var zip = "17857";
var point = new GLatLng(40.904355,-76.790794);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17858 40.880556 -76.4025
var zip = "17858";
var point = new GLatLng(40.880556,-76.4025);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17859 41.10156 -76.38097
var zip = "17859";
var point = new GLatLng(41.10156,-76.38097);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17860 40.844809 -76.635041
var zip = "17860";
var point = new GLatLng(40.844809,-76.635041);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17861 40.770278 -77.083889
var zip = "17861";
var point = new GLatLng(40.770278,-77.083889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17862 40.859722 -77.055556
var zip = "17862";
var point = new GLatLng(40.859722,-77.055556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17864 40.699593 -76.908215
var zip = "17864";
var point = new GLatLng(40.699593,-76.908215);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17865 40.993611 -76.789444
var zip = "17865";
var point = new GLatLng(40.993611,-76.789444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17866 40.803039 -76.498242
var zip = "17866";
var point = new GLatLng(40.803039,-76.498242);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17867 40.712544 -76.740605
var zip = "17867";
var point = new GLatLng(40.712544,-76.740605);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17868 40.951269 -76.637458
var zip = "17868";
var point = new GLatLng(40.951269,-76.637458);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17870 40.822372 -76.86825
var zip = "17870";
var point = new GLatLng(40.822372,-76.86825);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17872 40.790336 -76.561118
var zip = "17872";
var point = new GLatLng(40.790336,-76.561118);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17876 40.848611 -76.82
var zip = "17876";
var point = new GLatLng(40.848611,-76.82);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17877 40.874097 -76.674945
var zip = "17877";
var point = new GLatLng(40.874097,-76.674945);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17878 41.151517 -76.369624
var zip = "17878";
var point = new GLatLng(41.151517,-76.369624);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17880 40.892222 -77.126944
var zip = "17880";
var point = new GLatLng(40.892222,-77.126944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17881 40.781867 -76.670234
var zip = "17881";
var point = new GLatLng(40.781867,-76.670234);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17882 40.803056 -77.205556
var zip = "17882";
var point = new GLatLng(40.803056,-77.205556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17883 40.938611 -76.988333
var zip = "17883";
var point = new GLatLng(40.938611,-76.988333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17884 41.051667 -76.675
var zip = "17884";
var point = new GLatLng(41.051667,-76.675);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17885 40.858333 -77.295556
var zip = "17885";
var point = new GLatLng(40.858333,-77.295556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17886 40.964444 -76.884722
var zip = "17886";
var point = new GLatLng(40.964444,-76.884722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17887 41.075833 -76.875
var zip = "17887";
var point = new GLatLng(41.075833,-76.875);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17888 40.812087 -76.392922
var zip = "17888";
var point = new GLatLng(40.812087,-76.392922);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17889 40.890805 -76.871833
var zip = "17889";
var point = new GLatLng(40.890805,-76.871833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17901 40.683978 -76.212318
var zip = "17901";
var point = new GLatLng(40.683978,-76.212318);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17920 40.818333 -76.338611
var zip = "17920";
var point = new GLatLng(40.818333,-76.338611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17921 40.773231 -76.342972
var zip = "17921";
var point = new GLatLng(40.773231,-76.342972);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17922 40.596157 -76.13439
var zip = "17922";
var point = new GLatLng(40.596157,-76.13439);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17923 40.664328 -76.332788
var zip = "17923";
var point = new GLatLng(40.664328,-76.332788);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17925 40.763162 -76.049874
var zip = "17925";
var point = new GLatLng(40.763162,-76.049874);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17929 40.628361 -76.195028
var zip = "17929";
var point = new GLatLng(40.628361,-76.195028);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17930 40.711667 -76.138056
var zip = "17930";
var point = new GLatLng(40.711667,-76.138056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17931 40.782537 -76.231137
var zip = "17931";
var point = new GLatLng(40.782537,-76.231137);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17932 40.783889 -76.230556
var zip = "17932";
var point = new GLatLng(40.783889,-76.230556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17933 40.6025 -76.241111
var zip = "17933";
var point = new GLatLng(40.6025,-76.241111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17934 40.799444 -76.212778
var zip = "17934";
var point = new GLatLng(40.799444,-76.212778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17935 40.792162 -76.28581
var zip = "17935";
var point = new GLatLng(40.792162,-76.28581);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17936 40.751667 -76.336389
var zip = "17936";
var point = new GLatLng(40.751667,-76.336389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17938 40.666898 -76.473168
var zip = "17938";
var point = new GLatLng(40.666898,-76.473168);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17941 40.667571 -76.650709
var zip = "17941";
var point = new GLatLng(40.667571,-76.650709);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17942 40.626111 -76.123889
var zip = "17942";
var point = new GLatLng(40.626111,-76.123889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17943 40.763333 -76.383056
var zip = "17943";
var point = new GLatLng(40.763333,-76.383056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17944 40.672778 -76.279444
var zip = "17944";
var point = new GLatLng(40.672778,-76.279444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17945 40.778611 -76.376667
var zip = "17945";
var point = new GLatLng(40.778611,-76.376667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17946 40.806389 -76.247222
var zip = "17946";
var point = new GLatLng(40.806389,-76.247222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17948 40.812302 -76.139601
var zip = "17948";
var point = new GLatLng(40.812302,-76.139601);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17949 40.794444 -76.242222
var zip = "17949";
var point = new GLatLng(40.794444,-76.242222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17951 40.678333 -76.245556
var zip = "17951";
var point = new GLatLng(40.678333,-76.245556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//17952 40.76 -76.056389
var zip = "17952";
var point = new GLatLng(40.76,-76.056389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17953 40.729444 -76.085833
var zip = "17953";
var point = new GLatLng(40.729444,-76.085833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17954 40.690637 -76.261533
var zip = "17954";
var point = new GLatLng(40.690637,-76.261533);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17957 40.613614 -76.468205
var zip = "17957";
var point = new GLatLng(40.613614,-76.468205);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17959 40.722728 -76.11348
var zip = "17959";
var point = new GLatLng(40.722728,-76.11348);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17960 40.714851 -75.948409
var zip = "17960";
var point = new GLatLng(40.714851,-75.948409);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17961 40.643071 -76.083999
var zip = "17961";
var point = new GLatLng(40.643071,-76.083999);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17963 40.567093 -76.326913
var zip = "17963";
var point = new GLatLng(40.567093,-76.326913);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17964 40.704868 -76.523297
var zip = "17964";
var point = new GLatLng(40.704868,-76.523297);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17965 40.697731 -76.166046
var zip = "17965";
var point = new GLatLng(40.697731,-76.166046);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17966 40.574444 -76.404167
var zip = "17966";
var point = new GLatLng(40.574444,-76.404167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17967 40.855854 -76.23493
var zip = "17967";
var point = new GLatLng(40.855854,-76.23493);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17968 40.635238 -76.612833
var zip = "17968";
var point = new GLatLng(40.635238,-76.612833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//17970 40.719273 -76.192381
var zip = "17970";
var point = new GLatLng(40.719273,-76.192381);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17972 40.630571 -76.169973
var zip = "17972";
var point = new GLatLng(40.630571,-76.169973);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17974 40.695278 -76.234167
var zip = "17974";
var point = new GLatLng(40.695278,-76.234167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17976 40.816744 -76.203502
var zip = "17976";
var point = new GLatLng(40.816744,-76.203502);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17978 40.633447 -76.635018
var zip = "17978";
var point = new GLatLng(40.633447,-76.635018);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17979 40.563889 -76.204722
var zip = "17979";
var point = new GLatLng(40.563889,-76.204722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17980 40.584475 -76.550022
var zip = "17980";
var point = new GLatLng(40.584475,-76.550022);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//17981 40.626842 -76.398796
var zip = "17981";
var point = new GLatLng(40.626842,-76.398796);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17982 40.77 -76.037778
var zip = "17982";
var point = new GLatLng(40.77,-76.037778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//17983 40.644467 -76.544843
var zip = "17983";
var point = new GLatLng(40.644467,-76.544843);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17985 40.937152 -76.231032
var zip = "17985";
var point = new GLatLng(40.937152,-76.231032);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18001 40.5897 -75.4647
var zip = "18001";
var point = new GLatLng(40.5897,-75.4647);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18002 40.6729 -75.3793
var zip = "18002";
var point = new GLatLng(40.6729,-75.3793);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18003 40.7386 -75.6376
var zip = "18003";
var point = new GLatLng(40.7386,-75.6376);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18010 40.8648 -75.2073
var zip = "18010";
var point = new GLatLng(40.8648,-75.2073);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18011 40.486201 -75.62113
var zip = "18011";
var point = new GLatLng(40.486201,-75.62113);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18012 40.811111 -75.590556
var zip = "18012";
var point = new GLatLng(40.811111,-75.590556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18013 40.854907 -75.195644
var zip = "18013";
var point = new GLatLng(40.854907,-75.195644);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18014 40.755144 -75.40856
var zip = "18014";
var point = new GLatLng(40.755144,-75.40856);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18015 40.600167 -75.380507
var zip = "18015";
var point = new GLatLng(40.600167,-75.380507);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18016 40.6209 -75.3645
var zip = "18016";
var point = new GLatLng(40.6209,-75.3645);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18017 40.65168 -75.35823
var zip = "18017";
var point = new GLatLng(40.65168,-75.35823);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18018 40.627849 -75.392827
var zip = "18018";
var point = new GLatLng(40.627849,-75.392827);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18020 40.6609 -75.3274
var zip = "18020";
var point = new GLatLng(40.6609,-75.3274);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18025 40.6335 -75.3952
var zip = "18025";
var point = new GLatLng(40.6335,-75.3952);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18030 40.799722 -75.662222
var zip = "18030";
var point = new GLatLng(40.799722,-75.662222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18031 40.552621 -75.655269
var zip = "18031";
var point = new GLatLng(40.552621,-75.655269);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18032 40.655696 -75.46927
var zip = "18032";
var point = new GLatLng(40.655696,-75.46927);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18034 40.539594 -75.424208
var zip = "18034";
var point = new GLatLng(40.539594,-75.424208);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18035 40.738476 -75.552133
var zip = "18035";
var point = new GLatLng(40.738476,-75.552133);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18036 40.507553 -75.388778
var zip = "18036";
var point = new GLatLng(40.507553,-75.388778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18037 40.684865 -75.518825
var zip = "18037";
var point = new GLatLng(40.684865,-75.518825);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18038 40.786636 -75.518604
var zip = "18038";
var point = new GLatLng(40.786636,-75.518604);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18039 40.575556 -75.223611
var zip = "18039";
var point = new GLatLng(40.575556,-75.223611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18040 40.753333 -75.251667
var zip = "18040";
var point = new GLatLng(40.753333,-75.251667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18041 40.411876 -75.505618
var zip = "18041";
var point = new GLatLng(40.411876,-75.505618);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18042 40.6867 -75.23582
var zip = "18042";
var point = new GLatLng(40.6867,-75.23582);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18043 40.6883 -75.2211
var zip = "18043";
var point = new GLatLng(40.6883,-75.2211);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18044 40.688333 -75.221111
var zip = "18044";
var point = new GLatLng(40.688333,-75.221111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18045 40.6853 -75.2678
var zip = "18045";
var point = new GLatLng(40.6853,-75.2678);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18046 40.5475 -75.561667
var zip = "18046";
var point = new GLatLng(40.5475,-75.561667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18049 40.529295 -75.500991
var zip = "18049";
var point = new GLatLng(40.529295,-75.500991);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18050 40.8648 -75.2073
var zip = "18050";
var point = new GLatLng(40.8648,-75.2073);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18051 40.59304 -75.656794
var zip = "18051";
var point = new GLatLng(40.59304,-75.656794);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18052 40.647479 -75.495383
var zip = "18052";
var point = new GLatLng(40.647479,-75.495383);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18053 40.711826 -75.714687
var zip = "18053";
var point = new GLatLng(40.711826,-75.714687);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18054 40.353377 -75.435148
var zip = "18054";
var point = new GLatLng(40.353377,-75.435148);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18055 40.581715 -75.325513
var zip = "18055";
var point = new GLatLng(40.581715,-75.325513);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18056 40.448659 -75.579983
var zip = "18056";
var point = new GLatLng(40.448659,-75.579983);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18058 40.899891 -75.475974
var zip = "18058";
var point = new GLatLng(40.899891,-75.475974);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18059 40.723056 -76.530556
var zip = "18059";
var point = new GLatLng(40.723056,-76.530556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18060 40.508889 -75.4475
var zip = "18060";
var point = new GLatLng(40.508889,-75.4475);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18062 40.528543 -75.566618
var zip = "18062";
var point = new GLatLng(40.528543,-75.566618);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18063 40.783333 -75.186667
var zip = "18063";
var point = new GLatLng(40.783333,-75.186667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18064 40.744962 -75.319932
var zip = "18064";
var point = new GLatLng(40.744962,-75.319932);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18065 40.694444 -75.61
var zip = "18065";
var point = new GLatLng(40.694444,-75.61);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18066 40.654544 -75.741739
var zip = "18066";
var point = new GLatLng(40.654544,-75.741739);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18067 40.699765 -75.48742
var zip = "18067";
var point = new GLatLng(40.699765,-75.48742);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18068 40.486389 -75.520556
var zip = "18068";
var point = new GLatLng(40.486389,-75.520556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18069 40.624826 -75.597395
var zip = "18069";
var point = new GLatLng(40.624826,-75.597395);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18070 40.43167 -75.533124
var zip = "18070";
var point = new GLatLng(40.43167,-75.533124);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18071 40.816976 -75.601119
var zip = "18071";
var point = new GLatLng(40.816976,-75.601119);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18072 40.85182 -75.270115
var zip = "18072";
var point = new GLatLng(40.85182,-75.270115);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18073 40.391138 -75.486608
var zip = "18073";
var point = new GLatLng(40.391138,-75.486608);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18074 40.31566 -75.50218
var zip = "18074";
var point = new GLatLng(40.31566,-75.50218);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18076 40.375807 -75.484613
var zip = "18076";
var point = new GLatLng(40.375807,-75.484613);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18077 40.57824 -75.219064
var zip = "18077";
var point = new GLatLng(40.57824,-75.219064);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18078 40.681949 -75.623924
var zip = "18078";
var point = new GLatLng(40.681949,-75.623924);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18079 40.744444 -75.656944
var zip = "18079";
var point = new GLatLng(40.744444,-75.656944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18080 40.740695 -75.621612
var zip = "18080";
var point = new GLatLng(40.740695,-75.621612);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18081 40.556389 -75.289722
var zip = "18081";
var point = new GLatLng(40.556389,-75.289722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18083 40.753889 -75.2625
var zip = "18083";
var point = new GLatLng(40.753889,-75.2625);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18084 40.328889 -75.451389
var zip = "18084";
var point = new GLatLng(40.328889,-75.451389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18085 40.740833 -75.2575
var zip = "18085";
var point = new GLatLng(40.740833,-75.2575);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18086 40.734167 -75.544167
var zip = "18086";
var point = new GLatLng(40.734167,-75.544167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18087 40.554418 -75.602293
var zip = "18087";
var point = new GLatLng(40.554418,-75.602293);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18088 40.76147 -75.565749
var zip = "18088";
var point = new GLatLng(40.76147,-75.565749);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18091 40.816922 -75.326378
var zip = "18091";
var point = new GLatLng(40.816922,-75.326378);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18092 40.473425 -75.526146
var zip = "18092";
var point = new GLatLng(40.473425,-75.526146);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18098 40.5358 -75.4947
var zip = "18098";
var point = new GLatLng(40.5358,-75.4947);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18099 40.5358 -75.4947
var zip = "18099";
var point = new GLatLng(40.5358,-75.4947);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18101 40.602729 -75.470955
var zip = "18101";
var point = new GLatLng(40.602729,-75.470955);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18102 40.606818 -75.478139
var zip = "18102";
var point = new GLatLng(40.606818,-75.478139);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18103 40.589145 -75.464521
var zip = "18103";
var point = new GLatLng(40.589145,-75.464521);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18104 40.601849 -75.522499
var zip = "18104";
var point = new GLatLng(40.601849,-75.522499);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18105 40.6029 -75.4679
var zip = "18105";
var point = new GLatLng(40.6029,-75.4679);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18106 40.561451 -75.566424
var zip = "18106";
var point = new GLatLng(40.561451,-75.566424);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18109 40.6235 -75.4383
var zip = "18109";
var point = new GLatLng(40.6235,-75.4383);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18175 40.6029 -75.4679
var zip = "18175";
var point = new GLatLng(40.6029,-75.4679);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18195 40.5728 -75.6153
var zip = "18195";
var point = new GLatLng(40.5728,-75.6153);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18201 40.962107 -75.978193
var zip = "18201";
var point = new GLatLng(40.962107,-75.978193);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18202 40.958333 -75.975
var zip = "18202";
var point = new GLatLng(40.958333,-75.975);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18210 40.974786 -75.584206
var zip = "18210";
var point = new GLatLng(40.974786,-75.584206);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18211 40.746457 -75.834247
var zip = "18211";
var point = new GLatLng(40.746457,-75.834247);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18212 40.784444 -75.713889
var zip = "18212";
var point = new GLatLng(40.784444,-75.713889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18214 40.813811 -76.06109
var zip = "18214";
var point = new GLatLng(40.813811,-76.06109);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18216 40.922672 -75.940648
var zip = "18216";
var point = new GLatLng(40.922672,-75.940648);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18218 40.821942 -75.910385
var zip = "18218";
var point = new GLatLng(40.821942,-75.910385);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18219 40.991944 -76.056944
var zip = "18219";
var point = new GLatLng(40.991944,-76.056944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18220 40.841048 -76.069462
var zip = "18220";
var point = new GLatLng(40.841048,-76.069462);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18221 40.999722 -75.905833
var zip = "18221";
var point = new GLatLng(40.999722,-75.905833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18222 41.025525 -75.97676
var zip = "18222";
var point = new GLatLng(41.025525,-75.97676);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18223 40.986111 -75.941667
var zip = "18223";
var point = new GLatLng(40.986111,-75.941667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18224 41.019557 -75.888001
var zip = "18224";
var point = new GLatLng(41.019557,-75.888001);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18225 40.980556 -75.971667
var zip = "18225";
var point = new GLatLng(40.980556,-75.971667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18229 40.870002 -75.739665
var zip = "18229";
var point = new GLatLng(40.870002,-75.739665);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18230 40.923333 -75.941944
var zip = "18230";
var point = new GLatLng(40.923333,-75.941944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18231 40.900833 -76.003889
var zip = "18231";
var point = new GLatLng(40.900833,-76.003889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18232 40.831444 -75.882834
var zip = "18232";
var point = new GLatLng(40.831444,-75.882834);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18234 40.955278 -76
var zip = "18234";
var point = new GLatLng(40.955278,-76);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18235 40.830024 -75.706088
var zip = "18235";
var point = new GLatLng(40.830024,-75.706088);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18237 40.89791 -75.997117
var zip = "18237";
var point = new GLatLng(40.89791,-75.997117);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18239 40.990278 -75.983056
var zip = "18239";
var point = new GLatLng(40.990278,-75.983056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18240 40.862608 -75.82389
var zip = "18240";
var point = new GLatLng(40.862608,-75.82389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18241 40.938056 -76.17
var zip = "18241";
var point = new GLatLng(40.938056,-76.17);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18242 40.9075 -76.125833
var zip = "18242";
var point = new GLatLng(40.9075,-76.125833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18244 40.818056 -75.673056
var zip = "18244";
var point = new GLatLng(40.818056,-75.673056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18245 40.849337 -75.982477
var zip = "18245";
var point = new GLatLng(40.849337,-75.982477);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18246 40.964628 -76.163761
var zip = "18246";
var point = new GLatLng(40.964628,-76.163761);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18247 41.028056 -76.006389
var zip = "18247";
var point = new GLatLng(41.028056,-76.006389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18248 40.888073 -76.137952
var zip = "18248";
var point = new GLatLng(40.888073,-76.137952);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18249 40.997126 -76.071655
var zip = "18249";
var point = new GLatLng(40.997126,-76.071655);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18250 40.825524 -75.869275
var zip = "18250";
var point = new GLatLng(40.825524,-75.869275);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18251 41.001389 -76.076667
var zip = "18251";
var point = new GLatLng(41.001389,-76.076667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18252 40.798319 -75.97353
var zip = "18252";
var point = new GLatLng(40.798319,-75.97353);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18254 40.913333 -75.966944
var zip = "18254";
var point = new GLatLng(40.913333,-75.966944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18255 40.941085 -75.830635
var zip = "18255";
var point = new GLatLng(40.941085,-75.830635);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18256 40.941389 -76.1425
var zip = "18256";
var point = new GLatLng(40.941389,-76.1425);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18301 41.036714 -75.173463
var zip = "18301";
var point = new GLatLng(41.036714,-75.173463);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18302 41.0844 -75.1086
var zip = "18302";
var point = new GLatLng(41.0844,-75.1086);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18320 41.051111 -75.220833
var zip = "18320";
var point = new GLatLng(41.051111,-75.220833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18321 41.008007 -75.296726
var zip = "18321";
var point = new GLatLng(41.008007,-75.296726);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18322 40.930862 -75.410415
var zip = "18322";
var point = new GLatLng(40.930862,-75.410415);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18323 41.187778 -75.266111
var zip = "18323";
var point = new GLatLng(41.187778,-75.266111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18324 41.128476 -75.013207
var zip = "18324";
var point = new GLatLng(41.128476,-75.013207);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18325 41.233791 -75.257288
var zip = "18325";
var point = new GLatLng(41.233791,-75.257288);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18326 41.160605 -75.268228
var zip = "18326";
var point = new GLatLng(41.160605,-75.268228);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18327 40.982863 -75.149987
var zip = "18327";
var point = new GLatLng(40.982863,-75.149987);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18328 41.239966 -74.938018
var zip = "18328";
var point = new GLatLng(41.239966,-74.938018);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18330 40.966946 -75.452286
var zip = "18330";
var point = new GLatLng(40.966946,-75.452286);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18331 40.908866 -75.431373
var zip = "18331";
var point = new GLatLng(40.908866,-75.431373);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18332 41.088912 -75.279753
var zip = "18332";
var point = new GLatLng(41.088912,-75.279753);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18333 40.898156 -75.507437
var zip = "18333";
var point = new GLatLng(40.898156,-75.507437);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18334 41.067732 -75.448245
var zip = "18334";
var point = new GLatLng(41.067732,-75.448245);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18335 41.043056 -75.127778
var zip = "18335";
var point = new GLatLng(41.043056,-75.127778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18336 41.367437 -74.715358
var zip = "18336";
var point = new GLatLng(41.367437,-74.715358);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18337 41.322816 -74.88236
var zip = "18337";
var point = new GLatLng(41.322816,-74.88236);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18340 41.358265 -74.773876
var zip = "18340";
var point = new GLatLng(41.358265,-74.773876);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18341 40.998333 -75.1375
var zip = "18341";
var point = new GLatLng(40.998333,-75.1375);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18342 41.2175 -75.218889
var zip = "18342";
var point = new GLatLng(41.2175,-75.218889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18343 40.900839 -75.111545
var zip = "18343";
var point = new GLatLng(40.900839,-75.111545);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18344 41.121558 -75.352868
var zip = "18344";
var point = new GLatLng(41.121558,-75.352868);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18346 41.103989 -75.413554
var zip = "18346";
var point = new GLatLng(41.103989,-75.413554);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18347 41.118661 -75.555863
var zip = "18347";
var point = new GLatLng(41.118661,-75.555863);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18348 41.105278 -75.476389
var zip = "18348";
var point = new GLatLng(41.105278,-75.476389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18349 41.1 -75.359167
var zip = "18349";
var point = new GLatLng(41.1,-75.359167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18350 41.105387 -75.476038
var zip = "18350";
var point = new GLatLng(41.105387,-75.476038);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18351 40.923056 -75.096944
var zip = "18351";
var point = new GLatLng(40.923056,-75.096944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18352 40.989533 -75.278113
var zip = "18352";
var point = new GLatLng(40.989533,-75.278113);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18353 40.917179 -75.374761
var zip = "18353";
var point = new GLatLng(40.917179,-75.374761);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18354 40.928282 -75.293779
var zip = "18354";
var point = new GLatLng(40.928282,-75.293779);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18355 41.075147 -75.32646
var zip = "18355";
var point = new GLatLng(41.075147,-75.32646);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18356 41.012222 -75.111111
var zip = "18356";
var point = new GLatLng(41.012222,-75.111111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18357 41.227778 -75.238611
var zip = "18357";
var point = new GLatLng(41.227778,-75.238611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18360 40.987697 -75.24852
var zip = "18360";
var point = new GLatLng(40.987697,-75.24852);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18370 41.087936 -75.348278
var zip = "18370";
var point = new GLatLng(41.087936,-75.348278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18371 41.168112 -74.952614
var zip = "18371";
var point = new GLatLng(41.168112,-74.952614);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18372 41.048202 -75.309984
var zip = "18372";
var point = new GLatLng(41.048202,-75.309984);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18373 41.145278 -75.008056
var zip = "18373";
var point = new GLatLng(41.145278,-75.008056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18403 41.495633 -75.555232
var zip = "18403";
var point = new GLatLng(41.495633,-75.555232);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18405 41.603403 -75.11649
var zip = "18405";
var point = new GLatLng(41.603403,-75.11649);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18407 41.583481 -75.507363
var zip = "18407";
var point = new GLatLng(41.583481,-75.507363);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18410 41.475 -75.6775
var zip = "18410";
var point = new GLatLng(41.475,-75.6775);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18411 41.487795 -75.705713
var zip = "18411";
var point = new GLatLng(41.487795,-75.705713);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18413 41.648889 -75.599167
var zip = "18413";
var point = new GLatLng(41.648889,-75.599167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18414 41.539496 -75.703737
var zip = "18414";
var point = new GLatLng(41.539496,-75.703737);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18415 41.736623 -75.131151
var zip = "18415";
var point = new GLatLng(41.736623,-75.131151);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18416 41.377778 -75.545
var zip = "18416";
var point = new GLatLng(41.377778,-75.545);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18417 41.811712 -75.189081
var zip = "18417";
var point = new GLatLng(41.811712,-75.189081);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18419 41.576168 -75.765182
var zip = "18419";
var point = new GLatLng(41.576168,-75.765182);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18420 41.598056 -75.715
var zip = "18420";
var point = new GLatLng(41.598056,-75.715);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18421 41.654587 -75.48725
var zip = "18421";
var point = new GLatLng(41.654587,-75.48725);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18424 41.2448 -75.503653
var zip = "18424";
var point = new GLatLng(41.2448,-75.503653);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18425 41.437238 -75.012491
var zip = "18425";
var point = new GLatLng(41.437238,-75.012491);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18426 41.332145 -75.281911
var zip = "18426";
var point = new GLatLng(41.332145,-75.281911);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18427 41.401477 -75.354232
var zip = "18427";
var point = new GLatLng(41.401477,-75.354232);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18428 41.478685 -75.197822
var zip = "18428";
var point = new GLatLng(41.478685,-75.197822);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18430 41.76434 -75.504387
var zip = "18430";
var point = new GLatLng(41.76434,-75.504387);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18431 41.579227 -75.25279
var zip = "18431";
var point = new GLatLng(41.579227,-75.25279);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18433 41.532723 -75.542948
var zip = "18433";
var point = new GLatLng(41.532723,-75.542948);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18434 41.472443 -75.568891
var zip = "18434";
var point = new GLatLng(41.472443,-75.568891);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18435 41.504272 -75.074859
var zip = "18435";
var point = new GLatLng(41.504272,-75.074859);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18436 41.439476 -75.431257
var zip = "18436";
var point = new GLatLng(41.439476,-75.431257);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18437 41.866553 -75.32308
var zip = "18437";
var point = new GLatLng(41.866553,-75.32308);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18438 41.422278 -75.260717
var zip = "18438";
var point = new GLatLng(41.422278,-75.260717);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18439 41.817138 -75.383824
var zip = "18439";
var point = new GLatLng(41.817138,-75.383824);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18440 41.556667 -75.754167
var zip = "18440";
var point = new GLatLng(41.556667,-75.754167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18441 41.667713 -75.631934
var zip = "18441";
var point = new GLatLng(41.667713,-75.631934);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18443 41.649208 -75.08818
var zip = "18443";
var point = new GLatLng(41.649208,-75.08818);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18444 41.343194 -75.530137
var zip = "18444";
var point = new GLatLng(41.343194,-75.530137);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18445 41.304125 -75.338405
var zip = "18445";
var point = new GLatLng(41.304125,-75.338405);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18446 41.641198 -75.764073
var zip = "18446";
var point = new GLatLng(41.641198,-75.764073);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18447 41.467709 -75.601502
var zip = "18447";
var point = new GLatLng(41.467709,-75.601502);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18448 41.455 -75.583611
var zip = "18448";
var point = new GLatLng(41.455,-75.583611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18449 41.813611 -75.448333
var zip = "18449";
var point = new GLatLng(41.813611,-75.448333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18451 41.381197 -75.23032
var zip = "18451";
var point = new GLatLng(41.381197,-75.23032);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18452 41.482124 -75.589884
var zip = "18452";
var point = new GLatLng(41.482124,-75.589884);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18453 41.732204 -75.398944
var zip = "18453";
var point = new GLatLng(41.732204,-75.398944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18454 41.820556 -75.420278
var zip = "18454";
var point = new GLatLng(41.820556,-75.420278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18455 41.867264 -75.383147
var zip = "18455";
var point = new GLatLng(41.867264,-75.383147);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18456 41.582031 -75.320749
var zip = "18456";
var point = new GLatLng(41.582031,-75.320749);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18457 41.471111 -75.0425
var zip = "18457";
var point = new GLatLng(41.471111,-75.0425);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18458 41.418193 -74.917962
var zip = "18458";
var point = new GLatLng(41.418193,-74.917962);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18459 41.505278 -75.4125
var zip = "18459";
var point = new GLatLng(41.505278,-75.4125);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18460 41.271222 -75.381443
var zip = "18460";
var point = new GLatLng(41.271222,-75.381443);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18461 41.925087 -75.321238
var zip = "18461";
var point = new GLatLng(41.925087,-75.321238);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18462 41.890739 -75.449001
var zip = "18462";
var point = new GLatLng(41.890739,-75.449001);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18463 41.341912 -75.394467
var zip = "18463";
var point = new GLatLng(41.341912,-75.394467);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18464 41.369445 -75.101598
var zip = "18464";
var point = new GLatLng(41.369445,-75.101598);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18465 41.83395 -75.534215
var zip = "18465";
var point = new GLatLng(41.83395,-75.534215);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18466 41.183638 -75.391781
var zip = "18466";
var point = new GLatLng(41.183638,-75.391781);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18469 41.670873 -75.154246
var zip = "18469";
var point = new GLatLng(41.670873,-75.154246);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18470 41.707941 -75.546476
var zip = "18470";
var point = new GLatLng(41.707941,-75.546476);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18471 41.526389 -75.705833
var zip = "18471";
var point = new GLatLng(41.526389,-75.705833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18472 41.570276 -75.406478
var zip = "18472";
var point = new GLatLng(41.570276,-75.406478);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18473 41.526111 -75.203889
var zip = "18473";
var point = new GLatLng(41.526111,-75.203889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18501 41.3731 -75.6841
var zip = "18501";
var point = new GLatLng(41.3731,-75.6841);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18502 41.3732 -75.6788
var zip = "18502";
var point = new GLatLng(41.3732,-75.6788);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18503 41.409517 -75.664205
var zip = "18503";
var point = new GLatLng(41.409517,-75.664205);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18504 41.412777 -75.686081
var zip = "18504";
var point = new GLatLng(41.412777,-75.686081);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18505 41.39145 -75.665738
var zip = "18505";
var point = new GLatLng(41.39145,-75.665738);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18507 41.361492 -75.717093
var zip = "18507";
var point = new GLatLng(41.361492,-75.717093);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18508 41.438917 -75.662529
var zip = "18508";
var point = new GLatLng(41.438917,-75.662529);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18509 41.427353 -75.646454
var zip = "18509";
var point = new GLatLng(41.427353,-75.646454);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18510 41.408039 -75.648397
var zip = "18510";
var point = new GLatLng(41.408039,-75.648397);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18512 41.426184 -75.62294
var zip = "18512";
var point = new GLatLng(41.426184,-75.62294);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18514 41.3731 -75.6841
var zip = "18514";
var point = new GLatLng(41.3731,-75.6841);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18515 41.4476 -75.6669
var zip = "18515";
var point = new GLatLng(41.4476,-75.6669);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18517 41.390442 -75.715848
var zip = "18517";
var point = new GLatLng(41.390442,-75.715848);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18518 41.370076 -75.739075
var zip = "18518";
var point = new GLatLng(41.370076,-75.739075);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18519 41.462306 -75.624343
var zip = "18519";
var point = new GLatLng(41.462306,-75.624343);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18522 41.4303 -75.6437
var zip = "18522";
var point = new GLatLng(41.4303,-75.6437);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18540 41.3731 -75.6841
var zip = "18540";
var point = new GLatLng(41.3731,-75.6841);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18577 41.3731 -75.6841
var zip = "18577";
var point = new GLatLng(41.3731,-75.6841);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18601 41.068333 -76.176111
var zip = "18601";
var point = new GLatLng(41.068333,-76.176111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18602 41.119167 -75.719444
var zip = "18602";
var point = new GLatLng(41.119167,-75.719444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18603 41.066477 -76.244269
var zip = "18603";
var point = new GLatLng(41.066477,-76.244269);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18610 41.048502 -75.534309
var zip = "18610";
var point = new GLatLng(41.048502,-75.534309);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18611 41.198056 -76.306111
var zip = "18611";
var point = new GLatLng(41.198056,-76.306111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18612 41.363762 -75.958911
var zip = "18612";
var point = new GLatLng(41.363762,-75.958911);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18614 41.523213 -76.402145
var zip = "18614";
var point = new GLatLng(41.523213,-76.402145);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18615 41.466677 -75.856004
var zip = "18615";
var point = new GLatLng(41.466677,-75.856004);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18616 41.526925 -76.60079
var zip = "18616";
var point = new GLatLng(41.526925,-76.60079);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18617 41.174635 -76.074578
var zip = "18617";
var point = new GLatLng(41.174635,-76.074578);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18618 41.359181 -76.04506
var zip = "18618";
var point = new GLatLng(41.359181,-76.04506);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18619 41.448159 -76.697914
var zip = "18619";
var point = new GLatLng(41.448159,-76.697914);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18621 41.245923 -76.087915
var zip = "18621";
var point = new GLatLng(41.245923,-76.087915);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18622 41.200905 -76.197342
var zip = "18622";
var point = new GLatLng(41.200905,-76.197342);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18623 41.66621 -76.142566
var zip = "18623";
var point = new GLatLng(41.66621,-76.142566);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18624 41.05424 -75.633129
var zip = "18624";
var point = new GLatLng(41.05424,-75.633129);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18625 41.519444 -75.844444
var zip = "18625";
var point = new GLatLng(41.519444,-75.844444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18626 41.423889 -76.494444
var zip = "18626";
var point = new GLatLng(41.423889,-76.494444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18627 41.316944 -76.022778
var zip = "18627";
var point = new GLatLng(41.316944,-76.022778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18628 41.418002 -76.300206
var zip = "18628";
var point = new GLatLng(41.418002,-76.300206);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18629 41.558695 -76.103462
var zip = "18629";
var point = new GLatLng(41.558695,-76.103462);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18630 41.639163 -76.015464
var zip = "18630";
var point = new GLatLng(41.639163,-76.015464);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18631 41.023473 -76.292396
var zip = "18631";
var point = new GLatLng(41.023473,-76.292396);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18632 41.479236 -76.38313
var zip = "18632";
var point = new GLatLng(41.479236,-76.38313);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18634 41.19634 -76.004419
var zip = "18634";
var point = new GLatLng(41.19634,-76.004419);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18635 41.046887 -76.19809
var zip = "18635";
var point = new GLatLng(41.046887,-76.19809);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18636 41.418131 -76.045952
var zip = "18636";
var point = new GLatLng(41.418131,-76.045952);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18640 41.317501 -75.788492
var zip = "18640";
var point = new GLatLng(41.317501,-75.788492);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18641 41.330857 -75.744655
var zip = "18641";
var point = new GLatLng(41.330857,-75.744655);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18642 41.348557 -75.761104
var zip = "18642";
var point = new GLatLng(41.348557,-75.761104);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18643 41.337964 -75.816651
var zip = "18643";
var point = new GLatLng(41.337964,-75.816651);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18644 41.319713 -75.854071
var zip = "18644";
var point = new GLatLng(41.319713,-75.854071);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18651 41.245798 -75.948064
var zip = "18651";
var point = new GLatLng(41.245798,-75.948064);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18653 41.394167 -75.822222
var zip = "18653";
var point = new GLatLng(41.394167,-75.822222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18654 41.351389 -76.034444
var zip = "18654";
var point = new GLatLng(41.351389,-76.034444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18655 41.176674 -76.167096
var zip = "18655";
var point = new GLatLng(41.176674,-76.167096);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18656 41.30663 -76.133907
var zip = "18656";
var point = new GLatLng(41.30663,-76.133907);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18657 41.550687 -75.941043
var zip = "18657";
var point = new GLatLng(41.550687,-75.941043);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18660 41.06797 -76.085729
var zip = "18660";
var point = new GLatLng(41.06797,-76.085729);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18661 41.079049 -75.771492
var zip = "18661";
var point = new GLatLng(41.079049,-75.771492);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18690 41.336111 -75.963611
var zip = "18690";
var point = new GLatLng(41.336111,-75.963611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18701 41.244892 -75.884063
var zip = "18701";
var point = new GLatLng(41.244892,-75.884063);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18702 41.236512 -75.882557
var zip = "18702";
var point = new GLatLng(41.236512,-75.882557);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18703 41.2401 -75.8914
var zip = "18703";
var point = new GLatLng(41.2401,-75.8914);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18704 41.274223 -75.890338
var zip = "18704";
var point = new GLatLng(41.274223,-75.890338);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18705 41.268921 -75.845309
var zip = "18705";
var point = new GLatLng(41.268921,-75.845309);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18706 41.206709 -75.918157
var zip = "18706";
var point = new GLatLng(41.206709,-75.918157);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18707 41.134975 -75.937642
var zip = "18707";
var point = new GLatLng(41.134975,-75.937642);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18708 41.299802 -75.97108
var zip = "18708";
var point = new GLatLng(41.299802,-75.97108);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18709 41.284257 -75.893475
var zip = "18709";
var point = new GLatLng(41.284257,-75.893475);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18710 41.2454 -75.8819
var zip = "18710";
var point = new GLatLng(41.2454,-75.8819);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18711 41.2474 -75.8536
var zip = "18711";
var point = new GLatLng(41.2474,-75.8536);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18762 41.2401 -75.8914
var zip = "18762";
var point = new GLatLng(41.2401,-75.8914);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18764 41.2401 -75.8914
var zip = "18764";
var point = new GLatLng(41.2401,-75.8914);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18765 41.2401 -75.8914
var zip = "18765";
var point = new GLatLng(41.2401,-75.8914);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18766 41.2401 -75.8914
var zip = "18766";
var point = new GLatLng(41.2401,-75.8914);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18767 41.2401 -75.8914
var zip = "18767";
var point = new GLatLng(41.2401,-75.8914);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18769 41.2401 -75.8914
var zip = "18769";
var point = new GLatLng(41.2401,-75.8914);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18773 41.2401 -75.8914
var zip = "18773";
var point = new GLatLng(41.2401,-75.8914);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18801 41.839584 -75.882055
var zip = "18801";
var point = new GLatLng(41.839584,-75.882055);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18810 41.949002 -76.488855
var zip = "18810";
var point = new GLatLng(41.949002,-76.488855);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18812 41.966614 -75.937527
var zip = "18812";
var point = new GLatLng(41.966614,-75.937527);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18813 41.751111 -75.807222
var zip = "18813";
var point = new GLatLng(41.751111,-75.807222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18814 41.779722 -76.607778
var zip = "18814";
var point = new GLatLng(41.779722,-76.607778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18815 41.731111 -76.235
var zip = "18815";
var point = new GLatLng(41.731111,-76.235);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18816 41.746389 -75.898611
var zip = "18816";
var point = new GLatLng(41.746389,-75.898611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18817 41.863115 -76.617207
var zip = "18817";
var point = new GLatLng(41.863115,-76.617207);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18818 41.916445 -76.02569
var zip = "18818";
var point = new GLatLng(41.916445,-76.02569);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18820 41.803333 -75.644444
var zip = "18820";
var point = new GLatLng(41.803333,-75.644444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18821 41.977513 -75.732742
var zip = "18821";
var point = new GLatLng(41.977513,-75.732742);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18822 41.959798 -75.782595
var zip = "18822";
var point = new GLatLng(41.959798,-75.782595);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18823 41.779891 -75.678632
var zip = "18823";
var point = new GLatLng(41.779891,-75.678632);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18824 41.693196 -75.789656
var zip = "18824";
var point = new GLatLng(41.693196,-75.789656);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18825 41.864881 -75.609136
var zip = "18825";
var point = new GLatLng(41.864881,-75.609136);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18826 41.765856 -75.783101
var zip = "18826";
var point = new GLatLng(41.765856,-75.783101);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18827 41.956944 -75.585278
var zip = "18827";
var point = new GLatLng(41.956944,-75.585278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18828 41.757294 -76.091214
var zip = "18828";
var point = new GLatLng(41.757294,-76.091214);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18829 41.843415 -76.179604
var zip = "18829";
var point = new GLatLng(41.843415,-76.179604);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18830 41.976593 -76.118472
var zip = "18830";
var point = new GLatLng(41.976593,-76.118472);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18831 41.896555 -76.532777
var zip = "18831";
var point = new GLatLng(41.896555,-76.532777);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18832 41.699387 -76.500995
var zip = "18832";
var point = new GLatLng(41.699387,-76.500995);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18833 41.59867 -76.43983
var zip = "18833";
var point = new GLatLng(41.59867,-76.43983);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18834 41.866409 -75.717113
var zip = "18834";
var point = new GLatLng(41.866409,-75.717113);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18837 41.863403 -76.301498
var zip = "18837";
var point = new GLatLng(41.863403,-76.301498);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18840 41.984222 -76.521757
var zip = "18840";
var point = new GLatLng(41.984222,-76.521757);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18842 41.754373 -75.606723
var zip = "18842";
var point = new GLatLng(41.754373,-75.606723);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18843 41.797222 -75.891667
var zip = "18843";
var point = new GLatLng(41.797222,-75.891667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18844 41.714684 -75.902472
var zip = "18844";
var point = new GLatLng(41.714684,-75.902472);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18845 41.771782 -76.171696
var zip = "18845";
var point = new GLatLng(41.771782,-76.171696);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18846 41.604057 -76.259785
var zip = "18846";
var point = new GLatLng(41.604057,-76.259785);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18847 41.948669 -75.586249
var zip = "18847";
var point = new GLatLng(41.948669,-75.586249);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18848 41.763758 -76.464527
var zip = "18848";
var point = new GLatLng(41.763758,-76.464527);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18850 41.840809 -76.487574
var zip = "18850";
var point = new GLatLng(41.840809,-76.487574);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18851 41.939389 -76.196445
var zip = "18851";
var point = new GLatLng(41.939389,-76.196445);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18853 41.701499 -76.275433
var zip = "18853";
var point = new GLatLng(41.701499,-76.275433);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18854 41.782621 -76.383397
var zip = "18854";
var point = new GLatLng(41.782621,-76.383397);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18901 40.320391 -75.129987
var zip = "18901";
var point = new GLatLng(40.320391,-75.129987);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18902 40.3477 -75.0968
var zip = "18902";
var point = new GLatLng(40.3477,-75.0968);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18910 40.425833 -75.179444
var zip = "18910";
var point = new GLatLng(40.425833,-75.179444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18911 40.369444 -75.248611
var zip = "18911";
var point = new GLatLng(40.369444,-75.248611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18912 40.323611 -75.060278
var zip = "18912";
var point = new GLatLng(40.323611,-75.060278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18913 40.39079 -75.063127
var zip = "18913";
var point = new GLatLng(40.39079,-75.063127);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18914 40.289175 -75.214938
var zip = "18914";
var point = new GLatLng(40.289175,-75.214938);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18915 40.271814 -75.266861
var zip = "18915";
var point = new GLatLng(40.271814,-75.266861);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18916 40.354444 -75.133056
var zip = "18916";
var point = new GLatLng(40.354444,-75.133056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18917 40.371996 -75.204453
var zip = "18917";
var point = new GLatLng(40.371996,-75.204453);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18918 40.320833 -75.372778
var zip = "18918";
var point = new GLatLng(40.320833,-75.372778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18920 40.508689 -75.080372
var zip = "18920";
var point = new GLatLng(40.508689,-75.080372);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18921 40.533611 -75.179167
var zip = "18921";
var point = new GLatLng(40.533611,-75.179167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18922 40.292222 -75.059444
var zip = "18922";
var point = new GLatLng(40.292222,-75.059444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18923 40.336815 -75.153627
var zip = "18923";
var point = new GLatLng(40.336815,-75.153627);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18924 40.307778 -75.358056
var zip = "18924";
var point = new GLatLng(40.307778,-75.358056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18925 40.294518 -75.064946
var zip = "18925";
var point = new GLatLng(40.294518,-75.064946);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18926 40.3725 -75.108056
var zip = "18926";
var point = new GLatLng(40.3725,-75.108056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18927 40.34762 -75.27118
var zip = "18927";
var point = new GLatLng(40.34762,-75.27118);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18928 40.335556 -75.047778
var zip = "18928";
var point = new GLatLng(40.335556,-75.047778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18929 40.256599 -75.096093
var zip = "18929";
var point = new GLatLng(40.256599,-75.096093);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18930 40.531009 -75.211708
var zip = "18930";
var point = new GLatLng(40.531009,-75.211708);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18931 40.346389 -75.031944
var zip = "18931";
var point = new GLatLng(40.346389,-75.031944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18932 40.288781 -75.255535
var zip = "18932";
var point = new GLatLng(40.288781,-75.255535);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18933 40.407103 -75.055166
var zip = "18933";
var point = new GLatLng(40.407103,-75.055166);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18934 40.343821 -75.062962
var zip = "18934";
var point = new GLatLng(40.343821,-75.062962);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18935 40.436944 -75.399167
var zip = "18935";
var point = new GLatLng(40.436944,-75.399167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18936 40.251353 -75.234643
var zip = "18936";
var point = new GLatLng(40.251353,-75.234643);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18938 40.355613 -74.983889
var zip = "18938";
var point = new GLatLng(40.355613,-74.983889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18940 40.245817 -74.94313
var zip = "18940";
var point = new GLatLng(40.245817,-74.94313);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18942 40.459239 -75.157009
var zip = "18942";
var point = new GLatLng(40.459239,-75.157009);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18943 40.265833 -74.998333
var zip = "18943";
var point = new GLatLng(40.265833,-74.998333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18944 40.376526 -75.264803
var zip = "18944";
var point = new GLatLng(40.376526,-75.264803);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18946 40.296111 -75.006111
var zip = "18946";
var point = new GLatLng(40.296111,-75.006111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18947 40.4262 -75.107398
var zip = "18947";
var point = new GLatLng(40.4262,-75.107398);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18949 40.387222 -75.146944
var zip = "18949";
var point = new GLatLng(40.387222,-75.146944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18950 40.4225 -75.066667
var zip = "18950";
var point = new GLatLng(40.4225,-75.066667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18951 40.4411 -75.350667
var zip = "18951";
var point = new GLatLng(40.4411,-75.350667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18953 40.515278 -75.161389
var zip = "18953";
var point = new GLatLng(40.515278,-75.161389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18954 40.216672 -75.002936
var zip = "18954";
var point = new GLatLng(40.216672,-75.002936);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18955 40.472166 -75.32193
var zip = "18955";
var point = new GLatLng(40.472166,-75.32193);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18956 40.2575 -75.031111
var zip = "18956";
var point = new GLatLng(40.2575,-75.031111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18957 40.295833 -75.454722
var zip = "18957";
var point = new GLatLng(40.295833,-75.454722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18958 40.293333 -75.433333
var zip = "18958";
var point = new GLatLng(40.293333,-75.433333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18960 40.362024 -75.318953
var zip = "18960";
var point = new GLatLng(40.362024,-75.318953);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18962 40.3475 -75.271389
var zip = "18962";
var point = new GLatLng(40.3475,-75.271389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18963 40.380556 -75.008611
var zip = "18963";
var point = new GLatLng(40.380556,-75.008611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18964 40.312796 -75.321339
var zip = "18964";
var point = new GLatLng(40.312796,-75.321339);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18966 40.190212 -75.005994
var zip = "18966";
var point = new GLatLng(40.190212,-75.005994);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18968 40.438889 -75.4375
var zip = "18968";
var point = new GLatLng(40.438889,-75.4375);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18969 40.320478 -75.352001
var zip = "18969";
var point = new GLatLng(40.320478,-75.352001);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//18970 40.410556 -75.378611
var zip = "18970";
var point = new GLatLng(40.410556,-75.378611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//18971 40.349444 -75.381389
var zip = "18971";
var point = new GLatLng(40.349444,-75.381389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18972 40.541093 -75.125858
var zip = "18972";
var point = new GLatLng(40.541093,-75.125858);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//18974 40.206676 -75.090513
var zip = "18974";
var point = new GLatLng(40.206676,-75.090513);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18976 40.246438 -75.135392
var zip = "18976";
var point = new GLatLng(40.246438,-75.135392);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18977 40.291906 -74.882859
var zip = "18977";
var point = new GLatLng(40.291906,-74.882859);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//18979 40.310556 -75.449167
var zip = "18979";
var point = new GLatLng(40.310556,-75.449167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//18980 40.282222 -75.019167
var zip = "18980";
var point = new GLatLng(40.282222,-75.019167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18981 40.484167 -75.394167
var zip = "18981";
var point = new GLatLng(40.484167,-75.394167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//18991 40.206667 -75.1
var zip = "18991";
var point = new GLatLng(40.206667,-75.1);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19001 40.128141 -75.128918
var zip = "19001";
var point = new GLatLng(40.128141,-75.128918);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19002 40.166318 -75.207234
var zip = "19002";
var point = new GLatLng(40.166318,-75.207234);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19003 40.001971 -75.29665
var zip = "19003";
var point = new GLatLng(40.001971,-75.29665);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19004 40.01179 -75.23421
var zip = "19004";
var point = new GLatLng(40.01179,-75.23421);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19006 40.129686 -75.058979
var zip = "19006";
var point = new GLatLng(40.129686,-75.058979);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19007 40.109174 -74.860718
var zip = "19007";
var point = new GLatLng(40.109174,-74.860718);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19008 39.974666 -75.360214
var zip = "19008";
var point = new GLatLng(39.974666,-75.360214);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19009 40.131389 -75.067778
var zip = "19009";
var point = new GLatLng(40.131389,-75.067778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19010 40.023618 -75.329487
var zip = "19010";
var point = new GLatLng(40.023618,-75.329487);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19012 40.060327 -75.104774
var zip = "19012";
var point = new GLatLng(40.060327,-75.104774);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19013 39.849817 -75.374687
var zip = "19013";
var point = new GLatLng(39.849817,-75.374687);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19014 39.864282 -75.43321
var zip = "19014";
var point = new GLatLng(39.864282,-75.43321);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19015 39.865355 -75.388483
var zip = "19015";
var point = new GLatLng(39.865355,-75.388483);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19016 39.849444 -75.356111
var zip = "19016";
var point = new GLatLng(39.849444,-75.356111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19017 39.89 -75.475833
var zip = "19017";
var point = new GLatLng(39.89,-75.475833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19018 39.923579 -75.299592
var zip = "19018";
var point = new GLatLng(39.923579,-75.299592);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19019 40.1162 -75.0141
var zip = "19019";
var point = new GLatLng(40.1162,-75.0141);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19020 40.110881 -74.937753
var zip = "19020";
var point = new GLatLng(40.110881,-74.937753);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19021 40.093322 -74.899077
var zip = "19021";
var point = new GLatLng(40.093322,-74.899077);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19022 39.868457 -75.337397
var zip = "19022";
var point = new GLatLng(39.868457,-75.337397);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19023 39.916732 -75.266226
var zip = "19023";
var point = new GLatLng(39.916732,-75.266226);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19025 40.143141 -75.162379
var zip = "19025";
var point = new GLatLng(40.143141,-75.162379);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19026 39.949197 -75.303479
var zip = "19026";
var point = new GLatLng(39.949197,-75.303479);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19027 40.073056 -75.125
var zip = "19027";
var point = new GLatLng(40.073056,-75.125);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19028 39.974722 -75.450833
var zip = "19028";
var point = new GLatLng(39.974722,-75.450833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19029 39.866864 -75.293521
var zip = "19029";
var point = new GLatLng(39.866864,-75.293521);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19030 40.174822 -74.851923
var zip = "19030";
var point = new GLatLng(40.174822,-74.851923);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19031 40.106774 -75.21148
var zip = "19031";
var point = new GLatLng(40.106774,-75.21148);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19032 39.890508 -75.282117
var zip = "19032";
var point = new GLatLng(39.890508,-75.282117);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19033 39.890129 -75.329567
var zip = "19033";
var point = new GLatLng(39.890129,-75.329567);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19034 40.138592 -75.202175
var zip = "19034";
var point = new GLatLng(40.138592,-75.202175);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19035 40.045118 -75.282082
var zip = "19035";
var point = new GLatLng(40.045118,-75.282082);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19036 39.904848 -75.294559
var zip = "19036";
var point = new GLatLng(39.904848,-75.294559);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19037 39.917222 -75.440833
var zip = "19037";
var point = new GLatLng(39.917222,-75.440833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19038 40.10959 -75.154964
var zip = "19038";
var point = new GLatLng(40.10959,-75.154964);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//19039 39.943056 -75.469722
var zip = "19039";
var point = new GLatLng(39.943056,-75.469722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19040 40.178547 -75.107182
var zip = "19040";
var point = new GLatLng(40.178547,-75.107182);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19041 40.009739 -75.312116
var zip = "19041";
var point = new GLatLng(40.009739,-75.312116);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19043 39.900284 -75.308674
var zip = "19043";
var point = new GLatLng(39.900284,-75.308674);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19044 40.182057 -75.147932
var zip = "19044";
var point = new GLatLng(40.182057,-75.147932);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//19046 40.100477 -75.117273
var zip = "19046";
var point = new GLatLng(40.100477,-75.117273);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19047 40.175055 -74.915101
var zip = "19047";
var point = new GLatLng(40.175055,-74.915101);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19048 40.1744 -74.923
var zip = "19048";
var point = new GLatLng(40.1744,-74.923);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19049 40.1744 -74.923
var zip = "19049";
var point = new GLatLng(40.1744,-74.923);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19050 39.93779 -75.264872
var zip = "19050";
var point = new GLatLng(39.93779,-75.264872);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19052 39.893889 -75.448056
var zip = "19052";
var point = new GLatLng(39.893889,-75.448056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19053 40.151188 -74.983758
var zip = "19053";
var point = new GLatLng(40.151188,-74.983758);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19054 40.168142 -74.823138
var zip = "19054";
var point = new GLatLng(40.168142,-74.823138);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19055 40.148329 -74.83714
var zip = "19055";
var point = new GLatLng(40.148329,-74.83714);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19056 40.151861 -74.882632
var zip = "19056";
var point = new GLatLng(40.151861,-74.882632);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19057 40.143359 -74.861366
var zip = "19057";
var point = new GLatLng(40.143359,-74.861366);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19058 40.155 -74.829167
var zip = "19058";
var point = new GLatLng(40.155,-74.829167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19061 39.833934 -75.448309
var zip = "19061";
var point = new GLatLng(39.833934,-75.448309);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19063 39.915562 -75.407226
var zip = "19063";
var point = new GLatLng(39.915562,-75.407226);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19064 39.929599 -75.333786
var zip = "19064";
var point = new GLatLng(39.929599,-75.333786);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19065 39.905556 -75.388333
var zip = "19065";
var point = new GLatLng(39.905556,-75.388333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19066 40.003043 -75.250302
var zip = "19066";
var point = new GLatLng(40.003043,-75.250302);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19067 40.212064 -74.822153
var zip = "19067";
var point = new GLatLng(40.212064,-74.822153);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19070 39.906292 -75.323785
var zip = "19070";
var point = new GLatLng(39.906292,-75.323785);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19072 40.01768 -75.2594
var zip = "19072";
var point = new GLatLng(40.01768,-75.2594);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19073 39.986292 -75.406997
var zip = "19073";
var point = new GLatLng(39.986292,-75.406997);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19074 39.887026 -75.297247
var zip = "19074";
var point = new GLatLng(39.887026,-75.297247);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19075 40.113197 -75.18685
var zip = "19075";
var point = new GLatLng(40.113197,-75.18685);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19076 39.885737 -75.308165
var zip = "19076";
var point = new GLatLng(39.885737,-75.308165);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19078 39.878411 -75.321517
var zip = "19078";
var point = new GLatLng(39.878411,-75.321517);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19079 39.903511 -75.269524
var zip = "19079";
var point = new GLatLng(39.903511,-75.269524);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//19080 40.0435 -75.388
var zip = "19080";
var point = new GLatLng(40.0435,-75.388);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19081 39.896724 -75.347428
var zip = "19081";
var point = new GLatLng(39.896724,-75.347428);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19082 39.95785 -75.268128
var zip = "19082";
var point = new GLatLng(39.95785,-75.268128);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19083 39.97736 -75.310613
var zip = "19083";
var point = new GLatLng(39.97736,-75.310613);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19085 40.039875 -75.345866
var zip = "19085";
var point = new GLatLng(40.039875,-75.345866);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19086 39.887054 -75.372131
var zip = "19086";
var point = new GLatLng(39.887054,-75.372131);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//19087 40.059554 -75.40416
var zip = "19087";
var point = new GLatLng(40.059554,-75.40416);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19088 40.0438 -75.388
var zip = "19088";
var point = new GLatLng(40.0438,-75.388);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19089 40.0435 -75.388
var zip = "19089";
var point = new GLatLng(40.0435,-75.388);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19090 40.146725 -75.121297
var zip = "19090";
var point = new GLatLng(40.146725,-75.121297);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19091 39.916667 -75.388056
var zip = "19091";
var point = new GLatLng(39.916667,-75.388056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19092 39.9543 -75.1832
var zip = "19092";
var point = new GLatLng(39.9543,-75.1832);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19093 39.9543 -75.1832
var zip = "19093";
var point = new GLatLng(39.9543,-75.1832);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19094 39.875993 -75.346309
var zip = "19094";
var point = new GLatLng(39.875993,-75.346309);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19095 40.086673 -75.152417
var zip = "19095";
var point = new GLatLng(40.086673,-75.152417);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19096 40 -75.275984
var zip = "19096";
var point = new GLatLng(40,-75.275984);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19098 39.904167 -75.308889
var zip = "19098";
var point = new GLatLng(39.904167,-75.308889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19099 39.9522 -75.1641
var zip = "19099";
var point = new GLatLng(39.9522,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19101 39.9543 -75.1832
var zip = "19101";
var point = new GLatLng(39.9543,-75.1832);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19102 39.948908 -75.166109
var zip = "19102";
var point = new GLatLng(39.948908,-75.166109);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19103 39.951285 -75.174136
var zip = "19103";
var point = new GLatLng(39.951285,-75.174136);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19104 39.959732 -75.202445
var zip = "19104";
var point = new GLatLng(39.959732,-75.202445);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//19105 39.9543 -75.1832
var zip = "19105";
var point = new GLatLng(39.9543,-75.1832);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19106 39.94742 -75.147271
var zip = "19106";
var point = new GLatLng(39.94742,-75.147271);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19107 39.94867 -75.159339
var zip = "19107";
var point = new GLatLng(39.94867,-75.159339);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19108 39.9591 -75.1599
var zip = "19108";
var point = new GLatLng(39.9591,-75.1599);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//19109 39.9498 -75.1641
var zip = "19109";
var point = new GLatLng(39.9498,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19110 39.9504 -75.164
var zip = "19110";
var point = new GLatLng(39.9504,-75.164);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19111 40.059635 -75.081792
var zip = "19111";
var point = new GLatLng(40.059635,-75.081792);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19112 39.889252 -75.178207
var zip = "19112";
var point = new GLatLng(39.889252,-75.178207);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19113 39.864998 -75.275196
var zip = "19113";
var point = new GLatLng(39.864998,-75.275196);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19114 40.063356 -74.999032
var zip = "19114";
var point = new GLatLng(40.063356,-74.999032);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19115 40.090286 -75.041036
var zip = "19115";
var point = new GLatLng(40.090286,-75.041036);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19116 40.116599 -75.019803
var zip = "19116";
var point = new GLatLng(40.116599,-75.019803);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19118 40.081247 -75.2006
var zip = "19118";
var point = new GLatLng(40.081247,-75.2006);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//19119 40.054681 -75.186564
var zip = "19119";
var point = new GLatLng(40.054681,-75.186564);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19120 40.034254 -75.121256
var zip = "19120";
var point = new GLatLng(40.034254,-75.121256);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19121 39.981085 -75.174005
var zip = "19121";
var point = new GLatLng(39.981085,-75.174005);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19122 39.978014 -75.145882
var zip = "19122";
var point = new GLatLng(39.978014,-75.145882);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19123 39.965975 -75.150968
var zip = "19123";
var point = new GLatLng(39.965975,-75.150968);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19124 40.017798 -75.089526
var zip = "19124";
var point = new GLatLng(40.017798,-75.089526);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19125 39.978751 -75.126156
var zip = "19125";
var point = new GLatLng(39.978751,-75.126156);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19126 40.056839 -75.137854
var zip = "19126";
var point = new GLatLng(40.056839,-75.137854);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19127 40.027512 -75.224167
var zip = "19127";
var point = new GLatLng(40.027512,-75.224167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19128 40.040247 -75.223084
var zip = "19128";
var point = new GLatLng(40.040247,-75.223084);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19129 40.011816 -75.186149
var zip = "19129";
var point = new GLatLng(40.011816,-75.186149);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19130 39.967677 -75.173467
var zip = "19130";
var point = new GLatLng(39.967677,-75.173467);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19131 39.98447 -75.228226
var zip = "19131";
var point = new GLatLng(39.98447,-75.228226);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19132 39.995393 -75.16982
var zip = "19132";
var point = new GLatLng(39.995393,-75.16982);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19133 39.992467 -75.141505
var zip = "19133";
var point = new GLatLng(39.992467,-75.141505);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19134 39.99252 -75.113284
var zip = "19134";
var point = new GLatLng(39.99252,-75.113284);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19135 40.024694 -75.051827
var zip = "19135";
var point = new GLatLng(40.024694,-75.051827);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19136 40.042159 -75.024388
var zip = "19136";
var point = new GLatLng(40.042159,-75.024388);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19137 40.000849 -75.072654
var zip = "19137";
var point = new GLatLng(40.000849,-75.072654);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19138 40.05683 -75.156898
var zip = "19138";
var point = new GLatLng(40.05683,-75.156898);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19139 39.961166 -75.230301
var zip = "19139";
var point = new GLatLng(39.961166,-75.230301);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19140 40.011771 -75.145626
var zip = "19140";
var point = new GLatLng(40.011771,-75.145626);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19141 40.036473 -75.145109
var zip = "19141";
var point = new GLatLng(40.036473,-75.145109);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19142 39.922332 -75.233796
var zip = "19142";
var point = new GLatLng(39.922332,-75.233796);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//19143 39.944815 -75.228819
var zip = "19143";
var point = new GLatLng(39.944815,-75.228819);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19144 40.033773 -75.173099
var zip = "19144";
var point = new GLatLng(40.033773,-75.173099);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19145 39.922724 -75.181194
var zip = "19145";
var point = new GLatLng(39.922724,-75.181194);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19146 39.937949 -75.179364
var zip = "19146";
var point = new GLatLng(39.937949,-75.179364);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19147 39.936175 -75.156324
var zip = "19147";
var point = new GLatLng(39.936175,-75.156324);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19148 39.92068 -75.159538
var zip = "19148";
var point = new GLatLng(39.92068,-75.159538);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19149 40.036915 -75.066374
var zip = "19149";
var point = new GLatLng(40.036915,-75.066374);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19150 40.07262 -75.170621
var zip = "19150";
var point = new GLatLng(40.07262,-75.170621);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19151 39.977199 -75.254492
var zip = "19151";
var point = new GLatLng(39.977199,-75.254492);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19152 40.060571 -75.047079
var zip = "19152";
var point = new GLatLng(40.060571,-75.047079);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19153 39.905512 -75.244431
var zip = "19153";
var point = new GLatLng(39.905512,-75.244431);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19154 40.089738 -74.978052
var zip = "19154";
var point = new GLatLng(40.089738,-74.978052);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19155 40.0947 -74.9818
var zip = "19155";
var point = new GLatLng(40.0947,-74.9818);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19160 40.0117 -75.1463
var zip = "19160";
var point = new GLatLng(40.0117,-75.1463);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19161 40.0614 -75.0795
var zip = "19161";
var point = new GLatLng(40.0614,-75.0795);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19162 39.9522 -75.1641
var zip = "19162";
var point = new GLatLng(39.9522,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19170 39.9522 -75.1641
var zip = "19170";
var point = new GLatLng(39.9522,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19171 39.9522 -75.1641
var zip = "19171";
var point = new GLatLng(39.9522,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19172 39.9522 -75.1641
var zip = "19172";
var point = new GLatLng(39.9522,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19173 39.9522 -75.1641
var zip = "19173";
var point = new GLatLng(39.9522,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19175 39.9522 -75.1641
var zip = "19175";
var point = new GLatLng(39.9522,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19176 39.9523 -75.1638
var zip = "19176";
var point = new GLatLng(39.9523,-75.1638);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19177 39.9543 -75.1832
var zip = "19177";
var point = new GLatLng(39.9543,-75.1832);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19178 39.9543 -75.1832
var zip = "19178";
var point = new GLatLng(39.9543,-75.1832);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19179 40.0315 -75.1764
var zip = "19179";
var point = new GLatLng(40.0315,-75.1764);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19181 39.9522 -75.1641
var zip = "19181";
var point = new GLatLng(39.9522,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19182 39.9522 -75.1641
var zip = "19182";
var point = new GLatLng(39.9522,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19183 39.9522 -75.1641
var zip = "19183";
var point = new GLatLng(39.9522,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19184 39.9522 -75.1641
var zip = "19184";
var point = new GLatLng(39.9522,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19185 39.8893 -75.1701
var zip = "19185";
var point = new GLatLng(39.8893,-75.1701);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19187 39.9522 -75.1641
var zip = "19187";
var point = new GLatLng(39.9522,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19188 39.9522 -75.1641
var zip = "19188";
var point = new GLatLng(39.9522,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19191 39.9522 -75.1641
var zip = "19191";
var point = new GLatLng(39.9522,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19192 39.9543 -75.1832
var zip = "19192";
var point = new GLatLng(39.9543,-75.1832);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19193 39.9522 -75.1641
var zip = "19193";
var point = new GLatLng(39.9522,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19194 39.9543 -75.1827
var zip = "19194";
var point = new GLatLng(39.9543,-75.1827);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19195 39.9522 -75.1642
var zip = "19195";
var point = new GLatLng(39.9522,-75.1642);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19196 39.9522 -75.1641
var zip = "19196";
var point = new GLatLng(39.9522,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19197 39.9522 -75.1641
var zip = "19197";
var point = new GLatLng(39.9522,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//19244 39.9522 -75.1641
var zip = "19244";
var point = new GLatLng(39.9522,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19255 39.9522 -75.1641
var zip = "19255";
var point = new GLatLng(39.9522,-75.1641);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19301 40.04259 -75.482702
var zip = "19301";
var point = new GLatLng(40.04259,-75.482702);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19310 39.945782 -75.970343
var zip = "19310";
var point = new GLatLng(39.945782,-75.970343);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19311 39.821904 -75.768694
var zip = "19311";
var point = new GLatLng(39.821904,-75.768694);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19312 40.041184 -75.447457
var zip = "19312";
var point = new GLatLng(40.041184,-75.447457);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19316 40.053611 -75.820278
var zip = "19316";
var point = new GLatLng(40.053611,-75.820278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19317 39.864769 -75.588515
var zip = "19317";
var point = new GLatLng(39.864769,-75.588515);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19318 39.853333 -75.821944
var zip = "19318";
var point = new GLatLng(39.853333,-75.821944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19319 39.917496 -75.548738
var zip = "19319";
var point = new GLatLng(39.917496,-75.548738);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19320 39.984313 -75.825299
var zip = "19320";
var point = new GLatLng(39.984313,-75.825299);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19330 39.875686 -75.921381
var zip = "19330";
var point = new GLatLng(39.875686,-75.921381);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19331 39.885 -75.5205
var zip = "19331";
var point = new GLatLng(39.885,-75.5205);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19333 40.045181 -75.422691
var zip = "19333";
var point = new GLatLng(40.045181,-75.422691);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19335 40.016078 -75.718261
var zip = "19335";
var point = new GLatLng(40.016078,-75.718261);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19339 39.885 -75.5205
var zip = "19339";
var point = new GLatLng(39.885,-75.5205);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19340 39.885 -75.5205
var zip = "19340";
var point = new GLatLng(39.885,-75.5205);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19341 40.046817 -75.643196
var zip = "19341";
var point = new GLatLng(40.046817,-75.643196);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19342 39.901515 -75.504872
var zip = "19342";
var point = new GLatLng(39.901515,-75.504872);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19343 40.084602 -75.771103
var zip = "19343";
var point = new GLatLng(40.084602,-75.771103);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19344 40.083227 -75.88432
var zip = "19344";
var point = new GLatLng(40.083227,-75.88432);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19345 40.043889 -75.526944
var zip = "19345";
var point = new GLatLng(40.043889,-75.526944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19346 39.795501 -75.875827
var zip = "19346";
var point = new GLatLng(39.795501,-75.875827);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19347 39.748889 -75.824444
var zip = "19347";
var point = new GLatLng(39.748889,-75.824444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19348 39.855033 -75.70002
var zip = "19348";
var point = new GLatLng(39.855033,-75.70002);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19350 39.769558 -75.780707
var zip = "19350";
var point = new GLatLng(39.769558,-75.780707);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19351 39.7225 -75.875278
var zip = "19351";
var point = new GLatLng(39.7225,-75.875278);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19352 39.780905 -75.881784
var zip = "19352";
var point = new GLatLng(39.780905,-75.881784);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19353 40.028889 -75.621111
var zip = "19353";
var point = new GLatLng(40.028889,-75.621111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19354 40.059444 -75.745
var zip = "19354";
var point = new GLatLng(40.059444,-75.745);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//19355 40.037123 -75.533021
var zip = "19355";
var point = new GLatLng(40.037123,-75.533021);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19357 39.853889 -75.641667
var zip = "19357";
var point = new GLatLng(39.853889,-75.641667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19358 39.966667 -75.8
var zip = "19358";
var point = new GLatLng(39.966667,-75.8);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19360 39.7825 -75.875833
var zip = "19360";
var point = new GLatLng(39.7825,-75.875833);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19362 39.74411 -76.035551
var zip = "19362";
var point = new GLatLng(39.74411,-76.035551);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19363 39.782704 -75.981522
var zip = "19363";
var point = new GLatLng(39.782704,-75.981522);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19365 39.965388 -75.926041
var zip = "19365";
var point = new GLatLng(39.965388,-75.926041);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19366 39.900278 -75.626111
var zip = "19366";
var point = new GLatLng(39.900278,-75.626111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19367 39.964167 -75.886944
var zip = "19367";
var point = new GLatLng(39.964167,-75.886944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19369 39.981667 -75.891667
var zip = "19369";
var point = new GLatLng(39.981667,-75.891667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19371 40.099444 -75.879444
var zip = "19371";
var point = new GLatLng(40.099444,-75.879444);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19372 40.000127 -75.762859
var zip = "19372";
var point = new GLatLng(40.000127,-75.762859);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19373 39.904127 -75.531344
var zip = "19373";
var point = new GLatLng(39.904127,-75.531344);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19374 39.825117 -75.782533
var zip = "19374";
var point = new GLatLng(39.825117,-75.782533);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19375 39.895278 -75.734722
var zip = "19375";
var point = new GLatLng(39.895278,-75.734722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19376 40.010556 -75.843056
var zip = "19376";
var point = new GLatLng(40.010556,-75.843056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19380 39.984458 -75.596231
var zip = "19380";
var point = new GLatLng(39.984458,-75.596231);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19381 39.9611 -75.6044
var zip = "19381";
var point = new GLatLng(39.9611,-75.6044);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19382 39.944081 -75.588197
var zip = "19382";
var point = new GLatLng(39.944081,-75.588197);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19383 39.9389 -75.6062
var zip = "19383";
var point = new GLatLng(39.9389,-75.6062);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//19390 39.825314 -75.837374
var zip = "19390";
var point = new GLatLng(39.825314,-75.837374);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19395 39.930833 -75.552222
var zip = "19395";
var point = new GLatLng(39.930833,-75.552222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19397 40.0631 -75.4047
var zip = "19397";
var point = new GLatLng(40.0631,-75.4047);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19398 40.0407 -75.4231
var zip = "19398";
var point = new GLatLng(40.0407,-75.4231);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19399 40.0704 -75.4251
var zip = "19399";
var point = new GLatLng(40.0704,-75.4251);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19401 40.124464 -75.330446
var zip = "19401";
var point = new GLatLng(40.124464,-75.330446);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19403 40.14335 -75.384672
var zip = "19403";
var point = new GLatLng(40.14335,-75.384672);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19404 40.1213 -75.3402
var zip = "19404";
var point = new GLatLng(40.1213,-75.3402);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19405 40.103042 -75.340234
var zip = "19405";
var point = new GLatLng(40.103042,-75.340234);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19406 40.095581 -75.373706
var zip = "19406";
var point = new GLatLng(40.095581,-75.373706);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19407 40.1244 -75.4359
var zip = "19407";
var point = new GLatLng(40.1244,-75.4359);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19408 40.1567 -75.4045
var zip = "19408";
var point = new GLatLng(40.1567,-75.4045);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19409 40.1577 -75.3875
var zip = "19409";
var point = new GLatLng(40.1577,-75.3875);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19415 40.1215 -75.3405
var zip = "19415";
var point = new GLatLng(40.1215,-75.3405);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19420 40.1525 -75.456944
var zip = "19420";
var point = new GLatLng(40.1525,-75.456944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19421 40.129444 -75.638056
var zip = "19421";
var point = new GLatLng(40.129444,-75.638056);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19422 40.15939 -75.279656
var zip = "19422";
var point = new GLatLng(40.15939,-75.279656);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19423 40.2125 -75.368889
var zip = "19423";
var point = new GLatLng(40.2125,-75.368889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19424 40.152222 -75.266667
var zip = "19424";
var point = new GLatLng(40.152222,-75.266667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19425 40.097781 -75.639769
var zip = "19425";
var point = new GLatLng(40.097781,-75.639769);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19426 40.189277 -75.448762
var zip = "19426";
var point = new GLatLng(40.189277,-75.448762);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19428 40.079848 -75.301332
var zip = "19428";
var point = new GLatLng(40.079848,-75.301332);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19429 40.079167 -75.301944
var zip = "19429";
var point = new GLatLng(40.079167,-75.301944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19430 40.22 -75.416667
var zip = "19430";
var point = new GLatLng(40.22,-75.416667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19432 40.074444 -75.535556
var zip = "19432";
var point = new GLatLng(40.074444,-75.535556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19435 40.299924 -75.531975
var zip = "19435";
var point = new GLatLng(40.299924,-75.531975);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19436 40.202089 -75.250746
var zip = "19436";
var point = new GLatLng(40.202089,-75.250746);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19437 40.184167 -75.256667
var zip = "19437";
var point = new GLatLng(40.184167,-75.256667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19438 40.265922 -75.388335
var zip = "19438";
var point = new GLatLng(40.265922,-75.388335);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19440 40.277826 -75.297507
var zip = "19440";
var point = new GLatLng(40.277826,-75.297507);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19441 40.279444 -75.3875
var zip = "19441";
var point = new GLatLng(40.279444,-75.3875);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19442 40.130556 -75.5725
var zip = "19442";
var point = new GLatLng(40.130556,-75.5725);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19443 40.242778 -75.336944
var zip = "19443";
var point = new GLatLng(40.242778,-75.336944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19444 40.089597 -75.260052
var zip = "19444";
var point = new GLatLng(40.089597,-75.260052);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19446 40.237776 -75.295512
var zip = "19446";
var point = new GLatLng(40.237776,-75.295512);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19450 40.261667 -75.406389
var zip = "19450";
var point = new GLatLng(40.261667,-75.406389);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19451 40.255833 -75.360556
var zip = "19451";
var point = new GLatLng(40.255833,-75.360556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19453 40.13642 -75.499931
var zip = "19453";
var point = new GLatLng(40.13642,-75.499931);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19454 40.216593 -75.256483
var zip = "19454";
var point = new GLatLng(40.216593,-75.256483);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19455 40.210833 -75.278611
var zip = "19455";
var point = new GLatLng(40.210833,-75.278611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19456 40.131667 -75.46
var zip = "19456";
var point = new GLatLng(40.131667,-75.46);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19457 40.199444 -75.584167
var zip = "19457";
var point = new GLatLng(40.199444,-75.584167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19460 40.126704 -75.527192
var zip = "19460";
var point = new GLatLng(40.126704,-75.527192);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19462 40.107735 -75.279559
var zip = "19462";
var point = new GLatLng(40.107735,-75.279559);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19464 40.242989 -75.639256
var zip = "19464";
var point = new GLatLng(40.242989,-75.639256);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//19465 40.245278 -75.65
var zip = "19465";
var point = new GLatLng(40.245278,-75.65);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19468 40.19286 -75.530548
var zip = "19468";
var point = new GLatLng(40.19286,-75.530548);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19470 40.18 -75.731111
var zip = "19470";
var point = new GLatLng(40.18,-75.731111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19472 40.341944 -75.5725
var zip = "19472";
var point = new GLatLng(40.341944,-75.5725);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19473 40.247087 -75.460155
var zip = "19473";
var point = new GLatLng(40.247087,-75.460155);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19474 40.222778 -75.399167
var zip = "19474";
var point = new GLatLng(40.222778,-75.399167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19475 40.176477 -75.56969
var zip = "19475";
var point = new GLatLng(40.176477,-75.56969);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19477 40.186954 -75.237501
var zip = "19477";
var point = new GLatLng(40.186954,-75.237501);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19478 40.275556 -75.456944
var zip = "19478";
var point = new GLatLng(40.275556,-75.456944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19480 40.059722 -75.653611
var zip = "19480";
var point = new GLatLng(40.059722,-75.653611);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19481 40.0969 -75.47
var zip = "19481";
var point = new GLatLng(40.0969,-75.47);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19482 40.0969 -75.47
var zip = "19482";
var point = new GLatLng(40.0969,-75.47);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19483 40.08 -75.4159
var zip = "19483";
var point = new GLatLng(40.08,-75.4159);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19484 40.1016 -75.3991
var zip = "19484";
var point = new GLatLng(40.1016,-75.3991);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19485 40.1016 -75.3991
var zip = "19485";
var point = new GLatLng(40.1016,-75.3991);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19486 40.206667 -75.299722
var zip = "19486";
var point = new GLatLng(40.206667,-75.299722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19487 40.1024 -75.4785
var zip = "19487";
var point = new GLatLng(40.1024,-75.4785);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19488 40.0959 -75.3733
var zip = "19488";
var point = new GLatLng(40.0959,-75.3733);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19489 40.102 -75.4772
var zip = "19489";
var point = new GLatLng(40.102,-75.4772);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19490 40.201111 -75.346944
var zip = "19490";
var point = new GLatLng(40.201111,-75.346944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//19492 40.281673 -75.485462
var zip = "19492";
var point = new GLatLng(40.281673,-75.485462);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19493 40.0969 -75.47
var zip = "19493";
var point = new GLatLng(40.0969,-75.47);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19494 40.0969 -75.47
var zip = "19494";
var point = new GLatLng(40.0969,-75.47);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19495 40.0969 -75.47
var zip = "19495";
var point = new GLatLng(40.0969,-75.47);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19496 40.0969 -75.47
var zip = "19496";
var point = new GLatLng(40.0969,-75.47);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19501 40.242992 -76.056542
var zip = "19501";
var point = new GLatLng(40.242992,-76.056542);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19503 40.400557 -75.587483
var zip = "19503";
var point = new GLatLng(40.400557,-75.587483);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19504 40.381501 -75.574889
var zip = "19504";
var point = new GLatLng(40.381501,-75.574889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19505 40.379454 -75.625701
var zip = "19505";
var point = new GLatLng(40.379454,-75.625701);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19506 40.455061 -76.124732
var zip = "19506";
var point = new GLatLng(40.455061,-76.124732);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19507 40.480834 -76.274209
var zip = "19507";
var point = new GLatLng(40.480834,-76.274209);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19508 40.256304 -75.834373
var zip = "19508";
var point = new GLatLng(40.256304,-75.834373);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19510 40.443492 -75.883681
var zip = "19510";
var point = new GLatLng(40.443492,-75.883681);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19511 40.487222 -75.7425
var zip = "19511";
var point = new GLatLng(40.487222,-75.7425);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19512 40.333905 -75.660368
var zip = "19512";
var point = new GLatLng(40.333905,-75.660368);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19516 40.486111 -76.007778
var zip = "19516";
var point = new GLatLng(40.486111,-76.007778);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19518 40.270876 -75.739673
var zip = "19518";
var point = new GLatLng(40.270876,-75.739673);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19519 40.316667 -75.737222
var zip = "19519";
var point = new GLatLng(40.316667,-75.737222);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19520 40.156781 -75.786563
var zip = "19520";
var point = new GLatLng(40.156781,-75.786563);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19522 40.446766 -75.8144
var zip = "19522";
var point = new GLatLng(40.446766,-75.8144);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19523 40.2025 -75.836667
var zip = "19523";
var point = new GLatLng(40.2025,-75.836667);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19525 40.305941 -75.595296
var zip = "19525";
var point = new GLatLng(40.305941,-75.595296);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19526 40.548799 -75.987361
var zip = "19526";
var point = new GLatLng(40.548799,-75.987361);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//19529 40.632794 -75.85127
var zip = "19529";
var point = new GLatLng(40.632794,-75.85127);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19530 40.521354 -75.777395
var zip = "19530";
var point = new GLatLng(40.521354,-75.777395);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19533 40.415216 -75.994421
var zip = "19533";
var point = new GLatLng(40.415216,-75.994421);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19534 40.575284 -75.850002
var zip = "19534";
var point = new GLatLng(40.575284,-75.850002);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19535 40.351944 -75.789167
var zip = "19535";
var point = new GLatLng(40.351944,-75.789167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19536 40.480556 -75.758889
var zip = "19536";
var point = new GLatLng(40.480556,-75.758889);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19538 40.5425 -75.689167
var zip = "19538";
var point = new GLatLng(40.5425,-75.689167);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19539 40.499183 -75.687202
var zip = "19539";
var point = new GLatLng(40.499183,-75.687202);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19540 40.258442 -75.98332
var zip = "19540";
var point = new GLatLng(40.258442,-75.98332);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19541 40.478307 -76.012491
var zip = "19541";
var point = new GLatLng(40.478307,-76.012491);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19542 40.261667 -75.766944
var zip = "19542";
var point = new GLatLng(40.261667,-75.766944);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19543 40.155248 -75.899802
var zip = "19543";
var point = new GLatLng(40.155248,-75.899802);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19544 40.419167 -76.295556
var zip = "19544";
var point = new GLatLng(40.419167,-76.295556);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19545 40.345278 -75.633333
var zip = "19545";
var point = new GLatLng(40.345278,-75.633333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19547 40.383312 -75.770575
var zip = "19547";
var point = new GLatLng(40.383312,-75.770575);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19548 40.282778 -75.691111
var zip = "19548";
var point = new GLatLng(40.282778,-75.691111);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19549 40.581787 -76.026652
var zip = "19549";
var point = new GLatLng(40.581787,-76.026652);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19550 40.4575 -76.244722
var zip = "19550";
var point = new GLatLng(40.4575,-76.244722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19551 40.355281 -76.13659
var zip = "19551";
var point = new GLatLng(40.355281,-76.13659);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19554 40.512778 -76.104722
var zip = "19554";
var point = new GLatLng(40.512778,-76.104722);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19555 40.495495 -75.960313
var zip = "19555";
var point = new GLatLng(40.495495,-75.960313);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19559 40.492222 -76.183333
var zip = "19559";
var point = new GLatLng(40.492222,-76.183333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19560 40.402504 -75.904582
var zip = "19560";
var point = new GLatLng(40.402504,-75.904582);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersD.push(marker);

//19562 40.502941 -75.701528
var zip = "19562";
var point = new GLatLng(40.502941,-75.701528);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19564 40.523889 -75.873333
var zip = "19564";
var point = new GLatLng(40.523889,-75.873333);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19565 40.329289 -76.09014
var zip = "19565";
var point = new GLatLng(40.329289,-76.09014);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19567 40.374333 -76.198511
var zip = "19567";
var point = new GLatLng(40.374333,-76.198511);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersB.push(marker);

//19601 40.346621 -75.935132
var zip = "19601";
var point = new GLatLng(40.346621,-75.935132);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19602 40.330604 -75.919229
var zip = "19602";
var point = new GLatLng(40.330604,-75.919229);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19603 40.3362 -75.9277
var zip = "19603";
var point = new GLatLng(40.3362,-75.9277);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19604 40.350721 -75.914262
var zip = "19604";
var point = new GLatLng(40.350721,-75.914262);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19605 40.38859 -75.932769
var zip = "19605";
var point = new GLatLng(40.38859,-75.932769);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//19606 40.325109 -75.868178
var zip = "19606";
var point = new GLatLng(40.325109,-75.868178);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19607 40.299696 -75.953103
var zip = "19607";
var point = new GLatLng(40.299696,-75.953103);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19608 40.31449 -76.024086
var zip = "19608";
var point = new GLatLng(40.31449,-76.024086);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19609 40.325778 -75.995347
var zip = "19609";
var point = new GLatLng(40.325778,-75.995347);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19610 40.333478 -75.976382
var zip = "19610";
var point = new GLatLng(40.333478,-75.976382);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersA.push(marker);

//19611 40.324989 -75.944188
var zip = "19611";
var point = new GLatLng(40.324989,-75.944188);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//19612 40.3683 -75.9116
var zip = "19612";
var point = new GLatLng(40.3683,-75.9116);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersC.push(marker);

//19640 40.3683 -75.9116
var zip = "19640";
var point = new GLatLng(40.3683,-75.9116);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

//17202 39.9375911 -77.6611022
var zip = "17202";
var point = new GLatLng(39.9375911,-77.6611022);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//17622 40.0378755 -76.3055144
var zip = "17622";
var point = new GLatLng(40.0378755,-76.3055144);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersE.push(marker);

//19190 39.952335 -75.163789
var zip = "19190";
var point = new GLatLng(39.952335,-75.163789);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);

var zip = "19388";
var point = new GLatLng(39.9606643,-75.6054882);
var marker = createMarker(point,zip,"<br>"+zip);
gmarkersF.push(marker);


		
		
		
		
		
		
		
		
        // Display the map, with some controls and set the initial location 

        var map = new GMap2(document.getElementById("map"));
        map.addControl(new GLargeMapControl());
        map.addControl(new GMapTypeControl());
        map.setCenter(new GLatLng(40.582568,-74.278522), 11, G_SATELLITE_MAP);
        var mm = new GMarkerManager(map, {borderPadding:1});

        mm.addMarkers(gmarkersA,0,17);
		mm.addMarkers(gmarkersB,9,17);
		mm.addMarkers(gmarkersC,10,17);
        mm.addMarkers(gmarkersD,11,17);
        mm.addMarkers(gmarkersE,12,17);
        mm.addMarkers(gmarkersF,13,17);
        mm.refresh();
        om.Clear(); // Clear the loading message
      });
    }

    // display a warning if the browser was not compatible
    else {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }
  
    // This Javascript is based on code provided by the
    // Community Church Javascript Team
    // http://www.bisphamchurch.org.uk/   
    // http://econym.org.uk/gmap/
    
    //]]>
    </script>
  </body>
<?php include 'footer.php'; ?>
