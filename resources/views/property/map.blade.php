<script>
var map;

var locations = @php echo $aLocationsJson = json_encode($aLocations); @endphp;

function initMap() {
    myLatLng = {lat: locations[0]['lat'], lng: locations[0]['lon']};
    map = new google.maps.Map(document.getElementById('map'), {
    zoom: 6,
    center: myLatLng
    });
    setMarkers(map,locations);
}

function setMarkers(map,locations)
{

    var marker, i
    for (i = 0; i < locations.length; i++)
    {
        var title = locations[i]['title']
        var lat = locations[i]['lat']
        var long = locations[i]['lon']
        var content =  locations[i]['content']
        latlngset = new google.maps.LatLng(lat, long);

        var marker = new google.maps.Marker({
        map: map, title: title , position: latlngset
        });
        map.setCenter(marker.getPosition());

        var infowindow = new google.maps.InfoWindow()

        google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){
        return function() {
         if($('.gm-style-iw').length)
         {
            $('.gm-style-iw').parent().remove();
         }
         infowindow.setContent(content);
         infowindow.open(map,marker);
        };
        })(marker,content,infowindow));
    }
}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBF7qLSXQ8ydU4opxZvt9AuWm0BgpHR4O4&callback=initMap"></script>
