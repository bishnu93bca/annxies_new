<?php header("Content-Type: text/javascript");?>
   var rez = [];
	var pom=[];
	var tip=[];
	var extra=0;
	var query=[];
	var markers1g = [];
	var infoWindow;
    var locationSelect;
	var resultsBounds = null;
  	var resultsCount = 0;
  	var pagination = null;
	var geocoder;
	var iw;
	var places;
	var x=0;
	 var hostnameRegexp = new RegExp('^https?://.+?/');
    function initialize() {
        var mapCanvas = document.getElementById('margin-top');
		myLatlng=new google.maps.LatLng(<?php echo $_GET['lat']?>, <?php echo $_GET['lng'];?>);
        var mapOptions = {
          center: myLatlng,
          zoom: 15,
		  scaleControl: true,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(mapCanvas, mapOptions);
		var infoWindowA = new google.maps.InfoWindow();
		iw = new google.maps.InfoWindow();
		places = new google.maps.places.PlacesService(map);
		
		//bounds = new google.maps.LatLngBounds();
	  var image = 'icon/marker.png';
      var markerA = new MarkerWithLabel({
        map: map,
		icon:image,
        position: myLatlng,
		title:'<?php echo $_GET['title']?>',
			   labelContent: '<?php echo $_GET['title']?>',
			   labelAnchor: new google.maps.Point(1, 1),
			  labelClass: "labels2", // the CSS class for the label
			   labelStyle: {opacity: 1}			
      });		 
       //bounds.extend(myLatlng);
       //map.fitBounds(bounds);	  
		 html='<b><?php echo $_GET['title']?></b>'
      google.maps.event.addListener(markerA, 'click', function() {
        infoWindowA.setContent(html);
        infoWindowA.open(map, markerA);
      });	

     searchGoogle(0); 

/*google search*/	  	 		
     }
  function searchGoogle(n)
  {
	  resultsBounds = new google.maps.LatLngBounds();
     query[2] = 'restaurants';
	 query[1]='hotels';
	 query[0]='airport';
	 
	  places.textSearch({
	   location: myLatlng,
	   radius: '1',	   
       query: query[n],
	  //bounds: map.getBounds()
    }, addResults);	
  }
	//var input1 = document.getElementById('addressInput1');
	//var searchBox = new google.maps.places.SearchBox(input1);  
	function addResults(results, status, p)
	{   
    //pagination = p;
	 tip[2] ='restaurants';
	 tip[1]='hotels';
	 tip[0]='airport';
	 
    if (status == google.maps.places.PlacesServiceStatus.OK) {
		var image = 'icon/'+tip[extra]+'.png';
      for (var i = 0; i < results.length; i++) {
        markers1g[x] = new google.maps.Marker({
          position: results[i].geometry.location,
          map: map,
		  icon: image
        });
		rez[x]=results[i];
		pom[x]=tip[extra];
		if(tip[extra]=='airport')
		{
			addResult(rez[x], x,tip[extra]);
		}
        google.maps.event.addListener(markers1g[x], 'click', getDetails(rez[x], x));
        //addResult(rez[x], x,tip[extra]);
        resultsBounds.extend(rez[x].geometry.location);
		x++;
      }
      resultsCount += results.length;
      if (resultsCount == 1) {
        map.setCenter(results[0].geometry.location);
        map.setZoom(17);
      } else {
        map.setCenter(myLatlng);
        map.setZoom(15);		  
        //map.fitBounds(resultsBounds);
      }
    }
	
	extra++;
	if(extra<3)
	{
	searchGoogle(extra)
	}
	else
	{
        for (var j = 0; j < markers1g.length; j++) 
        {
            if (map.getBounds().contains(markers1g[j].getPosition())) 
            {
                // markers[i] in visible bounds
				if(pom[j]!='airport')
				{
			addResult(rez[j], j,pom[j]);
				}
				
            } 

        }		
	}
  }
function clearMarkers() {
    for (var i = 0; i < markers1g.length; i++) {
      if (markers1g[i]) {
        markers1g[i].setMap(null);
        markers1g[i] == null;
      }
    }
  }

  function getDetails(result, i) {
    return function() {
      places.getDetails({
          reference: result.reference
      }, showDetails(i));
    }
  }
  
  function showDetails(i) {
    return function(place, status) {
     /* if (iw) {
        iw.close();
        iw = null;
      }*/
      

      if (status == google.maps.places.PlacesServiceStatus.OK) {
        /*iw = new google.maps.InfoWindow({
          content: getIWContent(place)
        });
        iw.open(map, markers[i]);*/
		content=getIWContent(place);
		iw.setContent(content);
        iw.open(map, markers1g[i]);
        //showReviews(place.reviews);
      }
    }
  }

  function addResult(result, i,tip) {
    var results = document.getElementById("result-"+tip);
    var tr = document.createElement('tr');
	tr.setAttribute("class", "cursor");
    tr.style.backgroundColor = (i% 2 == 0 ? '#F0F0F0' : '#FFFFFF');
    tr.onclick = function() {
      google.maps.event.trigger(markers1g[i], 'click');
    };
    
    var iconTd = document.createElement('td');
    var nameTd = document.createElement('td');
    var icon = document.createElement('img');
    icon.src = result.icon;
    icon.setAttribute("class", "placeIcon");
    icon.setAttribute("className", "placeIcon");
	icon.style.height = '15px';
    icon.style.width = '15px';
    var name = document.createTextNode(result.name);
    iconTd.appendChild(icon);
    nameTd.appendChild(name);
    tr.appendChild(iconTd);
    tr.appendChild(nameTd);
    results.appendChild(tr);
  }
  
  function clearResults() {
    var results = document.getElementById("results");
    while (results.childNodes[0]) {
      results.removeChild(results.childNodes[0]);
    }
  }  

  function getIWContent(place) {
    var content = '';
    content += '<table>';
    content += '<tr class="iw_table_row">';
    content += '<td style="text-align: right"><img class="iwPlaceIcon" src="' + place.icon + '"/></td>';
    content += '<td><b><a href="' + place.url + '">' + place.name + '</a></b></td></tr>';
    content += '<tr class="iw_table_row"><td class="iw_attribute_name">Address:</td><td>' + place.vicinity + '</td></tr>';
    if (place.formatted_phone_number) {
      content += '<tr class="iw_table_row"><td class="iw_attribute_name">Telephone:</td><td>' + place.formatted_phone_number + '</td></tr>';      
    }
    if (place.rating) {
      var ratingHtml = '';
      for (var i = 0; i < 5; i++) {
        if (place.rating < (i + 0.5)) {
          ratingHtml += '&#10025;';
        } else {
          ratingHtml += '&#10029;';
        }
      }
      content += '<tr class="iw_table_row"><td class="iw_attribute_name">Rating:</td><td><span id="rating">' + ratingHtml + '</span></td></tr>';
    }
    if (place.website) {
      var fullUrl = place.website;
      var website = hostnameRegexp.exec(place.website);
      if (website == null) { 
        website = 'http://' + place.website + '/';
        fullUrl = website;
      }
      content += '<tr class="iw_table_row"><td class="iw_attribute_name">Website:</td><td><a href="' + fullUrl + '">' + website + '</a></td></tr>';
    }
    if (place.opening_hours) {
        var dayToday = (new Date()).getDay();
        var periods = place['opening_hours'].periods;
        var hours_html = '';
        for (var i = 0; i < periods.length; i++) {
            if (periods[i].open.day == dayToday) {
                hours_html += periods[i].open.time + ' - ' + periods[i].close.time + '<br/>';
            }
        }
        content += '<tr class="iw_table_row"><td class="iw_attribute_name">Open today: </td><td>' + hours_html + '</td></tr>';
    }
    content += '</table>';
    return content;
  }	 