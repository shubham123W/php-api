<?php
require_once(__DIR__."/../utils/jwt.php");

function authenticate($token){
    if(!$token || !verifyJWT($token)){
        echo json_encode(["status"=>"error","message"=>"Unauthorized"]);
        exit;
    }
}
?>
