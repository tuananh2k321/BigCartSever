<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../../database/connection.php");

use PHPMailer\PHPMailer\PHPMailer;

include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities/PHPMailer-master/src/PHPMailer.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities/PHPMailer-master/src/SMTP.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities/PHPMailer-master/src/Exception.php';

// http://localhost:3456/api/user/forgot_password.php

try {
    $body = json_decode(file_get_contents("php://input"));
    $email = $body->email;

    // check email is existing
    $result = $dbConn->query("select id from users where email = '$email'");
    $user = $result->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        echo json_encode(array(
            "status" => false,
            "message" => "email is not exits"
        ));
    } 

    // tạo token bằng cách mã hóa email và thời gian
    $token = md5(time() . $email);

    // lưu token vào database
    $dbConn->query(" insert into reset_password (email, token) values('$email', '$token')");
    
    // gửi email có link reset password
    $link = "<a href='http://localhost:3456/api/user/reset_password.php?email="
    . $email . "&token=" . $token . "'>Click to reset password</a>";
    $mail = new PHPMailer();
    $mail->CharSet = "utf-8";
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Username = "haizzj123@gmail.com";
    $mail->Password = "qmmjpwqhzuzrejwt";
    $mail->SMTPSecure = "ssl";
    $mail->Host = "ssl://smtp.gmail.com";
    $mail->Port = "465";
    $mail->From = "haizzj123@gmail.com";
    $mail->FromName = "big-cart";
    $mail->addAddress($email, 'Hello');
    $mail->Subject = "Reset Password";
    $mail->isHTML(true);
    $mail->Body = "Click on this link to reset password " . $link . " ";
    $res = $mail->Send();

    if ($res) {
        echo json_encode(array(
            "status" => true,
            "message" => "email sent successfully"
        ));
    } else {
        echo json_encode(array(
            "status" => false,
            "message" => "email sent fail"
        ));
    }


} catch (Exception $e) {
    echo json_encode(array(
        "status" => false,
        "message" => $e->getMessage()
    ));
}
?>
