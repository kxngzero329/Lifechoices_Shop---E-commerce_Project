<?php
session_start();
include 'db.php';

//allows for only john to see this cart if hes logged in
if (!isset($_SESSION['user_id']) || $_SESSION['username'] !== 'johnboy') {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT cart.cart_id, cart.quantity, items.item_name, items.item_price, items.image 
        FROM cart
        JOIN items ON cart.item_id = items.item_id
        WHERE cart.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Calculate total
$total = 0;
$items = [];
while ($row = $result->fetch_assoc()) {
  $row['item_total'] = $row['item_price'] * $row['quantity'];
  $total += $row['item_total'];
  $items[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>John's Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .card {
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .cart-count {
      max-width: 400px;
    }

    .product-img {
      height: 180px;
      object-fit: cover;
      border-bottom: 1px solid #ddd;
    }

    .card-body {
      display: flex;
      flex-direction: column;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="index.php"><img class="logo" src="images/logo1.png" alt="Lifechoices logo"
          style="width: 100px;"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="john_products.php">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Cart</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Log Out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- alert for signed in as john -->
  <div class="alert alert-success text-center" role="alert">
    You are logged in as <strong>John Boy</strong>
  </div>

  <div class="container mt-5">
    <h2 class="mb-4 display-4 text-center">Your Cart</h2>

    <p class="lead alert alert-info fw-bold text-center cart-count mx-auto mb-5">
      You have <span class="text-primary"><?= count($items) ?> item<?= count($items) == 1 ? '' : 's' ?></span> in your
      cart
    </p>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
      <?php foreach ($items as $row): ?>
        <?php
        $imageSrc = (str_starts_with($row['image'], 'http') || str_starts_with($row['image'], 'images/'))
          ? $row['image']
          : 'images/' . $row['image'];
        ?>
        <div class="col">
          <div class="card h-100 shadow-sm">
            <img src="<?= $imageSrc ?>" class="product-img card-img-top" alt="<?= htmlspecialchars($row['item_name']) ?>">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($row['item_name']) ?></h5>
              <p class="card-text mb-1">Price: <span
                  class="text-success fw-bold">R<?= number_format($row['item_price'], 2) ?></span></p>
              <p class="card-text mb-1">Quantity: <strong><?= $row['quantity'] ?></strong></p>
              <p class="card-text">Item Total: <strong>R<?= number_format($row['item_total'], 2) ?></strong></p>

              <div class="d-flex gap-2 mt-auto">
                <!-- Quantity Update -->
                <form method="post" action="update_cart.php" class="d-flex flex-grow-1">
                  <input type="hidden" name="cart_id" value="<?= $row['cart_id'] ?>">
                  <input type="number" name="quantity" value="<?= $row['quantity'] ?>"
                    class="form-control form-control-sm me-1" min="1">
                  <button type="submit" class="btn btn-outline-primary btn-sm">Update</button>
                </form>

                <!-- Remove -->
                <form method="post" action="remove_from_cart.php">
                  <input type="hidden" name="cart_id" value="<?= $row['cart_id'] ?>">
                  <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-trash-alt"></i>Remove</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <?php if (count($items) > 0): ?>
      <div class="card w-50 mx-auto">
        <div class="card-body text-center border-top">
          <h3>Total Amount: <span class="text-success">R<?= number_format($total, 2) ?></span></h3>
        </div>
      </div>
      <br><br>
    <?php endif; ?>
  </div>

  <script src="https://kit.fontawesome.com/a2d9d5a56f.js" crossorigin="anonymous"></script>
</body>

</html>