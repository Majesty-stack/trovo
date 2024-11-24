<?php
require_once('header.php');

$errorMessage = "";
$successMessage = "";

// Fetch locations from the database
$locations = [];
try {
    $stmt = $pdo->query("SELECT location_name, region FROM locations");
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Error fetching locations: " . $e->getMessage();
}

// Add your Google Maps API key here
$googleMapsApiKey = 'YOUR_GOOGLE_MAPS_API_KEY';
?>

<section class="content-header">
    <h1>Map Integration</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Location Map</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <div id="map" style="height: 500px; width: 100%;"></div>
        </div>
    </div>
</section>

<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap" async defer></script>

<script>
function initMap() {
    // Map options
    var options = {
        zoom: 10,
        center: {lat: 6.5244, lng: 3.3792} // Centered on Lagos, Nigeria
    }

    // New map
    var map = new google.maps.Map(document.getElementById('map'), options);

    // Array of locations (this example assumes latitude and longitude are hard-coded for demonstration)
    var locations = [
        {name: 'Ikeja', lat: 6.5965, lng: 3.3431},
        {name: 'Lekki', lat: 6.4562, lng: 3.6015},
        {name: 'Victoria Island', lat: 6.4281, lng: 3.4215},
        {name: 'Yaba', lat: 6.5143, lng: 3.3792}
    ];

    // Loop through locations
    locations.forEach(function(location) {
        addMarker({
            coords: {lat: location.lat, lng: location.lng},
            content: '<h4>' + location.name + '</h4>'
        });
    });

    // Add marker function
    function addMarker(props) {
        var marker = new google.maps.Marker({
            position: props.coords,
            map: map
        });

        // Check for custom content
        if (props.content) {
            var infoWindow = new google.maps.InfoWindow({
                content: props.content
            });

            marker.addListener('click', function() {
                infoWindow.open(map, marker);
            });
        }
    }
}
</script>

<?php require_once('footer.php'); ?>
