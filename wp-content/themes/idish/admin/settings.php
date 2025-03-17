<div class="container-fluid ">

 <div class="container py-5">

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12">
             <h5>Settings</h5>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12 float-right">
             <div class="" id="messages"></div>
        </div>
    </div>
       <hr>
     
  <?php $api_key =  get_option('google_map_api'); ?>
         <div class="row">
           
           <div class="col-sm-12 col-lg-6 col-md-6">

            <form action="" method="post" class=" small shadow-sm p-4">
                <div class="form-row mb-3">
                    <div class="col">
                         <label for="" class="fw-bold mb-2">Google Map API Key</label>
                         <input type="text" class="form-control shadow-none <?php if($api_key){ echo 'border border-success text-success';} ?>" id="googleMapKey" value="<?php echo $api_key; ?>" <?php if($api_key){ echo 'readonly';} ?>>
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col">
                       <button type="submit" id="addKeyBtn" class="btn btn-success btn-sm" name="addKeyBtn" style="<?php if($api_key){ echo 'display: none';}else{echo 'display: block';} ?>">Save Settings</button>
                       <button id="removeKeyBtn" class="btn btn-danger btn-sm" name="removeKeyBtn" style="display: <?php if($api_key){ echo 'block';}else{echo 'none';} ?>;">Remove Key</button>
                    </div>
                </div>
               
            </form>
               
           </div>
           <div class="col-sm-12 col-lg-6 col-md-6"></div>

         </div>

 </div>

</div>

<script>
    jQuery(document).ready(function($){
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';  // PHP variable for admin URL

        // When the "Add Key" button is clicked
        $('#addKeyBtn').click(function(e){
            e.preventDefault();

            var googleMapAPI = $('#googleMapKey').val(); // Get the API key from the input field

            // Check if the API key is empty
            if(googleMapAPI == '') {
                showMessage('danger', 'Error', 'API key is required.'); // Show error if no key is entered
            } else {
                // Data object to be sent in the AJAX request
                var data = {
                    'google_map_api': googleMapAPI
                };

                saveSettings(data); // Call function to save the settings
            }
        });

        // When the "Remove Key" button is clicked
        $('#removeKeyBtn').click(function(e){
            e.preventDefault();

            // Show a confirmation dialog before proceeding
            var confirmation = confirm("Are you sure you want to remove the Google Map API key? This action cannot be undone.");

            if (confirmation) {
                // If the user confirms, send an AJAX request to remove the Google Map API key
                var data = {
                    'google_map_api': ''  // Empty value to remove the key
                };

                removeSettings(data); // Call function to remove the settings
            } 
        });

        // Save settings using AJAX
        function saveSettings(data){
            $.ajax({
                url: ajaxurl, // Use the variable holding the correct URL
                type: 'POST',
                data: {
                    'action': 'save_settings',  // Action hook
                    'data': data                // Data to be saved
                },
                success: function(response) {
                    // On success, display a success message
                    if (response.success) {
                        showMessage('success', 'Success', 'Settings saved successfully.');
                        addKeySuccess('googleMapKey', 'addKeyBtn', 'removeKeyBtn', 'input');
                    } else {
                        // If there was an error, show the error message from the response
                        showMessage('danger', 'Error', response.data.message);
                    }
                },
                error: function(error) {
                    // If an error occurs with the AJAX request itself
                    showMessage('danger', 'Error', 'There was an issue with the request.');
                }
            });
        }

        // Remove settings using AJAX
        function removeSettings(data){
            $.ajax({
                url: ajaxurl, // Use the variable holding the correct URL
                type: 'POST',
                data: {
                    'action': 'remove_settings', // Action hook to remove settings
                    'data': data                 // Data to be removed
                },
                success: function(response) {
                    // On success, show the result message
                    if (response.success) {
                        showMessage('success', 'Success', 'API key removed successfully.');
                        removeKeySuccess('googleMapKey', 'addKeyBtn', 'removeKeyBtn', 'input');
                    } else {
                        // If there was an error, show the error message from the response
                        showMessage('danger', 'Error', response.data.message);
                    }
                },
                error: function(error) {
                    // If an error occurs with the AJAX request itself
                    showMessage('danger', 'Error', 'There was an issue with the request.');
                }
            });
        }

        // Add key success behavior
        function addKeySuccess(id, successBtnId, removeBtnId, fieldType = '') {
            // Add success styles to the input field
            $('#' + id).addClass('border border-success text-success');

            // Apply readonly attribute if it's an input or textarea
            if (fieldType === 'input' || fieldType === 'textarea') {
                $('#' + id).attr('readonly', true);
            }
            
            // Hide the success button and show the remove button
            $('#' + successBtnId).css({"display": "none"});
            $('#' + removeBtnId).css({"display": "block"});
        }

        // Remove key success behavior
        function removeKeySuccess(id, successBtnId, removeBtnId, fieldType = '') {
            // Remove success styles from the input field
            $('#' + id).removeClass('border border-success text-success');
            
            // Clear the input field value
            $('#' + id).val('');

            // Remove readonly attribute if it's an input or textarea
            if (fieldType === 'input' || fieldType === 'textarea') {
                $('#' + id).removeAttr('readonly');
            }

            // Show the success button and hide the remove button
            $('#' + successBtnId).css({"display": "block"});
            $('#' + removeBtnId).css({"display": "none"});
        }

        // Function to display messages on the page
        function showMessage(messageType, messageTitle, message) {
            var msghtml = '<div class="alert rounded-0 alert-' + messageType + ' alert-dismissible fade show p-2 m-0" role="alert">' +
                '<strong>' + messageTitle + '!</strong> ' + message +
                '<button type="button" class="btn-close p-1 m-2 shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>' +
                '</div>';

            // Add the message to the #messages div
            $('#messages').html(msghtml);
        }
    });
</script>

