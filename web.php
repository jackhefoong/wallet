<?php

require_once "controllers/Authenticators.php";
require_once "controllers/users.php";
require_once "controllers/admins.php";

if($_SERVER["REQUEST_METHOD"] == "GET") {
    $uri = basename($_SERVER["REQUEST_URI"]);
    switch($uri) {
        case "logout" :
            logout();
            break;
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"];

    switch($action) {
        case "register" :
            register($_POST);
            break;
        case "login" :
            login($_POST);
            break;
        case "feedback" :
            feedback($_POST);
            break;
        case "add_post":
            add_post($_POST);
            break;
        case "delete_post":
            delete_post($_POST);
            break;
        case "create_wallet":
            create_wallet($_POST);
            break;
        case "add_income":
            add_income($_POST);
            break;
        case "add_expenses":
            add_expenses($_POST);
            break;
        case "mark_as_read":
            mark_as_read($_POST);
            break;
        case "querymonth":
            querymonth($_POST);
            break;
    }
}

?>