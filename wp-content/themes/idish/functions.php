<?php
/* Enqueue Parent and Child Theme Styles */
function idish_child_enqueue_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/assets/css/custom-style.css', array('parent-style'), wp_get_theme()->get('Version'));

    // Bootstrap CSS
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', array(), '5.3.2');


    // Owl Carousel CSS
    wp_enqueue_style('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', array(), '2.3.4');
    wp_enqueue_style('owl-theme', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css', array(), '2.3.4');

    // Bootstrap JS
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.2', true);

    // Owl Carousel JS
    wp_enqueue_script('owl-carousel-js', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), '2.3.4', true);

    // Custom JS for initializing Owl Carousel
    // wp_enqueue_script('custom-carousel', get_stylesheet_directory_uri() . '/assets/js/custom-carousel.js', array('jquery', 'owl-carousel-js'), wp_get_theme()->get('Version'), true);
}
add_action('wp_enqueue_scripts', 'idish_child_enqueue_styles');


/* Enqueue Styles and Scripts for Admin Panel */
function idish_admin_enqueue_styles()
{
    // Bootstrap CSS
    wp_enqueue_style('bootstrap-admin', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', array(), '5.3.2');

    // Font Awesome CSS
    wp_enqueue_style('i-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');

    // Owl Carousel CSS
    wp_enqueue_style('owl-carousel-admin', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', array(), '2.3.4');
    wp_enqueue_style('owl-theme-admin', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css', array(), '2.3.4');

    // Custom Admin Styles
    wp_enqueue_style('idish-admin-style', get_stylesheet_directory_uri() . '/assets/css/admin-style.css', array(), wp_get_theme()->get('Version'));

    // Bootstrap JS
    wp_enqueue_script('bootstrap-admin-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.2', true);

    // Owl Carousel JS
    wp_enqueue_script('owl-carousel-admin-js', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), '2.3.4', true);

    // Custom Admin JS
    wp_enqueue_script('idish-admin-js', get_stylesheet_directory_uri() . '/assets/js/admin-custom.js', array('jquery'), wp_get_theme()->get('Version'), true);
}
add_action('admin_enqueue_scripts', 'idish_admin_enqueue_styles');


function idish_enqueue_fontawesome()
{
    // Enqueue Font Awesome CSS
    wp_enqueue_style('font-awesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', array(), '6.0.0-beta3');

    // Enqueue Font Awesome JS
    wp_enqueue_script('font-awesome-js', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js', array(), null, true);

    // Custom Header Styles
    wp_enqueue_style('idish-header-style', get_stylesheet_directory_uri() . '/assets/css/header-style.css', array(), wp_get_theme()->get('Version'));
}
add_action('wp_enqueue_scripts', 'idish_enqueue_fontawesome');




/* Include Additional Files */
require_once get_stylesheet_directory() . '/customizer.php';
require_once get_stylesheet_directory() . '/widgets.php';
require_once get_stylesheet_directory() . '/inc/wp-bootstrap-navwalker.php';
require_once get_stylesheet_directory() . '/inc/vendor/autoload.php';

use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Image;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\BatchAnnotateImagesRequest;

putenv('GOOGLE_APPLICATION_CREDENTIALS=' . get_stylesheet_directory() . '/inc/idishnew.json');

require_once get_stylesheet_directory() . '/ajax/home-ajax.php';
require_once get_stylesheet_directory() . '/ajax/admin-settings-ajax.php';

/* Theme Support */
function idish_child_theme_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('menus');
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'idish-child')
    ));
}
add_action('after_setup_theme', 'idish_child_theme_setup');


function idish_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'idish_add_woocommerce_support');


/* 
--------------------------------------------------------------------------------------------
 ADD MENU FOR THE THEME SETTING 
--------------------------------------------------------------------------------------------
*/


// Foogra Menu Register
function idish_child_register_menus()
{
    register_nav_menus(array(
        'foogra-menu' => __('Foogra Menu', 'idish-child'),
    ));
}
add_action('init', 'idish_child_register_menus');




