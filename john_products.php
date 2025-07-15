<?php
include 'db.php';
session_start();

// Add to cart logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    if (!isset($_SESSION['user_id']) || $_SESSION['username'] !== 'johnboy') {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $item_id = (int)$_POST['item_id'];

    // Check if item is already in cart
    $check_sql = "SELECT * FROM cart WHERE user_id = ? AND item_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $user_id, $item_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // If exists, update quantity
        $update_sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND item_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $user_id, $item_id);
        $update_stmt->execute();
    } else {
        // Else, insert new row
        $insert_sql = "INSERT INTO cart (user_id, item_id, quantity) VALUES (?, ?, 1)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ii", $user_id, $item_id);
        $insert_stmt->execute();
    }

    header("Location: john_products.php");
    exit();
}

// Get all items
$sql = "SELECT * FROM items";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php"><img class="logo" src="images/logo1.png" alt="Lifechoices logo" style="width: 100px;"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="john_cart.php">Cart</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Log Out</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="alert alert-success text-center" role="alert">
  You are logged in as <strong>John Boy</strong>
</div>
<div class="container mt-5">
  <div class="row">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="col-md-4 mb-4">
        <div class="card">
          <img src="<?= $row['image'] ?>" class="card-img-top" alt="<?= $row['item_name'] ?>" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title"><?= $row['item_name'] ?></h5>
            <p class="card-text">R<?= $row['item_price'] ?></p>
            <form method="post" action="john_products.php">
              <input type="hidden" name="item_id" value="<?= $row['item_id'] ?>">
              <button type="submit" class="btn btn-sm btn-success">Add to Cart</button>
            </form>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>
