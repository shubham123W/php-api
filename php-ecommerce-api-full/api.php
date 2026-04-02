<?php
header("Content-Type: application/json");

require_once("config/database.php");
require_once("utils/jwt.php");
require_once("middleware/auth.php");

$method = $_SERVER['REQUEST_METHOD'];

if ($method === "POST") {
    $input = json_decode(file_get_contents("php://input"), true);
    $action = $input["action"] ?? "";

    switch ($action) {
        case "register":
            register($input);
            break;
        case "login":
            login($input);
            break;
        case "add_order":
            authenticate($input["token"] ?? "");
            addOrder($input);
            break;
        default:
            echo json_encode(["status"=>"error","message"=>"Invalid action"]);
    }
}

if ($method === "GET") {
    $type = $_GET["type"] ?? "";
    getProducts($type);
}

/* FUNCTIONS */

function register($data){
    global $conn;
    $email = $data["email"];
    $pass = password_hash($data["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (email,password) VALUES (?,?)");
    $stmt->bind_param("ss",$email,$pass);

    echo $stmt->execute()
        ? json_encode(["status"=>"success","message"=>"Registered"])
        : json_encode(["status"=>"error","message"=>"Failed"]);
}

function login($data){
    global $conn;
    $stmt = $conn->prepare("SELECT id,password FROM users WHERE email=?");
    $stmt->bind_param("s",$data["email"]);
    $stmt->execute();

    $res = $stmt->get_result();
    if($res->num_rows>0){
        $user = $res->fetch_assoc();
        if(password_verify($data["password"],$user["password"])){
            $token = generateJWT($user["id"]);
            echo json_encode(["status"=>"success","token"=>$token]);
        } else {
            echo json_encode(["status"=>"error","message"=>"Wrong password"]);
        }
    } else {
        echo json_encode(["status"=>"error","message"=>"User not found"]);
    }
}

function getProducts($type){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM products WHERE type=?");
    $stmt->bind_param("s",$type);
    $stmt->execute();
    $res = $stmt->get_result();

    $data=[];
    while($row=$res->fetch_assoc()){
        $data[]=$row;
    }

    echo json_encode(["status"=>"success","data"=>$data]);
}

function addOrder($data){
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
    $stmt->bind_param("i",$data["pid"]);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    $stmt = $conn->prepare("INSERT INTO porder (productid,productname,price,mrp,description,qty,billno,img2,status) VALUES (?,?,?,?,?,1,?,?,1)");
    $stmt->bind_param("issssss",
        $data["pid"],
        $product["productname"],
        $product["price"],
        $product["mrp"],
        $product["description"],
        $data["billno"],
        $product["imag"]
    );

    echo $stmt->execute()
        ? json_encode(["status"=>"success","message"=>"Order added"])
        : json_encode(["status"=>"error","message"=>"Failed"]);
}
?>
