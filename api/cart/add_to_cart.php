<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../../database/connection.php");

// http://localhost:3456/api/cart/add_to_cart.php?userId=1&productId=2

try {
    // Lấy User_ID và Product_ID từ query parameters của API
    $userId = $_GET['userId'];
    $productId = $_GET['productId'];

    // Kiểm tra xem sản phẩm đã được thêm vào giỏ hàng trước đó hay chưa (nếu có, không thêm vào lại)
    $stmt_check = $dbConn->prepare(
        "SELECT userId, productId FROM carts WHERE userId = :userId AND productId = :productId"
    );

    $stmt_check->bindParam(":userId", $userId, PDO::PARAM_INT);
    $stmt_check->bindParam(":productId", $productId, PDO::PARAM_INT);
    $stmt_check->execute();

    // Lấy một bản ghi duy nhất từ câu truy vấn (fetch sẽ lấy bản ghi đầu tiên)
    $existingCart = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if ($existingCart) {
        echo json_encode(array(
            "status" => false,
            "message" => "Product is already in the cart list"
        ));
    } else {
        // Thêm sản phẩm vào danh sách yêu thích của người dùng
        $stmt_add = $dbConn->prepare(
            "INSERT INTO carts (userId, productId, quantityProduct, createdAt) VALUES (:userId, :productId, 1, CURRENT_TIMESTAMP)"
        );

        $stmt_add->bindParam(":userId", $userId, PDO::PARAM_INT);
        $stmt_add->bindParam(":productId", $productId, PDO::PARAM_INT);
        $stmt_add->execute();

        echo json_encode(array(
            "status" => true,
            "message" => "Product added to cart successfully",
            "productId" => $productId,
            "userId" => $userId
        ));
    }
} catch (Exception $e) {
    echo json_encode(array(
        "status" => false,
        "message" => $e->getMessage()
    ));
}
?>
