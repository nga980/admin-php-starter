<?php
require_once __DIR__ . '/config.php';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  // Demo only (no DB). In production, validate against DB + hashed password.
  $email = $_POST['email'] ?? '';
  $pass = $_POST['password'] ?? '';
  if ($email && $pass) {
    $_SESSION['user'] = ['email'=>$email,'name'=>'Admin'];
    header('Location: index.php');
    exit;
  }
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Đăng nhập Admin</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h4 class="mb-4 text-center">Đăng nhập</h4>
            <form method="post">
              <div class="form-group">
                <label>Email</label>
                <input name="email" type="email" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Mật khẩu</label>
                <input name="password" type="password" class="form-control" required>
              </div>
              <button class="btn btn-primary btn-block">Đăng nhập</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
