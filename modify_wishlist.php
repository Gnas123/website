<?php

// File path for the JSON wishlist
$json_file = 'wishlist.json';

// Check if the JSON file exists, otherwise create it
if (!file_exists($json_file)) {
    file_put_contents($json_file, json_encode([]));
}

// Load the JSON file
$json_data = file_get_contents($json_file);
$data = json_decode($json_data, true);

// Get data from AJAX request
$username = $_POST['username'] ?? null;
$anime_id = $_POST['anime_id'] ?? null;
$action = $_POST['action'] ?? null; // 'add' or 'remove'

if ($username && $anime_id && $action) {
    if ($action == "add") {
        // Add anime_id to the user's wishlist
        if (!isset($data[$username])) {
            $data[$username] = [];
        }
        if (!in_array($anime_id, $data[$username])) {
            $data[$username][] = $anime_id;
        }
    }
    if ($action == "remove") {
        // Remove anime_id from the user's wishlist
        if (isset($data[$username])) {
            $index = array_search($anime_id, $data[$username]);
            if ($index !== false) {
                unset($data[$username][$index]);
                $data[$username] = array_values($data[$username]); // Reindex the array
            }
        }
    }

    // Save updated data back to the JSON file
    file_put_contents($json_file, json_encode($data, JSON_PRETTY_PRINT));
    
    // $result = file_put_contents($json_file, json_encode($data, JSON_PRETTY_PRINT));
    // if ($result === false) {
    //     die("Error: Unable to write to file.");
    // } else {
    //     echo "File successfully written.";
    // }

    // Send a success response
    echo json_encode(["success" => true, "message" => "Wishlist updated successfully."]);
} else {
    // Send an error response
    echo json_encode(["success" => false, "message" => "Invalid input."]);
}








?>