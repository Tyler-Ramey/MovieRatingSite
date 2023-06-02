<?php
require_once('../config/dbconnect.php');

function uploadImage($title, $file)
{
    // Verify the uploaded image file
    if ($file['error'] === UPLOAD_ERR_OK) {
        $imageDir = 'uploads/'; // Directory to store uploaded images

        // Verify the file's type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $fileType = $finfo->file($file['tmp_name']);
        if (!isFileTypeAllowed($fileType)) {
            die('Error: Invalid file type. Only JPEG and PNG files are allowed.');
        }

        // Generate a unique filename for the uploaded image based on the movie title
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $uniqueFilename = generateUniqueFilename($title, $fileExtension);

        // Move the uploaded file to the permanent storage directory
        if (move_uploaded_file($file['tmp_name'], $imageDir . $uniqueFilename)) {
            $resizedImagePath = resizeImage($imageDir . $uniqueFilename, $imageDir, $uniqueFilename);

            return $resizedImagePath;
        } else {
            die('Error: Failed to move the uploaded file.');
        }
    } else {
        die('Error: File upload failed. Please try again.');
    }
}

// Function to generate a unique filename for the uploaded image
function generateUniqueFilename($name, $extension)
{
    $filename = strtolower($name);
    $filename = preg_replace('/[^a-z0-9]/', '_', $filename);
    $filename .= '_' . uniqid();
    $filename .= '.' . $extension;
    return $filename;
}

// Function to check if the file type is allowed
function isFileTypeAllowed($fileType)
{
    $allowedTypes = ['image/jpeg', 'image/png'];
    return in_array($fileType, $allowedTypes);
}

// Function to resize the uploaded image while maintaining aspect ratio
function resizeImage($sourceImagePath, $destinationDirectory, $newFilename)
{
    $thumbHeight = 150;
    $sourceImage = imagecreatefromstring(file_get_contents($sourceImagePath));
    $width = imagesx($sourceImage);
    $height = imagesy($sourceImage);
    $thumbWidth = floor($width * ($thumbHeight / $height));

    $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
    imagecopyresampled($thumbImage, $sourceImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);

    $resizedImagePath = $destinationDirectory . $newFilename;

    // Save the resized image to the destination directory
    if (imagejpeg($thumbImage, $resizedImagePath, 80)) {
        imagedestroy($sourceImage);
        imagedestroy($thumbImage);
        return $resizedImagePath;
    } else {
        imagedestroy($sourceImage);
        imagedestroy($thumbImage);
        die('Error: Failed to save the resized image.');
    }
}
?>
