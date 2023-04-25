<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Aws\S3\S3Client;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$region = 'us-east-2';
$bucketName = 'movie-upload-test-renz';
$accessKeyId = $_ENV['AWS_ACCESS_KEY_ID'];
$secretAccessKey = $_ENV['AWS_SECRET_ACCESS_KEY'];

$s3 = new S3Client([
    'version' => 'latest',
    'region' => $region,
    'credentials' => [
        'key' => $accessKeyId,
        'secret' => $secretAccessKey,
    ],
    'signature_version' => 'v4'
]);

function generateUploadURL()
{
    global $s3, $bucketName;
    $imageName = bin2hex(random_bytes(16));
    $params = [
        'Bucket' => $bucketName,
        'Key' => $imageName,
        'Expires' => 60
    ];
    $cmd = $s3->getCommand('PutObject', $params);
    $uploadURL = $s3->createPresignedRequest($cmd, '+20 minutes');
    return (string)$uploadURL->getUri();
}