function custom_admin_menu()
{
    // Add a top-level menu item
    add_menu_page(
        'Dish Finder', // Page title
        'Dish Finder', // Menu title
        'manage_options', // Capability required to access this menu
        'dish-finder', // Slug (the URL parameter)
        'custom_menu_page', // Callback function to display the page content
        'dashicons-food', // Icon for the menu (optional)
        6 // Position (optional, determines where in the menu the item appears)
    );

    // Add another submenu for some settings or another page
    add_submenu_page(
        'dish-finder', // Parent slug
        'Settings', // Page title
        'Settings', // Submenu title
        'manage_options', // Capability required
        'dish-finder-settings', // Slug
        'dish_finder_settings_page' // Callback function
    );
}

add_action('admin_menu', 'custom_admin_menu');

// Callback function for the main menu page
function custom_menu_page()
{
    echo "<div class='wrap'>";
    include('admin/dashboard.php');
    echo "</div>";
}

// Callback function for the "Settings" submenu
function dish_finder_settings_page()
{
    echo "<div class='wrap'>";
    include('admin/settings.php');
    echo "</div>";
}


/* 
--------------------------------------------------------------------------------------------

--------------------------------------------------------------------------------------------
*/

function food_dish_finder_enqueue_scripts()
{
    // Custom Styles
    wp_enqueue_style('food-dish-finder-css', get_stylesheet_directory_uri() . '/assets/css/food-dish-finder.css', array(), wp_get_theme()->get('Version'));

    // Custom JS
    wp_enqueue_script('food-dish-finder-js', get_stylesheet_directory_uri() . '/assets/js/food-dish-finder.js', array('jquery'), wp_get_theme()->get('Version'), true);

    // Add Google Maps API
    wp_enqueue_script('google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyC5zdCNSYZMqOf89qVIKir4MKXcRsOjwww&libraries=marker', null, null, true);
}
add_action('wp_enqueue_scripts', 'food_dish_finder_enqueue_scripts');

