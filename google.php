<?php
require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId($_ENV["CLINET_Id"]);
$client->setClientSecret($_ENV["CLINET_Secret"]);
$client->setRedirectUri($_ENV["CLINET_RedirectUri"]);
$client->addScope('email');
$client->addScope('profile');
?>