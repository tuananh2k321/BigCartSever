<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../../database/connection.php");

// http://localhost:3456/api/product/get_product_id.php?productId=2

try {
    // Lấy id từ query parameter của API
    $productId = $_GET['productId'];

    // Sử dụng Prepared Statements và đặt tên tham số là ":productId"
    $stmt = $dbConn->prepare(
        "SELECT 
            id, 
            name, 
            price, 
            weight, 
            quantity, 
            image, 
            description, 
            purchaseQuantity, 
            statusProduct, 
            categoryId 
        FROM 
            products
        WHERE 
            id = :productId"
    );

    // Truyền giá trị categoryId vào câu truy vấn
    $stmt->bindParam(":productId", $productId, PDO::PARAM_INT);

    // Thực thi câu truy vấn
    $stmt->execute();

    // Lấy một bản ghi duy nhất từ câu truy vấn (fetch_assoc sẽ lấy bản ghi đầu tiên)
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra nếu có kết quả
    if ($product) {
        echo json_encode(array(
            "status" => true,
            "message" => "Success",
            "product" => $product
        ));
    } else {
        echo json_encode(array(
            "status" => false,
            "message" => "Product not found"
        ));
    }

} catch (Exception $e) {
    echo json_encode(array(
        "status" => false,
        "message" => $e->getMessage()
    ));
}
?>
