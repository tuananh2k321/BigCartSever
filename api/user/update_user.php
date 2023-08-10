<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../../database/connection.php");

// http://localhost:3456/api/user/update_user.php?userId=1

try {
    // Lấy ID người dùng từ tham số URL
    $userId = isset($_GET['userId']) ? $_GET['userId'] : null;

    if (empty($userId)) {
        echo json_encode(array(
            "message" => "Thiếu thông tin ID người dùng."
        ));
        return;
    }

    $body = json_decode(file_get_contents("php://input"));

    $fullName = $body->fullName;
    $phoneNumber = $body->phoneNumber;
    $birthday = $body->birthday;
    $avatar = $body->avatar;

    if (empty($fullName) || empty($phoneNumber) || empty($birthday) || empty($avatar)) {
        echo json_encode(array(
            "message" => "Vui lòng cung cấp họ tên đầy đủ, số điện thoại và ngày sinh.",
        ));
        return;
    }

    // Kiểm tra xem người dùng với ID đã cho có tồn tại trong cơ sở dữ liệu hay không
    $userQuery = $dbConn->query("SELECT id FROM users WHERE id = $userId");
    if ($userQuery->rowCount() > 0) {
        // Cập nhật thông tin người dùng trong cơ sở dữ liệu
        $updateQuery = $dbConn->prepare("UPDATE users SET fullName = :fullName, phoneNumber = :phoneNumber, birthday = :birthday,  avatar = :avatar WHERE id = :userId");
        $updateQuery->bindParam(":fullName", $fullName);
        $updateQuery->bindParam(":phoneNumber", $phoneNumber);
        $updateQuery->bindParam(":birthday", $birthday);
        $updateQuery->bindParam(":avatar", $avatar);
        $updateQuery->bindParam(":userId", $userId);

        if ($updateQuery->execute()) {
            echo json_encode(array(
                "message" => "update sucessfully",
            ));
        } else {
            echo json_encode(array(
                "message" => "update fail",
            ));
        }
    } else {
        echo json_encode(array(
            "message" => "Không tìm thấy người dùng.",
        ));
    }
} catch (Exception $e) {
    echo json_encode(array(
        "message" => $e->getMessage()
    ));
}
