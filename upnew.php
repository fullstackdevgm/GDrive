<?php
require_once __DIR__ . '/vendor/autoload.php';

$client = new Google_Client();
// Get your credentials from the console
$client->setClientId('633138618569-d0gv1lf9dfh8kh7eoouemnbeuur3ujkk.apps.googleusercontent.com');
$client->setClientSecret('9aB3wVnDra9TzFLu0zuozYm5');
$client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
$client->setScopes(array('https://www.googleapis.com/auth/drive.file'));

session_start();
$_GET['code'] = "4/iADROuf2tQvVzzhPOHY8_wKzOoy0Cih92VxQ-amHWzg";
if (isset($_GET['code']) || (isset($_SESSION['access_token']) && $_SESSION['access_token'])) {
    if (isset($_GET['code'])) {
        $client->authenticate($_GET['code']);
        $_SESSION['access_token'] = $client->getAccessToken();
    } else
        $client->setAccessToken($_SESSION['access_token']);

    $service = new Google_Service_Drive($client);

    //Insert a file
    $file = new Google_Service_Drive_DriveFile();
    $file->setName(uniqid().'.jpg');
    $file->setDescription('A test document');
    $file->setMimeType('image/jpeg');

    $data = file_get_contents('2.jpg');

    $createdFile = $service->files->create($file, array(
          'data' => $data,
          'mimeType' => 'image/jpeg',
          'uploadType' => 'multipart'
        ));

    print_r($createdFile);

} else {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . $authUrl);
    exit();
}
?>