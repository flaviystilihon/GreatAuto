function initialize()
{
var myCenter=new google.maps.LatLng(29.7586497,-95.3607199);

  var mapProp = {
    center: new google.maps.LatLng(29.7586497,-95.3607199),
    zoom:14,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

var marker=new google.maps.Marker({
  position:myCenter,
  });

  var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

marker.setMap(map);

var infowindow = new google.maps.InfoWindow({
  content:"<b>GreatAuto</b><br>\n\
            Texas Avenue, 17<br>\n\
            Houston, Texas"
  });

infowindow.open(map,marker);
}

function loadScript()
{
  var script = document.createElement("script");
  script.type = "text/javascript";
  script.src = "http://maps.googleapis.com/maps/api/js?key=&sensor=false&callback=initialize";
  document.body.appendChild(script);
}

window.onload = loadScript;
