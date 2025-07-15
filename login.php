<?php
session_start();
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  $sql = "SELECT user_id, username, password FROM users WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($user = $result->fetch_assoc()) {
    if ($password === $user['password']) {
      $_SESSION['user_id'] = $user['user_id'];
      $_SESSION['username'] = $user['username'];

      if ($user['username'] === 'luke123') {
        header("Location: luke_cart.php");
      } elseif ($user['username'] === 'johnboy') {
        header("Location: john_cart.php");
      } else {
        header("Location: index.php");
      }
      exit();
    } else {
      $error = "Invalid password.";
    }
  } else {
    $error = "Username not found.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Login - LifeChoices Shop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    * {
      box-sizing: border-box;
    }

    html,body {
      height: 100%;
      margin: 0;
      overflow: hidden;

    }

    body {
      background: url('images/bg1.jpg') no-repeat center center/cover ;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .container {
      max-width: 100%;
      padding: 0 15px;


    }

    .login-card {
      background: #fff;
      opacity: 0.9;
      padding: 2.5rem;
      border-radius: 1.2rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);


    }

    .login-title {
      font-weight: 600;
      color: #2c3e50;
      font-size: 1.75rem;
    }

    .form-control {
      border-radius: 0.5rem;
    }

    .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
      border-color: #80bdff;
    }

    .btn-primary {
      background-color: #007bff;
      border: none;
      border-radius: 0.5rem;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }

    .info-box {
      background: #f8f9fa;
      opacity: 0.9;
      padding: 1.2rem;
      border-radius: 0.75rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      border-left: 4px solid #007bff;
      margin-bottom: 1.5rem;
    }

    footer {
      font-size: 0.85rem;
      color: #777;
    }
  </style>
</head>

<body>

  <div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-100">

      <!-- left column boxes -->
      <div class="col-md-5 d-none d-md-block">
        <div class="info-box">
          <h5 class="mb-2">Luke’s Account</h5>
          <p class="mb-1"><strong>Username:</strong> <code>luke123</code></p>
          <p class="mb-0"><strong>Password:</strong> <code>asdfghjkl</code></p>
        </div>
        <div class="info-box">
          <h5 class="mb-2">John’s Account</h5>
          <p class="mb-1"><strong>Username:</strong> <code>johnboy</code></p>
          <p class="mb-0"><strong>Password:</strong> <code>qwertyuiop</code></p>
        </div>
      </div>

      <!-- RIGHT COLUMN: Login Card -->
      <div class="col-md-6">
        <div class="login-card mx-auto">
          <h2 class="text-center login-title mb-4">Login</h2>

          <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>

          <form method="post" action="login.php" novalidate>
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input id="username" name="username" type="text" class="form-control" required autofocus />
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input id="password" name="password" type="password" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </form>

          <footer class="text-center mt-4 mb-0">
            &copy; <?= date("Y") ?> LifeChoices. All rights reserved.
          </footer>
        </div>
      </div>
    </div>
  </div>

</body>

</html>