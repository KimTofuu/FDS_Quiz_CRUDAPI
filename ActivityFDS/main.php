<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-Requested-With,  Origin, Content-Type,");
header("Access-Control-Max-Age: 86400");

date_default_timezone_set("Asia/Manila");
set_time_limit(1000);

$rootPath = $_SERVER["DOCUMENT_ROOT"];
$apiPath = $rootPath . "/ActivityFDS";

require_once($apiPath .'/configs/connection.php');
require_once($apiPath . '/model/crud.model.php');


$db = new connection();
$pdo = $db->connect();

$crud = new crud($pdo);

$data = json_decode(file_get_contents("php://input"));

$req = [];
if (isset($_REQUEST['request']))
    $req = explode('/', rtrim($_REQUEST['request'], '/'));
else $req = array("errorcatcher");

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if ($req[0]=='Get') {
            if($req[1]=='All'){echo json_encode($crud->getAllUsers()); return;}
            if($req[1]== 'One'){echo json_encode($crud->getUserById($data)); return;}
        }
        break;
    case 'POST':
        if($req[0] == 'Insert'){
            echo json_encode($crud->insertUser($data));
        }
        break;
    case 'PUT':
        if ($req[0]== 'Update') {
            echo json_encode($crud->updateUser($data));
        } else {
            echo json_encode(['message' => 'User ID is required for update']);
        }
        break;
    case 'DELETE':
        if ($req[0]== 'Remove') {
            echo json_encode($crud->deleteUser($data));
        } else {
            echo json_encode(['message' => 'User ID is required for deletion']);
        }
        break;
    default:
        echo json_encode(['message' => 'Unsupported request method']);
}


