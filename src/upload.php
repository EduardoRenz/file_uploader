<?php
@ini_set('upload_max_size', '2056M');
@ini_set('post_max_size', '2056M');
@ini_set('max_execution_time', '300');
require __DIR__ . '/../vendor/autoload.php';
include_once './GoogleDriveFileGateway.php';


$drive = new GoogleDriveFileGateway();
$upload = $drive->upload($_FILES['movie'], $_POST['name']);
#$files = $drive->getFiles();

echo "Success";