// Add a shortcode for the image upload form and Google Map
function food_dish_finder_shortcode()
{
    ob_start();
?>

    <div class="container-fluid p-0 m-0">
        <div id="map" style="height: 350px; width: 100%;"></div>
    </div>


    <div class="container-fluid">
        <div class="container py-4">
            <h2 class="text-center fw-bold">Upload a Food Dish Image</h2>
            <hr class="">

            <div class="d-flex justify-content-center align-items-center mb-3">
                <select id="citySelect" class="form-control  shadow-none w-25 mx-1">
                    <option value="brussels">Brussels</option>
                    <option value="belgium">Belgium</option>
                </select>
            </div>
            <div class="d-flex justify-content-center align-items-center my-2">
                <input type="text" class="form-control w-75 mx-1 shadow-none" id="dish_name" readonly="" style="display:none;">
            </div>


            <div class="d-flex justify-content-center align-items-center mb-3">
                <button class="btn btn-dark mx-1 shadow-none" id="uploadFileModalBtn" data-bs-toggle="modal" data-bs-target="#uploadFileModal">Upload File</button>
                <button class="btn btn-primary mx-1 shadow-none" id="takePhotoModalBtn" data-bs-toggle="modal" data-bs-target="#takePhotoModal">Take Photo</button>
            </div>

            <!-- ////////////////////////////////////////////////// Modal /////////////////////////////////////////// -->
            <!-- ////////////////////////////////////////////////// Modal /////////////////////////////////////////// -->
            <!-- ////////////////////////////////////////////////// Modal /////////////////////////////////////////// -->

            <div class="modal fade" id="uploadFileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-0">

                        <div class="modal-body">

                            <!-- Loader (Initially Hidden) -->
                            <div class="photo-loader-main text-center" id="upload-loader" style="display:none;">
                                <div class="">
                                    <i class="fa-solid fa-spinner fa-spin" id="upload-loader-icon"></i>
                                    <p class="text-center text-white mt-2" style="font-size: 12px;">Please Wait...</p>
                                </div>

                            </div>

                            <form id="uploadForm" action="" method="post" enctype="multipart/form-data">
                                <div class="form-row my-3">
                                    <div class="col">
                                        <input type="file" name="image" class="form-control shadow-none" accept="image/*" required id="imageFile">
                                    </div>
                                </div>


                                <hr>

                                <div class="d-flex justify-content-center align-items-center">
                                    <button type="reset" class="btn btn-sm btn-outline-dark mx-1" style="display: none;" id="resetBTN">reset</button>
                                    <button type="button" class="btn btn-sm btn-outline-success mx-1" id="searchBTN">Search</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger mx-1" id="cancelBTN" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="takePhotoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="takePhotoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-0">
                        <div class="modal-body">

                            <!-- Loader (Initially Hidden) -->
                            <div class="photo-loader-main text-center" id="photo-loader" style="display:none;">
                                <div class="">
                                    <i class="fa-solid fa-spinner fa-spin" id="photo-loader-icon"></i>
                                    <p class="text-center text-white mt-2" style="font-size: 12px;">Please Wait...</p>
                                </div>

                            </div>

                            <!-- Camera Section -->
                            <div id="cameraSection" style="display:none;">
                                <video id="camera" autoplay height="350px"></video>
                                <canvas id="canvas" style="display:none;"></canvas>
                                <img id="capturedImage" style="display:none; width: 100%; height: 350px;" />
                                <form id="cameraForm" action="" method="post">
                                    <input type="hidden" name="cameraImage" id="cameraImage">
                                </form>
                            </div>

                            <hr class="m-0 mt-1 mb-3 p-0">

                            <!-- Buttons -->
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-sm btn-outline-dark mx-1" id="resetBTn" style="display:none;">Reset</button>
                                <button type="button" class="btn btn-sm btn-outline-dark mx-1" id="captureBtn">Take Photo</button>
                                <button type="button" class="btn btn-sm btn-outline-success mx-1" id="searchButton" style="display:none;">Search</button>
                                <button type="button" class="btn btn-sm btn-outline-danger mx-1" id="cancelBtn" data-bs-dismiss="modal">Cancel</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Loader Styles -->
            <style>
                #photo-loader {
                    height: 93.5% !important;
                    width: 93.7% !important;
                    background: #0000004d;
                    position: absolute;
                    overflow: hidden;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }

                #photo-loader-icon {
                    font-size: 50px;
                    color: #fff;
                }

                #upload-loader {
                    height: 79.5% !important;
                    width: 93.7% !important;
                    background: #0000004d;
                    position: absolute;
                    overflow: hidden;
                    display: flex;
                    justify-content: center !important;
                    align-items: center !important;
                }

                #upload-loader-icon {
                    font-size: 50px;
                    color: #fff;
                }
            </style>

            <script>
                jQuery(document).ready(function($) {

                    const video = $('#camera')[0];
                    const canvas = $('#canvas')[0];
                    const cameraImage = $('#cameraImage');
                    const capturedImage = $('#capturedImage');
                    const searchButton = $('#searchButton');
                    const resetButton = $('#resetBTn');
                    const cancelButton = $('#cancelBtn');
                    const captureButton = $('#captureBtn');
                    const cameraSection = $('#cameraSection');
                    const loader = $('#photo-loader');
                    const loadertwo = $('#upload-loader');

                    let map;
                    let markers = [];


                    // Initialize Google Map
                    function initMap() {
                        map = new google.maps.Map(document.getElementById("map"), {
                            center: {
                                lat: 50.8503,
                                lng: 4.3517
                            }, // Default center (Brussels, Belgium)
                            zoom: 10,
                            disableDefaultUI: true,
                            zoomControl: true
                        });
                    }


                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                    const serachBTN = $('#searchBTN');
                    //$('#uploadFileModal').modal('show');


                    // Handle image upload and send to server
                    $('#searchBTN').on('click', function(e) {
                        e.preventDefault();
                        const file = $('#imageFile')[0].files[0];
                        const city = $('#citySelect').val(); // Get selected city

                        if (!file) {
                            alert('Please upload an image.');
                            $('#resetBTN').hide();
                            return;
                        }

                        $('#resetBTN').show();
                        $('#upload-loader').show();


                        const formData = new FormData();
                        formData.append('image', file);
                        formData.append('city', city); // Append selected city to the data
                        formData.append('action', 'food_dish_finder_upload');

                        var ajaxRequestOne = $.ajax({
                            url: "<?php echo admin_url('admin-ajax.php'); ?>",
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                // Hide the loader when the request is complete
                                $('#upload-loader').hide();
                                $('#uploadForm').trigger('reset');
                                $('#uploadFileModal').modal('hide');
                                $('#map').show();

                                if (response.success) {

                                    $('#dish_name').val(response.data.dishName);
                                    $('#dish_name').show();

                                    // Remove all existing markers
                                    markers.forEach(marker => marker.setMap(null));
                                    markers = [];

                                    // Create new markers for locations returned by the server
                                    if (response.data.locations.length > 0) {
                                        const firstLocation = response.data.locations[0];
                                        const firstPosition = {
                                            lat: firstLocation.lat,
                                            lng: firstLocation.lng
                                        };

                                        // Adjust map to center and zoom on the first marker
                                        map.setCenter(firstPosition);
                                        map.setZoom(12); // Zoom in for better visibility

                                        response.data.locations.forEach(location => {
                                            const customIcon = {
                                                url: '<?php echo get_stylesheet_directory_uri(); ?>/assets/images/spoon_fog_icon_red.png', // Path to your custom icon
                                                size: new google.maps.Size(32, 32), // Size of the icon
                                                scaledSize: new google.maps.Size(32, 32), // Scaled size if needed
                                                origin: new google.maps.Point(0, 0), // Origin of the image
                                                anchor: new google.maps.Point(16, 32) // Anchor point to position the icon
                                            };

                                            const marker = new google.maps.Marker({
                                                position: {
                                                    lat: location.lat,
                                                    lng: location.lng
                                                },
                                                map: map,
                                                title: location.name,
                                                icon: customIcon // Set the custom icon here
                                            });

                                            // Create a Bootstrap Card layout for the InfoWindow
                                            const infoWindowContent = `
                                        <div class="card" style="width: 18rem;">
                                            <div class="card-body">
                                                <h5 class="card-title">${location.name}</h5>
                                                <p class="card-text">
                                                    ${location.formatted_address}<br>
                                                    Rating: ${location.rating}<br>
                                                    Total Reviews: ${location.user_ratings_total}
                                                </p>
                                            </div>
                                        </div>
                                    `;

                                            const infowindow = new google.maps.InfoWindow({
                                                content: infoWindowContent
                                            });

                                            // Add event listener to open the info window when the marker is clicked
                                            marker.addListener('click', function() {
                                                infowindow.open(map, marker);
                                            });

                                            markers.push(marker);
                                        });
                                    } else {
                                        alert('No restaurants found');
                                    }
                                } else {
                                    alert(response.data);
                                }
                            },
                            error: function(xhr, status, error) {
                                $('#upload-loader').hide();
                                console.error(error);
                            }
                        });


                        $('#cancelBTN').click(function() {
                            if (ajaxRequestOne) {
                                ajaxRequestOne.abort();
                                console.log('AJAX request aborted.');
                            }
                        });
                    });




                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                    function showCamera() {
                        cameraSection.show();
                        captureButton.show();
                        navigator.mediaDevices.getUserMedia({
                                video: {
                                    facingMode: {
                                        exact: 'environment'
                                    }
                                }
                            })
                            .then(stream => {
                                video.srcObject = stream;
                                $(video).show();
                            })
                            .catch(() => {
                                navigator.mediaDevices.getUserMedia({
                                        video: {
                                            facingMode: 'user'
                                        }
                                    })
                                    .then(stream => {
                                        video.srcObject = stream;
                                        $(video).show();
                                    })
                                    .catch(err => console.error('Camera access denied:', err));
                            });
                    }

                    function stopCamera() {
                        if (video.srcObject) {
                            video.srcObject.getTracks().forEach(track => track.stop());
                            video.srcObject = null;
                        }
                        $(video).hide();
                    }

                    function takePhoto() {
                        const context = canvas.getContext('2d');
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                        context.drawImage(video, 0, 0, canvas.width, canvas.height);
                        const imageDataURL = canvas.toDataURL('image/png');
                        cameraImage.val(imageDataURL);
                        capturedImage.attr('src', imageDataURL).show();
                        searchButton.show();
                        resetButton.show();
                        captureButton.hide(); // Hide "Take Photo" button after capture

                        stopCamera();
                    }

                    function resetPhoto() {
                        capturedImage.hide().attr('src', '');
                        cameraImage.val('');
                        searchButton.hide();
                        resetButton.hide();
                        captureButton.show(); // Show "Take Photo" button on reset
                        showCamera();
                    }

                    function cancelProcess() {
                        stopCamera();
                        cameraSection.hide();
                        capturedImage.hide();
                        searchButton.hide();
                        resetButton.hide();
                        captureButton.show(); // Show "Take Photo" button on cancel
                        loader.hide(); // Ensure loader is hidden on cancel
                    }

                    $('#takePhotoModalBtn').click(function() {
                        showCamera();
                    });

                    $('#captureBtn').click(function() {
                        takePhoto();
                    });

                    $('#resetBTn').click(function() {
                        resetPhoto();
                    });

                    $('#cancelBtn').click(function() {
                        cancelProcess();
                    });

                    $('#searchButton').click(function() {
                        var cameraImageVal = $('#cameraImage').val();
                        var city = $('#citySelect').val();


                        if (cameraImageVal == '') {
                            alert('Captured image not found.');
                        } else {
                            loader.show();

                            var ajaxRequestTwo = $.ajax({
                                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                                type: 'post',
                                data: {
                                    'action': 'food_dish_finder_with_photo',
                                    'image': cameraImageVal,
                                    'city': city
                                },
                                success: function(response) {
                                    //alert('Image processed successfully');
                                    loader.hide();
                                    // resetPhoto();
                                    cancelProcess();

                                    $('#takePhotoModal').modal('hide');

                                    $('#map').show();

                                    if (response.success) {

                                        $('#dish_name').val(response.data.dishName);
                                        $('#dish_name').show();

                                        // Remove all existing markers
                                        markers.forEach(marker => marker.setMap(null));
                                        markers = [];

                                        // Create new markers for locations returned by the server
                                        if (response.data.locations.length > 0) {
                                            const firstLocation = response.data.locations[0];
                                            const firstPosition = {
                                                lat: firstLocation.lat,
                                                lng: firstLocation.lng
                                            };


                                            // console.log(response.data.locations);


                                            // Adjust map to center and zoom on the first marker
                                            map.setCenter(firstPosition);
                                            map.setZoom(12); // Zoom in for better visibility

                                            response.data.locations.forEach(location => {

                                                const customIcon = {
                                                    url: '<?php echo get_stylesheet_directory_uri(); ?>/assets/images/spoon_fog_icon_red.png', // Path to your custom icon
                                                    size: new google.maps.Size(32, 32), // Size of the icon
                                                    scaledSize: new google.maps.Size(32, 32), // Scaled size if needed
                                                    origin: new google.maps.Point(0, 0), // Origin of the image
                                                    anchor: new google.maps.Point(16, 32) // Anchor point to position the icon
                                                };

                                                const marker = new google.maps.Marker({
                                                    position: {
                                                        lat: location.lat,
                                                        lng: location.lng
                                                    },
                                                    map: map,
                                                    title: location.name,
                                                    icon: customIcon // Set the custom icon here
                                                });

                                                // Create a Bootstrap Card layout for the InfoWindow
                                                const infoWindowContent = `
                                        <div class="card" style="width: 18rem;">
                                            <div class="card-body">
                                                <h5 class="card-title">${location.name}</h5>
                                                <p class="card-text">
                                                    ${location.formatted_address}<br>
                                                    Rating: ${location.rating}<br>
                                                    Total Reviews: ${location.user_ratings_total}
                                                </p>
                                            </div>
                                        </div>
                                    `;

                                                const infowindow = new google.maps.InfoWindow({
                                                    content: infoWindowContent
                                                });

                                                // Add event listener to open the info window when the marker is clicked
                                                marker.addListener('click', function() {
                                                    infowindow.open(map, marker);
                                                });

                                                markers.push(marker);
                                            });
                                        } else {
                                            // Show  message
                                            alert("No restaurants found");
                                        }
                                    } else {
                                        alert(response.data) // Show message if there is an error or no data
                                    }


                                },
                                error: function() {
                                    alert('Error processing image.');
                                    loader.hide(); // Hide loader in case of error
                                }
                            });



                            $('#cancelBtn').click(function() {
                                if (ajaxRequestTwo) {
                                    ajaxRequestTwo.abort();
                                    console.log('AJAX request aborted.');
                                }
                            });




                        }
                    });

                    // Initialize the map once the script is loaded
                    window.addEventListener('load', initMap);

                });
            </script>


        </div>
    </div>

