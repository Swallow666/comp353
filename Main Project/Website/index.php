<?php 
session_start();

if(isset($_SESSION["user"])) {
    $user = $_SESSION["user"];

    // Redirect user to proper page
    
    if(isset($_SESSION["user_type"])) {
        $user_type = $_SESSION["user_type"];
        
        print_r($user);
        echo "<br />".$user_type;

        switch($user_type) {
            case "Sales Associate": {
                include("salesassociate.html");
            } break;
            case "Manager": {
                include("manager.html");
            } break;
            case "Regular": {
                include("regular.html");
            } break;
            case "Admin": {
                include("admin.html");
            }
            case "Client": {
                include("client.html");
            } break;
        }
    }
} else {
    $_SESSION["msg"] = "You must log in first";
    include("login.php");
}
?>
