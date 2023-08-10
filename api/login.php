<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../database/connection.php");

use PHPMailer\PHPMailer\PHPMailer;

include_once $_SERVER['DOCUMENT_ROOT'] . '../utilities/PHPMailer-master/src/PHPMailer.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '../utilities/PHPMailer-master/src/SMTP.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '../utilities/PHPMailer-master/src/Exception.php';

// http://localhost:3456/api/login.php

try {
    $body = json_decode(file_get_contents("php://input"));

    $email = $body->email;
    $pswd = $body->password;

    if (empty($email) || empty($pswd)) {
        echo json_encode(array(
            "message" => "empty",
            "email" =>$email,
            "pswd" =>$pswd,
       ));
    }

    $user = $dbConn->query("SELECT id, email, password, fullname, avatar, birthday, phoneNumber, verified FROM users WHERE email = '$email'");

    if ($user->rowCount() > 0) {
        $row = $user->fetch(PDO::FETCH_ASSOC);
        $id = $row['id'];
        $email = $row['email'];
        $password = $row['password'];
        $fullname = $row['fullname'];
        $avatar = $row['avatar'];
        $birthday = $row['birthday'];
        $phoneNumber = $row['phoneNumber'];
        $verified = $row['verified'];

        if ($verified) {
            if (password_verify($pswd, $password)){
                // lưu thông tin đăng nhập vào session
                echo json_encode(array(
                    "status" => true,
                    "message" =>"success",
                    "id" =>$id,
                    "email" =>$email,
                    "fullName" =>$fullname,
                    "birthday" =>$birthday,
                    "avatar" =>$avatar,
                    "phoneNumber" =>$phoneNumber
                    
            ));
            } else {
                echo json_encode(array(
                    "status" => false,
                    "message" => "incorrect password or email",
               ));
            }
        } else {
        //     echo json_encode(array(
        //         "status" => false,
        //         "message" => "feel free verify your email",
        //    ));
           // Create a verification token
        $token = md5(time() . $email);

        // Email verification link

        $link = "<a href='http://localhost:3456/api/user/verify_account.php?email="
        . $email . "&token=" . $token . "'>Click to verify account</a>";
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
        $mail->Subject = "Verify Account";
        $mail->isHTML(true);
        $mail->Body = "Click on this link to verify email " . $link . " ";
        $res = $mail->Send();
        // Configure mail settings here

        // Check if email is sent successfully
        if ($res) {
            echo json_encode(array(
                "status" => true,
                "message" => "send email successfully, please check your email to verify account",
            ));
            header("Location: login.php");
        } else {
            echo json_encode(array(
                "status" => false,
                "message" => "send email failed",
            ));
        }
    }

        
    } else {
        echo json_encode(array(
            "error" => false
       ));
    }
} catch (Exception $e) {

}

?>