<?php
    return ob_get_clean();
}
add_shortcode('food_dish_finder', 'food_dish_finder_shortcode');

// AJAX handler for image upload
add_action('wp_ajax_food_dish_finder_with_photo', 'food_dish_finder_with_photo_callback');
add_action('wp_ajax_nopriv_food_dish_finder_with_photo', 'food_dish_finder_with_photo_callback');

function food_dish_finder_with_photo_callback()
{
    $cameraImage = isset($_POST['image']) ? sanitize_text_field($_POST['image']) : '';
    $city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : 'brussels';

    $imageData = null;
    if (isset($cameraImage) && !empty($cameraImage)) {
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $cameraImage));
    }

    if ($imageData) {
        $client = new ImageAnnotatorClient();
        $image = (new Image())->setContent($imageData);

        // First, check if the image contains food using LABEL_DETECTION
        $foodFeature = (new Feature())->setType(Feature\Type::LABEL_DETECTION);
        $request = (new AnnotateImageRequest())
            ->setImage($image)
            ->setFeatures([$foodFeature]);

        $batchRequest = new BatchAnnotateImagesRequest();
        $batchRequest->setRequests([$request]);
        $response = $client->batchAnnotateImages($batchRequest);

        $labelDetection = $response->getResponses()[0]->getLabelAnnotations();

        $isFoodDetected = false;
        $dishName = "Unknown";

        // Loop through label detection results to check if any labels relate to food
        foreach ($labelDetection as $label) {
            $description = strtolower($label->getDescription());
            if (strpos($description, 'food') !== false || strpos($description, 'dish') !== false || strpos($description, 'meal') !== false) {
                $isFoodDetected = true;
                break;
            }
        }

        if ($isFoodDetected) {
            // If food is detected, proceed to detect the dish name using WEB_DETECTION
            $webFeature = (new Feature())->setType(Feature\Type::WEB_DETECTION);
            $requestWeb = (new AnnotateImageRequest())
                ->setImage($image)
                ->setFeatures([$webFeature]);

            $batchRequestWeb = new BatchAnnotateImagesRequest();
            $batchRequestWeb->setRequests([$requestWeb]);
            $responseWeb = $client->batchAnnotateImages($batchRequestWeb);

            $webDetection = $responseWeb->getResponses()[0]->getWebDetection();

            if ($webDetection && $webDetection->getWebEntities()) {
                foreach ($webDetection->getWebEntities() as $entity) {
                    if (!empty($entity->getDescription())) {
                        $dishName = htmlspecialchars($entity->getDescription());
                        break;
                    }
                }
            }

            // echo "<h3>Detected Dish:</h3><p>" . $dishName . "</p>";

            // Get restaurants based on the detected dish name in Brussels
            $locations = getRestaurantsByDish($dishName, $city);
            wp_send_json_success([
                'locations' => $locations,
                'dishName'  => $dishName
            ]);
        } else {
            wp_send_json_error('The uploaded image does not appear to be food. Please upload a valid food image.');
        }

        $client->close();
    }


    wp_die();
}


