<?php
// Get the image data sent from the client
$imageData = $_POST['imageData'];

// Remove the base64 data prefix
$encodedData = str_replace('data:image/png;base64,', '', $imageData);

// Decode the base64 image data
$decodedData = base64_decode($encodedData);

// Generate a unique file name for the captured image
$fileName = 'captured_image_' . time() . '.png';

// Specify the directory to save the captured images
$savePath = 'captured_images/';

// Check if the directory exists, and if not, create it
if (!is_dir($savePath)) {
    mkdir($savePath);
}

// Save the captured image to a file
file_put_contents($savePath . $fileName, $decodedData);

echo 'Image saved successfully.';
?>