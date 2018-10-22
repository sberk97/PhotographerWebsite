// Based on https://bootstrapious.com/p/google-maps-and-bootstrap-tutorial
$(document).ready(function() {
  $(function () {
    function initMap() {
      var location = new google.maps.LatLng(53.791144, -1.765060);

      var mapCanvas = document.getElementById('map');
      var mapOptions = {
        center: location,
        zoom: 16,
        panControl: false,
        streetViewControl: false,
        zoomControl: false,
        mapTypeControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      }

      var map = new google.maps.Map(mapCanvas, mapOptions);

      var marker = new google.maps.Marker({
        position: location,
        map: map
      });
    }
    google.maps.event.addDomListener(window, 'load', initMap);
  });
});