// AJAX handler for image upload
add_action('wp_ajax_food_dish_finder_upload', 'food_dish_finder_image_upload');
add_action('wp_ajax_nopriv_food_dish_finder_upload', 'food_dish_finder_image_upload');

// Handle the image upload and process the dish recognition
function food_dish_finder_image_upload()
{
    if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {

        $city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : 'brussels';

        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageData = file_get_contents($imageTmpPath);


        if ($imageData) {
            $client = new ImageAnnotatorClient();
            $image = (new Image())->setContent($imageData);

            // First, check if the image contains food using LABEL_DETECTION
            $foodFeature = (new Feature())->setType(Feature\Type::LABEL_DETECTION);
            $request = (new AnnotateImageRequest())
                ->setImage($image)
                ->setFeatures([$foodFeature]);

            $batchRequest = new BatchAnnotateImagesRequest();
            $batchRequest->setRequests([$request]);
            $response = $client->batchAnnotateImages($batchRequest);

            $labelDetection = $response->getResponses()[0]->getLabelAnnotations();

            $isFoodDetected = false;
            $dishName = "Unknown";

            // Loop through label detection results to check if any labels relate to food
            foreach ($labelDetection as $label) {
                $description = strtolower($label->getDescription());
                if (strpos($description, 'food') !== false || strpos($description, 'dish') !== false || strpos($description, 'meal') !== false) {
                    $isFoodDetected = true;
                    break;
                }
            }

            if ($isFoodDetected) {
                // If food is detected, proceed to detect the dish name using WEB_DETECTION
                $webFeature = (new Feature())->setType(Feature\Type::WEB_DETECTION);
                $requestWeb = (new AnnotateImageRequest())
                    ->setImage($image)
                    ->setFeatures([$webFeature]);

                $batchRequestWeb = new BatchAnnotateImagesRequest();
                $batchRequestWeb->setRequests([$requestWeb]);
                $responseWeb = $client->batchAnnotateImages($batchRequestWeb);

                $webDetection = $responseWeb->getResponses()[0]->getWebDetection();

                if ($webDetection && $webDetection->getWebEntities()) {
                    foreach ($webDetection->getWebEntities() as $entity) {
                        if (!empty($entity->getDescription())) {
                            $dishName = htmlspecialchars($entity->getDescription());
                            break;
                        }
                    }
                }

                // echo "<h3>Detected Dish:</h3><p>" . $dishName . "</p>";

                // Get restaurants based on the detected dish name in Brussels
                $locations = getRestaurantsByDish($dishName, $city);
                wp_send_json_success([
                    'locations' => $locations,
                    'dishName'  => $dishName
                ]);
            } else {
                wp_send_json_error('The uploaded image does not appear to be food. Please upload a valid food image.');
            }

            $client->close();
        }
    }

    wp_die();
}


