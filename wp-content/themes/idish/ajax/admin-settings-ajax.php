<?php 

add_action('wp_ajax_save_settings', 'save_settings_callback');
add_action('wp_ajax_nopriv_save_settings', 'save_settings_callback'); 

function save_settings_callback() {
    // Check if data is received
    if (!isset($_POST['data']) || empty($_POST['data'])) {
        wp_send_json_error(["message" => "Invalid request"]);
    }

    $data = $_POST['data'];
    $response = [];

    foreach ($data as $key => $value) {
        $sanitized_key = sanitize_key($key);
        $sanitized_value = sanitize_text_field($value);

        if (get_option($sanitized_key) === false) {
            // Add new option if it doesn't exist
            add_option($sanitized_key, $sanitized_value);
            $response[$sanitized_key] = "Setting saved successfully";
        } else {
            // Update existing option
            update_option($sanitized_key, $sanitized_value);
            $response[$sanitized_key] = "Setting updated successfully";
        }
    }

    // Send success response
    wp_send_json_success(["message" => "Settings processed", "data" =>
    $response]);

}



add_action('wp_ajax_remove_settings', 'remove_settings_callback');
add_action('wp_ajax_nopriv_remove_settings', 'remove_settings_callback'); 

function remove_settings_callback() {
    // Check if data is received
    if (!isset($_POST['data']) || empty($_POST['data'])) {
        wp_send_json_error(["message" => "Invalid request"]);
    }

    $data = $_POST['data'];
    $response = [];

    foreach ($data as $key => $value) {
        $sanitized_key = sanitize_key($key);

        if (get_option($sanitized_key) !== false) {
            // Delete option if it exists
            delete_option($sanitized_key);
            $response[$sanitized_key] = "Setting removed successfully";
        } else {
            $response[$sanitized_key] = "Setting does not exist";
        }
    }

    // Send success response
    wp_send_json_success(["message" => "Settings processed", "data" => $response]);
    wp_die();
}
