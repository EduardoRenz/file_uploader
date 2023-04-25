<?php
include_once './s3/s3.php';
$url = generateUploadURL();

if (isset($_FILES['movie'])) {
    $file = $_FILES['movie'];
    $fileName = $file['name'];
    $fileType = $file['type'];
    $fileSize = $file['size'];
    $fileTmpName = $file['tmp_name'];
    $uploadURL = generateUploadURL($fileName, $fileType);
    $imageName = isset($_POST['name']) ? $_POST['name'] : $file['name'];
    $fileContent = file_get_contents($fileTmpName);
    $result = $s3->putObject([
        'Bucket' => $bucketName,
        'Key' => $imageName,
        'Body' => $fileContent,
        'ContentType' => $fileType
        // '@http' => [
        //     'progress' => function ($downloadTotalSize, $downloadSizeSoFar, $uploadTotalSize, $uploadSizeSoFar) {
        //         printf(
        //             "$uploadTotalSize / $uploadTotalSize",
        //         );
        //     }
        // ]
    ]);
    echo 'Success'; // display uploaded file URL to user
}
