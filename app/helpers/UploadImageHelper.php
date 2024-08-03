<?php
use ImageKit\ImageKit;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable( __DIR__ . '/../../');
$dotenv->load();

// Upload Image
function uploadImage($file) {
    $imageKit = new ImageKit(
        $_ENV['IMAGEKIT_API_KEY'],
        $_ENV['IMAGEKIT_API_SECRET'],
        $_ENV['IMAGEKIT_END_POINT']
    );
    $result="";
    try {
        $uploadFile = $imageKit->uploadFile([
            'file' => fopen($file, 'r'), // Open file in read mode
            'fileName' => basename($file) // File name with folder
        ]);
        // print_r($uploadFile);
        $result = $uploadFile;
    } catch (Exception $e) {
        // $result = 'Upload error: ' . $e->getMessage();
        $result="";
    }
    return $result;
}
// Delete image after changed
function deleteImage($id){
    $imageKit = new ImageKit(
        $_ENV['IMAGEKIT_API_KEY'],
        $_ENV['IMAGEKIT_API_SECRET'],
        $_ENV['IMAGEKIT_END_POINT']
    );
    return $imageKit->deleteFile($id);
    // echo $id."<br>";
    // echo("Delete file : " . json_encode($deleteFile));
}