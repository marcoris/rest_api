<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type, Access-Control-Allow-Methods, Authorization, X-Requested-Width');

include_once '../config/Database.php';
include_once '../models/Category.php';

// Get token and continue
if ($_SERVER['HTTP_TOKEN'] != '' && $_SERVER['HTTP_TOKEN'] == '@@admintoken') {
    // Instantiate DB + connect
    $database = new Database();
    $db = $database->connect('myblog');

    // Instantiate Category object
    $category = new Category($db);

    // Get raw Categoryed data
    $data = json_decode(file_get_contents("php://input"));

    // Set id to update
    $category->id = $data->id;

    // Delete Category
    if ($category->delete()) {
        echo json_encode(
            array('message' => 'Category deleted')
        );
    } else {
        echo json_encode(
            array('message' => 'Category not deleted')
        );
    }
} else {
    echo json_encode(
        array('error' => 'Wrong token!')
    );
}
