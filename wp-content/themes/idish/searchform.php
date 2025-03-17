<?php get_header(); ?>
  

<!--   <div class="container-fluid">
      <div class="container p-5 text-center">

        <div class="row">
            <div class="col-sm-12 col-lg-6 col-md-6 offset-lg-3 offset-md-3">
                 <form id="dishSearchForm" class="shadow-sm p-4" style="border: 1px dashed #aaaa">

                    <h5 class=" text-muted ">Upload a Food Dish Image</h5>
                    <hr class="mb-4 text-muted">

                    <div class="d-flex justify-content-center">
                        <input type="file" id="imageUpload" class="form-control mx-1" accept="image/*">
                        <button type="button" class="btn btn-info text-white btn-sm mx-1" id="dishSearchBtn">Search</button>
                    </div>
                 </form>
            </div>
        </div>
        <div id="food-dish-finder">
            <div id="map" style="height: 400px; width: 100%;"></div>
        </div>
      </div>
  </div> -->

 <!--    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5zdCNSYZMqOf89qVIKir4MKXcRsOjwww"></script>
  
    <style>
        #map {
            width: 100%;
            height: 450px;
        }
        .custom-tooltip {
            position: absolute;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 10px;
            max-width: 250px;
            display: none;
            z-index: 1000;
        }
        .tooltip-arrow {
            position: absolute;
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-top: 10px solid white;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>

<div id="map"></div>

<script>
    function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 50.8503, lng: 4.3517 }, // Brussels, Belgium
            zoom: 12,
            disableDefaultUI: true, // Hide all controls
            zoomControl: true // Show only zoom control
        });

        // Marker Locations in Brussels
        const locations = [
            { lat: 50.8503, lng: 4.3517, title: "Black Restaurant", image: "restaurant.jpg", description: "Pizza ut tincidunt turpis, et rutrum neque" },
            { lat: 50.8467, lng: 4.3499, title: "Cafe Maison", image: "cafe.jpg", description: "Enjoy fresh coffee and snacks" }
        ];

        let activeTooltip = null;

        locations.forEach((location) => {
            const marker = new google.maps.Marker({
                position: { lat: location.lat, lng: location.lng },
                map: map,
                icon: "https://maps.google.com/mapfiles/kml/shapes/dining.png",
                title: location.title
            });

            const tooltip = document.createElement("div");
            tooltip.classList.add("custom-tooltip");
            tooltip.innerHTML = `
                <div class="card">
                    <img src="${location.image}" class="card-img-top" alt="${location.title}">
                    <div class="card-body">
                        <h5 class="card-title">${location.title}</h5>
                        <p class="card-text">${location.description}</p>
                    </div>
                    <div class="tooltip-arrow"></div>
                </div>
            `;
            document.body.appendChild(tooltip);

            // Custom Overlay to position tooltip correctly
            const overlay = new google.maps.OverlayView();
            overlay.onAdd = function () {
                const layer = this.getPanes().overlayMouseTarget;
                layer.appendChild(tooltip);
            };
            overlay.draw = function () {
                const projection = this.getProjection();
                if (!projection) return;
                const position = projection.fromLatLngToDivPixel(marker.getPosition());
                tooltip.style.left = `${position.x - tooltip.offsetWidth / 2}px`;
                tooltip.style.top = `${position.y - tooltip.offsetHeight - 10}px`; // 10px above marker
            };
            overlay.setMap(map);

            marker.addListener("click", () => {
                if (activeTooltip) activeTooltip.style.display = "none";
                tooltip.style.display = "block";
                activeTooltip = tooltip;
                overlay.draw(); // Reposition tooltip
            });

            map.addListener("click", () => {
                tooltip.style.display = "none";
            });

            map.addListener("zoom_changed", () => overlay.draw());
            map.addListener("drag", () => overlay.draw());
        });
    }

    window.onload = initMap;
</script> -->

<!-- <script>
function getUserLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            
            console.log("Latitude: " + lat + ", Longitude: " + lng);

            // Send coordinates to WordPress PHP via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "<?php //echo admin_url('admin-ajax.php'); ?>", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log("Response from PHP: " + xhr.responseText);
                }
            };
            xhr.send("action=save_user_location&latitude=" + lat + "&longitude=" + lng);
        }, function(error) {
            console.error("Error getting location:", error);
        });
    } else {
        console.error("Geolocation is not supported by this browser.");
    }
}

// Run the function when the page loads
document.addEventListener("DOMContentLoaded", getUserLocation);
</script>

 -->



 <?php
// Call the shortcode and echo the output
echo do_shortcode('[food_dish_finder]');
?>


<?php get_footer(); ?>