function getRestaurantsByDish($dishName, $city)
{

    $apiKey = 'AIzaSyC5zdCNSYZMqOf89qVIKir4MKXcRsOjwww';

    $locations = [];
    $next_page_token = null;

    $city_coords = [
        'brussels' => ['lat' => 50.8503, 'lng' => 4.3517],
        'belgium' => ['lat' => 50.8503, 'lng' => 4.3517],
    ];

    if (!isset($city_coords[$city])) {
        // Default to Brussels if city not found
        $city = 'brussels';
    }

    $cityLatitude = $city_coords[$city]['lat'];
    $cityLongitude = $city_coords[$city]['lng'];
    $radius = 50000;

    $googlePlacesUrl = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=" . urlencode($dishName) . "&location=$cityLatitude,$cityLongitude&radius=$radius&key=$apiKey";

    $response = file_get_contents($googlePlacesUrl);
    $data = json_decode($response, true);

    if (isset($data['results']) && count($data['results']) > 0) {

        foreach ($data['results'] as $restaurant) {

            $locations[] = [

                'name' => $restaurant['name'] ?? '',
                'formatted_address' => $restaurant['formatted_address'] ?? '',
                'link' =>  $restaurant['place_id'],
                'url' =>  "https://www.google.com/maps/place/?q=place_id:" . $restaurant['place_id'] . "",
                'rating' => $restaurant['rating'] ?? 0,
                'types' => $restaurant['types'] ?? [],
                'user_ratings_total' => $restaurant['user_ratings_total'] ?? 0,
                'lat' => $restaurant['geometry']['location']['lat'] ?? null,
                'lng' => $restaurant['geometry']['location']['lng'] ?? null,
            ];
        }

        return $locations;
    } else {
        return "<p>No restaurants found for '$dishName' in Brussels within the specified radius.</p>";
    }
}


