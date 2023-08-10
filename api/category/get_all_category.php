<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../../database/connection.php");
// http://localhost:3456/api/category/get_all_category.php

try {
    $result = $dbConn->query("SELECT id, name, image, bgColor FROM categories");
    $categories = $result->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(array(
        "status" => true,
        "message" => "Success",
        "categories" => $categories
    ));

} catch (Exception $e) {
    echo json_encode(array(
        "status" => false,
        "message" => $e->getMessage()
    ));
}
?>