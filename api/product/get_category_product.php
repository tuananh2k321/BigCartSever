<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../../database/connection.php");

// http://localhost:3456/api/product/get_category_product.php?categoryId=2

try {
    // Lấy categoryId từ query parameter của API
    $categoryId = $_GET['categoryId'];

    // Sử dụng Prepared Statements và đặt tên tham số là ":categoryId"
    $stmt = $dbConn->prepare(
        "SELECT 
            p.id, 
            p.name, 
            p.price, 
            p.weight, 
            p.quantity, 
            p.image, 
            p.description, 
            p.purchaseQuantity, 
            p.statusProduct, 
            p.categoryId,
            c.name as categoryName  -- Lấy thông tin tên của category từ bảng categories
        FROM 
            products p
        INNER JOIN
            categories c
        ON 
            p.categoryId = c.id
        WHERE 
            p.categoryId = :categoryId"
    );

    // Truyền giá trị categoryId vào câu truy vấn
    $stmt->bindParam(":categoryId", $categoryId, PDO::PARAM_INT);

    // Thực thi câu truy vấn
    $stmt->execute();

    // Lấy kết quả từ câu truy vấn
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(array(
        "status" => true,
        "message" => "Success",
        "products" => $products
    ));

} catch (Exception $e) {
    echo json_encode(array(
        "status" => false,
        "message" => $e->getMessage()
    ));
}
?>
