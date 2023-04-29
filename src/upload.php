<?php
header('Access-Control-Allow-Origin: *');
header('X-Accel-Buffering: no');
include_once './s3/s3.php';

if (!isset($_FILES['movie'])) exit;



$maxFileSize = 100000000; // 100MB in bytes

if ($_FILES['movie']['size'] > $maxFileSize) {
    // File size exceeds the limit, show an error message
    echo json_encode(['success' => false, "message" => "The file size cannot exceed 100MB."]);
    exit;
}

$url = generateUploadURL();
$file = $_FILES['movie'];
$fileName = $file['name'];
$fileType = $file['type'];
$fileSize = $file['size'];
$fileTmpName = $file['tmp_name'];
$uploadURL = generateUploadURL($fileName, $fileType);
$imageName = isset($_POST['name']) ? $_POST['name'] : $file['name'];
$fileContent = file_get_contents($fileTmpName);
set_time_limit(0);
ob_implicit_flush(1);

$result = $s3->putObject([
    'Bucket' => $bucketName,
    'Key' => $imageName,
    'Body' => $fileContent,
    'ContentType' => $fileType,
    'Metadata' => array(
        'original-name' => $file['name']
    ),
    '@http' => [
        'progress' => function ($downloadTotalSize, $downloadSizeSoFar, $uploadTotalSize, $uploadSizeSoFar) {
            if ($uploadSizeSoFar == 0) return;
            $percent = ($uploadSizeSoFar * 100) / $uploadTotalSize;
            echo json_encode(['success' => true, 'percent' => $percent]);
        }
    ]
]);

//echo 'Success'; // display uploaded file URL to user
