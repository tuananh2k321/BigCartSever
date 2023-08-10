<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../../database/connection.php");

// http://localhost:3456/api/user/get_user_by_id.php?userId=15

try {
    // Lấy categoryId từ query parameter của API
    $userId = $_GET['userId'];

    // Sử dụng Prepared Statements và đặt tên tham số là ":categoryId"
    $stmt = $dbConn->prepare(
        "SELECT 
            id,
            fullname,
            email,
            birthday,
            avatar,
            phoneNumber
        FROM 
            users 
        WHERE 
            id = :userId"
    );

    // Truyền giá trị categoryId vào câu truy vấn
    $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);

    // Thực thi câu truy vấn
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $row['id'];
        $email = $row['email'];
        $fullname = $row['fullname'];
        $avatar = $row['avatar'];
        $birthday = $row['birthday'];
        $phoneNumber = $row['phoneNumber'];

        // lưu thông tin đăng nhập vào session
        echo json_encode(array(
            "email" =>$email,
            "fullName" =>$fullname,
            "birthday" =>$birthday,
            "avatar" =>$avatar,
            "phoneNumber" =>$phoneNumber
        ));
        
    } else {
        echo json_encode(array(
            "error" => false
       ));
    }

} catch (Exception $e) {
    echo json_encode(array(
        "status" => false,
        "message" => $e->getMessage()
    ));
}
?>
