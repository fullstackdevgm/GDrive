<?php
require_once __DIR__ . '/vendor/autoload.php';

$client = new Google_Client();
// Get your credentials from the console
$client->setClientId('633138618569-nbj589lhguheabru7g5kb861lti3a3f2.apps.googleusercontent.com');
$client->setClientSecret('Jk6okOo5FgabRKY8u9XvDQca');
$client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
$client->setScopes(array('https://www.googleapis.com/auth/drive.file'));

if(isset($_POST['action']) && !empty($_POST['action'])) {
  if($_POST['action'] == "insertPermission") {
    session_start();

    if (!empty($_POST['code'])) {
      if (isset($_POST['code'])) {
        $client->authenticate($_POST['code']);
        $_SESSION['access_token'] = $client->getAccessToken();
      } else {
        $client->setAccessToken($_SESSION['access_token']);
      }

      $service = new Google_Service_Drive($client);

    //Insert the permission
      $value = $_POST["email"];
      $fileId = $_POST["file"];
      $newPermission = new Google_Service_Drive_Permission();
      $newPermission->setEmailAddress($value);
      $newPermission->setType("user");
      $newPermission->setRole("reader");
      try {
        $data['html'] = $service->permissions->create($fileId, $newPermission);
        $data['status'] = '2';
      } catch (Exception $e) {
        $data['html'] = "An error occurred: " . $e->getMessage();
        $data['status'] = '1';
      }

    } else {
      $authUrl = $client->createAuthUrl();
      $data['html'] = 'Get a code first: <a href="'.$authUrl.'">'.$authUrl.'</a>';
      $data['status'] = '0';
    }
    echo json_encode($data);
  }
}
?>