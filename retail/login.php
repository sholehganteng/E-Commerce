<?php
session_start();
include 'koneksi.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uname = $_POST['uname'];
    $password = $_POST['pass'];

    $stmt = $conn->prepare("SELECT * FROM tb_user WHERE username = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['uname'] = $uname;
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Admin CuysStore</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #2e86de, #48dbfb);
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-card {
      background: white;
      border-radius: 1rem;
      padding: 2rem;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      position: relative;
    }
    #loginBtn {
      transition: all 0.3s ease;
      position: relative;
    }
    .moving {
      position: absolute;
      animation: shake 0.5s infinite alternate;
    }
    @keyframes shake {
      0%   { transform: translateX(-30px) rotate(-3deg); }
      100% { transform: translateX(30px) rotate(3deg); }
    }
  </style>
</head>
<body>
  <div class="login-card">
    <h4 class="text-center mb-4">🔐 Hai, Mas-mas Admin</h4>
    <?php if ($error): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST" id="loginForm" autocomplete="off">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="uname" id="uname" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="pass" id="pass" class="form-control" required>
      </div>
      <div class="d-grid mt-4">
        <button type="submit" class="btn btn-primary" id="loginBtn">Login 🚀</button>
      </div>
    </form>
  </div>

  <script>
    const form = document.getElementById('loginForm');
    const btn = document.getElementById('loginBtn');
    const uname = document.getElementById('uname');
    const pass = document.getElementById('pass');

    form.addEventListener('submit', function(e) {
      if (!uname.value || !pass.value) {
        e.preventDefault();
        btn.classList.add('moving');

        const direction = Math.random() > 0.5 ? 1 : -1;
        btn.style.transform = `translateX(${direction * 100}px) rotate(${direction * 360}deg)`;
        setTimeout(() => {
          btn.style.transform = '';
          btn.classList.remove('moving');
        }, 1000);
      }
    });
  </script>
</body>
</html>
