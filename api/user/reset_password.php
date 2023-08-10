<?php
// url: http://127.0.0.1:3456/api/user/reset_password.php
include_once("../../database/connection.php");
// GET
if (!isset($_POST['submit'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];
    // kiểm tra email và token có tồn tại hay không
    if (empty($email) || empty($token)) {
        header("Location: 404.php");
        exit();
    }
    // kiểm tra token có hợp lệ hay không
    $result = $dbConn->query(" select id from 
                        reset_password where email = '$email' 
                        and token = '$token' 
                        and createdAt >= DATE_SUB(NOW(), INTERVAL 1 HOUR) 
                        and available = 1  ");
    $user = $result->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        header("Location: 404.php");
        exit();
    }
    // hiển thị form đổi mật khẩu
}
// POST
else {
    try {
        // đọc dữ liệu từ form
        $email = $_POST['email'];
        $token = $_POST['token'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        if ($password != $confirm_password) {
            echo "Mật khẩu không khớp";
            header("Location: 404.php");
            exit();
        }
        // kiểm tra token có hợp lệ hay không
        $result = $dbConn->query(" select id from 
                        reset_password where email = '$email' 
                        and token = '$token' 
                        and createdAt >= DATE_SUB(NOW(), INTERVAL 1 HOUR) 
                        and avaiable = 1  ");
        $user = $result->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            echo "Token không hợp lệ";
            header("Location: 404.php");
            exit();
        }
        // cập nhật mật khẩu mới
        $password = password_hash($password, PASSWORD_BCRYPT);
        $dbConn->query(" update users set 
                    password = '$password' 
                    where email = '$email' ");
        // hủy token
        $dbConn->query(" update reset_password set 
                    avaiable = 0 
                    where email = '$email'
                    and token = '$token' ");
        header("Location: login.php");
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Password Form</title>
  <!-- Link to Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+Q4/BzG8uSz/D/YZ8AeDajjltJOl11BgeAxw3+D0TxTSBjN" crossorigin="anonymous">
  <style>
    body {
      background: url('link_to_your_image.jpg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      align-items: center;
    }

    .form-container {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
      margin: auto;
      max-width: 400px; /* Tùy chỉnh độ rộng tối đa của form */
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="form-container">
          <form method="post">
            <div class="mb-3">
              <label for="newPassword" class="form-label">Mật khẩu mới</label>
              <input type="password" class="form-control" id="newPassword" name="password" required>
            </div>
            <div class="mb-3">
              <label for="confirmPassword" class="form-label">Nhập lại mật khẩu</label>
              <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Link to Bootstrap JS and Popper.js (required for Bootstrap's JavaScript plugins) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/2wgsu0FgdZy5gZOEM8SxrPBJLs1RsweFfUfg8M2t" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-dC3BH6hEZIp6zalNXVB+C6VITVBRp/dJEyV1Na5KqduZ33p0E1KGsh5pVWvxusV8" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-cZfzQ1ZLPb7i/b6If6DEHt9t1/yoHWWtn2t3QU6RqAcKkN5AXsRoTxn2swTj+o3R" crossorigin="anonymous"></script>
</body>
</html>

