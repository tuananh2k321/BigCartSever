<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../../database/connection.php");

// http://localhost:3456/api/cart/delete_cart.php?cartId=1

try {
    // Kiểm tra xem request method có phải là DELETE không
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        // Lấy Favorites ID từ query parameters của API
        $cartId = $_GET['cartId'];

        // Kiểm tra xem mục yêu thích có tồn tại không
        $stmt_check = $dbConn->prepare(
            "SELECT id FROM carts WHERE id = :cartId"
        );

        $stmt_check->bindParam(":cartId", $cartId, PDO::PARAM_INT);
        $stmt_check->execute();

        // Lấy một bản ghi duy nhất từ câu truy vấn (fetch sẽ lấy bản ghi đầu tiên)
        $existingCart = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (!$existingCart) {
            echo json_encode(array(
                "status" => false,
                "message" => "Cart not found"
            ));
        } else {
            // Xóa mục yêu thích bằng Favorites ID
            $stmt_delete = $dbConn->prepare(
                "DELETE FROM carts WHERE id = :cartId"
            );

            $stmt_delete->bindParam(":cartId", $cartId, PDO::PARAM_INT);
            $stmt_delete->execute();

            echo json_encode(array(
                "status" => true,
                "message" => "Cart deleted successfully",
                "cartId" => $cartId
            ));
        }
    } else {
        echo json_encode(array(
            "status" => false,
            "message" => "Invalid request method. Please use DELETE method to delete a cart."
        ));
    }
} catch (Exception $e) {
    echo json_encode(array(
        "status" => false,
        "message" => $e->getMessage()
    ));
}
?>
