<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once './interfaces/FileGateway.php';

define('DRIVE_BASE_ENDPONT', 'https://www.googleapis.com/drive/v3/');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class GoogleDriveFileGateway implements FileGateway
{
    private $folder;
    private $httpClient;
    private $googleClient;


    function __construct($folder = null)
    {
        $this->folder = $folder;
        $this->httpClient = new  GuzzleHttp\Client(['base_uri' => DRIVE_BASE_ENDPONT]);

        $this->googleClient = new Google_Client();
        $this->googleClient->setAuthConfigFile(__DIR__ . '/keys/auth.json');
        $this->googleClient->addScope(Google_Service_Drive::DRIVE);
    }

    public function getFiles()
    {

        $files = $this->httpClient->get('/files?key=teste');
        return $files;
    }
}
