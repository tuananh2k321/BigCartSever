<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../../database/connection.php");

// http://localhost:3456/api/cart/get_cart.php?userId=14

try {
    // Lấy id từ query parameter của API
    $userId = $_GET['userId'];

    // Sử dụng Prepared Statements và đặt tên tham số là ":userId"
    $stmt = $dbConn->prepare(
        "SELECT 
            carts.id, 
            carts.productId,
            carts.userId,
            carts.createdAt,
            carts.quantityProduct,
            products.name, 
            products.price, 
            products.weight, 
            products.quantity, 
            products.image, 
            products.description, 
            products.purchaseQuantity, 
            products.statusProduct, 
            products.categoryId 
        FROM 
            carts
        INNER JOIN 
            products 
        ON 
            carts.productId = products.id
        WHERE 
            carts.userId = :userId"
    );


    // Truyền giá trị userId vào câu truy vấn
    $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);

    // Thực thi câu truy vấn
    $stmt->execute();

    // Lấy một bản ghi duy nhất từ câu truy vấn (fetch_assoc sẽ lấy bản ghi đầu tiên)
    $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Kiểm tra nếu có kết quả
    if ($cart) {
        echo json_encode(array(
            "status" => true,
            "message" => "Success",
            "carts" => $cart
        ));
    } else {
        echo json_encode(array(
            "status" => false,
            "message" => "Cart not found"
        ));
    }

} catch (Exception $e) {
    echo json_encode(array(
        "status" => false,
        "message" => $e->getMessage()
    ));
}
?>
