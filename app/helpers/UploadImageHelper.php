<?php
use ImageKit\ImageKit;

function uploadImage($file) {
    $imageKit = new ImageKit(
        "public_oT6DViR8+Ipw9hhbWYdnlb3gz7Y=",
        "private_C6cJPhmSi8+q/+SxSUBY+gDXhxA=",
        "https://ik.imagekit.io/nhx8dixrzg"
    );
    $result="";
    try {
        $uploadFile = $imageKit->uploadFile([
            'file' => fopen($file, 'r'), // Open file in read mode
            'fileName' => 'profiles/' . basename($file) // File name with folder
        ]);
        // print_r($uploadFile);
        $result = $uploadFile->result->url;
    } catch (Exception $e) {
        // $result = 'Upload error: ' . $e->getMessage();
        $result="";
    }
    return $result;
}