//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!


// ---------------------------------- 15-03-25 ------------------------------------------- //



function custom_enqueue_scripts()
{
    wp_enqueue_script('custom-signup-js', get_stylesheet_directory_uri() . '/assets/js/custom-script.js', ['jquery'], null, true);
    wp_localize_script('custom-signup-js', 'my_ajax_object', ['ajax_url' => admin_url('admin-ajax.php')]);
}
add_action('wp_enqueue_scripts', 'custom_enqueue_scripts');



// Register User via AJAX
function custom_user_registration()
{

    if (!isset($_POST['email'])) {
        wp_send_json_error('Invalid request!');
    }

    // Sanitize Inputs
    $full_name        = sanitize_text_field($_POST['full_name']);
    $email            = sanitize_email($_POST['email']);
    $username         = sanitize_user($_POST['username']);
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation Checks
    if (empty($full_name) || empty($email) || empty($username) || empty($password) || empty($confirm_password)) {
        wp_send_json_error('All fields are required!');
    }

    if ($password !== $confirm_password) {
        wp_send_json_error('Passwords do not match!');
    }

    if (username_exists($username)) {
        wp_send_json_error('Username already exists. Choose another one.');
    }

    if (email_exists($email)) {
        wp_send_json_error('Email is already registered.');
    }

    // Create User
    $user_id = wp_create_user($username, $password, $email);

    if (!is_wp_error($user_id)) {
        // Add Full Name
        wp_update_user([
            'ID'          => $user_id,
            'display_name' => $full_name,
            'nickname'    => $full_name,
        ]);

        wp_send_json_success(['redirect_url' => home_url()]); // Success response
    } else {
        wp_send_json_error('Registration failed. Try again.');
    }
}

