<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../database/connection.php");

use PHPMailer\PHPMailer\PHPMailer;

include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities/PHPMailer-master/src/PHPMailer.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities/PHPMailer-master/src/SMTP.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities/PHPMailer-master/src/Exception.php';

// http://localhost:3456/api/register.php

try {
    $body = json_decode(file_get_contents("php://input"));

    $email = $body->email;
    $password = $body->password;
    $fullName = $body->fullName;
    $phoneNumber = $body->phoneNumber;
    $birthday = $body->birthday;

    if (empty($email) || empty($password) || empty($fullName) || empty($phoneNumber) || empty($birthday)) {
        echo json_encode(array(
            "message" => "empty",
            "email" => $email,
            "fullName" => $fullName,
            "password" => $password,
            "phoneNumber" => $phoneNumber,
            "birthday" => $birthday,

       ));
       return ;
    }

    $userEmail = $dbConn->query("SELECT id FROM users WHERE email = '$email'");
    // $userPhoneNumber = $dbConn->query("SELECT id FROM users WHERE phoneNumber = '$phoneNumber'");

    if ($userEmail->rowCount() > 0) {
        echo json_encode(array(
            "status" => false,
            "message" => "Email already exists",
        ));
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $dbConn->query("INSERT INTO users (email, password, fullname, phoneNumber, birthday) 
        VALUES ('$email','$password', '$fullName', '$phoneNumber', '$birthday')");
        echo json_encode(array(
            "status" => true,
            "message" => "Success",
            "email" => $email,
            "fullName" => $fullName,
            "password" => $password,
            "phoneNumber" => $phoneNumber,
            "birthday" => $birthday,
        ));
    }


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
    // if ($res) {
    //     echo json_encode(array(
    //         "status" => true,
    //         "message" => "send email successfully, please check your email to verify account",
    //     ));
    //     header("Location: login.php");
    // } else {
    //     echo json_encode(array(
    //         "status" => false,
    //         "message" => "send email failed",
    //     ));
    // }

} catch (Exception $e) {
    echo json_encode(array(
        "message" => $e
   ));
}
