<?php 
include_once("common.php");

// If the user is already logged in, just redirect him to the index
if(isset($_SESSION["user"])) {
    header("location: /");
}

$userSet = !empty($_POST["clientId"]); 
$passSet = !empty($_POST["clientPassword"]);

// If client login post variables are set, attempt log in
if($userSet && $passSet) {
    $db = new DatabaseConn();

    $clientId = $_POST["clientId"];
    $clientPassword = $_POST["clientPassword"];
    $db->loginClient($clientId, $clientPassword);

    exit();
} else {
    if(!$userSet) {
        pushError("Could not login, client username not set");
    }
    if(!$passSet) {
        pushError("Could not login, client password not set");
    }

    header("location: /");
}

?>