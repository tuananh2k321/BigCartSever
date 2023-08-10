<?php
     include_once("../../database/connection.php");
     // http://127.0.0.1:3456/view/verify_account.php

     try{
        $email = $_GET["email"];
        $token = $_GET["token"];

        if (empty($email) || empty($token)) {
            throw new Exception("Email or token are not exits!");
        }

        $user = $dbConn->query("SELECT id FROM users where email = '$email'");

        if ($user->rowCount() == 0) {
            throw new Exception("Email is not exits!");
        }

        // verify account
        $dbConn -> query("Update users SET verified = 1 WHERE email = '$email'");

        // transform login
        
     }catch(Exception $e) {
        header("Location: http://127.0.0.1:3456/view/error.php");
     }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel='stylesheet' href='/stylesheets/style.css' />
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <link href="/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/stylesheets/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="/stylesheets/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="/stylesheets/styleButton.css" rel="stylesheet">


    <!-- http://127.0.0.1:3456/view/register.php -->
</head>

<body>
    <div class="bg-gradient-primary">

        <div class="container">

            <!-- Outer Row -->
            <div class="row justify-content-center">

                <div class="col-xl-10 col-lg-12 col-md-9">

                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image" style="background: url(https://source.unsplash.com/K4mSJ7kc0As/600x800); background-position:center;background-size:cover;">
                                   
                                </div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Verify successfully</h1>
                                        </div>
                                       
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="../javascripts/jquery.min.js"></script>
    <script src="../javascripts/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../javascripts/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../javascripts/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../javascripts/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../javascripts/chart-area-demo.js"></script>
    <script src="../javascripts/chart-pie-demo.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>

</html>

