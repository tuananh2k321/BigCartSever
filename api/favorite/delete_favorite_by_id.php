<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../../database/connection.php");

// http://localhost:3456/api/favorite/delete_favorite_by_id.php?favoriteId=1

try {
    // Kiểm tra xem request method có phải là DELETE không
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        // Lấy Favorites ID từ query parameters của API
        $favoriteId = $_GET['favoriteId'];

        // Kiểm tra xem mục yêu thích có tồn tại không
        $stmt_check = $dbConn->prepare(
            "SELECT id FROM favorites WHERE id = :favoriteId"
        );

        $stmt_check->bindParam(":favoriteId", $favoriteId, PDO::PARAM_INT);
        $stmt_check->execute();

        // Lấy một bản ghi duy nhất từ câu truy vấn (fetch sẽ lấy bản ghi đầu tiên)
        $existingFavorite = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (!$existingFavorite) {
            echo json_encode(array(
                "status" => false,
                "message" => "Favorite not found"
            ));
        } else {
            // Xóa mục yêu thích bằng Favorites ID
            $stmt_delete = $dbConn->prepare(
                "DELETE FROM favorites WHERE id = :favoriteId"
            );

            $stmt_delete->bindParam(":favoriteId", $favoriteId, PDO::PARAM_INT);
            $stmt_delete->execute();

            echo json_encode(array(
                "status" => true,
                "message" => "Favorite deleted successfully",
                "favoritesId" => $favoriteId
            ));
        }
    } else {
        echo json_encode(array(
            "status" => false,
            "message" => "Invalid request method. Please use DELETE method to delete a favorite."
        ));
    }
} catch (Exception $e) {
    echo json_encode(array(
        "status" => false,
        "message" => $e->getMessage()
    ));
}
?>
