<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once './interfaces/FileGateway.php';

use Google\Client;
use Google\Service\Drive;

define('DRIVE_BASE_ENDPONT', 'https://www.googleapis.com/drive/v3/');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class GoogleDriveFileGateway implements FileGateway
{
    private $folder;
    private $googleClient;
    private $driveService;


    function __construct($folder = null)
    {
        $this->folder = $folder;
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/keys/auth.json');
        $this->googleClient = new Client();
        $this->googleClient->addScope(Drive::DRIVE);
        $this->googleClient->useApplicationDefaultCredentials();
        $this->driveService = new Drive($this->googleClient);
    }

    public function getFiles()
    {
        try {
            $files = array();
            $pageToken = null;
            do {
                $response = $this->driveService->files->listFiles(array(
                    'q' => "mimeType='image/jpeg'",
                    'spaces' => 'drive',
                    'pageToken' => $pageToken,
                    'fields' => 'nextPageToken, files(id, name)',
                    'includeItemsFromAllDrives' => true
                ));
                foreach ($response->files as $file) {
                    printf("Found file: %s (%s)\n", $file->name, $file->id);
                }
                array_push($files, $response->files);

                $pageToken = $response->pageToken;
            } while ($pageToken != null);
            return $files;
        } catch (Exception $e) {
            echo "Error Message: " . $e;
        }
    }

    public function upload($file)
    {
        try {
            $fileMetadata = new Drive\DriveFile(array(
                'name' => $file['name'],
                'parents' => ['1DUIqGuinrhQfNnyzKFBSZbuh9KW0ZVu5']
            ));
            $content = file_get_contents($file['tmp_name']);
            $file = $this->driveService->files->create($fileMetadata, array(
                'data' => $content,
                'mimeType' => $file['type'],
                'uploadType' => 'multipart',
                'fields' => 'id',
            ));
            printf("File ID: %s\n", $file->id);
            return $file->id;
        } catch (Exception $e) {
            echo "Error Message: " . $e;
        }
    }
}
