<?php
require_once('../config/dbconnect.php');

$title = $_POST['title'];
$releaseDate = $_POST['release-date'];
$summary = $_POST['summary'];

// Verify the uploaded image file
if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imageDir = 'uploads/'; // Directory to store uploaded images

    // Verify the file's type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $fileType = $finfo->file($_FILES['image']['tmp_name']);
    if (!isFileTypeAllowed($fileType)) {
        die('Error: Invalid file type. Only JPEG and PNG files are allowed.');
    }

    // Generate a unique filename for the uploaded image based on the movie title
    $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $uniqueFilename = generateUniqueFilename($title, $fileExtension);

    // Move the uploaded file to the permanent storage directory
    if (move_uploaded_file($_FILES['image']['tmp_name'], $imageDir . $uniqueFilename)) {
        $resizedImagePath = resizeImage($imageDir . $uniqueFilename, $imageDir, $uniqueFilename);

        // Insert the movie into the database with the image path
        $imagePath = $resizedImagePath;
        $sql = 'INSERT INTO movies (Title, ReleaseDate, Summary, ImagePath) VALUES (:title, :releaseDate, :summary, :imagePath)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':releaseDate', $releaseDate);
        $stmt->bindParam(':summary', $summary);
        $stmt->bindParam(':imagePath', $imagePath);
        $stmt->execute();

        // Redirect to the admin page after adding the movie
        header('Location: admin.php');
        exit();
    } else {
        die('Error: Failed to move the uploaded file.');
    }
} else {
    die('Error: File upload failed. Please try again.');
}

// Function to generate a unique filename for the uploaded image
function generateUniqueFilename($movieName, $extension) {
    $filename = strtolower($movieName);
    $filename = preg_replace('/[^a-z0-9]/', '_', $filename);
    $filename .= '_' . uniqid();
    $filename .= '.' . $extension;
    return $filename;
}

// Function to check if the file type is allowed
function isFileTypeAllowed($fileType) {
    $allowedTypes = ['image/jpeg', 'image/png'];
    return in_array($fileType, $allowedTypes);
}

// Function to resize the uploaded image while maintaining aspect ratio
function resizeImage($sourceImagePath, $destinationDirectory, $newFilename) {
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
