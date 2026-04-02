<?php
define('SECRET_KEY','mysecret');

function generateJWT($id){
    $header = base64_encode(json_encode(["alg"=>"HS256","typ"=>"JWT"]));
    $payload = base64_encode(json_encode(["id"=>$id,"exp"=>time()+3600]));
    $sig = base64_encode(hash_hmac("sha256","$header.$payload",SECRET_KEY,true));
    return "$header.$payload.$sig";
}

function verifyJWT($token){
    $parts = explode(".",$token);
    if(count($parts)!=3) return false;

    list($h,$p,$s) = $parts;
    $valid = base64_encode(hash_hmac("sha256","$h.$p",SECRET_KEY,true));
    if($s!==$valid) return false;

    $data = json_decode(base64_decode($p),true);
    return $data["exp"]>time();
}
?>