// Register AJAX Actions
add_action('wp_ajax_custom_user_registration', 'custom_user_registration');
add_action('wp_ajax_nopriv_custom_user_registration', 'custom_user_registration');







// Custom Forgot Password Handler
function custom_forgot_password()
{
    if (!isset($_POST['user_email'])) {
        wp_send_json_error('Invalid request.');
    }

    $user_email = sanitize_email($_POST['user_email']);

    // Empty Field Check
    if (empty($user_email)) {
        wp_send_json_error('Please enter your email address.');
    }

    // Email Validation
    if (!is_email($user_email)) {
        wp_send_json_error('Invalid email format.');
    }

    // Check if User Exists
    $user = get_user_by('email', $user_email);
    if (!$user) {
        wp_send_json_error('No user found with this email.');
    }

    // Send Reset Email
    $reset_link = wp_lostpassword_url();
    $subject = "Password Reset Request";
    $message = "Hi " . $user->display_name . ",\n\n";
    $message .= "Click the link below to reset your password:\n\n";
    $message .= $reset_link . "\n\n";
    $message .= "If you did not request this, please ignore this email.";

    wp_mail($user_email, $subject, $message);

    wp_send_json_success('Reset link sent successfully.');
}

// Register AJAX Actions
add_action('wp_ajax_custom_forgot_password', 'custom_forgot_password');
add_action('wp_ajax_nopriv_custom_forgot_password', 'custom_forgot_password');

